<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ScrapController extends Controller
{
    public function steamPrice(Request $request)
    {
        $url = $request->query('url');
        if (!$url || !str_contains($url, 'store.steampowered.com/app/')) {
            return response()->json(['error' => 'URL Steam invalide'], 400);
        }

        // Récupère l'ID du jeu Steam dans l'URL
        if (!preg_match('/store\.steampowered\.com\/app\/(\d+)/', $url, $matches)) {
            return response()->json(['error' => 'ID Steam non trouvé'], 400);
        }
        $appId = $matches[1];

        try {
            $apiUrl = "https://store.steampowered.com/api/appdetails?appids={$appId}&cc=fr&l=fr";
            // Désactive la vérification SSL pour contourner l'erreur cURL 60 (à ne faire que pour du dev/local !)
            $response = Http::withOptions(['verify' => false])->timeout(10)->get($apiUrl);
            if (!$response->ok()) {
                return response()->json(['error' => 'Impossible de récupérer les infos Steam'], 500);
            }
            $data = $response->json();
            // Retourne tout le JSON pour le front (pour accès à price_overview)
            return response()->json($data[$appId]['data'] ?? []);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération du prix Steam : ' . $e->getMessage()], 500);
        }
    }
}

