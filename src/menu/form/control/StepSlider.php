<?php


namespace menu\form\control;


class StepSlider extends baseControl
{
    private $type;
    private $min = 0;
    private $max = 100;
    private $showText;
    private $min0Text;
    private $minMaxText;

    public function __construct(string $text)
    {
        parent::__construct($text);
        $this->type = "step_slider";
    }


    public function getSteps():array {
        $array = [];
        for($i = 0;$i <= ($this->max - $this->min);$i++){
            if(($i + $this->min) == $this->min){
                $array[] = $this->min0Text;
                continue;
            }
            if(($i + $this->min) == $this->max){
                $array[] = $this->minMaxText;
                continue;
            }
            $array[] = str_replace("{i}",$i+$this->min,$this->showText);
        }
        return $array;

    }
    /**
     * @param int $max
     */
    public function setMax(int $max): void
    {
        $this->max = $max;
    }

    /**
     * @return int
     */
    public function getMin(): int
    {
        return $this->min;
    }

    /**
     * @return int
     */
    public function getMax(): int
    {
        return $this->max;
    }

    /**
     * @param int $min
     */
    public function setMin(int $min): void
    {
        $this->min = $min;
    }

    /**
     * @param mixed $min0Text
     */
    public function setMin0Text($min0Text): void
    {
        $this->min0Text = $min0Text;
    }

    /**
     * @param mixed $minMaxText
     */
    public function setMinMaxText($minMaxText): void
    {
        $this->minMaxText = $minMaxText;
    }

    /**
     * @param mixed $showText
     */
    public function setShowText($showText): void
    {
        $this->showText = $showText;
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