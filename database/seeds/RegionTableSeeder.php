<?php

use App\Region;
use Illuminate\Database\Seeder;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            ['id' => 'Asia', 'name' => 'Asien'],
            ['id' => 'Americas', 'name' => 'Amerika'],
            ['id' => 'Europe', 'name' => 'Europa'],
            ['id' => 'Africa', 'name' => 'Afrika'],
            ['id' => 'Oceania', 'name' => 'Ozeanien'],
            ['id' => 'USA', 'name' => 'USA']
        ];

        foreach($regions as $region) {
            Region::updateOrCreate(['id' => $region['id']],$region);
        }
    }
}
