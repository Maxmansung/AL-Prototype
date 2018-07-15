<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/newsComments.php");
require_once(PROJECT_ROOT . "/MVC/model/newsCommentsModel.php");
class newsCommentsController extends newsComments
{
    protected $editedDate;
    protected $avatarImage;
    protected $authorDetails ;

    public function __construct($id)
    {
        if ($id != "") {
            if (is_object($id)) {
                $newsModel = $id;
            } else {
                $newsModel = newsCommentsModel::getSingleComment($id);
            }
            $this->commentID = $newsModel->getCommentID();
            $this->commentText = $newsModel->getCommentText();
            $this->commentTime = $newsModel->getCommentTime();
            $this->authorID = $newsModel->getAuthorID();
            $this->newsID = $newsModel->getNewsID();
            $this->reported = $newsModel->getReported();
            $this->editable = $newsModel->getEditable();
            $this->editedDateFormat();
        }
    }

    private function getAvatar(){
        $temp = new profileController($this->authorID);
        $this->authorDetails = "";
        $this->avatarImage = $temp->getProfilePicture();
    }

    public function insertComment(){
        newsCommentsModel::insertNews($this,"Insert");
    }

    public function updateComment(){
        newsCommentsModel::insertNews($this,"Update");
    }

    public static function getAllNewsComments($newsID){
        $finalArray = [];
        $counter = 0;
        $list = newsCommentsModel::getAllComments($newsID);
        foreach ($list as $comment){
            $temp = new newsCommentsController($comment);
            $temp->getAvatar();
            $finalArray[$counter] = $temp->returnVars();
            $counter++;
        }
        return $finalArray;
    }

    public static function createComment($profile,$newsID,$commentText){
        $profile->getProfileAccess();
        if ($profile->getAccessAllGames()===1){
            $newsClean = preg_replace(data::$cleanPatterns['num'],"",$newsID);
            $news = new newsStoryController($newsClean);
            if ($news->getNewsID() != "") {
                $response = forumPostController::checkPostError($commentText);
                if (is_array($response)) {
                    return $response;
                } else {
                    $comment = new newsCommentsController("");
                    $comment->setCommentText($response);
                    $comment->setCommentTime(time());
                    $comment->setAuthorID($profile->getProfileName());
                    $comment->setNewsID($newsClean);
                    $comment->setReported(0);
                    $comment->setEditable(1);
                    $comment->insertComment();
                    $news->increaseComments();
                    $news->updateNews();
                    return array("ALERT"=>4,"DATA"=>"");
                }
            } else {
                return array("ERROR"=>"You cannot comment on this");
            }
        } else {
            return array("ERROR"=>28);
        }
    }

    private function editedDateFormat(){
        $this->editedDate =date("jS M",$this->getCommentTime());
    }

    public static function modifyComment($profile, $commentID, $text, $type){
        $profile->getProfileAccess();
        if ($profile->getAccessEditForum() === 1){
            $commentIDClean = preg_replace(data::$cleanPatterns['num'],"",$commentID);
            $comment = new newsCommentsController($commentIDClean);
            if ($comment->getReported() === 1){
                if ($comment->getEditable() === 1) {
                    if ($type === "Delete") {
                        $commentText = "$%* This post has been deleted $%*";
                        $comment->setEditable(0);
                    } else {
                        $commentText = forumPostController::checkPostError($text);
                        if (is_array($commentText)) {
                            return $commentText;
                        }
                    }
                    $comment->setCommentText($commentText);
                    $comment->setReported(0);
                    $comment->updateComment();
                    modTrackingController::createNewTrack(12, $profile->getProfileID(), $comment->getCommentID(), $type, "", "");
                    if ($type === "Delete") {
                        return array("ALERT" => 3, "DATA" => $comment->getAuthorID());
                    } else {
                        return array("ALERT" => 5, "DATA" => $comment->getAuthorID());
                    }
                } else {
                    return array("ERROR"=>"This comment is not editable");
                }
            } else {
                return array("ERROR"=>"You cannot edit unreported comments");
            }
        } else {
            return array("ERROR"=>28);
        }
    }
}