<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Free Games</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            body{
                font-family: 'Arial', sans-serif;
            }
            .card{
                transition: transform 0.2s;
            }
            .card:hover{
                transform: translateY(-5px);
            }
        </style>
    </head>
    <body class="bg-gray-900 text-white">
        <div class="container mx-auto p-4">
            <h1 class="text-4xl font-bold text-center text-yellow-400 mb-6">Free Games</h1>
            <form id="search-form" class="mb-6 flex flex-wrap justify-center gap-4">
                <input type="text" id="search" class="border border-yellow-400 bg-gray-800 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Search for a game...">
                <select id="sort-by" class="border border-yellow-400 bg-gray-800 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <option value="alphabetical">Alphabetical</option>
                    <option value="release-date">Release Date</option>
                    <option value="popularity">Popularity</option>
                </select>
                <select id="genre" class="border border-yellow-400 bg-gray-800 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <option value="">All Genres</option>
                    <option value="Action">Action</option>
                    <option value="Action Game">Action Game</option>
                    <option value="Action RPG">Action RPG</option>
                    <option value="ARPG">ARPG</option>
                    <option value="Battle Royale">Battle Royale</option>
                    <option value="Card">Card</option>
                    <option value="Card Game">Card Game</option>
                    <option value="Fantasy">Fantasy</option>
                    <option value="Fighting">Fighting</option>
                    <option value="MMO">MMO</option>
                    <option value="MMOARPG">MMOARPG</option>
                    <option value="MMORPG">MMORPG</option>
                    <option value="MOBA">MOBA</option>
                    <option value="Racing">Racing</option>
                    <option value="Shooter">Shooter</option>
                    <option value="Social">Social</option>
                    <option value="Sports">Sports</option>
                    <option value="Strategy">Strategy</option>
                </select>
                <button type="submit" class="bg-yellow-500 text-gray-900 p-2 rounded-md hover:bg-yellow-600 transition duration-300">Search</button>
            </form>
            <div id="games-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6"></div>
            <div id="pagination" class="flex justify-center space-x-2">
                <button id="prev-page" class="bg-yellow-500 text-gray-900 p-2 rounded-md hover:bg-yellow-600 transition duration-300">Previous</button>
                <span id="page-number" class="text-yellow-400 font-bold p-2"></span>
                <button id="next-page" class="bg-yellow-500 text-gray-900 p-2 rounded-md hover:bg-yellow-600 transition duration-300">Next</button>
            </div>
        </div>
        <script>
            let currentPage = 1;
            const resultsPerPage = 12;
            document.getElementById('search-form').addEventListener('submit', function(event){
                event.preventDefault();
                currentPage = 1;
                fetchGames();
            });
            document.getElementById('prev-page').addEventListener('click', function(){
                if(currentPage > 1){
                    currentPage--;
                    fetchGames();
                }
            });
            document.getElementById('next-page').addEventListener('click', function(){
                currentPage++;
                fetchGames();
            });
            function getPlatformIcon(platform){
                if(platform.includes('PC (Windows)')){
                    return '<img src="./img/win.png" class="w-4 h-4" alt="Windows">';
                }else if(platform.includes('Web Browser')){
                    return '<img src="./img/chrome.png" class="w-4 h-4" alt="Web Browser">';
                }
                return platform;
            }
            function formatDate(dateStr){
                const date = new Date(dateStr);
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return `${day}/${month}/${year}`;
            }
            function fetchGames(){
                const search = document.getElementById('search').value;
                const sortBy = document.getElementById('sort-by').value;
                const genre = document.getElementById('genre').value;
                const offset = (currentPage - 1) * resultsPerPage;
                fetch(`api.php?search=${search}&sort_by=${sortBy}&genre=${genre}&offset=${offset}&limit=${resultsPerPage}`)
                .then(response => response.json())
                .then(data => {
                    const gamesContainer = document.getElementById('games-container');
                    gamesContainer.innerHTML = '';
                    data.games.forEach(game => {
                        const gameElement = document.createElement('div');
                        gameElement.classList.add('card', 'bg-gray-800', 'p-4', 'rounded-lg', 'shadow-md', 'hover:shadow-xl', 'transition', 'duration-300');
                        gameElement.innerHTML = `
                            <img src="${game.thumbnail}" alt="${game.title}" class="w-full h-48 object-cover rounded mb-4">
                            <div class="p-2">
                                <h2 class="text-2xl font-bold mb-2 text-yellow-400">${game.title}</h2>
                                <p class="text-gray-300 mb-2">${game.short_description}</p>
                                <p class="text-gray-400 text-sm mt-2"><b>Release Date</b>: ${formatDate(game.release_date)}</p>
                                <p class="text-gray-400 text-sm mt-2"><b>Developer</b>: ${game.developer}</p>
                                <p class="text-gray-400 text-sm mt-2"><b>Publisher</b>: ${game.publisher}</p>
                                <div class="flex items-center justify-between mt-4">
                                    <span class="bg-gray-700 text-xs font-semibold px-2 py-1 rounded">${game.genre}</span>
                                    <span class="flex items-center space-x-1">
                                        ${getPlatformIcon(game.platform)}
                                    </span>
                                </div>
                                <a href="${game.game_url}" target="_blank" class="block bg-yellow-500 text-center mt-4 py-2 rounded hover:bg-yellow-600 transition duration-300">Play Now</a>
                            </div>
                        `;
                        gamesContainer.appendChild(gameElement);
                    });
                    document.getElementById('page-number').textContent = currentPage;
                    document.getElementById('prev-page').disabled = currentPage === 1;
                    document.getElementById('next-page').disabled = data.games.length < resultsPerPage;
                })
                .catch(error => console.error('Error fetching games:', error));
            }
            fetchGames();
        </script>
    </body>
</html>