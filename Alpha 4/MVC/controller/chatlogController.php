<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/chatlog.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/model/chatlogModel.php");
class chatlogController extends chatlog
{

    function updateChatLogZone(){
        chatlogModel::insertChatLogZone($this, "Update");
    }

    function insertChatLogZone(){
        chatlogModel::insertChatLogZone($this, "Insert");
    }

    function updateChatLogGroup(){
        chatlogModel::insertChatLogGroup($this, "Update");
    }

    function insertChatLogGroup(){
        chatlogModel::insertChatLogGroup($this, "Insert");
    }

    function updateChatLogBuilding(){
        chatlogModel::insertChatLogBuilding($this, "Update");
    }

    function insertChatLogBuilding(){
        chatlogModel::insertChatLogBuilding($this, "Insert");
    }

    function updateChatLogWorld(){
        chatlogModel::insertChatlogOther($this, "Update");
    }

    function insertChatLogWorld(){
        chatlogModel::insertChatlogOther($this, "Insert");
    }

    function getNewID($type){
        return chatlogModel::createMessageID($type);
    }

}