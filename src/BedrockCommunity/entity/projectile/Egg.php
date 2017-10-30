<?php

declare(strict_types = 1);

namespace BedrockCommunity\entity\projectile;

use pocketmine\entity\projectile\Throwable;

class Egg extends Throwable {
	const NETWORK_ID = self::EGG;

	public function onUpdate(int $currentTick): bool{
		if($this->isCollided || $this->age > 1200){
			// TODO: spawn chickens on collision
			$this->kill();
		}

		return parent::onUpdate($currentTick);
	}
}