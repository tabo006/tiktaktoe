<?php
function sendRequest($url, $data) {
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) {
        die('Error: ' . $http_response_header[0]);
    }

    return json_decode($result, true);
}

// Test reset game
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'reset']);
echo "Reset Game:\n";
print_r($response);

// Test making a move
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 0]);
echo "Player Move at Index 0:\n";
print_r($response);

// Test making a move at the same index (should be invalid)
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 0]);
echo "Player Move at Index 0 (Invalid):\n";
print_r($response);

// Test making another valid move
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 1]);
echo "Player Move at Index 1:\n";
print_r($response);

// Continue playing until win or draw
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 4]);
echo "Player Move at Index 4:\n";
print_r($response);

$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 8]);
echo "Player Move at Index 8:\n";
print_r($response);
?>