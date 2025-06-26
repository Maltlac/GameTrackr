document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('searchInput');
    const suggestions = document.getElementById('searchSuggestions');
    const form = document.getElementById('searchForm');

    let lastQuery = '';
    input.addEventListener('input', function() {
        const q = input.value.trim();
        if (!q) {
            suggestions.style.display = 'none';
            suggestions.innerHTML = '';
            return;
        }
        lastQuery = q;
        fetch('/api/games/autocomplete?q=' + encodeURIComponent(q))
            .then(res => res.json())
            .then(data => {
                if (input.value.trim() !== lastQuery) return; // ignore outdated results
                suggestions.innerHTML = '';
                if (data.length) {
                    data.forEach(game => {
                        const li = document.createElement('li');
                        li.className = 'list-group-item list-group-item-action';
                        li.textContent = game.title;
                        li.style.cursor = 'pointer';
                        li.onclick = () => {
                            input.value = game.title;
                            suggestions.style.display = 'none';
                            form.submit();
                        };
                        suggestions.appendChild(li);
                    });
                    suggestions.style.display = 'block';
                } else {
                    suggestions.style.display = 'none';
                }
            })
            .catch(() => {
                suggestions.style.display = 'none';
            });
    });

    // Masquer les suggestions si clic en dehors
    document.addEventListener('mousedown', function(e) {
        if (!suggestions.contains(e.target) && e.target !== input) {
            suggestions.style.display = 'none';
        }
    });

    // Masquer suggestions sur submit
    form.addEventListener('submit', function() {
        suggestions.style.display = 'none';
    });
});
