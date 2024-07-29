<?php
    if(!isset($_GET['search'])){
        $_GET['search'] = '';
    }
    if(!isset($_GET['sort_by'])){
        $_GET['sort_by'] = 'alphabetical';
    }
    $search = $_GET['search'];
    $sortBy = $_GET['sort_by'];
    $apiUrl = "https://www.freetogame.com/api/games";
    $response = file_get_contents($apiUrl);
    $games = json_decode($response, true);
    if($search){
        $games = array_filter($games, function($game) use ($search){
            return stripos($game['title'], $search) !== false;
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
    header('Content-Type: application/json');
    echo json_encode(array_values($games));
?>