<?php

namespace BedrockCommunity\level\generator\populator;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\populator\Populator;
use pocketmine\utils\Random;

class GroundFire extends Populator {
	/** @var ChunkManager */
	private $level;
	private $randomAmount;
	private $baseAmount;

	/**
	 * @param $amount
	 */
	public function setRandomAmount($amount){
		$this->randomAmount = $amount;
	}

	/**
	 * @param $amount
	 */
	public function setBaseAmount($amount){
		$this->baseAmount = $amount;
	}

	/**
	 * @param ChunkManager $level
	 * @param              $chunkX
	 * @param              $chunkZ
	 * @param Random $random
	 *
	 * @return mixed|void
	 */
	public function populate(ChunkManager $level, int $chunkX, int $chunkZ, Random $random){
		$this->level = $level;
		$amount = $random->nextRange(0, $this->randomAmount + 1) + $this->baseAmount;
		for($i = 0; $i < $amount; ++$i){
			$x = $random->nextRange($chunkX * 16, $chunkX * 16 + 15);
			$z = $random->nextRange($chunkZ * 16, $chunkZ * 16 + 15);
			$y = $this->getHighestWorkableBlock($x, $z);
			//echo "Fire to $x, $y, $z\n";
			if($y !== -1 and $this->canGroundFireStay($x, $y, $z)){
				$this->level->setBlockIdAt($x, $y, $z, Block::FIRE);
				// OLD $this->level->updateBlockLight($x, $y, $z);
				$this->level->setBlockLightAt($x, $y, $z, Block::get(Block::FIRE)->getLightLevel());
			}
		}
	}

	/**
	 * @param $x
	 * @param $z
	 *
	 * @return int
	 */
	private function getHighestWorkableBlock($x, $z){
		for($y = 0; $y <= 127; ++$y){
			$b = $this->level->getBlockIdAt($x, $y, $z);
			if($b == Block::AIR){
				break;
			}
		}

		return $y === 0 ? -1 : $y;
	}

	/**
	 * @param $x
	 * @param $y
	 * @param $z
	 *
	 * @return bool
	 */
	private function canGroundFireStay($x, $y, $z){
		$b = $this->level->getBlockIdAt($x, $y, $z);

		return ($b === Block::AIR or $b === Block::SNOW_LAYER) and $this->level->getBlockIdAt($x, $y - 1, $z) === 87;
	}
}