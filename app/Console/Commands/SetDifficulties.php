<?php

namespace App\Console\Commands;

use App\Country;
use Illuminate\Console\Command;

class SetDifficulties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:levels {relationship}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       $countries = Country::all();

       foreach($countries as $country) {
           $relationship = $this->argument('relationship');
           $level = $this->ask("Level von $relationship von $country->name");
           if($level) {
               $country->$relationship->update(compact('level'));
           }
       }
    }
}
