<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT."/MVC/controller/achievement.php");
require_once(PROJECT_ROOT."/MVC/model/achievementModel.php");
class achievementController extends achievement
{
    public function __construct($id)
    {
        if ($id != ""){
            $achievement = achievementModel::findAchievement($id);
            $this->achievementID = $achievement->achievementID;
            $this->name = $achievement->name;
            $this->description = $achievement->description;
            $this->icon = $achievement->icon;
            $this->scoreAdjustment = $achievement->scoreAdjustment;
        }
    }



    public static function getAchievements($achievementList)
    {
        $achievementArray = [];
        foreach ($achievementList as $key => $count) {
            $achievement = new achievementController($key);
            $achievementArray[$achievement->getAchievementID()] = ["details"=>$achievement->returnVars(),"count"=>$count];
        }
        return $achievementArray;
    }

    public static function getAchievementScore($achievementList)
    {
        $totalScore = 0;
        foreach ($achievementList as $key => $count) {
            $achievement = new achievementController($key);
            $totalScore+=(($achievement->getScoreAdjustment()*$count)/10);
        }
        return $totalScore;
    }

    public static function checkAchievement($type){
        switch ($type){
            case "R0010":
                $response = "A007";
                break;
            default:
                $response = false;
                break;
        }
        return $response;
    }
}