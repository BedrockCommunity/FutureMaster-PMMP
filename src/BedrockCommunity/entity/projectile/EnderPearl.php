<?php

declare(strict_types = 1);

namespace BedrockCommunity\entity\projectile;

use pocketmine\entity\Human;
use pocketmine\entity\projectile\Throwable;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\level\sound\EndermanTeleportSound;

class EnderPearl extends Throwable {
	const NETWORK_ID = self::ENDER_PEARL;

	public function onUpdate(int $currentTick): bool{
		if($this->isCollided || $this->age > 1200){
			$p = $this->getOwningEntity();
			if($p instanceof Human && $this->y > 0){ // HOOMAN
				$this->getLevel()->addSound(new EndermanTeleportSound($this->getPosition()), [$p]);
				$p->teleport($this->getPosition());
				$p->attack(new EntityDamageEvent($p, EntityDamageEvent::CAUSE_FALL, 5));
				$this->kill();
			}
		}

		return parent::onUpdate($currentTick);
	}
}