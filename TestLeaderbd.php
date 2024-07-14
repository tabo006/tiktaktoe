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
        die('Error');
    }

    return json_decode($result, true);
}
function printBoard($board) {
    echo "Current Board:<br>";
    for ($i = 0; $i < 9; $i++) {
        echo ($board[$i] === '' ? '-' : $board[$i]) . ' ';
        if (($i + 1) % 3 == 0) {
            echo "<br>";
        }
    }
    echo "<br>";
}
function printSessionSettings($session_cookie_file) {
    echo "Session Settings:<br>";
    echo "session.save_path: " . ini_get('session.save_path') . "<br>";
    echo "session.use_cookies: " . ini_get('session.use_cookies') . "<br>";
    echo "session.cookie_secure: " . ini_get('session.cookie_secure') . "<br>";
    echo "session.use_only_cookies: " . ini_get('session.use_only_cookies') . "<br>";
    echo "session.cookie_lifetime: " . ini_get('session.cookie_lifetime') . "<br>";

    // Check the session ID from the cookie file
    if (file_exists($session_cookie_file)) {
        $cookies = file_get_contents($session_cookie_file);
        echo "Cookies: <pre>" . htmlspecialchars($cookies) . "</pre><br>";
        if (preg_match('/PHPSESSID\s+(\S+)/', $cookies, $matches)) {
            echo "Session ID: " . $matches[1] . "<br>";
        } else {
            echo "Session ID not found in cookie file.<br>";
        }
    } else {
        echo "Session cookie file not found.<br>";
    }
    echo "<br>";
}

// Use a file to store session cookies
$session_cookie_file = tempnam(sys_get_temp_dir(), 'session');

// Print session settings before each request
printSessionSettings($session_cookie_file);

// Test resetting the game
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'reset'], $session_cookie_file);
echo "Reset Game:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";

// Test making a move
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 0], $session_cookie_file);
echo "Player Move at Index 0:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";

// Test making another move
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 1], $session_cookie_file);
echo "Player Move at Index 1:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";

// Continue playing until win or draw
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 4], $session_cookie_file);
echo "Player Move at Index 4:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";

$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 8], $session_cookie_file);
echo "Player Move at Index 8:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";

printSessionSettings($session_cookie_file);
?>