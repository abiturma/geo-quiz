<?php

namespace App\Console\Commands;

use App\Country;
use App\Region;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchRegions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:regions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var Client
     */
    protected $http;

    protected $url = "https://ajayakv-rest-countries-v1.p.rapidapi.com/rest/v1/all";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $http)
    {
        parent::__construct();
        $this->http = $http;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $body = (string) $this->http->get($this->url, [
            'headers' => [
                'x-rapidapi-key' => env('AJAYAKV_KEY')
            ]
        ])->getBody();
        $data = json_decode($body,true);

        foreach($data as $countryData) {
            $country = Country::firstWhere('iso', $countryData['alpha3Code']);
            $region = Region::find($countryData['region']);
            if(!$region) {
                $this->error('No Region '. $countryData['region']);
                continue;
            }
            if(!$country) {
                $this->error('No Country '. $countryData['alpha3Code']);
                continue;
            }
            $coords = $countryData['latlng'];

            $country->region()->associate($region)->save();
            $country->update(['geo_lat' => $coords[0],'geo_long' => $coords[1]]);

        }

    }
}
