<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Free Games</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            body{
                font-family: Arial, sans-serif;
            }
        </style>
    </head>
    <body class="bg-gray-100">
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-4">Free Games</h1>
            <form id="search-form" class="mb-4">
                <input type="text" id="search" class="border p-2 w-full mb-2" placeholder="Search for a game...">
                <select id="sort-by" class="border p-2 w-full">
                    <option value="alphabetical">Alphabetical</option>
                    <option value="release-date">Release Date</option>
                    <option value="popularity">Popularity</option>
                </select>
            </form>
            <div id="games-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"></div>
        </div>
        <script>
            document.getElementById('search-form').addEventListener('submit', function(event){
                event.preventDefault();
                fetchGames();
            });
            function fetchGames(){
                const search = document.getElementById('search').value;
                const sortBy = document.getElementById('sort-by').value;
                fetch(`api.php?search=${search}&sort_by=${sortBy}`)
                .then(response => response.json())
                .then(data => {
                    const gamesContainer = document.getElementById('games-container');
                    gamesContainer.innerHTML = '';
                    data.forEach(game => {
                        const gameElement = document.createElement('div');
                        gameElement.classList.add('bg-white', 'p-4', 'rounded', 'shadow');
                        gameElement.innerHTML = `
                            <h2 class="text-xl font-bold">${game.title}</h2>
                            <img src="${game.thumbnail}" alt="${game.title}" class="w-full h-48 object-cover mb-2">
                            <p>${game.short_description}</p>
                        `;
                        gamesContainer.appendChild(gameElement);
                    });
                })
                .catch(error => console.error('Error fetching games:', error));
            }
            fetchGames();
        </script>
    </body>
</html>