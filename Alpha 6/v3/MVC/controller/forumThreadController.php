<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/forumThread.php");
require_once(PROJECT_ROOT."/MVC/model/forumThreadModel.php");
class forumThreadController extends forumThread
{
    static $perPage = 10;
    protected $dateFormat = "";

    function getDateFormat(){
        return $this->dateFormat;
    }

    function setDateFormat($var){
        $this->dateFormat = $var;
    }

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
            $this->stickyThread = $threadModel->stickyThread;
            $this->dateFormat = $this->makeTime();
        }
    }

    private static function getAllThreadsType($definition,$table,$avatarTrue,$profile,$count,$sticky){
        if ($sticky === true){
            $array = forumThreadModel::getAllThreadsSticky($definition,$table);
        }else {
            $array = forumThreadModel::getAllThreads($definition,$table);
            $counter = 0;
            if ($count == 0){
                foreach ($array as $thread){
                    $counter++;
                }
                $count = ceil($counter/forumThreadController::$perPage);
                $counter = 0;
            }
        }
        $finalArray = [];
        $newArray = [];
        $minPage = forumThreadController::$perPage * ($count-1);
        $maxPage = $minPage + forumThreadController::$perPage;
        foreach ($array as $thread){
            $access = true;
            if ($sticky === false) {
                $access = false;
                if ($counter >= $minPage && $counter < $maxPage) {
                    $access = true;
                }
            }
            if ($access === true){
                $temp = new forumThreadController($thread['threadID'], $table);
                $postTable = str_replace("Threads", "Posts", $table);
                $reply = forumPostModel::getMostRecentPost($temp->getThreadID(), $postTable);
                if ($avatarTrue !== false) {
                    if ($avatarTrue === true) {
                        $avatar = new avatarController($profile->getAvatar());
                        $newArray = forumPostController::getAvatarPostThreadsArray($avatar->getForumPosts());
                    } else if ($avatarTrue === "party") {

                    }
                    $avatar = new avatarController($profile->getAvatar());
                    $party = new partyController($avatar->getPartyID());
                    if (in_array($temp->getCreatorID(), $party->getMembers()) == true) {
                        $avatar = new avatarController($temp->getCreatorID());
                        $temp->setCreatorID($avatar->getProfileID());
                    } else {
                        $temp->setCreatorID("Unknown");
                    }
                } else {
                    $newArray = forumPostController::getProfilePostThreadsArray($profile->getForumPosts());
                }
                if (in_array($temp->getThreadID(), $newArray)) {
                    $temp->setNewPost(true);
                } else {
                    $temp->setNewPost(false);
                }
                $temp->setLastPostBy($reply);
                $finalArray[$temp->getLastUpdate()] = $temp->returnVars();
            }
            if ($sticky === false) {
                $counter++;
            }
        }
        if ($sticky === false) {
            $finalArray["count"] = $counter;
        }
        return $finalArray;
    }


    public static function getAllThreads($tableDefinition,$count,$profile)
    {
        switch ($tableDefinition){
            case "mc":
                $avatar = new avatarController($profile->getAvatar());
                $threads = self::getAllThreadsType($avatar->getMapID(),"forumThreadsMap",true,$profile,$count,false);
                $threadsStick = self::getAllThreadsType($avatar->getMapID(),"forumThreadsMap",true,$profile,$count,true);
                $final = array_merge($threads,$threadsStick);
                $final["maxThreads"] = forumThreadController::$perPage;
                $response = $final;
                break;
            case "pc":
                $avatar = new avatarController($profile->getAvatar());
                $threads = self::getAllThreadsType($avatar->getPartyID(),"forumThreadsParty","party",$profile,$count,false);
                $threadsStick = self::getAllThreadsType($avatar->getPartyID(),"forumThreadsParty","party",$profile,$count,true);
                $final = array_merge($threads,$threadsStick);
                $final["maxThreads"] = forumThreadController::$perPage;
                $response = $final;
                break;
            default:
                $threads = self::getAllThreadsType($tableDefinition,"forumThreadsGeneral",false,$profile,$count,false);
                $threadsStick = self::getAllThreadsType($tableDefinition,"forumThreadsGeneral",false,$profile,$count,true);
                $final = array_merge($threads,$threadsStick);
                $final["maxThreads"] = forumThreadController::$perPage;
                $response = $final;
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

    public static function createNewThread($tableDefinition,$profile,$threadName,$sticky){
        $threadName = htmlentities($threadName,ENT_QUOTES | ENT_SUBSTITUTE);
        switch ($tableDefinition){
            case "mc":
                $threadID = self::newMapThread($profile->getAvatar(),$threadName,$sticky);
                break;
            case "pc":
                $threadID = self::newPartyThread($profile->getAvatar(),$threadName,$sticky);
                break;
            default:
                $threadID = self::newGeneralThread($profile,$threadName,$tableDefinition,$sticky);
                break;
        }
        return $threadID;
    }

    private static function newPartyThread($avatarID,$threadName,$sticky){
        $avatar = new avatarController($avatarID);
        $thread = new forumThreadController("","");
        $thread->tableName = "forumThreadsParty";
        $thread->threadDefinition = $avatar->getPartyID();
        $thread->threadTitle = $threadName;
        $thread->creatorID = $avatar->getAvatarID();
        $thread->posts = 0;
        $thread->lastUpdate = time();
        $thread->stickyThread = $sticky;
        $thread->threadID = forumThreadModel::createThreadID($thread->tableName);
        $thread->insertThread();
        return $thread->threadID;
    }

    private static function newMapThread($avatarID,$threadName,$sticky){
        $avatar = new avatarController($avatarID);
        $thread = new forumThreadController("","");
        $thread->tableName = "forumThreadsMap";
        $thread->threadDefinition = $avatar->getMapID();
        $thread->threadTitle = $threadName;
        $thread->creatorID = $avatar->getAvatarID();
        $thread->posts = 0;
        $thread->lastUpdate = time();
        $thread->stickyThread = $sticky;
        $thread->threadID = forumThreadModel::createThreadID($thread->tableName);
        $thread->insertThread();
        return $thread->threadID;
    }

    private static function newGeneralThread($profile,$threadName,$category,$sticky){
        $thread = new forumThreadController("","");
        $thread->tableName = "forumThreadsGeneral";
        $thread->threadDefinition = $category;
        $thread->threadTitle = $threadName;
        $thread->creatorID = $profile->getProfileName();
        $thread->posts = 0;
        $thread->lastUpdate = time();
        $thread->stickyThread = $sticky;
        $thread->threadID = forumThreadModel::createThreadID($thread->tableName);
        $thread->insertThread();
        return $thread->threadID;
    }

    public static function checkThread($threadTitle,$postText,$tableDefinition,$type,$sticky,$profile)
    {
        $profile->getProfileAccess();
        $title = preg_replace('#[^A-Za-z0-9 !?\-_()@:,."]#i', '',$threadTitle);
        if ($profile->getAccessEditForum()===0){
            $stickyFinal = 0;
        } else {
            $stickyFinal = intval(preg_replace(data::$cleanPatterns['num'],"",$sticky));
        }
        if($title != $threadTitle){
            return array("ERROR"=>"Dont use special chars");
        } elseif (strlen($title) > 50) {
            return array("ERROR" => 43);
        } elseif (strlen($title) < 4) {
            return array("ERROR" => 44);
        }
        $postFinalText = forumPostController::checkPostError($postText);
        if (is_array($postFinalText)){
            return $postFinalText;
        } else {
            $threadID = forumThreadController::createNewThread($tableDefinition,$profile,$title,$stickyFinal);
            $postID = forumPostController::createNewPost($tableDefinition,$profile,$postFinalText,$threadID);
            $postID["ALERT"] = 16;
            return $postID;
        }

    }

    function makeTime(){
        $difference = time()-$this->lastUpdate;
        if ($difference < 60){
            return "< 1 minute";
        } else if ($difference < 3600){
            $date = floor($difference/60);
            return $date." minutes ago";
        } else if ($difference < 86400){
            $date = floor($difference/3600);
            return $date." hours ago";
        } else {
            $date =date("jS M",$this->lastUpdate);
            return $date;
        }
    }
}