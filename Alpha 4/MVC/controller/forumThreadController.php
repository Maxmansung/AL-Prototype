<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/forumThread.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/profileController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/partyZonePlayerController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/forumCatagoriesController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/model/forumThreadModel.php");
class forumThreadController extends forumThread
{

    public function __construct($name,$tableName)
    {
        if ($name != ""){
            $this->tableName = $tableName;
            $threadModel = forumThreadModel::getThread($name,$tableName);
            $this->threadID = $threadModel->threadID;
            $this->threadDefinition = $threadModel->threadDefinition;
            $this->threadTitle = $threadModel->threadTitle;
            $this->creatorID = $threadModel->creatorID;
            $this->posts = $threadModel->posts;
            $this->lastUpdate = $threadModel->lastUpdate;
            $this->lastPostBy = $threadModel->lastPostBy;
        }
    }

    private static function getAllThreadsType($definition,$table,$avatarTrue,$profile){
        $array = forumThreadModel::getAllThreads($definition,$table);
        $finalArray = [];
        foreach ($array as $thread){
            $temp = new forumThreadController($thread['threadID'],$table);
            if ($avatarTrue == true){
                $partyZone = partyZonePlayerController::getSinglePlayerDetails($temp->getCreatorID(),$profile->getAvatar());
                if ($partyZone->getAvatarID() != "") {
                    $avatar = new avatarController($temp->getCreatorID());
                    $temp->setCreatorID($avatar->getProfileID());
                } else{
                    $temp->setCreatorID("Unknown");
                }
            }
            $finalArray[$temp->getLastUpdate()] = $temp->returnVars();
        }
        return $finalArray;
    }


    public static function getAllThreads($tableDefinition,$profileID)
    {
        $profile = new profileController($profileID);
        switch ($tableDefinition){
            case "mc":
                $avatar = new avatarController($profile->getAvatar());
                $map = new mapController($avatar->getMapID());
                $threads = self::getAllThreadsType($avatar->getMapID(),"forumThreadsMap",true,$profile);
                $response = ["threads"=>$threads,"title"=>$map->getName()];
                break;
            case "pc":
                $avatar = new avatarController($profile->getAvatar());
                $party = new partyController($avatar->getPartyID());
                $threads = self::getAllThreadsType($avatar->getPartyID(),"forumThreadsParty",true,$profile);
                $response = ["threads"=>$threads,"title"=>$party->getPartyName()];
                break;
            default:
                $category = new forumCatagoriesController($tableDefinition);
                $threads = self::getAllThreadsType($tableDefinition,"forumThreadsGeneral",false,$profile);
                $response = ["threads"=>$threads,"title"=>$category->getCatagoryName()];
                break;
        }
        return $response;
    }

    public function insertThread(){
        forumThreadModel::insertForumThread($this,"Insert");
    }

    public function updateThread(){
        forumThreadModel::insertForumThread($this,"Update");
    }

    public static function createNewThread($tableDefinition,$profileID,$threadName){
        $profile = new profileController($profileID);
        $threadName = htmlentities($threadName,ENT_QUOTES | ENT_SUBSTITUTE);
        switch ($tableDefinition){
            case "mc":
                $threadID = self::newMapThread($profile->getAvatar(),$threadName);
                break;
            case "pc":
                $threadID = self::newPartyThread($profile->getAvatar(),$threadName);
                break;
            default:
                $threadID = self::newGeneralThread($profileID,$threadName,$tableDefinition);
                break;
        }
        return $threadID;
    }

    private static function newPartyThread($avatarID,$threadName){
        $avatar = new avatarController($avatarID);
        $thread = new forumThreadController("","");
        $thread->tableName = "forumThreadsParty";
        $thread->threadDefinition = $avatar->getPartyID();
        $thread->threadTitle = $threadName;
        $thread->creatorID = $avatar->getAvatarID();
        $thread->posts = 0;
        $thread->lastUpdate = time();
        $thread->threadID = forumThreadModel::createThreadID($thread->tableName);
        $thread->insertThread();
        return $thread->threadID;
    }

    private static function newMapThread($avatarID,$threadName){
        $avatar = new avatarController($avatarID);
        $thread = new forumThreadController("","");
        $thread->tableName = "forumThreadsMap";
        $thread->threadDefinition = $avatar->getMapID();
        $thread->threadTitle = $threadName;
        $thread->creatorID = $avatar->getAvatarID();
        $thread->posts = 0;
        $thread->lastUpdate = time();
        $thread->threadID = forumThreadModel::createThreadID($thread->tableName);
        $thread->insertThread();
        return $thread->threadID;
    }

    private static function newGeneralThread($profileID,$threadName,$category){
        $profile = new profileController($profileID);
        $thread = new forumThreadController("","");
        $thread->tableName = "forumThreadsGeneral";
        $thread->threadDefinition = $category;
        $thread->threadTitle = $threadName;
        $thread->creatorID = $profile->getProfileID();
        $thread->posts = 0;
        $thread->lastUpdate = time();
        $thread->threadID = forumThreadModel::createThreadID($thread->tableName);
        $thread->insertThread();
        return $thread->threadID;
    }

    public static function checkThread($threadTitle,$length){
        if (strlen($threadTitle)>50){
            return array("ERROR"=>43);
        } elseif (strlen($threadTitle)<4){
            return array("ERROR"=>44);
        } elseif (intval($length) < 10) {
            return array("ERROR"=>46);
        } else {
            return array("SUCCESS"=>true);
        }
    }
}