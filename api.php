<?php
require_once 'TicTacToeGame.php';
require_once 'Leaderboard.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['game'])) {
    $_SESSION['game'] = new TicTacToeGame();
}
if (!isset($_SESSION['leaderboard'])) {
    $_SESSION['leaderboard'] = new Leaderboard();
}

$game = $_SESSION['game'];
$leaderboard = $_SESSION['leaderboard'];
$action = $_POST['action'];

switch ($action) {
    //used to reset board
    case 'reset':
        $game->resetGame();
        $response = ['status' => $game->getState()];
        break;
    //used to play (X always plays first)
    case 'play':
        $index = $_POST['index'];
        if ($game->getState() == 'Playing') {
            if ($game->play($index)) {
                if ($game->checkWin('X')) {
                    $response = ['status' => 'win', 'player' => 'X', 'Win_Index_ID' => $game->getWinIndex()];
                    $leaderboard->incScore('X');
                } elseif ($game->checkDraw()) {
                    $response = ['status' => 'draw'];
                    $leaderboard->incScore('Draw');
                } else {
                    //the computer play automatically after X plays 
                    //the computer's play index is returned in the repsonse for use in JS
                    $compIndex = $game->getComputerMoveIndex();
                    if ($game->play($compIndex)) {
                        if ($game->checkWin('O')) {
                            $response = ['status' => 'win', 'player' => 'O', 'comp_Index' => $compIndex, 'Win_Index_ID' => $game->getWinIndex()];
                            $leaderboard->incScore('O');
                        } elseif ($game->checkDraw()) {
                            $response = ['status' => 'draw', 'comp_Index' => $compIndex];
                            $leaderboard->incScore('Draw');
                        } else {
                            $response = ['status' => 'Playing','comp_Index' => $compIndex];
                        }
                    } else {
                        $response = ['status' => 'Error', 'comp_Index' => $compIndex];
                    }
                }
            } else {
                $response = ['status' => 'invalid'];
            }
        } else {
            if ($game->checkWin('X')) {
                $response = ['status' => 'win', 'player' => 'X', 'Win_Index_ID' => $game->getWinIndex()];
            } elseif ($game->checkWin('O')) {
                $response = ['status' => 'win', 'player' => 'O', 'Win_Index_ID' => $game->getWinIndex()];
            } elseif ($game->checkDraw()) {
                $response = ['status' => 'draw'];
            }
        }
        break;

    default:
        $response = ['status' => 'invalid_action'];
        break;
}

$_SESSION['game'] = $game;
$_SESSION['leaderboard'] = $leaderboard;

// Debugging: Print session game state after action
error_log('Session game state after action: ' . print_r($_SESSION['game'], true));

echo json_encode([
    'board' => $game->getBoard(), 
    'currentPlayer' => $game->getCurrentPlayer(), 
    'leaderboard' => $leaderboard->getScore(), 
    'response' => $response
]);
?>