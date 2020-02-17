<?php
declare(strict_types=1);

namespace Roci33\MorphX;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use Roci33\MorphX\Command\Morph;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\entity\Effect;

class Main extends PluginBase implements Listener {

    private $ps = [];

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->registerCommands();
    }

    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $this->ps[$player->getId()] = new PlayerData($this, $player->getName());
    }

    public function onQuit(PlayerQuitEvent $event) {
        $player = $event->getPlayer();
        if (isset($this->ps[$player->getId()])) {
            unset($this->ps[$player->getId()]);
            $player->removeEffect(Effect::INVISIBILITY);

        }
    }

    ///*******************************************RegisterEntityCommand**************************************************\\\
    private function registerCommands(): void {
        $this->getServer()->getCommandMap()->registerAll($this->getName(), [
            new Morph($this)
        ]);
    }
}

