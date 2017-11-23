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
interface IAchievement {
    public function getAchievementID();
    public function setAchievementID($achievementID);
    public function getName();
    public function setName($name);
    public function getDescription();
    public function setDesription($description);
    public function getIcon();
    public function setIcon($path);
}
