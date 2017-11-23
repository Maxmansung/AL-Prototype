<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/connection/db_conx.php");
class biomeTypeModel extends biomeType
{
    private function __construct($biomeModel)
    {
        $this->depth = intval($biomeModel['depth']);
        $this->value = $biomeModel['value'];
        $this->description = $biomeModel['description'];
        $this->descriptionLong = $biomeModel['descriptionLong'];
        $this->temperatureMod = intval($biomeModel['temperatureMod']);
        $this->findingChanceMod = intval($biomeModel['findingChanceMod']);
    }

    public static function getBiomeType($depth)
    {
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM BiomeType WHERE depth= :depth LIMIT 1');
        $req->execute(array(':depth' => $depth));
        $biomeModel = $req->fetch();
        return new biomeTypeModel($biomeModel);
    }

}