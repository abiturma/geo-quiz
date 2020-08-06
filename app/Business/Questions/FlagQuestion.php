<?php

namespace App\Business\Questions;


use App\Country;

class FlagQuestion extends BaseQuestion
{

    public const LEVEL_OFFSET = 0;

    public const BASE_XP = 20;

    protected $component = 'QuestionFlag';

    protected $optionCounts = [
        1 => 4,
        5 => 6,
        10 => 8,
        12 => 10
    ];

    protected function computeXp()
    {
        return round((static::BASE_XP + $this->optionsCount()) * 1 + 1 / 20 * $this->level);
    }

    protected function loadOptions()
    {
        return Country::where('id', '!=', $this->country->id)
            ->whereHas('region', function ($query) {
                $query->where('id', $this->country->region->id);
            })
            ->get()
            ->random($this->optionsCount() - 1)
            ->merge([$this->country])
            ->map(function ($country) {
                return [
                    'name' => $country->name,
                    'is_correct' => $country->id === $this->country->id
                ];
            })
            ->sortBy('name')
            ->values();
    }

    protected function optionsCount()
    {
        return collect($this->optionCounts)->filter(function ($value, $key) {
            return $key <= $this->level;
        })->max();
    }

    protected function loadData()
    {
        return [
            'id' => $this->country->id,
            'flag' => $this->country->flag->path,
        ];
    }
}
