<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/deathCause.php");
require_once(PROJECT_ROOT."/MVC/model/deathCauseModel.php");
class deathCauseController extends deathCause
{


    public function __construct($causeID)
    {
        if ($causeID != ""){
            $deathModel = deathCauseModel::getCause($causeID);
            $this->key = $deathModel->key;
            $this->causeName = $deathModel->causeName;
            $this->description = $deathModel->description;
            $this->image = $deathModel->image;
        }
    }
}