<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //

    protected $fillable = ['geo_lat','geo_long','name','iso'];


    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function flag()
    {
        return $this->hasOne(Flag::class);
    }

    public function capital()
    {
        return $this->hasOne(Capital::class);
    }

    public function map()
    {
        return $this->hasOne(Map::class);
    }




}
