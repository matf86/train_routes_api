<?php

namespace App\Http\Controllers;

use App\Exceptions\NoRouteFoundException;
use App\Http\Requests\FindRouteRequest;
use App\Services\TrainRoute;
use Illuminate\Support\Facades\Cache;

class ShortestRouteController extends Controller
{
    public function show(FindRouteRequest $request)
    {
        try {

            $start = $request->query('start');
            $destination =$request->query('destination');

            $train_routes = Cache::rememberForever("shortest_route:{$start}:{$destination}",
               function() use ($request) {
                   return (new TrainRoute(
                       $request->query('start'),
                       $request->query('destination')
                   ))->getShortestRoutes();
               });

            return response()->json([
                'routes' => $train_routes->getRoutes(),
                'distance' =>$train_routes->getDistance()
            ]);

        } catch (NoRouteFoundException $e) {

            return response()->json('No routes found', 404);
        }
    }
}
