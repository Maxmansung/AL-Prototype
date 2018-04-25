<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/reporting.php");
require_once(PROJECT_ROOT."/MVC/model/reportingModel.php");
class reportingController extends reporting
{

    function __construct($id)
    {
        if ($id != ""){
            if (is_object($id)){
                $reportingModel = $id;
            } else {
                $reportingModel = reportingModel::findReport($id);
            }
            $this->reportID = $reportingModel->getReportID();
            $this->reporter = $reportingModel->getReporter();
            $this->reportType = $reportingModel->getReportType();
            $this->reportObject = $reportingModel->getReportObject();
            $this->reportedPlayer = $reportingModel->getReportedPlayer();
            $this->resolved = $reportingModel->getResolved();
            $this->details = $reportingModel->getDetails();
            $this->timestampCreated = $reportingModel->getTimestampCreated();
            $this->timestampResolved = $reportingModel->getTimestampResolved();
            $this->resolvedBy = $reportingModel->getResolvedBy();
        }
    }

    private function createTimestamp($type){
        switch ($type){
            case 0:
                $time = $this->timestampCreated;
                $response = date("g:ia j-M",$time);
                $this->setTimestampCreated($response);
                $time = $this->timestampResolved;
                $response = date("g:ia j-M",$time);
                $this->setTimestampResolved($response);
                break;
            case 1:
                $time = $this->timestampCreated;
                $response = date("g:ia j-M",$time);
                $this->setTimestampCreated($response);
                break;
            case 2:
                $time = $this->timestampResolved;
                $response = date("g:ia j-M",$time);
                $this->setTimestampResolved($response);
                break;
        }

    }

    static function newReportPost($reporter,$postID,$forumType,$details){
        if ((time()-$reporter->getReportTimer()) > 1800) {
            $detailsClean = preg_replace(data::$cleanPatterns['special'], '', $details);
            $report = new reportingController("");
            $tableName = forumPostController::convertCodeTable($forumType);
            $post = new forumPostController($postID, $tableName);
            $report->setReporter($reporter->getProfileName());
            $report->setReportType(1);
            $report->setReportObject(($forumType . "+" . $postID));
            $report->setReportedPlayer($post->getCreatorID());
            $report->setResolved(0);
            $report->setDetails($detailsClean);
            $report->setTimestampCreated(time());
            $check = reportingModel::findReportExists($report);
            if ($check === false) {
                $response = $report->postReport();
                $reporter->setReportTimer(time());
                $reporter->uploadProfile();
                return array("ALERT" => 18, "DATA" => $response);
            } else {
                return array("ERROR" => 127);
            }
        } else {
            return array("ERROR"=>126);
        }
    }

    static function newReportCreateMap($reporter,$mapID,$details){
        if (1 === 2){
            //CHANGE THIS TO CHECK FOR IF THE MAP HAS ALREADY BEEN REPORTED
            return array("ERROR"=>"This map has already been reported");
        } else {
            $pattern = "#[^A-Za-z0-9 ?()!,;:+-_\"']#i";
            $detailsClean = preg_replace($pattern, '', $details);
            $report = new reportingController("");
            $mapIDClean = preg_replace('#[^0-9]#i',"",$mapID);
            $map = new mapController($mapIDClean);
            if ($map->getMapID() == $mapID && $mapID != null && $reporter->getCreatedMap() == $mapID) {
                $report->setReporter($reporter->getProfileName());
                $report->setReportType(2);
                $report->setReportObject($map->getMapID());
                $report->setReportedPlayer($reporter->getProfileName());
                $report->setResolved(0);
                $report->setDetails($detailsClean);
                $report->setTimestampCreated(time());
                $check = reportingModel::findReportExists($report);
                if ($check === false) {
                    $response = $report->postReport();
                    return array("ALERT" => 18, "DATA" => $response);
                } else {
                    return array("ERROR" => 134);
                }
            }
            return array("ERROR"=>135);
        }
    }

    public function updateReport(){
        reportingModel::insertReport($this, "Update");
    }

    public function postReport(){
        reportingModel::insertReport($this, "Insert");
    }

    public static function getAllReports($closed,$profile){
        $profile->getProfileAccess();
        if ($closed === true){
            $list = reportingModel::findAllReportsIncomplete();
        } else {
            $list = reportingModel::findAllReportsIncomplete();
        }
        $mapArray = [];
        $forumArray = [];
        $counterMap = 0;
        $counterFourm = 0;
        foreach($list as $report){
            $temp = new reportingController($report);
            $temp->createTimestamp(0);
            switch($temp->getReportType()){
                case 1:
                    if ($profile->getAccessEditForum() === 1) {
                        $forumArray[$counterFourm] = $temp->returnVars();
                        $counterFourm++;
                    }
                    break;
                case 2:
                    if ($profile->getAccessEditMap() === 1) {
                        $mapArray[$counterMap] = $temp->returnVars();
                        $counterMap++;
                        break;
                    }
            }
        }
        $finalArray = array("map"=>$mapArray,"forum"=>$forumArray);
        return $finalArray;
    }

    public static function resolveReport($id,$message,$profile){
        $profile->getProfileAccess();
        $cleanID = preg_replace(data::$cleanPatterns['num'],"",$id);
        $messageClean = preg_replace(data::$cleanPatterns['special'],"",$message);
        $report = new reportingController($cleanID);
        $access = false;
        switch ($report->getReportType()){
            case 1:
                if ($profile->getAccessEditForum() === 1) {
                    $access = true;
                }
                break;
            case 2:
                if ($profile->getAccessEditMap() === 1) {
                    $access = true;
                    break;
                }
        }
        if ($access === true){
            $report->setResolvedBy($profile->getProfileName());
            $report->setTimestampResolved(time());
            $report->setResolved(1);
            $report->updateReport();
            modTrackingController::createNewTrack(2,$profile->getProfileID(),$report->getReportID(),"","","");
            $checker = profileAlertController::createReportAlert($report->getReporter(),$messageClean,$report->getReportID());
            return array("ALERT"=>"28","DATA"=>$checker);
        } else {
            return array("ERROR"=>28);
        }
    }
}