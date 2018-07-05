<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class biome9 extends biomeType
{

    function __construct()
    {
        $this->depth = 9;
        $this->value = "Ashfield";
        $this->description = "All that's left is ash and destruction";
        $this->descriptionLong = "Ash fields are created from the leftover destruction of a god, either from the hot springs or a volcano";
        $this->temperatureMod = 5;
        $this->findingChanceMod = 1;
        $this->finalType = 0;
        $this->biomeImage = "ash";
        $this->biomeItems = [5];
        $this->depletedTo = 3;
    }
}