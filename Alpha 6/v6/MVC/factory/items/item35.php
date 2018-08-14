<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item35 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 35;
        $this->identity = "Human Flesh";
        $this->icon = "flesh";
        $this->description = "This frozen bit of meat looks suspiciously like a someones limb...";
        $this->itemType = 1;
        $this->usable = true;
        $this->survivalBonus = 0;
        $this->statusImpact = 2;
        $this->edible = "Wow, just... wow...<br>Things have really gone downhill if you're eating those that came before you.<br><br>I hope it was worth it...";
        $this->inedible = "No way, you'd have to be really hungry to eat something that looks like it came off someone else.";
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
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