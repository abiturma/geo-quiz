<?php

namespace App\Business;


use App\UserProfile;

class NextLevel
{

    /**
     * @var User
     */
    protected $profile;

    protected $increments = [
       1 => 1000,
       2 => 2000,
       3 => 4000,
       4 => 5000,
       5 => 8000,
       6 => 10000,
       7 => 12000,
       8 => 15000,
       9 => 20000,
       10 => 25000,
       11 => 30000,
       12 => 40000
    ];

    public function __construct(UserProfile $profile)
    {
        $this->profile = $profile;
    }

    public function goal()
    {
        return 2000;
    }

    public function current()
    {
        return 100;
    }

    protected function aggregates()
    {
        $carry = 0;
        collect($this->increments)->map(function($val) use (&$carry) {
            $carry+=$val;
            return $carry;
        });
    }


}
