<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class nightfallView
{
    protected $timerUntil;

    public function __construct()
    {
        $this->timerUntil = $this->getTimer();
    }

    public function returnVars(){
        return get_object_vars($this);
    }


    private function getTimer(){
        $time = strtotime("now");
        $hours = date("H",time());
        $mins = date("i",time());
        if ($hours >= 22 && $mins >=30){
            $next = strtotime("tomorrow 10:30pm");
        } else {
            $next = strtotime("today 10:30pm");
        }
        return $next-$time;
    }

}