<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/MVC/data/data.php');
class db_conx {

    private static $instance = NULL;

    private function __construct() {}

    private function __clone() {}

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            self::$instance = new PDO('mysql:host='.data::$db['host'].';dbname='. data::$db['dbname'], data::$db['username'], data::$db['password']);
        }
        return self::$instance;
    }
}