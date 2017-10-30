<?php

namespace BedrockCommunity\tile;

use BedrockCommunity\inventory\EnderChestInventory;

use pocketmine\inventory\InventoryHolder;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\tile\Nameable;
use pocketmine\tile\Spawnable;

class EnderChest extends Spawnable implements InventoryHolder, Nameable {

	/**
	 * @return string
	 */
	public function getName(): string{
		return isset($this->namedtag->CustomName) ? $this->namedtag->CustomName->getValue() : "Ender Chest";
	}

	public function getDefaultName(): string{
		return "Ender Chest";
	}

	public function addAdditionalSpawnData(CompoundTag $nbt): void{
		if($this->hasName()){
			$nbt->CustomName = $this->namedtag->CustomName;
		}
	}

	/**
	 * @return bool
	 */
	public function hasName(): bool{
		return isset($this->namedtag->CustomName);
	}

	/**
	 * @param void $str
	 */
	public function setName(string $str){
		if($str === ""){
			unset($this->namedtag->CustomName);

			return;
		}

		$this->namedtag->CustomName = new StringTag("CustomName", $str);
	}

	public function getInventory(): EnderChestInventory{
		// tnx https://github.com/RealDevs/TableSpoon
		return new EnderChestInventory($this);
	}

}