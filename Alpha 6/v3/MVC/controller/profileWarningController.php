<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/profileWarning.php");
require_once(PROJECT_ROOT . "/MVC/model/profileWarningModel.php");
class profileWarningController extends profileWarning
{

    private function getWarningPoints($id){
        switch ($id){
            case 1:
                //Warning for bad language
                $this->setPoints(1);
                break;
            case 2:
                //Warning for aggressive behaviour
                $this->setPoints(2);
                break;
            case 3:
                //Warning for being Andre
                $this->setPoints(4);
                break;
            case 4:
                //Warning for other things
                $this->setPoints(0);
                break;
        }
    }

    public function __construct($id)
    {
        if ($id != ""){
            if (is_object($id)){
                $warningModel = $id;
            } else {
                $warningModel = profileWarningModel::findWarning($id);
            }
            $this->warningID = $warningModel->getWarningID();
            $this->profileID = $warningModel->getProfileID();
            $this->warningType = $warningModel->getWarningType();
            $this->reason = $warningModel->getReason();
            $this->points = $warningModel->getPoints();
            $this->active = $warningModel->getActive();
            $this->givenTimestamp = $warningModel->getGivenTimestamp();
            $this->profileGiven = $warningModel->getProfileGiven();
        }
    }

    public function insertWarning(){
        profileWarningModel::insertWarning($this,"Insert");
    }

    public function updateWarning(){
        profileWarningModel::insertWarning($this,"Update");
    }

    public static function getProfileWarnings($profileID){
        return profileWarningModel::getProfileWarnings($profileID);
    }

    public static function givePlayerWarning($profile,$warningProfile,$warningType,$warningReason){
        $profile->getProfileAccess();
        if ($profile->getAccessEditForum() === 1){
            $profileWarning = new profileController($warningProfile);
            if ($profileWarning->getProfileID() != ""){
                $warning = new profileWarningController("");
                $warning->setProfileID($profileWarning->getProfileID());
                $warningClean = intval(preg_replace(data::$cleanPatterns['num'],"",$warningType));
                $reasonClean = preg_replace(data::$cleanPatterns['special'],"",$warningReason);
                $warning->setWarningType($warningClean);
                $warning->getWarningPoints($warningType);
                $warning->setReason($reasonClean);
                $warning->setActive(1);
                $warning->setGivenTimestamp(time());
                $warning->setProfileGiven($profile->getProfileID());
                $warning->insertWarning();
                $list = profileWarningModel::getProfileWarnings($profileWarning->getProfileID());
                $total = 0;
                foreach ($list as $item){
                    $total += $item->getPoints();
                }
                modTrackingController::createNewTrack(10,$profile->getProfileID(),$profileWarning->getProfileID(),$warningClean,"","");
                $dataArray = array("name"=>$profileWarning->getProfileName(),"points"=>$total);
                return array("ALERT"=>1,"DATA"=>$dataArray);
            } else {
                return array("ERROR">37);
            }
        } else {
            return array("ERROR"=>28);
        }
    }

}