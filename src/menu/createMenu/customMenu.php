<?php


namespace menu\createMenu;


class customMenu extends menu
{
    /*
     * 跳转UI
     * */
    private $ui;
    /*
     * 执行指令
     * */
    private $cmd;
    /*
     * 执行模式
     * */
    private $mode;
    /*
    * 点击信息
    * */
    private $click;
    /*
     * 控件
     * */
    private $control = [];

    public function __construct($name)
    {
        parent::__construct($name);
        $this->init();
    }

    private function init(){
        $this->ui = $this->config->get("跳转UI");
        $this->cmd = $this->config->get("指令");
        $this->mode = $this->config->get("执行模式");
        $this->click = $this->config->get("点击信息");
        $this->control = $this->MenuClass();
    }

    /**
     * @return customMenuClass[]
    */
    private function MenuClass():array {
        $menus = [];
        $array = $this->config->getAll();
        foreach ($array["content"] as $buttonName => $value){
            $menus[] = new customMenuClass($this->name
                ,$value["文本"]
                ,$value["返回变量"]
                ,$value["type"]
                ,$value);
        }
        return $menus;
    }

    /**
     * @return bool|mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return bool|mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getClick()
    {
        return $this->click;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @return mixed
     */
    public function getUi()
    {
        return $this->ui;
    }

    /**
     * @return mixed
     */
    public function getCmd()
    {
        return $this->cmd;
    }

    /**
     * @return customMenuClass[]
     */
    public function getControl(): array
    {
        return $this->control;
    }

}