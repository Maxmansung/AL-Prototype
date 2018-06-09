<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class biome4 extends biomeType
{

    function __construct()
    {
        $this->depth = 4;
        $this->value = "Forest";
        $this->description = "A sparse forest of thin and barren trees";
        $this->descriptionLong = "Writing about the forest in more detail should be written here";
        $this->temperatureMod = 3;
        $this->findingChanceMod = 4;
        $this->finalType = 0;
        $this->biomeImage = "forest";
        $this->biomeItems = [1,1,12,12,15];
    }
}