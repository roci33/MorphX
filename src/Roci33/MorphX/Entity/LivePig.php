<?php
declare(strict_types=1);

namespace Roci33\MorphX\Entity;
use pocketmine\entity\Living;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use Roci33\MorphX\Main;
use Roci33\MorphX\PlayerData;

class LivePig extends Living {
    public const NETWORK_ID = self::PIG;

    public $width = 0.9;
    public $height = 0.9;
    public $player;
    public $plugin;

    public function __construct(Level $level, CompoundTag $nbt, Player $player, Main $plugin) {
        parent::__construct($level, $nbt);
        $this->player = $player;
        $this->plugin = $plugin;
    }

    public function getName(): string {
        return "Pig";
    }

    public function canSaveWithChunk(): bool {
        return false;
    }

    public function entityBaseTick(int $tickDiff = 1): bool {
        if (!$this->player->isFlying()) {
            $this->setPosition(new Vector3($this->player->getX(), $this->player->getY(), $this->player->getZ()));
            $this->setRotation($this->player->getYaw(), $this->player->getPitch());
            return true;
        }
        $this->player->sendMessage(TextFormat::RED . "Error: You cannot spawn an entity if you are flying ");
        $data = new PlayerData($this->plugin, $this->player->getName());
        $id = $this->player->getLevel()->getEntity($data->getId());
        $id->close();
        $data->removeEntityId();
        $data->save();
        return true;
    }
}