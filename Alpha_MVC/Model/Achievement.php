<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * The achievement class defines the structure for generated achievement added 
 * to player profiles.
 * An Achievement represents the general and special successes of a player he or
 * she earned during all maps played.
 *
 * @author Falk (Nefasu) <Falk.Testing@web.de>
 */
class Achievement implements IAchievement {
    private $achievementID;
    private $name;
    private $description;
    //The path to the icon location
    private $icon;
    
    function __construct($name, $description, $icon) {
        $this->description = $description;
        $this->icon = $icon;
        $this->name = $name;
    }
    
    /*
     * This function acts as a constructor for an existing object within the
     * database structure queried via the corresponding SQL command.
     * 
     * @return  The fully constructed achievement object
     * 
     */ 
    function sql_construct($achievementID, $name, $description, $icon) {
        $object = new self($description, $icon, $name);
        $object->achievementID = $achievementID;
        return $object;
    }
    
    public function getAchievementID() {
        return $this->achievementID;
    }
    
    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getIcon() {
        return $this->icon;
    }

    public function setAchievementID($achievementID) {
        $this->achievementID = $achievementID;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDesription($description) {
        $this->description = $description;
    }

    public function setIcon($path) {
        $this->icon = $path;
    }
}
