<?php

declare(strict_types=1);

namespace BedrockCommunity\level\generator\populator;

use pocketmine\level\ChunkManager;
use pocketmine\level\generator\object\Ore as ObjectOre;
use pocketmine\level\generator\object\OreType;
use pocketmine\level\generator\populator\Populator;
use pocketmine\utils\Random;

class NetherOre extends Populator {
	/** @var OreType[] */
	private $oreTypes = [];

	public function populate(ChunkManager $level, int $chunkX, int $chunkZ, Random $random){
		foreach($this->oreTypes as $type){
			$ore = new ObjectOre($random, $type);
			for($i = 0; $i < $ore->type->clusterCount; ++$i){
				$x = $random->nextRange($chunkX << 4, ($chunkX << 4) + 15);
				$y = $random->nextRange($ore->type->minHeight, $ore->type->maxHeight);
				$z = $random->nextRange($chunkZ << 4, ($chunkZ << 4) + 15);
				if($ore->canPlaceObject($level, $x, $y, $z)){
					$ore->placeObject($level, $x, $y, $z);
				}
			}
		}
	}

	/**
	 * @param OreType[] $types
	 */
	public function setOreTypes(array $types){
		$this->oreTypes = $types;
	}
}