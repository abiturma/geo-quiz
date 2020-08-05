<?php

namespace App;

use App\Business\NextLevel;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    //

    public function getNextLevelAttribute()
    {
        return new NextLevel($this);
    }
}
