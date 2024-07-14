<?php
class Leaderboard{
    private $score;


    public function __construct()
    {
        $this->resetScore();
    }

    public function resetScore(){
        $this->score= array('X'=>0, 'O'=> 0);
    }

    public function getScore()
    {
        return $this->score;
    }

    public function getScoreX()
    {
        return $this->score['X'];
    }

    public function getScoreO()
    {
        return $this->score['O'];
    }

    public function incScore($player)
    {
        return $this->score[$player]++;
    }
}