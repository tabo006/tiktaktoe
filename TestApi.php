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
$session_cookie_file = tempnam(sys_get_temp_dir(), 'session');


// Test resetting the game
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'reset'], $session_cookie_file);
echo "Reset Game:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";
// Print session settings after the request
printSessionSettings($session_cookie_file);


// Test making a move
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 0], $session_cookie_file);
echo "Player Move at Index 0:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";

// Test making an invalid move
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

//invalid move 2
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 4], $session_cookie_file);
echo "Player Move at Index 4:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";


$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 7], $session_cookie_file);
echo "Player Move at Index 7:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";

//win situation
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 8], $session_cookie_file);
echo "Player Move at Index 8:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";

//check if allowed to play after win
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 3], $session_cookie_file);
echo "Player Move at Index 3:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";

// Test draw situation
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'reset'], $session_cookie_file);
echo "Reset Game:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";

$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 0], $session_cookie_file);
echo "Player Move at Index 0:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 1], $session_cookie_file);
echo "Player Move at Index 1:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 2], $session_cookie_file);
echo "Player Move at Index 2:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 4], $session_cookie_file);
echo "Player Move at Index 4:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 3], $session_cookie_file);
echo "Player Move at Index 3:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 5], $session_cookie_file);
echo "Player Move at Index 5:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 7], $session_cookie_file);
echo "Player Move at Index 7:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 6], $session_cookie_file);
echo "Player Move at Index 6:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 6], $session_cookie_file);
echo "Player Move at Index 6:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";
$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 8], $session_cookie_file);
echo "Player Move at Index 8:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";

$response = sendRequest('http://localhost:8000/api.php', ['action' => 'play', 'index' => 8], $session_cookie_file);
echo "Player Move at Index 8:<br>";
print_r($response);
printBoard($response['board']);
echo "<br>";
// Print session settings after the request
printSessionSettings($session_cookie_file);
?>