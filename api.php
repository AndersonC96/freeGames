<?php
    $search = $_GET['search'] ?? '';
    $sortBy = $_GET['sort_by'] ?? 'alphabetical';
    $genre = $_GET['genre'] ?? '';
    $offset = (int)($_GET['offset'] ?? 0);
    $limit = (int)($_GET['limit'] ?? 12);
    $apiUrl = "https://www.freetogame.com/api/games";
    $response = file_get_contents($apiUrl);
    $games = json_decode($response, true);
    if($search){
        $games = array_filter($games, function($game) use ($search){
            return stripos($game['title'], $search) !== false;
        });
    }
    if($genre){
        $games = array_filter($games, function($game) use ($genre){
            return stripos($game['genre'], $genre) !== false;
        });
    }
    switch($sortBy){
        case 'alphabetical':
            usort($games, function($a, $b){
                return strcmp($a['title'], $b['title']);
            });
            break;
        case 'release-date':
            usort($games, function($a, $b){
                return strtotime($b['release_date']) - strtotime($a['release_date']);
            });
            break;
        case 'popularity':
            usort($games, function($a, $b){
                return $b['popularity'] - $a['popularity'];
            });
            break;
    }
    $totalGames = count($games);
    $games = array_slice($games, $offset, $limit);
    header('Content-Type: application/json');
    echo json_encode([
        'games' => array_values($games),
        'totalGames' => $totalGames
    ]);
?>