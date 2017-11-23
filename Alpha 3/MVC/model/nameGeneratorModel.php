<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/connection/db_conx.php");
class nameGeneratorModel extends nameGenerator
{

    private function __construct($genModel)
    {
        $this->type = $genModel['type'];
        $this->firstName = $genModel['firstName'];
        $this->middleName = $genModel['middleName'];
        $this->lastName = $genModel['lastName'];
    }


    public static function nameList($type){
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT * FROM nameGenerator WHERE nameType= :type");
        $req->bindParam(':type', $type);
        $req->execute();
        $nameList = $req->fetchAll();
        return $nameList;
    }
}