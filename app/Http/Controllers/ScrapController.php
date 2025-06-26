<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ScrapController extends Controller
{
    private function isSteamUrl($url)
    {
        return str_contains($url, 'store.steampowered.com/app/');
    }

    private function isEpicUrl($url)
    {
        // Correction : accepte aussi les URLs commençant par "store.epicgames.com"
        return str_contains($url, 'epicgames.com/store') || str_contains($url, 'store.epicgames.com');
    }

    private function isInstantGamingUrl($url)
    {
        return str_contains($url, 'instant-gaming.com/');
    }

    // Remplace la méthode steamPrice par getPrice (nouveau nom unique)
    public function steamPrice(Request $request)
    {
        return $this->getPrice($request);
    }

    public function getPrice(Request $request)
    {
        $url = $request->query('url');
        if (!$url) {
            return response()->json(['error' => 'URL manquante'], 400);
        }

        if ($this->isSteamUrl($url)) {
            return $this->getSteamPrice($url);
        }

        if ($this->isEpicUrl($url)) {
            return $this->getEpicPrice($url);
        }

        if ($this->isInstantGamingUrl($url)) {
            return $this->getInstantGamingPrice($url);
        }

        return response()->json(['error' => 'URL non supportée'], 400);
    }

    private function getSteamPrice($url)
    {
        if (!preg_match('/store\.steampowered\.com\/app\/(\d+)/', $url, $matches)) {
            return response()->json(['error' => 'ID Steam non trouvé'], 400);
        }
        $appId = $matches[1];
        try {
            $apiUrl = "https://store.steampowered.com/api/appdetails?appids={$appId}&cc=fr&l=fr";
            $response = Http::withOptions(['verify' => false])->timeout(10)->get($apiUrl);
            if (!$response->ok()) {
                return response()->json(['error' => 'Impossible de récupérer les infos Steam'], 500);
            }
            $data = $response->json();
            // Retourne directement le bloc data (ou null)
            if (isset($data[$appId]['success']) && $data[$appId]['success'] && isset($data[$appId]['data'])) {
                return response()->json($data[$appId]['data']);
            }
            return response()->json(null);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération du prix Steam : ' . $e->getMessage()], 500);
        }
    }

    private function getEpicPrice($url)
    {
        try {
            // Récupère le slug du jeu depuis l'URL Epic Games
            // Exemple d'URL : https://store.epicgames.com/fr/p/rainbow-six-siege-x
            $matches = [];
            if (!preg_match('#epicgames\.com/.*/p/([^/?]+)#', $url, $matches)) {
                return response()->json(['error' => 'Impossible d\'extraire le slug Epic Games depuis l\'URL'], 400);
            }
            $slug = $matches[1];

            // Certains slugs Epic Games ont un suffixe "-x" ou autre, on tente sans le suffixe si 404
            $trySlugs = [$slug];
            if (str_ends_with($slug, '-x')) {
                $trySlugs[] = substr($slug, 0, -2);
            }

            foreach ($trySlugs as $trySlug) {
                $apiUrl = "https://store-site-backend-static.ak.epicgames.com/graphql";
                $query = [
                    'query' => 'query searchStoreQuery($slug: String!) {
                        Catalog {
                            catalogOffers(namespace: "", locale: "fr-FR", params: {productSlug: $slug}) {
                                elements {
                                    title
                                    productSlug
                                    price {
                                        totalPrice {
                                            discountPrice
                                            currencyCode
                                        }
                                    }
                                }
                            }
                        }
                    }',
                    'variables' => [
                        'slug' => $trySlug
                    ]
                ];

                $response = Http::withOptions(['verify' => false])
                    ->timeout(10)
                    ->post($apiUrl, $query);

                if ($response->ok()) {
                    $data = $response->json();
                    // Debug : retourne tout le JSON pour inspection
                    // return response()->json($data);

                    // Recherche du bon élément par productSlug
                    if (
                        isset($data['data']['Catalog']['catalogOffers']['elements'])
                        && is_array($data['data']['Catalog']['catalogOffers']['elements'])
                    ) {
                        foreach ($data['data']['Catalog']['catalogOffers']['elements'] as $element) {
                            if (
                                isset($element['productSlug']) &&
                                (
                                    $element['productSlug'] === $trySlug ||
                                    $element['productSlug'] === 'fr/p/' . $trySlug ||
                                    str_ends_with($element['productSlug'], $trySlug)
                                )
                            ) {
                                if (isset($element['price']['totalPrice']['discountPrice'])) {
                                    $discount = $element['price']['totalPrice']['discountPrice'];
                                    $currency = $element['price']['totalPrice']['currencyCode'] ?? 'EUR';
                                    if ($discount == 0) {
                                        $price = 'gratuit';
                                    } else {
                                        $price = number_format($discount / 100, 2, ',', ' ') . ' ' . $currency;
                                    }
                                    return response()->json(['price' => $price]);
                                }
                            }
                        }
                    }
                }
            }

            return response()->json(['price' => null]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération du prix Epic Games : ' . $e->getMessage()], 500);
        }
    }

    private function getInstantGamingPrice($url)
    {
        try {
            $response = Http::withOptions([
                'verify' => false,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'
                ]
            ])->timeout(10)->get($url);

            if (!$response->ok()) {
                return response()->json(['error' => 'Impossible de récupérer la page Instant Gaming', 'status' => $response->status()], 500);
            }
            $html = $response->body();

            libxml_use_internal_errors(true);
            $dom = new \DOMDocument();
            $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
            $xpath = new \DOMXPath($dom);

            // Recherche la div avec toutes les classes "panel item wide"
            $panelNodes = $xpath->query("//div[contains(concat(' ', normalize-space(@class), ' '), ' panel ') and contains(concat(' ', normalize-space(@class), ' '), ' item ') and contains(concat(' ', normalize-space(@class), ' '), ' wide ')]");
            $price = null;
            $debug = null;
            $found = false;
            foreach ($panelNodes as $panelNode) {
                if ($found) break;
                $amountNodes = (new \DOMXPath($dom))->query(".//div[contains(@class, 'amount')]", $panelNode);
                foreach ($amountNodes as $amountNode) {
                    if ($found) break;
                    $totalNodes = (new \DOMXPath($dom))->query("./div[contains(@class, 'total')]", $amountNode);
                    foreach ($totalNodes as $node) {
                        $text = trim($node->textContent);
                        $debug = $text;
                        if (preg_match('/[\d,.]+ ?€/', $text, $m)) {
                            $price = $m[0];
                            $found = true;
                            break;
                        }
                    }
                }
            }
            return response()->json(['price' => $price, 'debug' => $debug]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors du scrapping Instant Gaming : ' . $e->getMessage()], 500);
        }
    }
}


