<?php
session_start();
require_once 'TicTacToeGame.php';

header('Content-Type: application/json');

// Debugging: Print session ID to ensure it's consistent across requests
error_log('Session ID: ' . session_id());

if (!isset($_SESSION['game'])) {
    $_SESSION['game'] = new TicTacToeGame();
}

// Debugging: Print session game state before action
error_log('Session game state before action: ' . print_r($_SESSION['game'], true));

$game = $_SESSION['game'];

$action = $_POST['action'];

switch ($action) {
    case 'reset':
        $game->resetGame();
        $response = ['status' => $game->getState()];
        break;

    case 'play':
        $index = $_POST['index'];
        if ($game->play($index)) {
            if ($game->checkWin('X')) {
                $response = ['status' => 'win', 'player' => 'X'];
            } elseif ($game->checkWin('O')) {
                $response = ['status' => 'win', 'player' => 'O'];
            } elseif ($game->checkDraw()) {
                $response = ['status' => 'draw'];
            } else {
                $response = ['status' => 'Playing'];
            }
        } else {
            $response = ['status' => 'invalid'];
        }
        break;
}

$_SESSION['game'] = $game;

// Debugging: Print session game state after action
error_log('Session game state after action: ' . print_r($_SESSION['game'], true));

echo json_encode(['board' => $game->getBoard(), 'currentPlayer' => $game->getCurrentPlayer(), 'response' => $response]);
?>