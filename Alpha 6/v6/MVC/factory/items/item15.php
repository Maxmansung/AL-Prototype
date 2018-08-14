<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item15 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 15;
        $this->identity = "Nuts and Seeds";
        $this->icon = "seeds";
        $this->description = "They're pretty tough but with some effort you could get some nutrition perhaps?";
        $this->itemType = 1;
        $this->usable = true;
        $this->survivalBonus = 0;
        $this->statusImpact = 2;
        $this->edible = "You bite into the hard shells and almost breaks your teeth, you cant tell if you ate anything but shells";
        $this->inedible = "These nuts and seeds definitely don't look appealing enough for you to want to eat them today";
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        $avatar->useStamina(-2);
        $check = rand(0,1);
        if ($check == 0) {
            $responseController = responseController::getStatusChangeType($this->statusImpact);
            $newStatuses = $responseController->statusChange($avatar->getStatusArray());
            $avatar->setStatusArray($newStatuses);
        }
        $response = achievementController::checkAchievement(array("RECIPE", $this->itemTemplateID));
        if ($response !== false) {
            $avatar->addAchievement($response);
        }
        $avatar->removeInventoryItem($this->itemTemplateID);
        $avatar->updateAvatar();
        return array("ALERT" => 9, "DATA" => $this->edible);
    }
}