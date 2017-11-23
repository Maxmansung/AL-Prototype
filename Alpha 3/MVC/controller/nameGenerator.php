<?php

include_once($_SERVER['DOCUMENT_ROOT']."/MVC/interface/nameGenerator_Interface.php");
class nameGenerator implements nameGenerator_Interface
{

    protected $type;
    protected $firstName;
    protected $middleName;
    protected $lastName;

    function __toString()
    {
        $output = $this->type;
        $output .= '/ '.$this->firstName;
        $output .= '/ '.$this->middleName;
        $output .= '/ '.$this->lastName;
        return $output;
    }

    function returnVars(){
        return get_object_vars($this);
    }

    function getType()
    {
        return $this->type;
    }

    function setType($var)
    {
        $this->type = $var;
    }

    function getFirstName()
    {
        return $this->firstName;
    }

    function setFirstName($var)
    {
        $this->firstName = $var;
    }

    function getMiddleName()
    {
        return $this->middleName;
    }

    function setMiddleName($var)
    {
        $this->middleName = $var;
    }

    function getLastName()
    {
        return $this->lastName;
    }

    function setLastName($var)
    {
        $this->lastName = $var;
    }
}