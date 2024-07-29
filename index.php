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
        </style>
    </head>
    <body class="bg-gray-100">
        <div class="container mx-auto p-4">
            <h1 class="text-4xl font-bold text-center text-blue-600 mb-6">Free Games</h1>
            <form id="search-form" class="mb-6">
                <input type="text" id="search" class="border border-blue-300 p-2 w-full mb-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search for a game...">
                <select id="sort-by" class="border border-blue-300 p-2 w-full mb-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="alphabetical">Alphabetical</option>
                    <option value="release-date">Release Date</option>
                    <option value="popularity">Popularity</option>
                </select>
                <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 transition duration-300">Search</button>
            </form>
            <div id="games-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6"></div>
            <div id="pagination" class="flex justify-center space-x-2">
                <button id="prev-page" class="bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 transition duration-300">Previous</button>
                <span id="page-number" class="text-blue-600 font-bold p-2"></span>
                <button id="next-page" class="bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 transition duration-300">Next</button>
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
                const offset = (currentPage - 1) * resultsPerPage;
                fetch(`api.php?search=${search}&sort_by=${sortBy}&offset=${offset}&limit=${resultsPerPage}`)
                .then(response => response.json())
                .then(data => {
                    const gamesContainer = document.getElementById('games-container');
                    gamesContainer.innerHTML = '';
                    data.games.forEach(game => {
                        const gameElement = document.createElement('div');
                        gameElement.classList.add('bg-gray-800', 'text-white', 'p-4', 'rounded-lg', 'shadow-md', 'hover:shadow-xl', 'transition', 'duration-300');
                        gameElement.innerHTML = `
                            <img src="${game.thumbnail}" alt="${game.title}" class="w-full h-48 object-cover rounded mb-4">
                            <div class="p-2">
                                <h2 class="text-2xl font-bold mb-2">${game.title}</h2>
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
                                <a href="${game.game_url}" target="_blank" class="block bg-blue-600 text-center mt-4 py-2 rounded hover:bg-blue-700 transition duration-300">Play Now</a>
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