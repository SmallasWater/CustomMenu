<?php


namespace menu;

use menu\createMenu\buttonMenu;
use menu\createMenu\customMenu;
use menu\createMenu\menu;
use menu\createMenu\showMenu;
use menu\form\control\DropDown;
use menu\form\control\Input;
use menu\form\control\StepSlider;
use menu\form\control\Toggle;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;
use pocketmine\Player;
use pocketmine\Server;

class event implements Listener
{

    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        $item = main::getMain()->getItem();
        if(!main::getMain()->hasItem($player)){
            $player->getInventory()->addItem($item);
            $player->sendMessage(main::getMain()->getGiveMenuMessage());
        }
    }

    public function onPacketReceived(DataPacketReceiveEvent $e)
    {
        $player = $e->getPlayer();
        if($player instanceof Player)
        {
            $pk = $e->getPacket();
            if($pk instanceof ModalFormResponsePacket)
            {
                $id = $pk->formId;
                $data = json_decode($pk->formData);
                switch($id) {
                    case showMenu::CLICK:
                        unset(main::getMain()->playerClickCount[$player->getName()]);
                        if ($pk->formData == "null\n") return;
                        if(isset(main::getMain()->playerClickMenu[$player->getName()])){
                            $menu = main::getMain()->playerClickMenu[$player->getName()];
                            if($menu instanceof buttonMenu){
                                $this->callButtonMenu($player,$menu,$data);
                            }
                            if($menu instanceof customMenu){
                                if(count($data) > 0){
                                    $this->callCustomMenu($player,$menu,$data);
                                }
                            }
                        }
                        break;
                    default:break;
                }
            }

        }

    }
    private function callCustomMenu(Player $player,customMenu $menu,$data){
        $cmd = $menu->getCmd();
        $mode = $menu->getMode();
        $click = $menu->getClick();
        $ui = $menu->getUi();
        if($cmd != null && $cmd != ""){
            $cmd = $this->str_replaceMessage($menu,$data,$cmd);
            $cmd = str_replace("@p","{$player->getName()}",$cmd);
            switch ($mode){
                case menu::PLAYER:
                    Server::getInstance()->dispatchCommand($player,$cmd);
                    break;
                case menu::CONSOLE:
                    Server::getInstance()->dispatchCommand(new ConsoleCommandSender(),$cmd);
                    break;
                default:break;
            }
        }
        if($ui != null && $ui != ""){
            $ui = $this->str_replaceMessage($menu,$data,$ui);
            if(main::getMain()->isInArray($ui)){
                $clickMenu = main::getMain()->getMenu($ui);
                showMenu::sendClick($player,$clickMenu);
            }else{
                Server::getInstance()->getLogger()->error("不存在".$ui."菜单");
            }
        }
        if($click != null && $click != ""){
            $player->sendMessage($this->str_replaceMessage($menu,$data,$click));
        }
    }

    private function str_replaceMessage(customMenu $controls,$data,$cmd):string {
        $class = $controls->getControl();
        if($class != null){
            for ($i = 0; $i < count($data);$i++){
                $base = $class[$i]->toControl();
                if($base instanceof DropDown){
                    $cmd = str_replace($class[$i]->getReturnType(),$base->getList()[$data[$i]],$cmd);
                    continue;
                }else if($base instanceof StepSlider){
                    $cmd = str_replace($class[$i]->getReturnType(), ($base->getMin() + $data[$i]) . "", $cmd);
                    continue;

                }else if($base instanceof Toggle){
                    $cmd = str_replace($class[$i]->getReturnType(),($data[$i] == 1?"true":"false"),$cmd);
                    continue;
                } else if($base instanceof Input){
                    $cmd = str_replace($class[$i]->getReturnType(),$data[$i],$cmd);
                }

            }
        }
        return $cmd;
    }

    private function callButtonMenu(Player $player,buttonMenu $menu,int $data){
        $menuClass = $menu->getMenuClass()[$data];
        $cmd = $menuClass->getCmd();
        $ui = $menuClass->getUi();
        $click = $menuClass->getClickMessage();
        if($cmd != null && $cmd != ""){
            $cmd = str_replace("@p","{$player->getName()}",$cmd);
            switch ($menuClass->getMode()){
                case menu::PLAYER:
                    Server::getInstance()->dispatchCommand($player,$cmd);
                    break;
                case menu::CONSOLE:
                    Server::getInstance()->dispatchCommand(new ConsoleCommandSender(),$cmd);
                    break;
                default:break;
            }
        }
        if($ui != null && $ui != ""){
            if(main::getMain()->isInArray($ui)){
                $clickMenu = main::getMain()->getMenu($ui);
                showMenu::sendClick($player,$clickMenu);
            }else{
                Server::getInstance()->getLogger()->error("不存在".$ui."菜单");
            }
        }
        if($click != null && $click != ""){
            $player->sendMessage($click);
        }
    }



    public function playerInt(PlayerInteractEvent $event)
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        if(main::getMain()->isMenu($item)){
            if(!isset(main::getMain()->playerClickCount[$player->getName()])) {
                main::getMain()->playerClickCount[$player->getName()] = true;
                showMenu::sendClick($player, main::getMain()->getMainMenu());
            }

        }

    }




}