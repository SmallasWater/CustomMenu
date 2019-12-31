<?php


namespace menu\form\control;


class DropDown extends baseControl
{
    private $type;

    private $list = [];

    public function __construct(string $text)
    {
        parent::__construct($text);
        $this->type = "dropdown";
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->list;
    }

    /**
     * @param array $list
     */
    public function setList(array $list): void
    {
        $this->list = $list;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getText(): string
    {
        return $this->text;
    }
}