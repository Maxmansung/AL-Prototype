<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item16 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 16;
        $this->identity = "Homemade Salad";
        $this->icon = "salad";
        $this->description = "A rough and ready salad, but at least it might be a little nutritious";
        $this->itemType = 1;
        $this->usable = true;
        $this->survivalBonus = 0;
        $this->statusImpact = 2;
        $this->edible = "You gulp down the slop and do your best to keep it from coming back up again.";
        $this->inedible = "You still feel sick from the last time you ate, which wasn't very long ago.";
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