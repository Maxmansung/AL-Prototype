<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item23 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 23;
        $this->identity = "Frozen Toad";
        $this->icon = "toad";
        $this->description = "It's like a toad popsicle... I wonder what happens if you lick it..";
        $this->itemType = 1;
        $this->usable = true;
        $this->survivalBonus = -2;
        $this->statusImpact = 3;
        $this->edible = "You start to lick the frozen little creature and your tongue instantly sticks to it's skin. As you you try to pull yourself away the world around melts and you begin to hear colours...";
        $this->inedible = "Eugh, even if the world wasn't spinning it's difficult to see why you'd want to touch that thing...";
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