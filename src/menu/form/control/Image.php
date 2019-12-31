<?php


namespace menu\form\control;


class Image
{
    const IMAGE_DATA_TYPE_PATH = "path";
    const IMAGE_DATA_TYPE_URL = "url";
    private $type;
    private $data;

    function __construct(string $path,string $data)
    {
        $this->type = $path;
        $this->data = $data;

    }

    /**
     * @return String
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @return String
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param String $data
     */
    public function setData(string $data)
    {
        $this->data = $data;
    }

    /**
     * @param String $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

}