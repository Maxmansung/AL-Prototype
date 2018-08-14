<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item13 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 13;
        $this->identity = "Water";
        $this->icon = "water";
        $this->description = "Your water wont last long at these temperatures";
        $this->itemType = 1;
        $this->usable = false;
        $this->survivalBonus = 0;
        $this->statusImpact = 2;
        $this->edible = "You gulp down the water and feel a chill travel through you";
        $this->inedible = "No way, there's bits floating in it and its freezing cold, you'll need to be a lot more desperate";
        $this->givesRecipe = array();
        $this->dayEndChanges = true;
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

    public function dayEnding()
    {
        return array("ITEM"=>17);
    }
}