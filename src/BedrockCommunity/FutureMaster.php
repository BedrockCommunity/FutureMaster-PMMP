<?php

declare(strict_types = 1);

namespace BedrockCommunity;

use BedrockCommunity\block\BlockManager;
use BedrockCommunity\commands\CommandManager;
use BedrockCommunity\entity\EntityManager;
use BedrockCommunity\item\enchantment\Enchantment;
use BedrockCommunity\item\ItemManager;
use BedrockCommunity\plugin\AllAPILoaderManager;
use BedrockCommunity\task\CheckPlayersTask;
use BedrockCommunity\tile\Tile;

use pocketmine\level\Level;
use pocketmine\Player as PMPlayer;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class FutureMaster extends PluginBase {
// Use static variables if it's going to be accessed by other Classes :)

	/** @var string */
	public static $netherName = "nether";
	/** @var Level */
	public static $netherLevel;

	/** @var string */
	public static $endName = "ender";
	/** @var Level */
	public static $endLevel;

	/** @var Config */
	public static $config;

	/** @var string */
	public static $checkingMode = "task";
	/** @var bool */
	public static $lightningFire = false;
	/** @var string[] */
	public static $teleporting = [];
	/** @var bool */
	public $loadAllAPIs = false;
	/** @var PMPlayer[] */
	public $lastUses = [];
	private $splashes = [
		'Low-Calorie blend',
		"Don't panic! Have a cup of tea",
		"In England, Everything stops for tea",
		"ENGLAND IS MY CITY (not really)",
		"POWERED By Dubstep",
		// Add more splashes fur fun. xD
	];

	public function onLoad(){
		if(Utils::checkSpoon()){
			$this->getLogger()->error("This plugin is for PMMP only. It is meant to extend PMMP's functionality.");
			$this->getLogger()->error("The plugin will now disable itself to prevent any interference with the existing Spoon features.");
			$this->getServer()->getPluginManager()->disablePlugin($this);
		}
		@mkdir($this->getDataFolder());
		$this->saveDefaultConfig();
		self::$config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

		self::$netherName = self::$config->get("netherName", "nether");
		self::$endName = self::$config->get("endName", "ender");
		self::$checkingMode = self::$config->get("dimensionDetectionType", "task");
		$this->loadAllAPIs = self::$config->get("loadAllAPIs", false);
		self::$lightningFire = self::$config->get("lightningFire", false);
	}

	public function onEnable(){
		$rm = $this->splashes[array_rand($this->splashes)];

		CommandManager::init();
		Enchantment::init();
		BlockManager::init();
		ItemManager::init();
		EntityManager::init();
		// LevelManager::init(); EXECUTED VIA EventListener
		if($this->loadAllAPIs){
			AllAPILoaderManager::init();
		}
		Tile::init();


		if(self::$checkingMode == "task"){
			$this->getServer()->getScheduler()->scheduleRepeatingTask(new CheckPlayersTask($this), 10);
		}
		$this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
	}
}