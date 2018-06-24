<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class responseController
{

    protected $changeType;
    protected $failStatus;
    protected $succeedStatus;

    function getChangeType(){
        return $this->changeType;
    }

    function getFailStatus(){
        return $this->failStatus;
    }

    function getSucceedStatus(){
        return $this->succeedStatus;
    }

    public static function getStatusChangeType($id){
        $response = "";
        switch ($id){
            case 2:
                $response = new responseFood();
                break;
            case 3:
                $response = new responseDrug();
                break;
            case 4:
                $response = new responseMedicine();
                break;
            case 5:
                $response = new responseSnack();
                break;
        }
        return $response;
    }

}