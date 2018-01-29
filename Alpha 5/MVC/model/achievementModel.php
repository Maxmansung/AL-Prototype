<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class achievementModel extends achievement
{
    private function __construct($achivementModel)
    {
        $this->achievementID = $achivementModel['achievementID'];
        $this->name = $achivementModel['name'];
        $this->description = $achivementModel['description'];
        $this->icon = $achivementModel['icon'];
        $this->scoreAdjustment = $achivementModel['scoreAdjustment'];
    }

    public static function findAchievement($achievementID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM Achievement WHERE achievementID= :achievementID LIMIT 1');
        $req->execute(array(':achievementID' => $achievementID));
        $achivementModel = $req->fetch();
        return new achievementModel($achivementModel);
    }
}