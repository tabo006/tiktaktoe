<?php
session_start();

header('Content-Type: application/json');

// Check if the leaderboard is already set in the session; if not, initialize it
if (!isset($_SESSION['leaderboard'])) {
    $_SESSION['leaderboard'] = ['user' => 0, 'computer' => 0];
}

// Load the leaderboard from the session into a local variable
$leaderboard = $_SESSION['leaderboard'];

// Handle a POST request to update the leaderboard
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the winner from the POST data
    $winner = $_POST['winner'];
    
    // Increment the corresponding win count
    if ($winner === 'user') {
        $leaderboard['user']++;
    } elseif ($winner === 'computer') {
        $leaderboard['computer']++;
    }
    
    // Update the session leaderboard with the new counts
    $_SESSION['leaderboard'] = $leaderboard;
}

// Return the leaderboard as a JSON response
echo json_encode($leaderboard);
?>