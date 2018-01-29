<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class deathCauseModel extends deathCause
{

    private function __construct($causeModel)
    {
        $this->key = $causeModel['mainKey'];
        $this->causeName = $causeModel['causeName'];
        $this->description = $causeModel['description'];
        $this->image = $causeModel['image'];
    }

    public static function getCause($key){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM deathCause WHERE mainKey= :mainKey');
        $req->bindParam(':mainKey', $key);
        $req->execute();
        $cause = $req->fetch();
        return new deathCauseModel($cause);

    }
}