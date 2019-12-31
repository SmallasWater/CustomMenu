<?php


namespace menu\form\control;


abstract class baseControl
{
    public $text;


    public function __construct(string $text){
        $this->text = $text;
    }

    abstract public function getType(): string;

    abstract public function getText(): string;

}