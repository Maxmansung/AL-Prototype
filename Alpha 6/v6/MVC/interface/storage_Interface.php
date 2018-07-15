<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
interface storage_Interface
{

    function getStorageID();
    function setStorageID($var);
    function getZoneID();
    function setZoneID($var);
    function getItems();
    function setItems($var);
    function getMaximumCapacity();
    function setMaximumCapacity($var);
    function getStorageLevel();
    function setStorageLevel($var);
    function getLockBuilt();
    function setLockBuilt($var);
    function getLockStrength();
    function setLockStrength($var);
    function getLockMax();
    function setLockMax($var);
}