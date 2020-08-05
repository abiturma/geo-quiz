<?php

namespace App\Business;


use App\Http\Resources\RegionResource;
use App\Region;

class Meta
{

    public static function toJson()
    {

        $regions = Region::all();

        return collect([
            'regions' => RegionResource::collection($regions)
        ])->toJson();

    }

}
