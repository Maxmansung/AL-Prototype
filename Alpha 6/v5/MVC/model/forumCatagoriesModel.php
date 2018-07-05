<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class forumCatagoriesModel extends forumCatagories
{

    private function __construct($catagoryModel)
    {
        $this->catagoryID = $catagoryModel['catagoryID'];
        $this->catagoryName = $catagoryModel['catagoryName'];
        $this->description = $catagoryModel['description'];
        $this->flavourText = $catagoryModel['flavourText'];
        $this->accessType = $catagoryModel['accessType'];
    }

    public static function insertForumCatagory($forumController,$type){
        $db = db_conx::getInstance();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO forumCatagories (catagoryID, catagoryName, description, flavourText, accessType) VALUES (:catagoryID, :catagoryName, :description, :flavourText, :accessType)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE forumCatagories SET catagoryName= :catagoryName, description= :description, flavourText= :flavourText, accessType= :accessType WHERE catagoryID= :catagoryID");
        }
        $req->bindParam(':catagoryID', $forumController->getCatagoryID());
        $req->bindParam(':catagoryName', $forumController->getCatagoryName());
        $req->bindParam(':description', $forumController->getDescription());
        $req->bindParam(':flavourText', $forumController->getFlavourText());
        $req->bindParam(':accessType', $forumController->getAccessType());
        $req->execute();
    }

    public static function getCatagory($name){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM forumCatagories WHERE catagoryID= :catagoryID');
        $req->execute(array('catagoryID' => $name));
        $catagoryModel = $req->fetch();
        return new forumCatagoriesModel($catagoryModel);
    }

    public static function getAllCatagories(){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT catagoryID FROM forumCatagories');
        $req->execute();
        $catagoryIDArray = $req->fetchAll();
        return $catagoryIDArray;
    }
}