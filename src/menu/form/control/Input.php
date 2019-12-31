<?php

namespace menu\form\control;


class Input extends baseControl
{
    private $type;
    private $defaultText = null;
    function __construct(string $text)
    {
        parent::__construct($text);
        $this->type = "input";

    }

    /**
     * @return mixed
     */
    public function getDefaultText()
    {
        return $this->defaultText;
    }


    /**
     * @param mixed $defaultText
     */
    public function setDefaultText($defaultText): void
    {
        $this->defaultText = $defaultText;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }


    public function getText(): string
    {
       return $this->text;
    }
}