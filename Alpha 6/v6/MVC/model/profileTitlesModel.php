<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class profileTitles
    {

     protected $titleID;
     protected $titleText;

     private function __construct($titles)
     {
         $this->titleID = $titles['titleID'];
         $this->titleText = $titles['titleName'];
     }

    //This function finds a title by titleID
    public static function getTitle($titleID)
    {
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT titleText FROM profileTitles WHERE titleID= :titleID LIMIT 1');
        $req->bindParam(':titleID', $titleID);
        $req->execute();
        $titlesModel = $req->fetch();
        return $titlesModel['titleText'];
    }

    //This function converts the keys into a title
    public static function calculateTitle($playerStats){
         $title = self::topTitleCalc($playerStats);
         if (count($title)>1){
             $titleID = self::arrayTitle($title);
         } else {
             $titleID = self::singleTitle($title[0]);
         }
         return self::getTitle($titleID);
    }

    //This function calculates which title the player gets
    private static function topTitleCalc($playerStats)
    {
        $total = 0;
        foreach ($playerStats as $stat) {
            $total += $stat;
        }
        $favArray = [];
        $topArray = [];
        foreach ($playerStats as $key => $stat) {
            if ($stat / $total >= 0.36) {
                if ($stat / $total >= 0.51) {
                    array_push($topArray,$key);
                } else {
                    array_push($favArray,$key);
                }
            }
        }
        if (count($topArray)==1 && count($favArray)==1){
            $result = array_merge($topArray,$favArray);
            return $result;
        } elseif (count($favArray)>1){
            return $favArray;
        } elseif (count($topArray) == 1 && count($favArray)<1){
            return $topArray;
        } else{
            return array("none");
        }
    }

    //This function calculates the name based on an array
    private static function arrayTitle($titleArray){
        switch ($titleArray[0]){
            case "build":
                switch ($titleArray[1]){
                    case "search":
                        return "T007";
                        break;
                    case "move":
                        return "T006";
                        break;
                    case "break":
                        return "T009";
                        break;
                    case "research":
                        return "T012";
                        break;
                    default:
                        return "T999";
                        break;
                }
                break;
            case "search":
                switch ($titleArray[1]){
                    case "build":
                        return "T007";
                        break;
                    case "move":
                        return "T008";
                        break;
                    case "break":
                        return "T011";
                        break;
                    case "research":
                        return "T015";
                        break;
                    default:
                        return "T999";
                        break;
                }
                break;
            case "move":
                switch ($titleArray[1]){
                    case "build":
                        return "T006";
                        break;
                    case "search":
                        return "T008";
                        break;
                    case "break":
                        return "T010";
                        break;
                    case "research":
                        return "T013";
                        break;
                    default:
                        return "T999";
                        break;
                }
                break;
            case "break":
                switch ($titleArray[1]){
                    case "build":
                        return "T009";
                        break;
                    case "search":
                        return "T011";
                        break;
                    case "move":
                        return "T010";
                        break;
                    case "research":
                        return "T015";
                        break;
                    default:
                        return "T999";
                        break;
                }
                break;
            case "research":
                switch ($titleArray[1]){
                    case "build":
                        return "T012";
                        break;
                    case "search":
                        return "T013";
                        break;
                    case "move":
                        return "T014";
                        break;
                    case "break":
                        return "T015";
                        break;
                    default:
                        return "T999";
                        break;
                }
                break;
            default:
                return "T999";
                break;
        }
    }



    //This function calculates the name based on an array
    private static function singleTitle($title){
        switch ($title){
            case "none":
                return "T000";
                break;
            case "build":
                return "T001";
                break;
            case "move":
                return "T002";
                break;
            case "search":
                return "T003";
                break;
            case "break":
                return "T004";
                break;
            case "research":
                return "T005";
                break;
            default:
                return "T999";
                break;
        }
    }

}