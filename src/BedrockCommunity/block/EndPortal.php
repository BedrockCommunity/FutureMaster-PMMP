<?php

namespace BedrockCommunity\block;

use pocketmine\block\Block;
use pocketmine\block\Solid;
use pocketmine\item\Item;
use pocketmine\math\Vector3;

class EndPortal extends Solid {

	protected $id = Block::END_PORTAL;

	/** @var  Vector3 */
	private $temporalVector = null;

	public function __construct($meta = 0){
		$this->meta = $meta;
		if($this->temporalVector === null){
			$this->temporalVector = new Vector3(0, 0, 0);
		}
	}

	public function getLightLevel(): int{
		return 1;
	}

	public function getName(): string{
		return "End Portal";
	}

	public function getHardness(): float{
		return -1;
	}

	public function getResistance(): float{
		return 18000000;
	}

	public function isBreakable(Item $item): bool{
		return false;
	}

	public function canPassThrough(): bool{
		return true;
	}

	public function hasEntityCollision(): bool{
		return true;
	}
}