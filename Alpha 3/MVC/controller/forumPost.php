<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/interface/forumPost_Interface.php");
class forumPost implements forumPost_Interface
{

    protected $postID;
    protected $creatorID;
    protected $postDate;
    protected $editable;
    protected $postText;
    protected $threadID;
    protected $postCount;
    protected $tableName;

    public function __toString()
    {
        $output = $this->postID;
        $output .= '/ '.$this->creatorID;
        $output .= '/ '.$this->postDate;
        $output .= '/ '.$this->editable;
        $output .= '/ '.$this->postText;
        $output .= '/ '.$this->threadID;
        $output .= '/ '.$this->postCount;
        return $output;
    }

    function returnVars(){
        return get_object_vars($this);
    }

    function getPostID()
    {
        return $this->postID;
    }

    function setPostID($var)
    {
        $this->postID = $var;
    }

    function getCreatorID()
    {
        return $this->creatorID;
    }

    function setCreatorID($var)
    {
        $this->creatorID = $var;
    }

    function getPostDate()
    {
        return $this->postDate;
    }

    function setPostDate($var)
    {
        $this->postDate = $var;
    }

    function getEditable()
    {
        return $this->editable;
    }

    function setEditable($var)
    {
        $this->editable = $var;
    }

    function getPostText()
    {
        return $this->postText;
    }

    function setPostText($var)
    {
        $this->postText = $var;
    }

    function getThreadID()
    {
        return $this->threadID;
    }

    function setThreadID($var)
    {
        $this->threadID = $var;
    }

    function getPostCount()
    {
        return $this->postCount;
    }

    function setPostCount($var)
    {
        $this->postCount = $var;
    }

    function getTableName(){
        return $this->tableName;
    }

    function setTableName($var)
    {
        $this->tableName = $var;
    }
}