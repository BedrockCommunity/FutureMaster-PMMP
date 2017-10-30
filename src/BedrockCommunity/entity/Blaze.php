<?php

namespace BedrockCommunity\entity;

use BedrockCommunity\item\enchantment\Enchantment;

use pocketmine\entity\Monster;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\item\Item;
use pocketmine\Player;

class Blaze extends Monster {
	const NETWORK_ID = self::BLAZE;

	public $width = 0.3;
	public $length = 0.9;
	public $height = 1.8;

	public function getName(): string{
		return "Blaze";
	}

	public function getDrops(): array{
		$cause = $this->lastDamageCause;
		if($cause instanceof EntityDamageByEntityEvent){
			$damager = $cause->getDamager();
			if($damager instanceof Player){
				$looting = $damager->getInventory()->getItemInHand()->getEnchantment(Enchantment::LOOTING);
				if($looting !== null){
					$lootingL = $looting->getLevel();
				} else {
					$lootingL = 0;
				}
				$drops = [Item::get(Item::BLAZE_ROD, 0, mt_rand(0, 1 + $lootingL))];

				return $drops;
			}
		}

		return [];

	}
}