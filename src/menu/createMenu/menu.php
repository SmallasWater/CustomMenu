<?php


namespace menu\createMenu;


use menu\main;

abstract class menu
{

    const PLAYER = 0;

    const OP = 1;

    const CONSOLE = 2;



    public $config;
    /*
     * 菜单名称
     * */
    public $name;
    /*
     * 标题
     * */
    public $title;
//    /*
//     * 自定义信息
//     * */
//    public $content;
    /*
     * 类型
     * */
    public $type;



    public function __construct(string $name)
    {
        $this->name = $name;
        $this->config = main::getMain()->getMenuConfig($name);
        $this->type = $this->config->get("type");
        $this->title = $this->config->get("标题");

    }

    /**
     * @param String $name
     * @return buttonMenu|customMenu
     */
    public static function getMenu(string $name){
        switch (main::getMain()->getMenuConfig($name)->get("type")){
            case "form":
                return new buttonMenu($name);
                break;
            case "custom_form":
                return new customMenu($name);
                break;
        }
        return new buttonMenu($name);
    }
}