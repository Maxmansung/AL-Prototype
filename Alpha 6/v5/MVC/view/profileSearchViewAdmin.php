<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class profileSearchViewAdmin
{

    protected $profile;
    protected $profileID;
    protected $profileImage;
    protected $login;
    protected $warningPoints;
    protected $accountType;
    protected $lifeTimeWarnings;

    public function __construct($profileController)
    {
        $this->profile = $profileController->getProfileName();
        $this->profileID = $profileController->getProfileID();
        $this->profileImage = $profileController->getProfilePicture();
        $tempLogin = intval($profileController->getLastLogin());
        $this->login = date("j-M",$tempLogin);
        $this->accountType = $profileController->getAccountType();
        $this->createWarningRecord();
    }

    function returnVars(){
        return get_object_vars($this);
    }

    private function createWarningRecord(){
        $finalScore = 0;
        $totalCount = 0;
        $list = profileWarningController::getProfileWarnings($this->profileID);
        foreach ($list as $warning){
            $totalCount++;
            if ($warning->getActive() === 1){
                $finalScore += $warning->getPoints();
            }
        }
        $this->warningPoints = $finalScore;
        $this->lifeTimeWarnings = $totalCount;
    }

    public static function searchSpiritResults($name,$profileController)
    {
        $profileController->getProfileAccess();
        $finalArray = [];
        if ($profileController->getAccessEditUsers() === 1) {
            $nameClean = preg_replace('#[^A-Za-z0-9]#i', '', $name);
            $nameArray = profileModel::findAllProfiles($nameClean,10);
            foreach ($nameArray as $profile) {
                $player = new profileSearchViewAdmin($profile);
                $finalArray[$player->profileID] = $player->returnVars();
            }
        }
        return $finalArray;
    }
}