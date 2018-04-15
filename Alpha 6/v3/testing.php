<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/ajax_php/ajax_MVC.php");
$testing = new profileDetailsController(1);
echo json_encode($testing->returnVars());