<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item9 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 9;
        $this->identity = "Raw Meat";
        $this->icon = "meat";
        $this->description = "You could eat this to restore some stamina and stave off hunger";
        $this->itemType = 1;
        $this->usable = true;
        $this->survivalBonus = 0;
        $this->statusImpact = 2;
        $this->edible = "You pinch your nose and bite into the bloody carcass, its better then being hungry...";
        $this->inedible = "You can't bear the smell, and wouldn't eat this unless you were starving.";
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        $avatar->useStamina(-5);
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