<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class forumPostModel extends forumPost
{

    private function __construct($postModel)
    {
        $this->postID = intval($postModel['postID']);
        $this->creatorID = $postModel['creatorID'];
        $this->postDate = intval($postModel['postDate']);
        $this->editable = $postModel['editable'];
        $this->postText = $postModel['postText'];
        $this->threadID = intval($postModel['threadID']);
        $this->postCount = intval($postModel['postCount']);
    }

    public static function insertForumPost($postController,$type){
        $table = $postController->getTableName();
        $postID = intval($postController->getPostID());
        $creatorID = $postController->getCreatorID();
        $postDate = intval($postController->getPostDate());
        $editable = $postController->getEditable();
        $postText = $postController->getPostText();
        $threadID = intval($postController->getThreadID());
        $postCount = intval($postController->getPostCount());
        $db = db_conx::getInstance();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO ".$table." (postID, creatorID, postDate, editable, postText, threadID, postCount) VALUES (:postID, :creatorID, :postDate, :editable, :postText, :threadID, :postCount)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE ".$table." SET creatorID= :creatorID, postDate= :postDate, editable= :editable, postText= :postText, threadID= :threadID, postCount= :postCount WHERE postID= :postID");
        }
        $req->bindParam(':postID', $postID);
        $req->bindParam(':creatorID', $creatorID);
        $req->bindParam(':postDate', $postDate);
        $req->bindParam(':editable', $editable);
        $req->bindParam(':postText', $postText);
        $req->bindParam(':threadID', $threadID);
        $req->bindParam(':postCount', $postCount);
        $req->execute();
    }

    public static function getPost($name,$table)
    {
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM '.$table.' WHERE postID= :postID');
        $req->execute(array('postID' => $name));
        $postModel = $req->fetch();
        return new forumPostModel($postModel);
    }

    public static function getAllPosts($threadID,$table){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT postID FROM '.$table.' WHERE threadID= :threadID');
        $req->execute(array('threadID' => $threadID));
        $postIDArray = $req->fetchAll();
        return $postIDArray;

    }

    public static function getMostRecentPost($threadID,$table){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT creatorID FROM '.$table.' WHERE threadID= :threadID ORDER BY postID DESC LIMIT 1');
        $req->execute(array('threadID' => $threadID));
        $postIDArray = $req->fetch();
        return $postIDArray['creatorID'];

    }


    public static function createThreadID($type){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT postID FROM '.$type.' ORDER BY postID DESC LIMIT 1');
        $req->execute();
        $tempID = $req->fetch();
        return $tempID['postID']+1;
    }

}