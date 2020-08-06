<?php

namespace App\Business;


use App\Business\Questions\FlagQuestion;
use App\Country;

class QuestionFactory
{
    protected $regions;

    protected $length;

    public function regions($regions)
    {
        $this->regions = $regions;
        return $this;
    }

    public function length($length)
    {
        $this->length = $length;
        return $this;
    }

    public function user($user)
    {
        $this->profile = $user->profile;
        return $this;
    }

    public function create()
    {
        return Country::whereHas('region', function ($query) {
            return $query->whereIn('id', $this->regions);
        })->get()->shuffle()->take($this->length)->map(function ($country) {
            return new FlagQuestion($country, $this->profile->level);
        });
    }

}
