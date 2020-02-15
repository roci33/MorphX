<?php
declare(strict_types=1);

namespace Roci33\MorphX\Entity;
use pocketmine\entity\Living;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;

class LiveWitherSkeleton extends Living {
    public const NETWORK_ID = self::WITHER_SKELETON;

    public $width = 0.72;
    public $height = 2.4;
    public $player;

    public function __construct(Level $level, CompoundTag $nbt, Player $player) {
        parent::__construct($level, $nbt);
        $this->player = $player;
    }

    public function getName(): string {
        return "Wither_Skeleton";
    }

    public function canSaveWithChunk() : bool{
        return false;
    }

    public function entityBaseTick(int $tickDiff = 1): bool {
        $speed = 1;
        $mp = $this->player->subtract($this)->normalize()->multiply($speed);
        $this->setMotion($mp);
        $this->setRotation($this->player->getYaw(), $this->player->getPitch());
        return true;
    }
}