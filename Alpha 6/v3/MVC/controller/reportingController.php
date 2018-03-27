<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/reporting.php");
require_once(PROJECT_ROOT."/MVC/model/reportingModel.php");
class reportingController extends reporting
{

    function __construct($id)
    {
        if ($id != "") {
            $reportingModel = reportingModel::findReport($id);
            $this->reportID = $reportingModel->getReportID();
            $this->reporter = $reportingModel->getReporter();
            $this->reportType = $reportingModel->getReportType();
            $this->reportObject = $reportingModel->getReportObject();
            $this->reportedPlayer = $reportingModel->getReportedPlayer();
            $this->resolved = $reportingModel->getResolved();
            $this->details = $reportingModel->getDetails();
            $this->timestampCreated = $reportingModel->getTimestampCreated();
            $this->timestampResolved = $reportingModel->getTimestampResolved();
        }
    }

    static function newReportPost($reporter,$postID,$forumType,$details){
        if ((time()-$reporter->getReportTimer()) > 1800) {
            $pattern = "#[^A-Za-z0-9 ?()!,;:+-_\"']#i";
            $detailsClean = preg_replace($pattern, '', $details);
            $report = new reportingController("");
            $tableName = forumPostController::convertCodeTable($forumType);
            $post = new forumPostController($postID, $tableName);
            $report->setReporter($reporter->getProfileID());
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

    public function updateReport(){
        reportingModel::insertReport($this, "Update");
    }

    public function postReport(){
        reportingModel::insertReport($this, "Insert");
    }
}