<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class statusesModel extends statuses
{
    private function __construct($statusModel)
    {
        $this->statusID = intval($statusModel['statusID']);
        $this->statusName = $statusModel['statusName'];
        $this->statusDescription = $statusModel['statusDescription'];
        $this->statusImage = $statusModel['statusImage'];
        $this->statusModifier = intval($statusModel['modifier']);
        $this->startingStat = intval($statusModel['startingStat']);
    }

    public static function getStatus($statusID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM statuses WHERE statusID= :statusID LIMIT 1');
        $req->execute(array(':statusID' => $statusID));
        $statusModel = $req->fetch();
        return new statusesModel($statusModel);
    }

    public static function startingStats(){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT statusID, startingStat FROM statuses');
        $req->execute();
        $statusModel = $req->fetchAll();
        $blankArray = [];
        foreach ($statusModel as $stat){
            $number = intval($stat['statusID']);
            $blankArray[$number] = intval($stat['startingStat']);
        }
        return $blankArray;
    }

}