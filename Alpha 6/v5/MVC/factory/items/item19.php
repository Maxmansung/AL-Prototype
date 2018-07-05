<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item19 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 19;
        $this->identity = "Cold Fish";
        $this->icon = "fish";
        $this->description = "This is a pretty sorry looking fish, but maybe you could eat it";
        $this->itemType = 1;
        $this->usable = true;
        $this->survivalBonus = -1;
        $this->statusImpact = 2;
        $this->edible = "It's like eating ice, but slimy.";
        $this->inedible = "You're not hungry enough.";
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