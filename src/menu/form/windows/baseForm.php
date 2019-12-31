<?php


namespace menu\form\windows;


use pocketmine\Player;

abstract class baseForm
{
    public $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    abstract public function send(Player $player,int $id);

}