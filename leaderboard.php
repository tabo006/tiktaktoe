<?php
class Leaderboard{
    private $score;

    public function __construct()
    {
        $this->resetScore();
    }

    public function resetScore(){
        $this->score= array('X'=>0, 'O'=> 0, 'Draw'=>0);
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

    public function getScoreDraw()
    {
        return $this->score['Draw'];
    }

    public function incScore($player)
    {
        return $this->score[$player]++;
    }
}