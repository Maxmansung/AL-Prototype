<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class websiteData
{

    protected $variable;
    protected $response;

    function getVariable()
    {
        return $this->variable;
    }

    function setVariable($var)
    {
        $this->variable = $var;
    }

    function getResponse()
    {
        return $this->response;
    }

    function setResponse($var)
    {
        $this->response = $var;
    }

    public function __construct($variable)
    {
        if ($variable !== ""){
            $dataModel = self::findVariable($variable);
            $this->variable = $dataModel['variable'];
            $this->response = $dataModel['response'];
        }
    }

    public static function findVariable($variable){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM websiteData WHERE variable= :variable LIMIT 1');
        $req->execute(array(':variable' => $variable));
        $dataModel = $req->fetch();
        return $dataModel;
    }

    public function updateVariable(){
        $db = db_conx::getInstance();
        $req = $db->prepare('UPDATE websiteData SET response= :response WHERE variable= :variable');
        $req->bindParam(':variable', $this->variable);
        $req->bindParam(':response', $this->response);
        $req->execute();


    }

}