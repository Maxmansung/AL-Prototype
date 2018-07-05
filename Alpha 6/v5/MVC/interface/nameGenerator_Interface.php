<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
interface nameGenerator_Interface
{

    function getType();
    function setType($var);
    function getFirstName();
    function setFirstName($var);
    function getMiddleName();
    function setMiddleName($var);
    function getLastName();
    function setLastName($var);

}