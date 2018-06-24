<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/shrineActions.php");
require_once(PROJECT_ROOT."/MVC/model/shrineActionsModel.php");
class shrineActionsController extends shrineActions
{

    function __construct($id)
    {
        if ($id != "") {
            if (is_object($id)) {
                $actionModel = $id;
            } else {
                $actionModel = shrineActionsModel::getSingleAction($id);
            }
            $this->worshipID = $actionModel->getWorshipID();
            $this->avatar = $actionModel->getAvatar();
            $this->profileName = $actionModel->getProfileName();
            $this->partyID = $actionModel->getPartyID();
            $this->partyName = $actionModel->getPartyName();
            $this->mapID = $actionModel->getMapID();
            $this->currentDay = $actionModel->getCurrentDay();
            $this->shrineType = $actionModel->getShrineType();
            $this->worshipTime = $actionModel->getWorshipTime();
        }
    }

    public static function createNewWorship($avatar,$party,$shrine){
        $action = new shrineActionsController("");
        $action->setAvatar($avatar->getAvatarID());
        $action->setProfileName($avatar->getProfileID());
        $action->setPartyID($party->getPartyID());
        $action->setPartyName($party->getPartyName());
        $action->setMapID($avatar->getMapID());
        $action->setCurrentDay($avatar->getCurrentDay());
        $action->setShrineType($shrine->getShrineID());
        $action->setWorshipTime(time());
        $action->insertAction();
    }

    public function insertAction(){
        shrineActionsModel::insertAction($this,"Insert");
    }

    public function updateAction(){
        shrineActionsModel::insertAction($this,"Update");
    }

    public function deleteAction(){
        shrineActionsModel::deleteAction($this->getWorshipID());
    }

    public static function getMapTributes($mapID,$day){
        return shrineActionsModel::getMapActions($mapID,$day);
    }

    public static function checkFavour($identifier,$currentDay,$type){
        $array = [];
        $list = [];
        switch ($type){
            case 1:
                $array = shrineType::$soloShrines;
                $list = shrineActionsModel::getPlayerActions($identifier,$currentDay);
                break;
            case 2:
                $array = shrineType::$teamShrines;
                $list = shrineActionsModel::getPartyActions($identifier,$currentDay);
                break;
            case 3:
                $array = shrineType::$mapShrines;
                $list = shrineActionsModel::getPlayerActions($identifier,$currentDay);
                break;
        }
        $check = false;
        foreach ($list as $action){
            if (in_array($action->getShrineType(),$array)){
                $check = true;
            }
        }
        return $check;
    }

    public static function deleteSoloFavour($avatarID,$currentDay){
        $array = shrineType::$soloShrines;
        foreach ($array as $type){
            shrineActionsModel::deleteShrineActions($avatarID,$type,$currentDay);
        }
    }

    public static function deleteTeamFavour($partyID,$currentDay){
        $array = shrineType::$teamShrines;
        foreach ($array as $type){
            shrineActionsModel::deleteShrineActionsParty($partyID,$type,$currentDay);
        }
    }
}