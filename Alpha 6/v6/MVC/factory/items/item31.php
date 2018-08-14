<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item31 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 31;
        $this->identity = "Frostbite Heal";
        $this->icon = "frostbiteHeal";
        $this->description = "This miracle cure may just be enough to mend someones frostbite!";
        $this->itemType = 1;
        $this->usable = true;
        $this->survivalBonus = 0;
        $this->statusImpact = 4;
        $this->edible = "You rub the concoction all over you and wait, within seconds the burning starts and grows until the pain becomes so intense that it feels like you're going to die. Finally you black out";
        $this->inedible = "You can only use a frostbite heal if you have frostbite, and if you've not been healed before...";
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
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