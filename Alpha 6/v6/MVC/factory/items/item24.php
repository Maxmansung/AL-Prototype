<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item24 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 24;
        $this->identity = "Stew";
        $this->icon = "stew";
        $this->description = "Wow, that home cooked meal actually looks tasty!";
        $this->itemType = 1;
        $this->usable = true;
        $this->survivalBonus = 0;
        $this->statusImpact = 2;
        $this->edible = "You gulp down the stew, not only is it feeling but it actually doesn't make you want to throw it back up. You actually feel better for once!";
        $this->inedible = "Such good food shouldn't be wasted when you're still feeling nauseous from the last thing you ate.";
        $this->givesRecipe = array();
        $this->dayEndChanges = true;
    }

    function consumeItem($avatar)
    {
        $avatar->useStamina(-10);
        $responseController = responseController::getStatusChangeType($this->statusImpact);
        $newStatuses = $responseController->statusChange($avatar->getStatusArray());
        $avatar->setStatusArray($newStatuses);
        $response = achievementController::checkAchievement(array("RECIPE", $this->itemTemplateID));
        if ($response !== false) {
            $avatar->addAchievement($response);
        }
        $avatar->removeInventoryItem($this->itemTemplateID);
        $avatar->updateAvatar();
        return array("ALERT" => 9, "DATA" => $this->edible);
    }
}