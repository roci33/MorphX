<?php
declare(strict_types=1);

namespace Roci33\MorphX;
use pocketmine\entity\Entity;
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
            $data = new PlayerData($this, $player->getName());
            if ($data->isId() and $player->getLevel()->getEntity($data->getId()) instanceof Entity) {
                $id = $player->getLevel()->getEntity($data->getId());
                $id->close();
                foreach ($this->getServer()->getOnlinePlayers() as $player) {
                    $player->showPlayer($player);
                }
                $data->removeEntityId();
                $data->save();
            }
        }
    }

    ///*******************************************RegisterEntityCommand**************************************************\\\
    private function registerCommands(): void {
        $this->getServer()->getCommandMap()->registerAll($this->getName(), [
            new Morph($this)
        ]);
    }
}

