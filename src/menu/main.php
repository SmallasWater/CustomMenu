<?php


namespace menu;


use menu\createMenu\menu;
use menu\createMenu\showMenu;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class main extends PluginBase
{

    const ID = "DIYMenu";

    private static $main;

    public $playerClickMenu = [];

    //针对win10

    public $playerClickCount = [];

    public function onEnable()
    {
        self::$main = $this;
        @mkdir($this->getDataFolder(),0777,true);
        if(!is_file($this->getDataFolder()."config.yml")){
            $this->saveDefaultConfig();
            $this->reloadConfig();
        }
        @mkdir($this->getDataFolder()."Menus/",0777,true);
        $this->getServer()->getPluginManager()->registerEvents(new event(),$this);
        $this->getLogger()->info("自定义菜单加载成功---by若水");
        if(!$this->isInArray($this->getMenuTitle())){
            $this->createMenu($this->getMenuTitle());
        }
    }

    /**
     * @return mixed
     */
    public static function getMain():main
    {
        return self::$main;
    }

    public function getMenuConfig(String $name):Config{
        return new Config($this->getDataFolder()."/Menus/".$name.".yml",Config::YAML,[]);
    }



    public function getMenuTitle():String{
        return $this->getConfig()->get("菜单名称");
    }

    public function getMenu(String $name){
        return menu::getMenu($name);
    }

    public function getMainMenu():menu{
        if(!$this->isInArray($this->getMenuTitle())){
            $this->createMenu($this->getMenuTitle());
        }
        return menu::getMenu($this->getMenuTitle());
    }


    /*
     * 判断是否存在菜单
     * */
    public function isInArray(String $name):bool {
        return is_file($this->getDataFolder()."/Menus/".$name.".yml");
    }

    /*
     * 进服是否给予
     * */

    public function isGive():bool {
        return $this->getConfig()->get("进服是否给予");
    }
    /*
     * 是否附魔
     * */

    public function isEnchant():bool {
        return $this->getConfig()->get("附魔光辉");
    }

    /*
    * 是否为菜单
    * */

    public function isMenu(Item $item):bool {
        $tag = $item->getNamedTag();
        if($tag->hasTag("ID")){
            return ($tag->getTag("ID") instanceof StringTag && $tag->getTag("ID")->getValue() == self::ID);
        }
        return false;
    }


    /*
     * 菜单lore
     * */
    public function getLore():String {
        return $this->getConfig()->get("菜单lore");
    }
    /*
     * 给予菜单提示
     * */
    public function getGiveMenuMessage():String {
        return $this->getConfig()->get("给予菜单提示");
    }
    /*
     * 菜单物品
     * */
    public function getItem():Item {
        $sItem = $this->getConfig()->get("菜单物品");
        $array = explode(":",$sItem);
        if(isset($array[0]) && isset($array[1])){
            $item = new Item(intval($array[0]),intval($array[1]));
        }else if(isset($array[0])){
            $item =  new Item(intval($array[0]),0);

        }else{
            $item =  new Item(264,0);
        }
        $itemTag = $item->getNamedTag();
        if($this->isEnchant()){
            $ench = new ListTag("ench", [], NBT::TAG_Compound);
            $itemTag->setTag($ench);
        }
        $itemTag->setTag(new StringTag("ID",self::ID));
        $item->setNamedTag($itemTag);
        $item->setCustomName($this->getMenuTitle());
        $item->setLore(explode("\n",$this->getLore()));
        return $item;
    }

    /**
     *
     * @return String[]
    */
    public function getMenus():array {
        $array = [];
        $dir = $this->getDataFolder() . "/Menus/";
        $dir_list = scandir($dir);
        foreach ($dir_list as $l) {
            $name = explode('.yml',$l);
            if ($name[0] != '.' && $name[0] != '..') {
                $array[] = $name[0];
            }
        }
        return $array;
    }



    public function hasItem(Player $player):bool {
        foreach($player->getInventory()->getContents() as $items){
            if(main::getMain()->isMenu($items)){
                return true;
            }
        }
        return false;
    }


    public function createMenu(String $name,$type = null){
        $resTask = $this->getResource("menu.yml");
        if($type == "custom"){
            $resTask = $this->getResource("menu2.yml");
        }
        stream_copy_to_stream($resTask,$fp = fopen($this->getDataFolder()."/Menus/".$name.".yml","wb"));
        fclose($resTask);
        fclose($fp);
        $config = $this->getMenuConfig($name);
        if($name != $this->getMenuTitle()){
            $config->set("标题",$this->getMenuTitle()."---".$name);
        }else{
            $config->set("标题",$this->getMenuTitle());
        }
        $config->save();

    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if($command->getName() == "menu"){
            if(!isset($args[0])){
                if($sender instanceof Player){
                    if(!$this->hasItem($sender)){
                        $sender->getInventory()->addItem($this->getItem());
                        $sender->sendMessage($this->getGiveMenuMessage());
                    }
                    showMenu::sendClick($sender,$this->getMainMenu());
                }
            }else if($args[0] == "add"){
                if(isset($args[1])){
                   if($args[1] == "custom" || $args[1] == "form"){
                       if(!$this->isInArray($args[2])){
                           $this->createMenu($args[2],$args[1]);
                           $sender->sendMessage($args[2]."菜单创建成功");
                       }else{
                           $sender->sendMessage("菜单".$args[2]."存在");
                       }
                   }else{
                       $sender->sendMessage("请输入菜单类型 custom/form");
                   }
                }else{
                    $sender->sendMessage("请输入菜单类型 custom/form");
                }
            }
        }
        return true;
    }

}