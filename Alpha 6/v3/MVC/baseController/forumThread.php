<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/forumThread_Interface.php");
class forumThread implements forumThread_Interface
{

    protected $threadID;
    protected $threadDefinition;
    protected $threadTitle;
    protected $creatorID;
    protected $posts;
    protected $lastUpdate;
    protected $tableName;
    protected $lastPostBy;
    protected $stickyThread;
    protected $newPost;

    public function __toString()
    {
        $output = $this->threadID;
        $output .= '/ '.$this->threadDefinition;
        $output .= '/ '.$this->threadTitle;
        $output .= '/ '.$this->creatorID;
        $output .= '/ '.$this->posts;
        $output .= '/ '.$this->lastUpdate;
        $output .= '/ '.$this->tableName;
        $output .= '/ '.$this->stickyThread;
        $output .= '/ '.$this->newPost;
        return $output;
    }

    function returnVars(){
        return get_object_vars($this);
    }

    function getThreadID()
    {
        return $this->threadID;
    }

    function setThreadID($var)
    {
        $this->threadID = $var;
    }

    function getThreadDefinition()
    {
        return $this->threadDefinition;
    }

    function setThreadDefinition($var)
    {
        $this->threadDefinition = $var;
    }

    function getThreadTitle()
    {
        return $this->threadTitle;
    }

    function setThreadTitle($var)
    {
        $this->threadTitle = $var;
    }

    function getCreatorID()
    {
        return $this->creatorID;
    }

    function setCreatorID($var)
    {
        $this->creatorID = $var;
    }

    function getPosts()
    {
        return intval($this->posts);
    }

    function setPosts($var)
    {
        $this->posts = $var;
    }

    function increasePosts()
    {
        $this->posts = intval($this->posts)+1;
    }

    function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    function setLastUpdate($var)
    {
        $this->lastUpdate = $var;
    }

    function getTableName(){
        return $this->tableName;
    }

    function setTableName($var)
    {
        $this->tableName = $var;
    }

    function getLastPostBy(){
        return $this->lastPostBy;
    }

    function setLastPostBy($var){
        $this->lastPostBy = $var;
    }

    function getNewPost(){
        return $this->newPost;
    }

    function setNewPost($var){
        $this->newPost = $var;
    }

    function getStickyThread()
    {
        return $this->stickyThread;
    }

    function setStickyThread($var)
    {
        $this->stickyThread = $var;
    }
}