<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/forumPost.php");
require_once(PROJECT_ROOT."/MVC/model/forumPostModel.php");
class forumPostController extends forumPost
{
    protected $avatarImage;
    protected $timeFormat;

    function getAvatarImage(){
        return $this->avatarImage;
    }

    function setAvatarImage($var){
        $this->avatarImage = $var;
    }

    public function __construct($name,$tableName)
    {
        if ($name != ""){
            $this->tableName = $tableName;
            $threadModel = forumPostModel::getPost($name,$tableName);
            $this->postID = $threadModel->postID;
            $this->creatorID = $threadModel->creatorID;
            $this->postDate = $threadModel->postDate;
            $this->editable = $threadModel->editable;
            $this->postText = $threadModel->postText;
            $this->threadID = $threadModel->threadID;
            $this->postCount = $threadModel->postCount;
            $this->timeFormat = $this->makeTime();
        }
    }

    private static function getAllPostsThread($threadID,$table,$avatarTrue,$personalProfile){
        $array = forumPostModel::getAllPosts($threadID,$table);
        $finalArray = [];
        foreach ($array as $post) {
            $temp = new forumPostController($post['postID'], $table);
            $profile = new profileController($personalProfile);
            if ($avatarTrue !== false) {
                $avatar = new avatarController($profile->getAvatar());
                if ($avatarTrue === true) {
                    if (in_array($temp->getPostID(), $avatar->getForumPosts())) {
                        $avatar->removeForumPosts($temp->getPostID());
                        $avatar->updateAvatar();
                        $temp->setNewPost(true);
                    } else {
                        $temp->setNewPost(false);
                    }
                } else if ($avatarTrue === "party"){

                }
                $partyZone = partyZonePlayerController::getSinglePlayerDetails($temp->getCreatorID(),$profile->getAvatar());
                if ($partyZone->getAvatarID() != "") {
                    $profilePlayer = new profileController($partyZone->getAvatarName());
                    $temp->setCreatorID($profilePlayer->getProfileID());
                    $temp->setAvatarImage($profilePlayer->getProfilePicture());
                } else {
                    $temp->setCreatorID("Unknown");
                    $temp->setAvatarImage("Unknown.png");
                }
            } else {
                if (in_array($temp->getPostID(),$profile->getForumPosts())){
                    $profile->removeForumPosts($temp->getPostID());
                    $profile->uploadProfile();
                    $temp->setNewPost(true);
                } else {
                    $temp->setNewPost(false);
                }
                $profilePlayer = new profileController($temp->getCreatorID());
                if ($profilePlayer->getProfilePicture() != null) {
                    $temp->setAvatarImage($profilePlayer->getProfilePicture());
                } else {
                    $temp->setAvatarImage("generic.png");
                }
            }
            $finalArray[$temp->getPostCount()] = $temp->returnVars();
        }
        return $finalArray;
    }


    public static function getAllPosts($tableDefinition,$threadID,$personalProfile)
    {
        switch ($tableDefinition){
            case "mc":
                $thread = new forumThreadController($threadID,"forumThreadsMap");
                $threads = self::getAllPostsThread($threadID,"forumPostsMap",true,$personalProfile);
                $response = ["threads"=>$threads,"title"=>$thread->getThreadTitle()];
                break;
            case "pc":
                $thread = new forumThreadController($threadID,"forumThreadsParty");
                $threads = self::getAllPostsThread($threadID,"forumPostsParty","party",$personalProfile);
                $response = ["threads"=>$threads,"title"=>$thread->getThreadTitle()];
                break;
            default:
                $thread = new forumThreadController($threadID,"forumThreadsGeneral");
                $threads = self::getAllPostsThread($threadID,"forumPostsGeneral",false,$personalProfile);
                $response = ["threads"=>$threads,"title"=>$thread->getThreadTitle()];
                break;
        }
        return $response;
    }

    public function insertPost(){
        forumPostModel::insertForumPost($this,"Insert");
    }

    public function updatePost(){
        forumPostModel::insertForumPost($this,"Update");
    }

    public static function checkPostError($postText){
        if (strlen($postText) < 10) {
            return array("ERROR" => 46);
        }else if (strlen($postText) > 5000) {
            $postText = substr($postText, 0, 5000);
            $postText = htmlentities($postText, ENT_QUOTES | ENT_SUBSTITUTE);
            return $postText;
        } else {
            $postText = htmlentities($postText, ENT_QUOTES | ENT_SUBSTITUTE);
            return $postText;
        }
    }

