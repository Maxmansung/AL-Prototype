<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/newsStory_Interface.php");
class newsStory implements newsStory_Interface
{

    protected $newsID;
    protected $title;
    protected $author;
    protected $timestampPosted;
    protected $postText;
    protected $comments;
    protected $month;
    protected $day;
    protected $visible;

    function __toString()
    {
        $output = $this->newsID;
        $output .= '/ '.$this->title;
        $output .= '/ '.$this->author;
        $output .= '/ '.$this->timestampPosted;
        $output .= '/ '.$this->postText;
        $output .= '/ '.$this->comments;
        $output .= '/ '.$this->month;
        $output .= '/ '.$this->day;
        $output .= '/ '.$this->visible;
        return $output;
    }

    function returnVars(){
        return get_object_vars($this);
    }

    function getNewsID()
    {
        return $this->newsID;
    }

    function setNewsID($var)
    {
        $this->newsID = $var;
    }

    function getTitle()
    {
        return $this->title;
    }

    function setTitle($var)
    {
        $this->title = $var;
    }

    function getAuthor()
    {
         return $this->author;
    }

    function setAuthor($var)
    {
        $this->author = $var;
    }

    function getTimestampPosted()
    {
        return $this->timestampPosted;
    }

    function setTimestampPosted($var)
    {
        $this->timestampPosted = $var;
    }

    function autoTimestampPosted()
    {
        $this->timestampPosted = time();
    }

    function getPostText()
    {
        return $this->postText;
    }

    function setPostText($var)
    {
        $this->postText = $var;
    }

    function getComments()
    {
        return $this->comments;
    }

    function setComments($var)
    {
        $this->comments = $var;
    }

    function increaseComments()
    {
        $this->comments++;
    }

    function getMonth()
    {
        return $this->month;
    }

    function getDay()
    {
        return $this->day;
    }

    function autoDayMonth()
    {
        $this->month = date("M",$this->timestampPosted);
        $this->day = date("j",$this->timestampPosted);
    }

    function getVisible()
    {
        return $this->visible;
    }

    function setVisible($var)
    {
        $this->visible = $var;
    }
}