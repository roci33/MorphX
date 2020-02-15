<?php
declare(strict_types=1);

namespace Roci33\MorphX;

class PlayerData {
    private $main;
    private $player;

    /** @var int|null */
    public $id = null;

    public function __construct(Main $main, string $player) {
        $this->main = $main;
        $this->player = $player;

        $path = $this->getPath();
        if (!is_file($path)) {
            return;
        }
        $data = yaml_parse_file($path);
        $this->id = $data["id"];
    }

    public function save() {
        yaml_emit_file($this->getPath(), [
            "id" => $this->id
        ]);
    }

    public function getPath(): string {
        return $this->main->getDataFolder() . strtolower($this->player) . ".yml";
    }

    ///*******************************************EntityID**************************************************\\\

    public function saveEntityId(int $id) {
        $this->id = $id;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function isId(): bool {
        if ($this->id !== null) {
            return true;
        }
        return false;
    }

    public function removeEntityId() {
        $this->id = null;
    }
}
