<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/newsStory.php");
require_once(PROJECT_ROOT."/MVC/model/newsStoryModel.php");
class newsStoryController extends newsStory
{
    public function __construct($id)
    {
        if ($id != ""){
            $newsModel = newsStoryModel::newsList($id);
            $this->newsID = $newsModel->getNewsID();
            $this->title = $newsModel->getTitle();
            $this->author = $newsModel->getAuthor();
            $this->timestampPosted = $newsModel->getTimestampPosted();
            $this->postText = $newsModel->getPostText();
            $this->comments = $newsModel->getComments();
            $this->autoDayMonth();
        }
    }

    private function createNews($title, $author, $postText){
        $this->title = $title;
        $this->author = $author;
        $this->autoTimestampPosted();
        $this->postText = $postText;
        $this->comments = 0;
    }

    public static function getAllNews(){
        return newsStoryModel::getAllNews();
    }



    public function insertNews(){
        newsStoryModel::insertNews($this,"Insert");
    }

    public function updateNews(){
        newsStoryModel::insertNews($this,"Update");
    }

    public static function createNewNews($profileController, $title, $postText){
        if ($profileController->getAccountType() <= 3){
            $newsStory = new newsStoryController("");
            $newsStory->createNewNews($title,$profileController->getProfileID(),$postText);
            $newsStory->insertNews();
            return array("SUCCESS"=>TRUE);
        } else {
            return array("ERROR"=>"Incorrect account type to create news");
        }
    }

}