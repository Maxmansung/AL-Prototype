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
        $this->lastPostBy = "";
        $this->stickyThread = intval(($threadModel['stickyThread']));
    }

    public static function insertForumThread($forumController,$type){
        $table = $forumController->getTableName();
        $threadID = intval($forumController->getThreadID());
        $threadTitle = $forumController->getThreadTitle();
        $creatorID = $forumController->getCreatorID();
        $posts = intval($forumController->getPosts());
        $threadDefinition = $forumController->getThreadDefinition();
        $lastUpdate = intval($forumController->getLastUpdate());
        $stickyThread = intval($forumController->getStickyThread());
        $db = db_conx::getInstance();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO ".$table." (threadID, threadTitle, creatorID, posts, threadDefinition, lastUpdate, stickyThread) VALUES (:threadID, :threadTitle, :creatorID, :posts, :threadDefinition, :lastUpdate, :stickyThread)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE ".$table." SET threadTitle= :threadTitle, creatorID= :creatorID, posts= :posts, threadDefinition= :threadDefinition, lastUpdate= :lastUpdate, stickyThread= :stickyThread WHERE threadID= :threadID");
        }
        $req->bindParam(':threadID', $threadID);
        $req->bindParam(':threadTitle', $threadTitle);
        $req->bindParam(':creatorID', $creatorID);
        $req->bindParam(':posts', $posts);
        $req->bindParam(':threadDefinition', $threadDefinition);
        $req->bindParam(':lastUpdate', $lastUpdate);
        $req->bindParam(':stickyThread', $stickyThread);
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
        $req = $db->prepare('SELECT threadID FROM '.$table.' WHERE threadDefinition= :threadDefinition AND stickyThread = 0');
        $req->execute(array('threadDefinition' => $threadDefinition));
        $threadIDArray = $req->fetchAll();
        return $threadIDArray;
    }

    public static function getAllThreadsSticky($threadDefinition,$table){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT threadID FROM '.$table.' WHERE threadDefinition= :threadDefinition AND stickyThread = 1');
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