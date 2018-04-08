<?php

namespace App\Http\Controllers;

use App\Exceptions\DestinationException;
use App\Http\Requests\AddTrainRequest;
use App\Station;

class TrainsController extends Controller
{

    public function store(AddTrainRequest $request)
    {
        try {

            Station::addDestination($request['train'][0], $request['train'][1]);

            return response()->json(['message' => 'Train route successfully added']);

        } catch (DestinationException $e) {

            return response()->json(['message' => 'Posted route already exists'], 409);

        }
    }
}
