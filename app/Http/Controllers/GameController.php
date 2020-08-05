<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Resources\CountryResource;
use App\Http\Resources\QuestionResource;
use Illuminate\Http\Request;

class GameController extends Controller
{

    public function start()
    {
        $questions = Country::where('level','<=', 4)->get()->random(10)->shuffle()->map->toQuestion();
        $questions = QuestionResource::collection($questions);
        return view('main')->with(compact('questions'));
    }


}
