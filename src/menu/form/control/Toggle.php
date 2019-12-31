<?php

namespace menu\form\control;


class Toggle extends baseControl
{
    private $type;
    function __construct(string $text)
    {
        parent::__construct($text);
        $this->type = "toggle";

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