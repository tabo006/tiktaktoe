<?php

class TicTacToeGame{
    private $board;
    private $currentPlayer;
    private $currentState;
    private $movesCount;
    private $winIndecies;

    public function __construct()
    {
        $this->resetGame();
    }

    public function resetGame(){
        $this->board = ['', '', '','','','','','',''];
        $this-> currentState = 'Playing';
        $this-> movesCount=0;
        $this -> currentPlayer='X';
        $this -> winIndecies= [0,0,0];
    }

    public function getBoard()
    {
        return $this->board;
    }

    public function getCurrentPlayer()
    {
        return $this->currentPlayer;
    }

    public function getState()
    {
        return $this->currentState;
    }

    public function getMoves()
    {
        return $this->movesCount;
    }

    public function play($index){
        if ($this->board[$index] == ''){
            $this->board[$index] = $this->currentPlayer;
            $this->currentPlayer = ($this->currentPlayer == 'X') ? 'O' : 'X'; // Switch player
            $this -> movesCount +=1;
            return true;
        }else{
            return false;
        }
    }

    public function isBoardFull()
    {
        foreach ($this->board as $box) {
            if ($box == '') {
                return false;
            }
        }
        return true;
    }

    public function getComputerMoveIndex(){
        $emptySquares = array();

        for ($i = 0; $i < 9; $i++) {
            if ($this->board[$i] == false) {
                $emptySquares[] = $i;
            }
        }
    // Get a random index from the empty squares array
    $randomIndex = rand(0, count($emptySquares) - 1);

    // Get the randomly selected empty square
    $randomSquare = $emptySquares[$randomIndex];

    return $randomSquare;
    }
     
    public function checkWin($player){
        if ($this-> board[0] == $player && $this-> board[1] == $player && $this-> board[2] == $player ){
            $this->currentState=$player;
            $this->winIndecies= [1,2,3];
            return true;
        } else if ($this-> board[3] == $player && $this-> board[4] == $player && $this-> board[5] == $player ){
            $this->currentState=$player;
            $this->winIndecies= [4,5,6];
            return true;
        } else if ($this-> board[6] == $player && $this-> board[7] == $player && $this-> board[8] == $player ){
            $this->currentState=$player;
            $this->winIndecies= [7,8,9];
            return true;
        } else if ($this-> board[0] == $player && $this-> board[3] == $player && $this-> board[6] == $player ){
            $this->currentState=$player;
            $this->winIndecies= [1,4,7];
            return true;
        } else if ($this-> board[1] == $player && $this-> board[4] == $player && $this-> board[7] == $player ){
            $this->currentState=$player;
            $this->winIndecies= [2,5,8];
            return true;
        }else if ($this-> board[2] == $player && $this-> board[5] == $player && $this-> board[8] == $player ){
            $this->currentState=$player;
            $this->winIndecies= [3,6,9];
            return true;
        }else if ($this-> board[0] == $player && $this-> board[4] == $player && $this-> board[8] == $player ){
            $this->currentState=$player;
            $this->winIndecies= [1,5,9];
            return true;
        }else if ($this-> board[2] == $player && $this-> board[4] == $player && $this-> board[6] == $player ){
            $this->currentState=$player;
            $this->winIndecies= [3,5,7];
            return true;
        }else{
            return false;
        }
    }

    public function checkDraw(){
        if ($this -> getMoves() == 9 && $this-> checkWin('X') == false && $this-> checkWin('O') == false){
            $this->currentState = 'Draw';
            return true;
        }else{
            return false;
        }
    }
    
    public function getWinIndex(){
        return $this->winIndecies;
    }

    public function PrintBoard() {
        foreach ($this->board as $index => $value) {
            echo $value === '' ? '-' : $value;
            if (($index + 1) % 3 === 0) {
                echo "<br>";
            } else {
                echo " ";
            }
        }
    }

}