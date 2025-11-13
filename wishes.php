<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$file = 'wishes.json';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (file_exists($file)) {
        echo file_get_contents($file);
    } else {
        echo '[]';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $wishes = [];
    if (file_exists($file)) {
        $wishes = json_decode(file_get_contents($file), true);
    }
    
    $newWish = [
        'name' => $input['name'] ?? 'Friend',
        'text' => $input['text'],
        'timestamp' => date('c')
    ];
    
    array_unshift($wishes, $newWish);
    file_put_contents($file, json_encode($wishes));
    
    echo json_encode(['success' => true]);
}
?>
