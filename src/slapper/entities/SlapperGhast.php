<?php
namespace slapper\entities;

use pocketmine\entity\Entity;
use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\Player;

class SlapperGhast extends Entity implements SlapperEntity
{

    const NETWORK_ID = 41;

    public function getName()
    {
        return $this->getDataProperty(2);
    }

    public function spawnTo(Player $player)
    {

        $pk = new AddEntityPacket();
        $pk->eid = $this->getId();
        $pk->type = self::NETWORK_ID;
        $pk->x = $this->x;
        $pk->y = $this->y;
        $pk->z = $this->z;
        $pk->yaw = $this->yaw;
        $pk->pitch = $this->pitch;
	@$flags |= 1 << 15;
	@$flags |= 1 << 16;
        $pk->metadata = [
	0 => [7, $flags],
        4 => [4, str_ireplace("{name}", $player->getName(), str_ireplace("{display_name}", $player->getDisplayName(), $player->hasPermission("slapper.seeId") ? $this->getDataProperty(2) . "\n" . \pocketmine\utils\TextFormat::GREEN . "Entity ID: " . $this->getId() : $this->getDataProperty(2)))],
	38 => [7, -1]
        ];
        $player->dataPacket($pk);
        parent::spawnTo($player);
    }


}
