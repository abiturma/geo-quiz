<?php

namespace App\Business\Questions;


use App\Country;

abstract class BaseQuestion
{

    public const LEVEL_OFFSET = 0;

    public const BASE_XP = 20;

    protected $country;

    protected $options;

    protected $level;

    protected $component;

    protected $data;


    public function __construct(Country $country, $level)
    {
        $this->country = $country;
        $this->level = $level;
    }

    public function level()
    {
        return $this->level;
    }

    public function component()
    {
        return $this->component;
    }

    public function data()
    {
        if (!$this->data) {
            $this->data = $this->loadData();
        }
        return $this->data;
    }

    public function xp()
    {
        return $this->computeXp();
    }

    public function options()
    {
        if (!$this->options) {
            $this->options = $this->loadOptions();
        }

        return $this->options;
    }

    public function relativeLevel()
    {
        return $this->level - static::LEVEL_OFFSET;
    }

    public function id()
    {
        return $this->component().'#'.$this->country->id;
    }

    abstract protected function computeXp();

    abstract protected function loadOptions();

    abstract protected function loadData();


}
