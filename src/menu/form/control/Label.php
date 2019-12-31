<?php


namespace menu\form\control;


class Label extends baseControl
{


    private $type;
    function __construct(string $text)
    {
        parent::__construct($text);
        $this->type = "label";

    }
    public function getType(): string
    {
       return $this->type;
    }

    public function getText(): string
    {
       return $this->text;
    }

    /**
     * @param String $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }
}