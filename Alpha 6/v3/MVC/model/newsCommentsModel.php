<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class newsCommentsModel extends newsComments
{

    private function __construct($newsModel)
    {
        $this->commentID = intval($newsModel['commentID']);
        $this->commentText = $newsModel['commentText'];
        $this->commentTime = intval($newsModel['commentTime']);
        $this->authorID = $newsModel['authorID'];
        $this->newsID = intval($newsModel['newsID']);
        $this->reported = intval($newsModel['reported']);
        $this->editable = intval($newsModel['editable']);
    }

    public static function insertNews($newsController, $type)
    {
        $db = db_conx::getInstance();
        $commentID = intval($newsController->getCommentID());
        $commentText = $newsController->getCommentText();
        $commentTime = intval($newsController->getCommentTime());
        $authorID = $newsController->getAuthorID();
        $newsID = intval($newsController->getNewsID());
        $reported = intval($newsController->getReported());
        $editable = intval($newsController->getEditable());
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO newsComments (commentText, commentTime, authorID, newsID, reported, editable) VALUES (:commentText, :commentTime, :authorID, :newsID, :reported, :editable)");
        } elseif ($type == "Update") {
            $req = $db->prepare("UPDATE newsComments SET commentText= :commentText, commentTime= :commentTime, authorID= :authorID, newsID= :newsID, reported= :reported, editable= :editable WHERE commentID= :commentID");
            $req->bindParam(':commentID', $commentID);
        }
        $req->bindParam(':commentText', $commentText);
        $req->bindParam(':commentTime', $commentTime);
        $req->bindParam(':authorID', $authorID);
        $req->bindParam(':newsID', $newsID);
        $req->bindParam(':reported', $reported);
        $req->bindParam(':editable', $editable);
        $req->execute();
    }

    public static function getSingleComment($commentID){
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT * FROM newsComments WHERE commentID= :commentID LIMIT 1");
        $req->bindParam(':commentID', $commentID);
        $req->execute();
        $newsModel = $req->fetch();
        return new newsCommentsModel($newsModel);
    }

    public static function getAllComments($newsID){
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT * FROM newsComments WHERE newsID= :newsID");
        $req->bindParam(':newsID', $newsID);
        $req->execute();
        $commentModel = $req->fetchAll();
        $finalArray = [];
        $counter = 0;
        foreach ($commentModel as $comment){
            $finalArray[$counter] = new newsCommentsModel($comment);
            $counter++;
        }
        return $finalArray;
    }

}