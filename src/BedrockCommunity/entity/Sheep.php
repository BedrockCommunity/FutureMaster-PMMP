<?php

namespace BedrockCommunity\entity;

use BedrockCommunity\item\enchantment\Enchantment;
use BedrockCommunity\Player;

use pocketmine\entity\Animal;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\item\Item;

class Sheep extends Animal {
	const NETWORK_ID = self::SHEEP;

	public $width = 0.3;
	public $length = 0.9;
	public $height = 0;

	public function getName(): string{
		return "Sheep";
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
				$drops = [Item::get(Item::WOOL, mt_rand(0, 15), 1)]; // TODO: Implement this properly.
				$drops[] = Item::get(Item::RAW_MUTTON, 0, mt_rand(1, 2 + $lootingL));

				return $drops;
			}
		}

		return [];
	}
}