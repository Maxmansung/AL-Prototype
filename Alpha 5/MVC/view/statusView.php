<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class statusView
{

    protected $description;
    protected $image;

    function returnVars()
    {
        return get_object_vars($this);
    }


    private function __construct($statusModel)
    {
        $this->description = $statusModel->getStatusDescription();
        $this->image = $statusModel->getStatusImage();

    }

    public static function getStatusView($statusArray){
        $finalArray = [];
        foreach ($statusArray as $key=>$stat){
            if ($stat === 1){
                $temp = new statusesController($key);
                $view = new statusView($temp);
                $finalArray[$temp->getStatusName()] = $view->returnVars();
            }
        }
        return $finalArray;
    }

}