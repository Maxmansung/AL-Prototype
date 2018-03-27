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
            $this->visible = $newsModel->getVisible();
            $this->autoDayMonth();
        }
    }

    private function createNews($title, $author, $postText,$visible){
        $this->title = $title;
        $this->author = $author;
        $this->autoTimestampPosted();
        $this->postText = $postText;
        $this->comments = 0;
        if ($visible == true){
            $this->visible = true;
        } else {
            $this->visible = false;
        }
    }

    public static function getAllNews(){
        return newsStoryModel::getAllNews();
    }

    public static function getAllVisibleNews(){
        return newsStoryModel::getAllVisibleNews();
    }

    public function deleteNews(){
        newsStoryModel::deleteNews($this->getNewsID());
    }

    public function insertNews(){
        newsStoryModel::insertNews($this,"Insert");
    }

    public function updateNews(){
        newsStoryModel::insertNews($this,"Update");
    }

    public static function postingNews($profileController, $title, $postText, $visible, $type){
        if ($profileController->getAccountType() <= 3) {
            $visibleClean = boolval(preg_replace('#[^0-9]#i', '', $visible));
            $titleClean = preg_replace('#[^A-Za-z0-9 ?()!.,£$]#i', '', $title);
            if (strlen($titleClean) < 3) {
                return array("ERROR" => 128);
            } else {
                if (strlen($titleClean) > 30) {
                    return array("ERROR" => 129);
                } else {
                    if (strlen($postText) < 10) {
                        return array("ERROR" => 130);
                    } else {
                        if ($type === "new"){
                            $newsStory = new newsStoryController("");
                            $newsStory->createNews($titleClean, $profileController->getProfileID(), $postText, $visibleClean);
                            $newsStory->insertNews();
                        } else {
                            $typeClean = intval(preg_replace('#[^0-9]#i', '', $type));
                            $newsStory = new newsStoryController($typeClean);
                            $newsStory->setTitle($titleClean);
                            $newsStory->setPostText($postText);
                            if ($newsStory->getVisible() != 1){
                                $newsStory->setVisible($visible);
                                $newsStory->autoTimestampPosted();
                            }
                            $newsStory->updateNews();
                        }
                        return array("ALERT" => 19, "DATA" =>"");
                    }
                }
            }
        } else {
            return array("ERROR"=>"Incorrect account type to create news");
        }
    }

    public static function deleteNewsController($profileController, $newsID){
        if ($profileController->getAccountType() >= 3){
            return array("ERROR"=>28);
        } else {
            $newsClean = intval(preg_replace('#[^0-9]#i', '', $newsID));
            $news = new newsStoryController($newsClean);
            $news->deleteNews();
            return array("ALERT"=>20,"DATA"=>true);
        }
    }

}