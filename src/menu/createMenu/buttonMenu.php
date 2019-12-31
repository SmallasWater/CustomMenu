<?php


namespace menu\createMenu;


use pocketmine\utils\Config;

class buttonMenu extends menu
{
    private $menuClass = [];

    public $content;

    public function __construct($name)
    {
        parent::__construct($name);
        $this->init();
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return String
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return Config
     */
    public function getConfig():Config
    {
        return $this->config;
    }


    /**
     * @return buttonMenuClass[]
     */
    public function getMenuClass(): array
    {
        return $this->menuClass;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }


    private function init(){
        $this->menuClass = $this->MenuClass();
        $this->content = $this->config->get("content");
    }

    private function MenuClass():array {
        $menus = [];
        $array = $this->config->getAll();
        foreach ($array["按键"] as $buttonName => $value){
            $menus[] = new buttonMenuClass($this->name,$buttonName
                ,$value["指令"]
                ,$value["跳转UI"]
                ,$value["点击信息"]
                ,$value["图片类型"]
                ,$value["图片路径"]
                ,intval($value["执行模式"]));

        }
        return $menus;
    }

}