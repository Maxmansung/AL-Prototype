<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class profileImagesController
{

    protected $avatarFolder;
    protected $targetDir;
    protected $targetFile;



    public function __construct()
    {
       $this->avatarFolder = "/avatarimages/";
       $this->targetDir = $_SERVER['DOCUMENT_ROOT'].$this->avatarFolder;
    }

    public function testing($image){
        return $image;
    }

    public function checkUpload($uploadFile,$profileID)
    {
        $profile = new profileController($profileID);
        if ($profile->getProfileID() != "") {
            $securityTimer = time() - $profile->getUploadSecurity();
            if ($securityTimer > 43200) {
                $targetFile = $this->targetDir . $profileID;
                // Check if image file is a actual image or fake image
                $check = getimagesize($uploadFile["tmp_name"]);
                if ($check !== false) {
                    // Check file size
                    if ($uploadFile["size"] > 1000000) {
                        return array("ERROR"=>123);
                    }
                    if ($uploadFile["size"] < 300) {
                        return array("ERROR"=>124);
                    }
                    // Allow certain file formats
                    if ($uploadFile["type"] != "image/jpg" && $uploadFile["type"] != "image/png" && $uploadFile["type"] != "image/jpeg" && $uploadFile["type"] != "image/gif") {
                        return array("ERROR"=>121);
                    }
                    $name = explode(".", $uploadFile["name"]);
                    $extension = end($name);
                    $uploadFile["name"] = $profile->getProfileID().".".$extension;
                    $targetFile .= ".".$extension;
                    unlink($targetFile);
                    if (move_uploaded_file($uploadFile["tmp_name"], $targetFile)) {
                        $profile->setProfilePicture($uploadFile["name"]);
                        $profile->setUploadSecurity();
                        $profile->uploadProfile();
                        return array("SUCCESS"=>true);
                    } else {
                        return array("ERROR"=>"Sorry, there was an error uploading your file.");
                    }
                } else {
                    return array("ERROR"=>121);
                }
            } else {
                return array("ERROR"=>125);
            }
        } else {
            return array("ERROR"=>"Error with profile");
        }
    }
}