<?php

namespace BedrockCommunity\level\generator\populator;

use pocketmine\level\ChunkManager;
use pocketmine\level\generator\object\Ore as ObjectOre;
use pocketmine\level\generator\populator\Populator;
use pocketmine\utils\Random;

class NetherGlowStone extends Populator {

	/** @var ChunkManager */
	//private $level;
	private $oreTypes = [];

	/**
	 * @param ChunkManager $level
	 * @param              $chunkX
	 * @param              $chunkZ
	 * @param Random $random
	 *
	 * @return mixed|void
	 */
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
	 * @param $x
	 * @param $z
	 *
	 * @return int

	private function getHighestWorkableBlock($x, $z){
		for($y = 127; $y >= 0; --$y){
			$b = $this->level->getBlockIdAt($x, $y, $z);
			if($b == 0){
				break;
			}
		}

		return $y === 0 ? -1 : ++$y;
	}*/

}