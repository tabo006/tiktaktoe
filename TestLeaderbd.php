<?php
require_once 'Leaderboard.php';

// Function to print the current scores
function printScores($leaderboard) {
    echo "Current Scores:<br>";
    echo "Player X: " . $leaderboard->getScoreX() . "<br>";
    echo "Player O: " . $leaderboard->getScoreO() . "<br><br>";
}

// Instantiate the Leaderboard class
$leaderboard = new Leaderboard();

// Print initial scores
echo "Initial Scores:<br>";
printScores($leaderboard);

// Increment score for Player X
echo "Incrementing score for Player X:<br>";
$leaderboard->incScore('X');
printScores($leaderboard);

// Increment score for Player O
echo "Incrementing score for Player O:<br>";
$leaderboard->incScore('O');
printScores($leaderboard);

// Increment score for Player X again
echo "Incrementing score for Player X again:<br>";
$leaderboard->incScore('X');
printScores($leaderboard);

// Reset scores
echo "Resetting Scores:<br>";
$leaderboard->resetScore();
printScores($leaderboard);

// Print final scores
echo "Final Scores:<br>";
printScores($leaderboard);
?>