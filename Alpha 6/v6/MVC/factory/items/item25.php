<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item25 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 25;
        $this->identity = "Distilled Drug";
        $this->icon = "distilledDrug";
        $this->description = "This looks pretty potent, I hope you know what you're doing with it...";
        $this->itemType = 1;
        $this->usable = true;
        $this->survivalBonus = 0;
        $this->statusImpact = 3;
        $this->edible = "The powder makes you want to vomit violently as it touches your tongue, but within seconds a blinding light appears behind your eyes and all the pain melts away.";
        $this->inedible = "You're already high, taking something like this would kill you instantly!";
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        $avatar->useStamina(-15);
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