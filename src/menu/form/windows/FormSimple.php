<?php


namespace menu\form\windows;


use menu\form\control\Button;
use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\Player;

class FormSimple extends baseForm
{
    
    /*
     * 内容
     * */
    private $content;

    private $type;

    private $buttons = [];

    function __construct(string $title)
    {
        parent::__construct($title);
        $this->type = "form";
    }


    /**
     * @param String $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @param String $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function addButton(Button $button){
        $this->buttons[] = $button;
    }

    /**
     * @return Button[]
     */
    public function getButtons(): array
    {
        return $this->buttons;
    }


    public function send(Player $player,int $id){
        $data = [];
        $data["type"] = $this->type;
        $data["title"] = $this->title;
        $data["content"] = $this->content;
        $buttons = [];
        foreach($this->buttons as $btn){
            $buttons[] = [
                "text" => $btn->getText(),
                "image"=>[
                    "type" => $btn->getImage()->getType(),
                    "data" => $btn->getImage()->getData()
                ]
            ];
        }
        $data["buttons"] = $buttons;
        $pk = new ModalFormRequestPacket();
        $pk->formId = $id;
        $pk->formData = json_encode($data);
        $player->sendDataPacket($pk);
    }



}