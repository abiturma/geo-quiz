<?php

namespace App\Console\Commands;

use App\Country;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PHPUnit\Framework\Constraint\Count;
use Symfony\Component\DomCrawler\Crawler;

class FetchCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Countries';


    protected $base = 'https://de.wikipedia.org';

    protected $url = '/wiki/Liste_der_Staaten_der_Erde';
    /**
     * @var Client
     */
    protected $http;

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
        $countries = $this->getCountries();

        $bar = $this->output->createProgressBar(count($countries));

        foreach ($countries as $country) {
            $data = $this->getCountryData($country);
            $country = Country::updateOrCreate(['iso' => $data['iso']], $data);
            if(!empty($data['flag_path'])) {
                $country->flag()->updateOrCreate(['path' => $data['flag_path']]);
            }
            if(!empty($data['capital'])) {
                $country->capital()->updateOrCreate(['name' => $data['capital']]);
            }
            if(!empty($data['map_path'])) {
                $country->map()->updateOrCreate(['path' => $data['map_path']]);
            }

            $bar->advance();
        }

    }

    protected function getCountries()
    {
        $body = $this->http->get($this->base . '/' . $this->url)->getBody();
        $crawler = new Crawler((string)$body, $this->base);
        $results = [];
        $crawler->filter('table')->filter('tr')->each(function ($tr) use (&$results) {
            $result = [];
            $map = ['name' => 0, 'url' => 0, 'capital' => 2, 'iso' => 7];
            $tr->filter('td')->each(function ($td, $index) use ($tr, &$result, $map) {

                $keys = array_keys($map, $index);
                foreach ($keys as $key) {
                    $method = Str::camel("parse_$key");
                    $result[$key] = method_exists($this, $method) ? $this->$method($td, $tr) : $td->text();
                }
            });

            if (!empty($result['iso'])) {
                return $results[] = $result;
            }
        });
        return $results;
    }

    protected function parseName($td)
    {
        return $td->filter('a')->text();
    }

    protected function parseCapital($td, $tr)
    {
        $name = $td->text();
        if (Str::startsWith($name, 'Stadtstaat')) {
            return $this->parseName($tr->filter('td')->first());
        }

        $capital = $td->filter('a');
        if (count($capital) > 0) {
            return $capital->text();
        }
    }

    protected function parseUrl($td)
    {
        return $td->filter('a')->link()->getUri();
    }

    protected function parseIso($td)
    {
        $iso = $td->text();
        return preg_match('/^[A-Z]{3}$/', $iso) ? $iso : '';
    }

    protected function parseInternationalName($td)
    {
        return preg_split('/ oder /', $td->text())[0];
    }


    protected function getCountryData($country)
    {
        $body = $this->http->get($country['url'])->getBody();
        $crawler = new Crawler((string)$body, $this->base);

        $flagUrl = $crawler->filter('table.wikitable tbody tbody')->first()->filter('a')->link()->getUri();

        $flagBody = $this->http->get($flagUrl)->getBody();
        $flagCrawler = new Crawler((string)$flagBody, $this->base);
        $flagLink = $flagCrawler->filter('.fullMedia a.internal')->first()->link()->getUri();

        $svg = $this->http->get($flagLink)->getBody();


        $path = '/flags/' . $country['iso'] . '.svg';
        Storage::disk('public')->put($path, $svg);

        $country['flag_path'] = $path;
        try {
            $mapLink = $crawler->filter('table.wikitable map + img')->first()->attr('src');
//        $mapLink = $crawler->filter('table.wikitable')->first()->filter('tr')->last()->filter('img')->attr('src');
            $png = $this->http->get($mapLink)->getBody();

            $mapPath = '/maps/' . $country['iso'] . '.png';

            Storage::disk('public')->put($mapPath, $png);

            $country['map_path'] = $mapPath;

        } catch (\Exception $e) {
            $this->error('No map for ' . $country['name']);
        }

        return $country;

    }

}
