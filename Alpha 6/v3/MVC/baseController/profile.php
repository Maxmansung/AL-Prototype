<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/profile_Interface.php");
class profile implements profile_Interface
{
    protected $profileID;
    protected $profileName;
    protected $password;
    protected $profilePicture;
    protected $gameStatus;
    protected $avatarID;
    protected $email;
    protected $lastlogin;
    protected $loginIP;
    protected $accountType;
    protected $passwordRecovery;
    protected $passwordRecoveryTimer;
    protected $cookieKey;
    protected $forumPosts;
    protected $reportTimer;
    protected $createdMap;
    protected $accessNewMap;
    protected $accessEditMap;
    protected $accessEditForum;
    protected $accessPostNews;
    protected $accessActivated;
    protected $accessAllGames;
    protected $accessAdminPage;

    public function __toString()
    {
        $output = $this->profileID;
        $output .= '/ '.$this->password;
        $output .= '/ '.$this->profilePicture;
        $output .= '/ '.$this->email;
        $output .= '/ '.$this->lastlogin;
        $output .= '/ '.$this->loginIP;
        $output .= '/ '.$this->accountType;
        $output .= '/ '.$this->gameStatus;
        $output .= '/ '.$this->avatarID;
        $output .= '/ '.$this->passwordRecovery;
        $output .= '/ '.$this->passwordRecoveryTimer;
        $output .= '/ '.$this->cookieKey;
        $output .= '/ '.json_encode($this->forumPosts);
        $output .= '/ '.$this->createdMap;
        return $output;
    }

    function returnVars(){
        return get_object_vars($this);
    }

    function getProfileID()
    {
        return $this->profileID;
    }

    function setProfileID($profileID)
    {
        $this->profileID = $profileID;
    }

    function getProfileName()
    {
        return $this->profileName;
    }

    function setProfileName($var)
    {
        $this->profileName = $var;
    }

    function getPassword()
    {
        return $this->password;
    }

    function setPassword($password)
    {
        $this->password = $password;
    }

    function getProfilePicture()
    {
        return $this->profilePicture;
    }

    function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
    }

    function getEmail()
    {
        return $this->email;
    }

    function setEmail($email)
    {
        $this->email = $email;
    }

    function getLastLogin()
    {
        return $this->lastlogin;
    }

    function setLastLogin($lastLogin)
    {
        $this->lastlogin = $lastLogin;
    }

    function getLoginIP()
    {
        return $this->loginIP;
    }

    function setLoginIP($loginIP)
    {
        $this->loginIP = $loginIP;
    }

    function getAccountType()
    {
        return $this->accountType;
    }

    function setAccountType($accountType)
    {
        $this->accountType = $accountType;
    }

    function getGameStatus()
    {
        return $this->gameStatus;
    }

    function setGameStatus($gameStatus)
    {
        if ($gameStatus == "in") {
            $this->gameStatus = "in";
        } elseif ($gameStatus == "death"){
            $this->gameStatus = "death";
        } else {
            $this->gameStatus = "ready";
        }
    }

    function getAvatar()
    {
        return $this->avatarID;
    }

    function setAvatar($avatar)
    {
        $this->avatarID = $avatar;
    }

    function getPasswordRecovery()
    {
        return $this->passwordRecovery;
    }

    function setPasswordRecovery()
    {
        $salt = data::$salt["salt2"];
        $password = crypt(time(),"$6$".$salt);
        $password =  preg_replace('#[^a-z0-9]#i', '', $password);
        $password = substr($password,0,20);
        $this->passwordRecovery = $password;
    }

    function getPasswordRecoveryTimer()
    {
        return $this->passwordRecoveryTimer;
    }

    function setPasswordRecoveryTimer()
    {
        $this->passwordRecoveryTimer = time();
    }

    function resetPasswordRecovery(){}

    function getCookieKey()
    {
        return $this->cookieKey;
    }

    function setCookieKey()
    {
        $this->cookieKey = data::keyGenerator();
    }

    function getForumPosts()
    {
        return $this->forumPosts;
    }

    function setForumPosts($var)
    {
        $this->forumPosts = $var;
    }

    function addForumPosts($var)
    {
        if (is_array($this->forumPosts)) {
            if (!in_array($var, $this->forumPosts)) {
                array_push($this->forumPosts, $var);
            }
        } else {
            $temp = [$this->forumPosts];
            array_push($temp, $var);
            $this->forumPosts = $temp;
        }
    }

    function removeForumPosts($var)
    {
        $index = array_search($var, $this->forumPosts);
        if ( $index !== false ) {
            unset( $this->forumPosts[$index]);
            $this->forumPosts = array_values($this->forumPosts);
        }
    }

    function getReportTimer()
    {
        return $this->reportTimer;
    }

    function setReportTimer($var)
    {
        $this->reportTimer = $var;
    }

    function getCreatedMap()
    {
        return $this->createdMap;
    }

    function setCreatedMap($var)
    {
        $this->createdMap = $var;
    }

    function getAccessNewMap()
    {
        return $this->accessNewMap;
    }

    function setAccessNewMap($var)
    {
        $this->accessNewMap = $var;
    }

    function getAccessEditMap()
    {
        return $this->accessEditMap;
    }

    function setAccessEditMap($var)
    {
        $this->accessEditMap = $var;
    }

    function getAccessEditForum()
    {
        return $this->accessEditForum;
    }

    function setAccessEditForum($var)
    {
        $this->accessEditForum = $var;
    }

    function getAccessPostNews()
    {
        return $this->accessPostNews;
    }

    function setAccessPostNews($var)
    {
        $this->accessPostNews = $var;
    }

    function getAccessActivated()
    {
        return $this->accessActivated;
    }

    function setAccessActivated($var)
    {
        $this->accessActivated = $var;
    }

    function getAccessAllGames()
    {
        return $this->accessAllGames;
    }

    function setAccessAllGames($var)
    {
        $this->accessAllGames = $var;
    }

    function getAccessAdminPage()
    {
        return $this->accessAdminPage;
    }

    function setAccessAdminPage($var)
    {
        $this->accessAdminPage = $var;
    }
}