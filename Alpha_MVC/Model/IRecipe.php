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
interface IRecipe {
    public function getRecipeID();
    public function setRecipeID($recipeID);
    public function getDescription();
    public function setDescription($description);
    public function getRequiredItems();
    public function addRequriedItem($itemTemplateID);
    public function removeRequiredItem($itemTemplateID);
    public function getConsumedItems();
    public function addConsumedItem($itemTemplateID);
    public function removeConsumedItem($itemTemplateID);
    public function getGeneratedItems();
    public function addGeneratedItem($itemTemplateID);
    public function removeGeneratedItem($itemTemplateID);
}
