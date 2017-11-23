<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/connection/db_conx.php");
class gameTypeModel
{

    protected $type;

    function getType(){
        return $this->type;
    }

    function setType($var){
        $this->type = $var;
    }

    private function __construct($typeModel)
    {
        $this->type = $typeModel['type'];
    }

    public static function getTypes(){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT type FROM mapType');
        $req->execute();
        $types = $req->fetchAll();
        $arrayFinal = [];
        $counter = 0;
        foreach ($types as $model){
            $arrayFinal[$counter] = new gameTypeModel($model);
            $counter++;
        }
        return $arrayFinal;

    }
}