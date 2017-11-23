<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/forumPost.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/profileController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/forumThreadController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/partyZonePlayerController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/model/forumPostModel.php");
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
            if ($avatarTrue == true) {
                $profile = new profileController($personalProfile);
                $partyZone = partyZonePlayerController::getSinglePlayerDetails($temp->getCreatorID(),$profile->getAvatar());
                if ($partyZone->getAvatarID() != "") {
                    $profile = new profileController($partyZone->getAvatarName());
                    $temp->setCreatorID($profile->getProfileID());
                    $temp->setAvatarImage($profile->getProfilePicture());
                } else {
                    $temp->setCreatorID("Unknown");
                    $temp->setAvatarImage("Unknown.png");
                }
            } else {
                $profile = new profileController($temp->getCreatorID());
                $temp->setAvatarImage($profile->getProfilePicture());
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
                $threads = self::getAllPostsThread($threadID,"forumPostsParty",true,$personalProfile);
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

    public static function createNewPost($tableDefinition,$profileID,$postText,$threadID){
        if (strlen($postText) < 10){
            $postID = array("ERROR"=>46);
        } else {
            $profile = new profileController($profileID);
            if (strlen($postText) > 5000) {
                $postText = substr($postText, 0, 5000);
            }
            $postText = htmlentities($postText, ENT_QUOTES | ENT_SUBSTITUTE);
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
        return array("PostID"=>$post->getPostID());
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
        return array("PostID"=>$post->getPostID());
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
        return array("PostID"=>$post->getPostID());
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
            $date = date("g:Ha",$this->getPostDate());
            $date .="<br/>".date("jS M",$this->getPostDate());
            return $date;
        }
    }

}