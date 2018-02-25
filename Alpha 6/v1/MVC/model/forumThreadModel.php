<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class forumThreadModel extends forumThread
{

    private function __construct($threadModel)
    {
        $this->threadID = intval($threadModel['threadID']);
        $this->threadDefinition = $threadModel['threadDefinition'];
        $this->threadTitle = $threadModel['threadTitle'];
        $this->creatorID = $threadModel['creatorID'];
        $this->posts = intval($threadModel['posts']);
        $this->lastUpdate = intval($threadModel['lastUpdate']);
        $this->lastPostBy = $threadModel['lastPostBy'];
    }

    public static function insertForumThread($forumController,$type){
        $table = $forumController->getTableName();
        $db = db_conx::getInstance();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO ".$table." (threadID, threadTitle, creatorID, posts, threadDefinition, lastUpdate) VALUES (:threadID, :threadTitle, :creatorID, :posts, :threadDefinition, :lastUpdate)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE ".$table." SET threadTitle= :threadTitle, creatorID= :creatorID, posts= :posts, threadDefinition= :threadDefinition, lastUpdate= :lastUpdate WHERE threadID= :threadID");
        }
        $req->bindParam(':threadID', intval($forumController->getThreadID()));
        $req->bindParam(':threadTitle', $forumController->getThreadTitle());
        $req->bindParam(':creatorID', $forumController->getCreatorID());
        $req->bindParam(':posts', intval($forumController->getPosts()));
        $req->bindParam(':threadDefinition', $forumController->getThreadDefinition());
        $req->bindParam(':lastUpdate', intval($forumController->getLastUpdate()));
        $req->execute();
    }

    public static function getThread($name,$table)
    {
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM '.$table.' WHERE threadID= :threadID');
        $req->execute(array('threadID' => $name));
        $threadModel = $req->fetch();
        return new forumThreadModel($threadModel);
    }

    public static function getAllThreads($threadDefinition,$table){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT threadID FROM '.$table.' WHERE threadDefinition= :threadDefinition');
        $req->execute(array('threadDefinition' => $threadDefinition));
        $threadIDArray = $req->fetchAll();
        return $threadIDArray;

    }

    //This returns the next value in the counter columnn in order to add to the new item information
    public static function createThreadID($type){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT threadID FROM '.$type.' ORDER BY threadID DESC LIMIT 1');
        $req->execute();
        $tempID = $req->fetch();
        return $tempID['threadID']+1;
    }

}