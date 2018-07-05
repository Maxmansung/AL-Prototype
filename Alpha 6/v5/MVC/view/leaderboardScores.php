<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class leaderboardScores
{
    protected $position;
    protected $profile;
    protected $profileID;
    protected $score;
    protected $type;
    protected $avatar;

    private function __construct($profileID,$shrineScore,$position,$profileName,$picture)
    {
        $this->position = intval($position);
        $this->profile = $profileName;
        $this->profileID = intval($profileID);
        $this->score = intval($shrineScore);
        $this->avatar = $picture;
    }

    public function returnVars(){
        return get_object_vars($this);
    }

    public static function getScoresType($type){
        $typeClean = intval(preg_replace(data::$cleanPatterns['num'], '', $type));
        switch ($typeClean){
            case 1:
                $name  = "soloLeaderboard";
                break;
            case 2:
                $name  = "teamLeaderboard";
                break;
            case 3:
                $name  = "fullLeaderboard";
                break;
            default:
                return array("ERROR"=>"Incorrect leaderboard type");
                break;
        }
        $list = profileDetailsModel::getAllShrineScores($name);
        $finalArray = [];
        $counter = 1;
        foreach ($list as $profile) {
            if ($profile[$name] > 0) {
                $temp = new leaderboardScores($profile['profileID'], $profile[$name], $counter, $profile['profileName'],$profile['profilePicture']);
                $finalArray[$counter] = $temp->returnVars();
                $counter++;
            }
        }
        return $finalArray;
    }
}