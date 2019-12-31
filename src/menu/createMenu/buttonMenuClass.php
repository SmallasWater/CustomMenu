<?php

namespace menu\createMenu;


class buttonMenuClass
{

    /*
    * 执行模式
    * */
    private $mode;
    /*
     * 菜单名称
     */
    private $menuName;
    /*
     * 按键名称
     * */
    private $buttonName;
    /*
     * 指令
     * */
    private $cmd;
    /*
     * 跳转UI
     * */
    private $ui;
    /*
     * 点击信息
     * */
    private $clickMessage;
    /*
     * 图片类型
     * */
    private $imageType;
    /*
     * 图片路径
     * */
    private $imagePath;

    public function __construct(string $menuName,string $buttonName,string $cmd,string $ui,string $clickMessage,string $imageType,string $imagePath,int $mode)
    {
        $this->menuName = $menuName;
        $this->buttonName = $buttonName;
        $this->cmd = $cmd;
        $this->ui = $ui;
        $this->clickMessage = $clickMessage;
        $this->imageType = $imageType;
        $this->imagePath = $imagePath;
        $this->mode = $mode;

    }

    /**
     * @return string
     */
    public function getMenuName(): string
    {
        return $this->menuName;
    }
    /**
     * @return string
     */
    public function getButtonName(): string
    {
        return $this->buttonName;
    }

    /**
     * @return string
     */
    public function getClickMessage(): string
    {
        return $this->clickMessage;
    }

    /**
     * @return string
     */
    public function getCmd(): string
    {
        return $this->cmd;
    }

    /**
     * @return string
     */
    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    /**
     * @return string
     */
    public function getImageType(): string
    {
        return $this->imageType;
    }

    /**
     * @return int
     */
    public function getMode(): int
    {
        return $this->mode;
    }

    /**
     * @return string
     */
    public function getUi(): string
    {
        return $this->ui;
    }


}