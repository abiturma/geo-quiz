<?php

namespace App;


use Illuminate\Http\Resources\DelegatesToResource;

class Question
{

    use DelegatesToResource;

    /**
     * @var Country
     */

    protected $resource;

    protected $options;

    public function __construct(Country $country)
    {
        $this->resource = $country;
    }

    public function options()
    {
        if (!$this->options) {
            $this->options = $this->parseOptions($this->getBaseOptions());
        }
        return $this->options;
    }

    protected function parseOptions($options)
    {
        return $options->map(function ($option) {
            return [
                'display' => $option->name,
                'is_correct' => $option->id === $this->id,
            ];
        });
    }

    protected function getBaseOptions()
    {
        return Country::where('id', '!=', $this->id)->where('level','<=',$this->level+2)->inRandomOrder()->limit(3)->get()->merge([$this->resource])->shuffle();
    }


}
