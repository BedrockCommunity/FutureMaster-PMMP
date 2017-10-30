<?php

namespace BedrockCommunity\block;

use BedrockCommunity\tile\Tile;
use BedrockCommunity\tile\EnderChest as TileEnderChest;

use pocketmine\block\Block;
use pocketmine\block\Transparent;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\Player;

class EnderChest extends Transparent {

	protected $id = Block::ENDER_CHEST;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function canBeActivated(): bool{
		return true;
	}

	public function getHardness(): float{
		return 22.5;
	}

	public function getResistance(): float{
		return 3000;
	}

	public function getLightLevel(): int{
		return 7;
	}

	public function getName(): string{
		return "Ender Chest";
	}

	public function getToolType(): int{
		return Tool::TYPE_PICKAXE;
	}

	public function place(Item $item, Block $block, Block $target, int $face, Vector3 $facePos, Player $player = null): bool{
		$faces = [
			0 => 4,
			1 => 2,
			2 => 5,
			3 => 3,
		];

		$this->meta = $faces[$player instanceof Player ? $player->getDirection() : 0];

		$this->getLevel()->setBlock($block, $this, true, true);

		$nbt = new CompoundTag("", [
			new StringTag("id", Tile::ENDER_CHEST),
			new IntTag("x", $this->x),
			new IntTag("y", $this->y),
			new IntTag("z", $this->z),
		]);

		if($item->hasCustomName()){
			$nbt->CustomName = new StringTag("CustomName", $item->getCustomName());
		}

		Tile::createTile("EnderChest", $this->getLevel(), $nbt);

		return true;
	}

	public function onActivate(Item $item, Player $player = null): bool{
		if($player instanceof Player){
			$top = $this->getSide(Vector3::SIDE_UP);
			if($top->isTransparent() !== true){
				return true;
			}

			if(!(($tile = $this->getLevel()->getTile($this)) instanceof TileEnderChest)){
				$nbt = new CompoundTag("", [
					new StringTag("id", Tile::ENDER_CHEST),
					new IntTag("x", $this->x),
					new IntTag("y", $this->y),
					new IntTag("z", $this->z),
				]);
				$tile = Tile::createTile("EnderChest", $this->getLevel(), $nbt);
			}

			if($player->isCreative()){
				return true;
			}

			if($tile instanceof TileEnderChest){
				// tnx https://github.com/RealDevs/TableSpoon
				$player->addWindow($tile->getInventory());
			}
		}

		return true;
	}

	public function getDrops(Item $item): array{
		if($item->hasEnchantment(Enchantment::SILK_TOUCH)){
			return [
				[$this->id, 0, 1],
			];
		}

		return [
			[Item::OBSIDIAN, 0, 8],
		];
	}

	protected function recalculateBoundingBox(): AxisAlignedBB{
		return new AxisAlignedBB(
			$this->x + 0.0625,
			$this->y,
			$this->z + 0.0625,
			$this->x + 0.9375,
			$this->y + 0.9475,
			$this->z + 0.9375
		);
	}

}