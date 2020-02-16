<?php
declare(strict_types=1);

namespace Roci33\MorphX\Command;
use pocketmine\Player;
use Roci33\MorphX\Entity\LiveCow;
use Roci33\MorphX\Entity\LiveCreeper;
use Roci33\MorphX\Entity\LiveSheep;
use Roci33\MorphX\Entity\LiveSkeleton;
use Roci33\MorphX\Entity\LiveVillager;
use Roci33\MorphX\Entity\LiveWitch;
use Roci33\MorphX\Entity\LiveWither;
use Roci33\MorphX\Entity\LiveWitherSkeleton;
use Roci33\MorphX\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;
use pocketmine\entity\Entity;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use Roci33\MorphX\Entity\LiveZombie;
use Roci33\MorphX\PlayerData;

class Morph extends Command implements PluginIdentifiableCommand {

    /** @var $plugin */
    private $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("morph", "This command allows you to become an entity", "Usage: /morph <mob>", ["m"]);
        $this->setPermission("morphX.command.morph");
        $this->plugin = $plugin;
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        $data = new PlayerData($this->plugin, $sender->getName());
        if ($this->testPermission($sender)) {
            if ($sender instanceof Player) {
                if (isset($args[0])) {
                    switch ($args[0]) {
                        case "help":
                            $sender->sendMessage(TextFormat::BLUE . "Command: \n" . "/morph list: Give you the list of Entity \n " . "/morph entity: It transforms you into the entity");
                            break;
                        case "list":
                            $sender->sendMessage(TextFormat::BLUE . "List Entity: cow, creeper, sheep, skeleton, villager, witch, wither, wither skeleton, zombie");
                            break;
                        case "remove":
                            if ($data->isId()) {
                                if ($sender->getLevel()->getEntity($data->getId()) instanceof Entity) {
                                    $sender->removeEffect(Effect::INVISIBILITY);
                                    $sender->sendMessage(TextFormat::RED . "You are now visibile");
                                    $id = $sender->getLevel()->getEntity($data->getId());
                                    $id->close();
                                    $data->removeEntityId();
                                    $data->save();
                                } else {
                                    $sender->sendMessage(TextFormat::RED . "Error: Entity not found");
                                    $data->removeEntityId();
                                    $data->save();
                                    $sender->sendMessage(TextFormat::BLUE . "All entity have been removed");
                                }
                            } else {
                                $sender->sendMessage(TextFormat::RED . "Error: Entity not found");
                            }
                            break;
                        case "zombie":
                            if (!$data->isId()) {
                                $nbt = Entity::createBaseNBT($sender->asVector3());
                                $ent = new LiveZombie($sender->level, $nbt, $sender);
                                $sender->sendMessage(TextFormat::RED . "Now you are Zombie!");
                                $ent->spawnToAll();
                                $sender->addEffect(new EffectInstance(Effect::getEffect(Effect::INVISIBILITY), INT32_MAX, 0, false));
                                $data->saveEntityId($ent->getId());
                                $data->save();
                            } else {
                                $sender->sendMessage(TextFormat::RED . "Error: you  have just spawn a mob, use /morph remove");
                            }
                            break;
                        case "villager":
                            if (!$data->isId()) {
                                $nbt = Entity::createBaseNBT($sender->asVector3());
                                $ent = new LiveVillager($sender->level, $nbt, $sender);
                                $sender->sendMessage(TextFormat::BLUE . "Now you are Villager!");
                                $ent->spawnToAll();
                                $sender->addEffect(new EffectInstance(Effect::getEffect(Effect::INVISIBILITY), INT32_MAX, 0, false));
                                $data->saveEntityId($ent->getId());
                                $data->save();
                            } else {
                                $sender->sendMessage(TextFormat::RED . "Error: you  have just spawn a mob, use /morph remove");
                            }
                            break;
                        case "skeleton":
                            if (!$data->isId()) {
                                $nbt = Entity::createBaseNBT($sender->asVector3());
                                $ent = new LiveSkeleton($sender->level, $nbt, $sender);
                                $sender->sendMessage(TextFormat::BLUE . "Now you are Skeleton!");
                                $ent->spawnToAll();
                                $sender->addEffect(new EffectInstance(Effect::getEffect(Effect::INVISIBILITY), INT32_MAX, 0, false));
                                $data->saveEntityId($ent->getId());
                                $data->save();
                            } else {
                                $sender->sendMessage(TextFormat::RED . "Error: you  have just spawn a mob, use /morph remove");
                            }
                            break;
                        case "creeper":
                            if (!$data->isId()) {
                                $nbt = Entity::createBaseNBT($sender->asVector3());
                                $ent = new LiveCreeper($sender->level, $nbt, $sender);
                                $sender->sendMessage(TextFormat::BLUE . "Now you are Creeper!");
                                $ent->spawnToAll();
                                $sender->addEffect(new EffectInstance(Effect::getEffect(Effect::INVISIBILITY), INT32_MAX, 0, false));
                                $data->saveEntityId($ent->getId());
                                $data->save();
                            } else {
                                $sender->sendMessage(TextFormat::RED . "Error: you  have just spawn a mob, use /morph remove");
                            }
                            break;
                        case "sheep":
                            if (!$data->isId()) {
                                $nbt = Entity::createBaseNBT($sender->asVector3());
                                $ent = new LiveSheep($sender->level, $nbt, $sender);
                                $sender->sendMessage(TextFormat::BLUE . "Now you are Sheep!");
                                $ent->spawnToAll();
                                $sender->addEffect(new EffectInstance(Effect::getEffect(Effect::INVISIBILITY), INT32_MAX, 0, false));
                                $data->saveEntityId($ent->getId());
                                $data->save();
                            } else {
                                $sender->sendMessage(TextFormat::RED . "Error: you  have just spawn a mob, use /morph remove");
                            }
                            break;
                        case "cow":
                            if (!$data->isId()) {
                                $nbt = Entity::createBaseNBT($sender->asVector3());
                                $ent = new LiveCow($sender->level, $nbt, $sender);
                                $sender->sendMessage(TextFormat::BLUE . "Now you are Cow!");
                                $ent->spawnToAll();
                                $sender->addEffect(new EffectInstance(Effect::getEffect(Effect::INVISIBILITY), INT32_MAX, 0, false));
                                $data->saveEntityId($ent->getId());
                                $data->save();
                            } else {
                                $sender->sendMessage(TextFormat::RED . "Error: you  have just spawn a mob, use /morph remove");
                            }
                            break;
                        case "witherskeleton":
                            if (!$data->isId()) {
                                $nbt = Entity::createBaseNBT($sender->asVector3());
                                $ent = new LiveWitherSkeleton($sender->level, $nbt, $sender);
                                $sender->sendMessage(TextFormat::BLUE . "Now you are Wither Skeleton!");
                                $ent->spawnToAll();
                                $sender->addEffect(new EffectInstance(Effect::getEffect(Effect::INVISIBILITY), INT32_MAX, 0, false));
                                $data->saveEntityId($ent->getId());
                                $data->save();
                            } else {
                                $sender->sendMessage(TextFormat::RED . "Error: you  have just spawn a mob, use /morph remove");
                            }
                            break;
                        case "wither":
                            if (!$data->isId()) {
                                $nbt = Entity::createBaseNBT($sender->asVector3());
                                $ent = new LiveWither($sender->level, $nbt, $sender);
                                $sender->sendMessage(TextFormat::BLUE . "Now you are Wither!");
                                $ent->spawnToAll();
                                $sender->addEffect(new EffectInstance(Effect::getEffect(Effect::INVISIBILITY), INT32_MAX, 0, false));
                                $data->saveEntityId($ent->getId());
                                $data->save();
                            } else {
                                $sender->sendMessage(TextFormat::RED . "Error: you  have just spawn a mob, use /morph remove");
                            }
                            break;
                        case "witch":
                            if (!$data->isId()) {
                                $nbt = Entity::createBaseNBT($sender->asVector3());
                                $ent = new LiveWitch($sender->level, $nbt, $sender);
                                $sender->sendMessage(TextFormat::BLUE . "Now you are Witch!");
                                $ent->spawnToAll();
                                $sender->addEffect(new EffectInstance(Effect::getEffect(Effect::INVISIBILITY), INT32_MAX, 0, false));
                                $data->saveEntityId($ent->getId());
                                $data->save();
                            } else {
                                $sender->sendMessage(TextFormat::RED . "Error: you  have just spawn a mob, use /morph remove");
                            }
                            break;
                    }
                } else {
                    $sender->sendMessage(TextFormat::RED . "Error: Unset name of mob, use /morph help ");
                }
            }
        }
        return true;
    }

    /**
     * @return Main
     */
    public
    function getPlugin(): Plugin {
        return $this->plugin;
    }
}

