<?php


namespace menu\form\control;


class Button
{
    private $text = "";
    private $image;
    function __construct(string $text,Image $image = null)
    {
        $this->text = $text;
        $this->image = $image;
    }

    /**
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }

    /**
     * @param Image $image
     */
    public function setImage(Image $image)
    {
        $this->image = $image;
    }

    /**
     * @return Image
     */
    public function getImage(): Image
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }


}