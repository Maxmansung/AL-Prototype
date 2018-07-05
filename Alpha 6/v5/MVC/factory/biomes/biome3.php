<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class biome3 extends biomeType
{

    function __construct()
    {
        $this->depth = 3;
        $this->value = "Scrubland";
        $this->description = "Low spiny bushes cover the ground";
        $this->descriptionLong = "Detailed description of the scrubland goes here";
        $this->temperatureMod = 2;
        $this->findingChanceMod = 2;
        $this->finalType = 0;
        $this->biomeImage = "scrub";
        $this->biomeItems = [1,1,12,2,18,15];
        $this->depletedTo = 2;
    }
}