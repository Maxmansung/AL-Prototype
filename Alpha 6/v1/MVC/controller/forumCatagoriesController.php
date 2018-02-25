<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/forumCatagories.php");
require_once(PROJECT_ROOT."/MVC/model/forumCatagoriesModel.php");
class forumCatagoriesController extends forumCatagories
{

    public function __construct($name,$profileID)
    {
        if ($name != ""){
            $catagoryModel = forumCatagoriesModel::getCatagory($name);
            $this->catagoryID = $catagoryModel->catagoryID;
            $this->catagoryName = $catagoryModel->catagoryName;
            $this->description = $catagoryModel->description;
            $this->flavourText = $catagoryModel->flavourText;
            $this->accessType = $catagoryModel->accessType;
            $access = self::getPlayerAccess($profileID, $this->accessType);
            $this->accessType = $access;
            $this->newPosts = $this->checkIfNewPost($profileID,$name);
        }
    }

    public static function getAllCatagories($profileID){
        $response = forumCatagoriesModel::getAllCatagories();
        $finalArray = [];
        foreach ($response as $catagory) {
            $temp = new forumCatagoriesController($catagory['catagoryID'],$profileID);
            $finalArray[$temp->getCatagoryID()] = $temp->returnVars();
        }
        return $finalArray;
    }

    public function insertCategory(){
        forumCatagoriesModel::insertForumCatagory($this,"Insert");
    }

    public function updateCategory(){
        forumCatagoriesModel::insertForumCatagory($this,"Update");
    }

    private static function getPlayerAccess($profileID,$accessType){
        $access = false;
        if ($accessType != "all") {
            $profile = new profileController($profileID);
            if ($accessType == "avatar") {
                if ($profile->getAvatar() != "") {
                    $access = true;
                }
            }
        } else {
            $access = true;
        }
        return $access;
    }

    private function checkIfNewPost($profileID,$category){
        $profile = new profileController($profileID);
        if ($category === "g"){
            if($profile->getForumPosts() !== array()){
                return true;
            } else{
                return false;
            }
        } else if ($category === "mc"){
            if ($this->getAccessType() === true) {
                $avatar = new avatarController($profile->getAvatar());
                if ($avatar->getForumPosts() !== array()) {
                    return true;
                }
            }
            return false;
        } else {
            return false;
        }
    }
}