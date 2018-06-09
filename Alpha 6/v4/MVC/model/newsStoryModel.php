<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class newsStoryModel extends newsStory
{

    private function __construct($newsModel)
    {
        $this->newsID = intval($newsModel['newsID']);
        $this->title = $newsModel['title'];
        $this->author = $newsModel['author'];
        $this->timestampPosted = intval($newsModel['timestampPosted']);
        if (isset($newsModel['postText'])) {
            $this->postText = $newsModel['postText'];
        }
        $this->comments = intval($newsModel['comments']);
        $this->autoDayMonth();
        $this->visible = intval($newsModel['visible']);
    }


    public static function newsList($newsID){
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT * FROM newsTable WHERE newsID= :newsID LIMIT 1");
        $req->bindParam(':newsID', $newsID);
        $req->execute();
        $newsModel = $req->fetch();
        return new newsStoryModel($newsModel);
    }

    public static function getAllNews(){
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT * FROM newsTable");
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

    public static function getAllVisibleNews(){
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT newsID, title, author, timestampPosted, comments, visible FROM newsTable WHERE visible = 1");
        $req->execute();
        $newsModel = $req->fetchAll();
        $finalArray = [];
        $counter = 0;
        foreach ($newsModel as $news){
            $temp = new newsStoryModel($news);
            if ($temp->getVisible() == true) {
                $finalArray[$counter] = $temp->returnVars();
                $counter++;
            }
        }
        return $finalArray;
    }


    public static function insertNews($newsController, $type){
        $db = db_conx::getInstance();
        $title = $newsController->getTitle();
        $author = $newsController->getAuthor();
        $timestampPosted = intval($newsController->getTimestampPosted());
        $postText = $newsController->getPostText();
        $comments = intval($newsController->getComments());
        $visible = intval($newsController->getVisible());
        $newsID =  intval($newsController->getNewsID());
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO newsTable (title, author, timestampPosted, postText, comments, visible) VALUES (:title, :author, :timestampPosted, :postText, :comments, :visible)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE newsTable SET title= :title, author= :author, timestampPosted= :timestampPosted, postText= :postText, comments= :comments, visible= :visible WHERE newsID= :newsID");
        }
        $req->bindParam(':title', $title);
        $req->bindParam(':author', $author);
        $req->bindParam(':timestampPosted', $timestampPosted);
        $req->bindParam(':postText', $postText);
        $req->bindParam(':comments', $comments);
        $req->bindParam(':visible', $visible);
        if ($type == "Update") {
            $req->bindParam(':newsID', $newsID);
        }
        $req->execute();
    }

    public static function deleteNews($newsID){
            $db = db_conx::getInstance();
            $req = $db->prepare('DELETE FROM newsTable WHERE newsID= :newsID LIMIT 1');
            $req->execute(array('newsID' => $newsID));
            return "Success";
        }
}