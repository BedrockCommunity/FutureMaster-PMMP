<?php

declare(strict_types = 1);

namespace BedrockCommunity\level\generator\ender\biome;

use pocketmine\level\generator\biome\Biome;

class EnderBiome extends Biome {

	public function getName(): string{
		return "Ender";
	}
}