    public static function createNewPost($tableDefinition,$profileID,$postText,$threadID){
        if (strlen($postText) < 10){
            $postID = array("ERROR"=>46);
        } else {
            $profile = new profileController($profileID);
            if (strlen($postText) > 5000) {
                $postText = substr($postText, 0, 5000);
            }
            $postText = htmlspecialchars($postText, ENT_QUOTES);
            switch ($tableDefinition) {
                case "mc":
                    $thread = new forumThreadController($threadID, "forumThreadsMap");
                    $avatar = new avatarController($profile->getAvatar());
                    if ($avatar->getMapID() == $thread->getThreadDefinition()) {
                        $postID = self::newMapPost($profile->getAvatar(), $postText, $threadID);
                    } else {
                        $postID = array("ERROR" => 45);
                    }
                    break;
                case "pc":
                    $thread = new forumThreadController($threadID, "forumThreadsParty");
                    $avatar = new avatarController($profile->getAvatar());
                    if ($avatar->getPartyID() == $thread->getThreadDefinition()) {
                        $postID = self::newPartyPost($profile->getAvatar(), $postText, $threadID);
                    } else {
                        $postID = array("ERROR" => 45);
                    }
                    break;
                default:
                    $postID = self::newGeneralPost($profileID, $postText, $threadID);
                    break;
            }
        }
        return $postID;
    }

    private static function newPartyPost($avatarID,$postText,$threadID){
        $avatar = new avatarController($avatarID);
        $post = new forumPostController("","");
        $post->tableName = "forumPostsParty";
        $post->postID = forumPostModel::createThreadID($post->tableName);
        $post->creatorID = $avatar->getAvatarID();
        $post->postDate = time();
        $post->editable = 1;
        $post->postText = $postText;
        $post->threadID = $threadID;
        $thread = new forumThreadController($threadID,"forumThreadsParty");
        $post->postCount = $thread->getPosts();
        $post->insertPost();
        $thread->increasePosts();
        $thread->setLastUpdate(time());
        $thread->updateThread();
        return array("ALERT"=>15,"DATA"=>$post->getPostID());
    }

    private static function newMapPost($avatarID,$postText,$threadID){
        $avatar = new avatarController($avatarID);
        $post = new forumPostController("","");
        $post->tableName = "forumPostsMap";
        $post->postID = forumPostModel::createThreadID($post->tableName);
        $post->creatorID = $avatar->getAvatarID();
        $post->postDate = time();
        $post->editable = 1;
        $post->postText = $postText;
        $post->threadID = $threadID;
        $thread = new forumThreadController($threadID,"forumThreadsMap");
        $post->postCount = $thread->getPosts();
        $post->insertPost();
        $thread->increasePosts();
        $thread->setLastUpdate(time());
        $thread->updateThread();
        avatarController::addNewPostsMap($avatar->getMapID(),$post->getPostID());
        $avatar->removeForumPosts($post->getPostID());
        $avatar->updateAvatar();
        return array("ALERT"=>15,"DATA"=>$post->getPostID());
    }

    private static function newGeneralPost($profileID,$postText,$threadID){
        $post = new forumPostController("","");
        $post->tableName = "forumPostsGeneral";
        $post->postID = forumPostModel::createThreadID($post->tableName);
        $post->creatorID = $profileID;
        $post->postDate = time();
        $post->editable = 1;
        $post->postText = $postText;
        $post->threadID = $threadID;
        $thread = new forumThreadController($threadID,"forumThreadsGeneral");
        $post->postCount = $thread->getPosts();
        $post->insertPost();
        $thread->increasePosts();
        $thread->setLastUpdate(time());
        $thread->updateThread();
        profileController::addNewPostProfiles($post->getPostID());
        $profile = new profileController($profileID);
        $profile->removeForumPosts($post->getPostID());
        $profile->uploadProfile();
        return array("ALERT"=>15,"DATA"=>$post->getPostID());
    }

    function makeTime(){
        $difference = time()-$this->postDate;
        if ($difference < 60){
            return "< 1 minute";
        } else if ($difference < 3600){
            $date = floor($difference/60);
            return $date." minutes ago";
        } else if ($difference < 86400){
            $date = floor($difference/3600);
            return $date." hours ago";
        } else {
            $date =date("jS M",$this->getPostDate());
            $date .=" at ".date("G:H",$this->getPostDate());
            return $date;
        }
    }

    public static function getProfilePostThreadsArray($postArray){
        $newArray = [];
        foreach ($postArray as $postID){
            $tempPost = new forumPostController($postID,"forumPostsGeneral");
            if (!in_array($tempPost->getThreadID(),$newArray)){
                array_push($newArray,$tempPost->getThreadID());
            }
        }
        return $newArray;
    }

    public static function getAvatarPostThreadsArray($postArray){
        $newArray = [];
        foreach ($postArray as $postID){
            $tempPost = new forumPostController($postID,"forumPostsMap");
            if (!in_array($tempPost->getThreadID(),$newArray)){
                array_push($newArray,$tempPost->getThreadID());
            }
        }
        return $newArray;
    }


    public static function convertCodeTable($tableID){
        switch ($tableID){
            case "mc":
                return "forumPostsMap";
                break;
            case "pc":
                return "forumPostsParty";
                break;
            default:
                return "forumPostsGeneral";
                break;
        }

    }

}