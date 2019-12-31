<?php


namespace menu\createMenu;



use menu\form\control\Button;
use menu\form\control\Image;
use menu\form\windows\FormCustom;
use menu\form\windows\FormSimple;
use menu\main;
use pocketmine\Player;


class showMenu
{
    const CLICK = 0xAAC0002;

    public static function sendClick(Player $player,menu $class){
        main::getMain()->playerClickMenu[$player->getName()] = $class;
        $windows = null;
        if($class instanceof buttonMenu){
            $windows = new FormSimple($class->getTitle());
            $windows->setContent($class->getContent());
            foreach($class->getMenuClass() as $button){
                $windows->addButton(new Button($button->getButtonName(),new Image($button->getImageType(),$button->getImagePath())));
            }
        }
        if($class instanceof customMenu){
            $windows = new FormCustom($class->getTitle());
            foreach ($class->getControl() as $item){
                $windows->addContent($item->toControl());
            }
        }
        if($windows != null){
            $windows->send($player,self::CLICK);
        }
    }


}