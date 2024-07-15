<?php
require_once 'TicTacToeGame.php';

function testTicTacToeGame() {
    // Create a new game instance
    $game = new TicTacToeGame();

    // Print the initial state
    echo "Initial State:" . $game-> getState() ."<br>";
    echo "Board: ";
    $game->PrintBoard();
    echo "<br>Current Player: " . $game->getCurrentPlayer() . "<br>";
    echo "Game State: " . $game->getState() . "<br>";
    echo "Moves Count: " . $game->getMoves() . "<br>";

    // Test making a move
    echo "<br>Making a move at index 0:<br>";
    $game->play(0);
    $game->PrintBoard();
    echo "Moves Count: " . $game->getMoves() . "<br>";
    echo "<br>Current Player: " . $game->getCurrentPlayer() . "<br>";

    // Test making a move at an occupied index
    echo "<br>Attempting to play at an occupied index 0:<br>";
    $validMove = $game->play(0);
    if (!$validMove) {
        echo "Invalid move, index 0 is already occupied.<br>";
    }
    echo "Moves Count: " . $game->getMoves() . "<br>";
    $game->PrintBoard();

    // Test computer making a move
    echo "<br>Computer making a move:<br>";
    $computerMove = $game->getComputerMoveIndex();
    echo "Computer chose index: " . $computerMove . "<br>";
    $game->play($computerMove - 1); // Adjusting index for 0-based array
    $game->PrintBoard();

    // Test win condition
    echo "<br>Setting up a win condition for X:<br>";
    $game->play(1);
    $game->PrintBoard();
    echo "<br>Moves Count: " . $game->getMoves() . "<br>";
    echo "<br>Play<br>";
    $game->play(3); // O's turn
    $game->PrintBoard();
    echo "<br>Moves Count: " . $game->getMoves() . "<br>";
    echo "<br>Play<br>";
    $game->play(2);
    $game->PrintBoard();
    echo "<br>Moves Count: " . $game->getMoves() . "<br>";
    if ($game->checkWin('X')) {
        echo "X wins!<br>";
    } else if ($game->checkWin('O')){
        echo "O wins!<br>";
    } else {
        echo "No one won";
    }

    // Test draw condition
    echo "<br>Setting up a draw condition:<br>";
    $game->resetGame();
    $moves = [0, 1, 2, 4, 3, 5, 7, 6, 8]; // This sequence results in a draw
    foreach ($moves as $move) {
        $game->play($move);
    }
    $game->PrintBoard();
    if ($game->checkDraw()) {
        echo "It's a draw!<br>";
    } else {
        echo "The game is not a draw.<br>";
    }
    echo "<br>Moves Count: " . $game->getMoves() . "<br>";
}

// Run the test
testTicTacToeGame();
?>