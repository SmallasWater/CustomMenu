<?php


namespace menu\createMenu;


use menu\form\control\baseControl;
use menu\form\control\DropDown;
use menu\form\control\Input;
use menu\form\control\Label;
use menu\form\control\StepSlider;
use menu\form\control\Toggle;


class customMenuClass
{


    /*
    * 控件文本
    */
    private $text;
    /*
    * 菜单名称
    */
    private $menuName;
    /*
    * 返回变量
    */
    private $returnType;
    /*
     * 控件类型
     * */
    private $type;

    /*
     *其他设置
    */
    private $value = [];



    public function __construct(string $menuName,string $text,string $returnType,string $type,array $value)
    {
        $this->text = $text;
        $this->menuName = $menuName;
        $this->returnType = $returnType;
        $this->type = $type;
        $this->value = $value;

    }

    /**
     * @return String
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return String
     */
    public function getMenuName(): string
    {
        return $this->menuName;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return String
     */
    public function getReturnType(): string
    {
        return $this->returnType;
    }

    public function toControl():baseControl{
        switch ($this->type){
            case "input":
                $input =  new Input($this->text);
                if(isset($this->value["default"])){
                    $input->setDefaultText($this->value["default"]);
                }
                return $input;
                break;
            case "toggle":
                return new Toggle($this->text);
                break;
            case "label":
                return new Label($this->text);
                break;
            case "dropdown":
                $drop = new DropDown($this->text);
                $drop->setList($this->value["list"]);
                return $drop;
                break;
            case "step_slider":
                $step = new StepSlider($this->text);
                $step->setMin($this->value["min"]);
                $step->setMax($this->value["max"]);
                $step->setShowText($this->value["text"]);
                $step->setMin0Text($this->value["min0Text"]);
                $step->setMinMaxText($this->value["minMaxText"]);
                return $step;
                break;
        }
        return null;
    }

}