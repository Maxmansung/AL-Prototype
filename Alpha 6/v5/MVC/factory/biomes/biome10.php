<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class biome10 extends biomeType
{

    function __construct()
    {
        $this->depth = 10;
        $this->value = "Cave";
        $this->description = "Something or someone has created this cave, it seems ideal to hide in";
        $this->descriptionLong = "This cave is the ideal place to hide, the chances of finding something this good are so samall!";
        $this->temperatureMod = 15;
        $this->findingChanceMod = -1;
        $this->finalType = 1;
        $this->biomeImage = "cave";
        $this->biomeItems = [5];
        $this->depletedTo = 0;
    }
}