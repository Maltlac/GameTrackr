document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.platform-link').forEach(link => {
        const url = link.getAttribute('href');
        const priceSpan = document.getElementById('price-' + link.dataset.platform);

        // Steam
        if (url && url.includes('store.steampowered.com/app/')) {
            if (priceSpan) {
                priceSpan.innerText = 'Chargement...';
                fetch('/api/scrap-price?url=' + encodeURIComponent(url))
                    .then(res => res.json())
                    .then(data => {
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

        // Instant Gaming
        if (url && url.includes('instant-gaming.com/')) {
            if (priceSpan) {
                priceSpan.innerText = 'Chargement...';
                fetch('/api/scrap-price?url=' + encodeURIComponent(url))
                    .then(res => res.json())
                    .then(data => {
                        // On prend le dernier prix trouvé (le plus bas dans la page)
                        if (data && data.price) {
                            priceSpan.innerText = ' : ' + data.price;
                        } else if (data && data.debug) {
                            priceSpan.innerText =   JSON.stringify(data.debug);
                        } else {
                            priceSpan.innerText = ' : Prix non trouvé';
                        }
                    })
                    .catch(() => {
                        priceSpan.innerText = ' : Erreur';
                    });
            }
        }

        // Epic Games (debug uniquement, tu peux le retirer si tu ne veux plus Epic)
        if (url && url.includes('store.epicgames.com')) {
            if (priceSpan) {
                priceSpan.innerText = 'Chargement...';
                fetch('/api/scrap-price?url=' + encodeURIComponent(url))
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.price) {
                            priceSpan.innerText = ' : ' + data.price;
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