<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Falk (Nefasu) <Falk.Testing@web.de>
 */
interface IProfile {
    public function getProfileID();
    public function setProfileID($profielID);
    public function getPassword();
    public function setPassword($password);
    public function getProfilePicture();
    public function setProfilePicture($path);
    public function getEmail();
    public function setEmail($email);
    public function getLastLogin();
    public function setLastLogin($timestamp);
    public function getLoginIP();
    public function setLoginIP($ip);
    public function getAccounttype();
    public function setAccountType($accountType);
    public function getGameStatus();
    public function setGameStatus($gameStatus);
    public function getAvatar();
    public function setAvatar($avatarID);
    public function getAchievements();
    public function addAchievement($achievementID);
    public function joinGame();
}
