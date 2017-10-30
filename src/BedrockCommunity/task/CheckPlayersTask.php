<?php

declare(strict_types = 1);

namespace BedrockCommunity\task;

use BedrockCommunity\FutureMaster;
use BedrockCommunity\Utils;

use pocketmine\network\mcpe\protocol\ChangeDimensionPacket;
use pocketmine\network\mcpe\protocol\PlayStatusPacket;
use pocketmine\network\mcpe\protocol\types\DimensionIds;
use pocketmine\scheduler\PluginTask;
use pocketmine\Server;

class CheckPlayersTask extends PluginTask {
	public function onRun(int $currentTick){
		foreach(Server::getInstance()->getOnlinePlayers() as $p){
			$epo = Utils::isInsideOfEndPortal($p);
			$po = Utils::isInsideOfPortal($p);
			if($epo || $po/* && !in_array($p->getName(), Main::$teleporting)*/){
				if($p->getLevel()->getName() !== FutureMaster::$netherLevel->getName() && $p->getLevel()->getName() !== FutureMaster::$endLevel->getName()){
					if($po){
						$pk = new ChangeDimensionPacket();
						$pk->dimension = DimensionIds::NETHER;
						$pk->position = FutureMaster::$netherLevel->getSafeSpawn();
						$p->dataPacket($pk);
						$p->sendPlayStatus(PlayStatusPacket::PLAYER_SPAWN);
						$p->teleport(FutureMaster::$netherLevel->getSafeSpawn());
						//Main::$teleporting[] = $p->getName();
					}elseif($epo){
						$pk = new ChangeDimensionPacket();
						$pk->dimension = DimensionIds::THE_END;
						$pk->position = FutureMaster::$endLevel->getSafeSpawn();
						$p->dataPacket($pk);
						$p->sendPlayStatus(PlayStatusPacket::PLAYER_SPAWN);
						$p->teleport(FutureMaster::$endLevel->getSafeSpawn());
						//Main::$teleporting[] = $p->getName();
					}
				}else{
					$pk = new ChangeDimensionPacket();
					$pk->dimension = DimensionIds::OVERWORLD;
					$pk->position = Server::getInstance()->getDefaultLevel()->getSafeSpawn();
					$p->dataPacket($pk);
					$p->sendPlayStatus(PlayStatusPacket::PLAYER_SPAWN);
					$p->teleport(Server::getInstance()->getDefaultLevel()->getSafeSpawn());
					//Main::$teleporting[] = $p->getName();
				}
			}
		}
	}
}