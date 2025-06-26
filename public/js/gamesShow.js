document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.platform-link').forEach(link => {
        const url = link.getAttribute('href');
        const priceSpan = document.getElementById('price-' + link.dataset.platform);

        // Si Steam, appelle l'API backend pour éviter le CORS
        if (url && url.includes('store.steampowered.com/app/')) {
            if (priceSpan) {
                priceSpan.innerText = 'Chargement...';
                fetch('/api/scrap-price?url=' + encodeURIComponent(url))
                    .then(res => res.json())
                    .then(data => {
                        // Correction : la réponse backend retourne directement l'objet data de Steam
                        // donc il faut accéder directement à is_free et price_overview
                        if (data && typeof data === 'object') {
                            if (data.is_free) {
                                priceSpan.innerText = ' : gratuit';
                            } else if (data.price_overview && data.price_overview.final_formatted) {
                                priceSpan.innerText = ' : ' + data.price_overview.final_formatted;
                            } else {
                                priceSpan.innerText = ' : Prix non trouvé';
                            }
                        } else {
                            priceSpan.innerText = ' : Prix non trouvé';
                        }
                    })
                    .catch(() => {
                        priceSpan.innerText = ' : Erreur';
                    });
            }
        }
    });
});