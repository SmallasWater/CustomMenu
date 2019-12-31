<?php


namespace menu\form\windows;


use menu\form\control\baseControl;
use menu\form\control\DropDown;
use menu\form\control\Input;
use menu\form\control\StepSlider;
use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\Player;

class FormCustom extends baseForm
{
    private $type;
    private $content = [];

    public function __construct(string $title)
    {
        parent::__construct($title);
        $this->type = "custom_form";
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return String
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return baseControl[]
     */
    public function getContent(): array
    {
        return $this->content;
    }

    public function addContent(baseControl $control){
        $this->content[] = $control;
    }



    public function send(Player $player,int $id){
        $data = [];
        $data["type"] = $this->type;
        $data["title"] = $this->title;
        $contents = [];
        foreach($this->getContent() as $c){
            if($c instanceof Input){
                if($c->getDefaultText() != null){
                    $contents[] = [
                        "type" => $c->getType(),
                        "text" => $c->getText(),
                        "defaultText" => $c->getDefaultText()
                    ];
                    continue;
                }

            }
            if($c instanceof StepSlider){
                $contents[] = [
                    "type" => $c->getType(),
                    "text" => $c->getText(),
                    "steps" => $c->getSteps()
                ];
                continue;
            }
            if($c instanceof DropDown){
                $contents[] = [
                    "type" => $c->getType(),
                    "text" => $c->getText(),
                    "options" => $c->getList()
                ];
                continue;
            }
            $contents[] = [
                "type" => $c->getType(),
                "text" => $c->getText(),
            ];


        }
        $data["content"] = $contents;
        $pk = new ModalFormRequestPacket();
        $pk->formId = $id;
        $pk->formData = json_encode($data);
        $player->sendDataPacket($pk);
    }



}