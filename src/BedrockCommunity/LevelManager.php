<?php

namespace BedrockCommunity;

use BedrockCommunity\level\generator\ender\Ender;
use BedrockCommunity\level\generator\hell\Nether;
use BedrockCommunity\level\generator\VoidGenerator;

use pocketmine\level\generator\Generator;
use pocketmine\Server as PMServer;

class LevelManager {
	public static function init(){
		self::registerGenerators();
		self::loadAndGenerateLevels();
	}

	public static function registerGenerators(){
		Generator::addGenerator(Nether::class, "nether");
		Generator::addGenerator(Ender::class, "ender");
		Generator::addGenerator(VoidGenerator::class, "void");
	}

	public static function loadAndGenerateLevels(){
		if(!PMServer::getInstance()->loadLevel(FutureMaster::$netherName)){
			PMServer::getInstance()->generateLevel(FutureMaster::$netherName, time(), Generator::getGenerator("nether"));
		}
		FutureMaster::$netherLevel = PMServer::getInstance()->getLevelByName(FutureMaster::$netherName);


		if(!PMServer::getInstance()->loadLevel(FutureMaster::$endName)){
			PMServer::getInstance()->generateLevel(FutureMaster::$endName, time(), Generator::getGenerator("ender"));
		}
		FutureMaster::$endLevel = PMServer::getInstance()->getLevelByName(FutureMaster::$endName);
	}
}