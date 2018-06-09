<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class reportingModel extends reporting
{

    private function __construct($reportingModel)
    {
        $this->reportID = intval($reportingModel['reportID']);
        $this->reporter = $reportingModel['reporter'];
        $this->reportType = intval($reportingModel['reportType']);
        $this->reportObject = $reportingModel['reportObject'];
        $this->reportedPlayer = $reportingModel['reportedPlayer'];
        $this->resolved = intval($reportingModel['resolved']);
        $this->details = $reportingModel['details'];
        $this->timestampCreated = intval($reportingModel['timestampCreated']);
        $this->timestampResolved = intval($reportingModel['timestampResolved']);
        $this->resolvedBy = $reportingModel['resolvedBy'];
    }

    public static function findReport($reportID){
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT * FROM reporting WHERE reportID= :reportID LIMIT 1");
        $req->execute(array(':reportID' => $reportID));
        $reportModel = $req->fetch();
        return new reportingModel($reportModel);
    }

    public static function findReportExists($controller){
        $db = db_conx::getInstance();
        $reportObject = $controller->getReportObject();
        $reporter = $controller->getReporter();
        $req = $db->prepare("SELECT * FROM reporting WHERE reportObject= :reportObject AND reporter= :reporter LIMIT 1");
        $req->bindParam(':reportObject', $reportObject);
        $req->bindParam(':reporter', $reporter);
        $req->execute();
        $reportModel = $req->fetch();
        if ($reportModel['reporter'] === $controller->getReporter()){
            return true;
        } else {
            return false;
        }
    }

    public static function unresolvedReportType($reportType){
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT * FROM reporting WHERE reportType= :reportType AND resolved= 0");
        $req->execute(array(':reportType' => $reportType));
        $reportModel = $req->fetchAll();
        $finalArray = [];
        foreach ($reportModel as $report){
            $temp = new reportingModel($report);
            $finalArray[$temp->reportID] = $temp;
        }
        return $finalArray;
    }

    public static function insertReport($controller, $type){
        $db = db_conx::getInstance();
        $reportID = intval($controller->getReportID());
        $reporter = $controller->getReporter();
        $reportType = intval($controller->getReportType());
        $reportObject = $controller->getReportObject();
        $reportedPlayer = $controller->getReportedPlayer();
        $resolved = intval($controller->getResolved());
        $details = $controller->getDetails();
        $timestampCreated = intval($controller->getTimestampCreated());
        $timestampResolved = intval($controller->getTimestampResolved());
        $resolvedBy =  $controller->getResolvedBy();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO reporting (reporter, reportType, reportObject, reportedPlayer, resolved, details, timestampCreated, timestampResolved, resolvedBy) VALUES (:reporter, :reportType, :reportObject, :reportedPlayer,:resolved,:details,:timestampCreated, :timestampResolved, :resolvedBy)");
        } elseif ($type == "Update") {
            $req = $db->prepare("UPDATE reporting SET reporter= :reporter, reportType= :reportType, reportObject= :reportObject, reportedPlayer= :reportedPlayer, resolved= :resolved, details= :details, timestampCreated= :timestampCreated, timestampResolved= :timestampResolved , resolvedBy= :resolvedBy WHERE reportID= :reportID");
            $req->bindParam(':reportID', $reportID);
        }
        $req->bindParam(':reporter', $reporter);
        $req->bindParam(':reportType', $reportType);
        $req->bindParam(':reportObject', $reportObject);
        $req->bindParam(':reportedPlayer', $reportedPlayer);
        $req->bindParam(':resolved', $resolved);
        $req->bindParam(':details', $details);
        $req->bindParam(':timestampCreated', $timestampCreated);
        $req->bindParam(':timestampResolved', $timestampResolved);
        $req->bindParam(':resolvedBy', $resolvedBy);
        $req->execute();
        if ($type == "Insert"){
            $check = intval($db->lastInsertId());
            return $check;
        }
    }

    public static function findAllReportsIncomplete(){
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT * FROM reporting WHERE resolved= 0");
        $req->execute();
        $reportModel = $req->fetchAll();
        $finalArray = [];
        foreach ($reportModel as $report) {
            $temp = new reportingModel($report);
            $finalArray[$temp->reportID] = $temp;
        }
        return $finalArray;
    }



}