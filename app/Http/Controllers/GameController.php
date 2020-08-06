<?php

namespace App\Http\Controllers;

use App\Business\QuestionFactory;
use App\Country;
use App\Http\Resources\CountryResource;
use App\Http\Resources\QuestionResource;
use Illuminate\Http\Request;

class GameController extends Controller
{

    public function start(Request $request, QuestionFactory $factory)
    {
        $questions = $factory->regions($request->regions)->length($request->length)->user(auth()->user())->create();
        return QuestionResource::collection($questions);
    }


}
