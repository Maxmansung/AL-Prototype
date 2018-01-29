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
        $db = db_conx::getInstance();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO ".$table." (postID, creatorID, postDate, editable, postText, threadID, postCount) VALUES (:postID, :creatorID, :postDate, :editable, :postText, :threadID, :postCount)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE ".$table." SET creatorID= :creatorID, postDate= :postDate, editable= :editable, postText= :postText, threadID= :threadID, postCount= :postCount WHERE postID= :postID");
        }
        $req->bindParam(':postID', intval($postController->getPostID()));
        $req->bindParam(':creatorID', $postController->getCreatorID());
        $req->bindParam(':postDate', intval($postController->getPostDate()));
        $req->bindParam(':editable', $postController->getEditable());
        $req->bindParam(':postText', $postController->getPostText());
        $req->bindParam(':threadID', intval($postController->getThreadID()));
        $req->bindParam(':postCount', intval($postController->getPostCount()));
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

    //This returns the next value in the counter columnn in order to add to the new item information
    public static function createThreadID($type){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT postID FROM '.$type.' ORDER BY postID DESC LIMIT 1');
        $req->execute();
        $tempID = $req->fetch();
        return $tempID['postID']+1;
    }

}