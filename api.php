<?php
require_once 'TicTacToeGame.php';
session_start();


header('Content-Type: application/json');



if (!isset($_SESSION['game'])) {
    $_SESSION['game'] = new TicTacToeGame();
}

$game = $_SESSION['game'];

$action = $_POST['action'];

switch ($action) {
    case 'reset':
        $game->resetGame();
        $response = ['status' => $game->getState()];
        break;

    case 'play':
        $index = $_POST['index'];
        if ($game->getState() == 'Playing'){
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
        }else{
            if ($game->checkWin('X')) {
                $response = ['status' => 'win', 'player' => 'X'];
            } elseif ($game->checkWin('O')) {
                $response = ['status' => 'win', 'player' => 'O'];
            } elseif ($game->checkDraw()) {
                $response = ['status' => 'draw'];
            }
        }

}

$_SESSION['game'] = $game;

// Debugging: Print session game state after action
error_log('Session game state after action: ' . print_r($_SESSION['game'], true));

echo json_encode(['board' => $game->getBoard(), 'currentPlayer' => $game->getCurrentPlayer(), 'response' => $response]);
?>