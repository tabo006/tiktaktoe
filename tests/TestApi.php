<?php
function sendRequest($url, $data, $session_cookie_file) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_COOKIEJAR, $session_cookie_file);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $session_cookie_file);
    $response = curl_exec($ch);
    if ($response === FALSE) {
        die('Error: ' . curl_error($ch));
    }
    curl_close($ch);

    return json_decode($response, true);
}

function printBoard($board) {
    if ($board === NULL) {
        echo "Board is NULL.<br>";
        return;
    }
    
    echo "Current Board:<br>";
    for ($i = 0; $i < 9; $i++) {
        echo ($board[$i] === '' ? '-' : $board[$i]) . ' ';
        if (($i + 1) % 3 == 0) {
            echo "<br>";
        }
    }
    echo "<br>";
}

// Use a file to store session cookies
$session_cookie_file = tempnam(sys_get_temp_dir(), 'session');

// Function to reset the game and print the board
function resetGame($session_cookie_file) {
    $response = sendRequest('http://localhost:8000/api.php', ['action' => 'reset'], $session_cookie_file);
    echo "Reset Game:<br>";
    print_r($response);
    printBoard($response['board']);
    echo "<br>";
}

// Function to play a move and print the response and board
function playMove($index, $session_cookie_file) {
    $response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => $index], $session_cookie_file);
    echo "Player Move at Index $index:<br>";
    print_r($response);
    printBoard($response['board']);
    if ($response['response']['status'] == 'win') {
        echo "Player " . $response['response']['player'] . " wins!<br>";
    } elseif ($response['response']['status'] == 'draw') {
        echo "The game is a draw.<br>";
    } elseif ($response['response']['status'] == 'invalid') {
        echo "Invalid move at index $index.<br>";
    } elseif (isset($response['response']['comp_Index'])) {
        echo "Computer played at Index " . $response['response']['comp_Index'] . "<br>";
    }
    echo "<br>";
}

// Test resetting the game and playing moves
resetGame($session_cookie_file);

// X wins
$moves_x_win = [0, 3, 1, 4, 2];
foreach ($moves_x_win as $index) {
    playMove($index, $session_cookie_file);
}

// Reset for next game
resetGame($session_cookie_file);

// X wins again
$moves_x_win_again = [0, 3, 1, 4, 2];
foreach ($moves_x_win_again as $index) {
    playMove($index, $session_cookie_file);
}

// Reset for next game
resetGame($session_cookie_file);

// O wins
$moves_o_win = [0, 3, 1, 4, 7, 5];
foreach ($moves_o_win as $index) {
    playMove($index, $session_cookie_file);
}

// Attempt to play at an index that has already been played
playMove(5, $session_cookie_file);

// Print final leaderboard
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'reset'], $session_cookie_file);
echo "Final Leaderboard:<br>";
print_r($response['leaderboard']);
?>