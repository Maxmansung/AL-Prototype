<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class newsStoryModel extends newsStory
{

    private function __construct($newsModel)
    {
        $this->newsID = $newsModel['newsID'];
        $this->title = $newsModel['title'];
        $this->author = $newsModel['author'];
        $this->timestampPosted = $newsModel['timestampPosted'];
        if (isset($newsModel['postText'])) {
            $this->postText = $newsModel['postText'];
        }
        $this->comments = $newsModel['comments'];
        $this->autoDayMonth();
    }


    public static function newsList($newsID){
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT * FROM newsTable WHERE newsID= :newsID LIMIT 1");
        $req->bindParam(':type', $newsID);
        $req->execute();
        $newsModel = $req->fetch();
        return new newsStoryModel($newsModel);
    }

    public static function getAllNews(){
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT newsID, title, author, timestampPosted, comments FROM newsTable");
        $req->execute();
        $newsModel = $req->fetchAll();
        $finalArray = [];
        $counter = 0;
        foreach ($newsModel as $news){
            $temp = new newsStoryModel($news);
            $finalArray[$counter] = $temp->returnVars();
            $counter++;
        }
        return $finalArray;
    }


    public static function insertNews($newsController, $type){
        $db = db_conx::getInstance();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO newsTable (newsID, title, author, timestampPosted, postText, comments) VALUES (:newsID, :title, :author, :timestampPosted, :postText, :comments)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE newsTable SET title= :title, author= :author, timestampPosted= :timestampPosted, postText= :postText, comments= :comments WHERE newsID= :newsID");
        }
        $req->bindParam(':title', $newsController->getTitle());
        $req->bindParam(':author', $newsController->getAuthor());
        $req->bindParam(':timestampPosted', $newsController->getTimestampPosted());
        $req->bindParam(':postText', $newsController->getPostText());
        $req->bindParam(':comments', $newsController->getComments());
        if ($type == "Update") {
            $req->bindParam(':newsID', $newsController->getNewsID());
        }
        $req->execute();
    }
}