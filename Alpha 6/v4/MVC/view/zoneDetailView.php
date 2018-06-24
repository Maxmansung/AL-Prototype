<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class zoneDetailView
{

    protected $marker;
    protected $known;
    protected $depleted;
    protected $playersInZone;
    protected $partyThere;
    protected $biomeType;

    function __construct($zone,$party,$self)
    {
        $this->partyThere = false;
        foreach ($zone->getAvatars() as $player){
            if (in_array($player,$party->getMembers())){
                $this->partyThere = true;
            }
        }
        $list = $party->getZoneExploration();
        $zoneExplored = $list[intval($zone->getName())];
        if ($zoneExplored[0] !== "x") {
            $biomeName = "biome" . $zoneExplored[0];
            $biome = new $biomeName();
            $this->biomeType = $biome->getValue();
            $this->known = true;
        } else {
            $this->known = false;
        }
        $this->marker = $zoneExplored[2];
        $this->depleted = $zoneExplored[1];
        $counter = 0;
        if ($this->partyThere === true){
            foreach ($zone->getAvatars() as $player){
                if (in_array($player,$party->getPlayersKnown())){
                    $tempAvatar = new avatarController($player);
                    $newAvatar = new otherAvatarView($tempAvatar,$self,false,array(),$party);
                    $this->playersInZone[$counter] = $newAvatar->returnVars();
                } else {
                    $this->playersInZone[$counter] = "Unknown";
                }
                $counter++;
            }
        }
    }

    function returnVars()
    {
        return get_object_vars($this);
    }

}