<?php

namespace App\Services;

use App\Exceptions\NoRouteFoundException;
use App\Station;
use Illuminate\Support\Facades\Cache;

class TrainRoute
{
    private $from, $to, $distance;
    private $routes = [];

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to  = $to;
    }

    public function getDistance()
    {
        return $this->distance;
    }

    private function setDistance($value)
    {
        $this->distance = $value;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function getShortestRoutes()
    {
        $routes = Station::getAllRoutesMatrix();

        $result = $this->calculateShortestRoutes($routes);

        if(!isset($result['distances'][$this->to])) {
            throw new NoRouteFoundException();
        }

        $this->setDistance($result['distances'][$this->to]);
        $this->setRoutes($result['parents_list']);

        return $this;
    }

    public function calculateShortestRoutes($adjacencyHash)
    {
        return Cache::rememberForever('shortest:'.$this->from, function() use ($adjacencyHash) {
            $q = new \SplQueue();

            $q->enqueue($this->from);

            $distance[$this->from] = 0;
            $parentsList[$this->from] = false;

            while (!$q->isEmpty()) {
                $node = $q->dequeue();

                $neighbours = $adjacencyHash[$node];

                foreach ($neighbours as $neighbour) {

                    if (!isset($distance[$neighbour])) {

                        $q->enqueue($neighbour);

                        $distance[$neighbour] = $distance[$node] + 1;

                        $parentsList[$neighbour][] = $node;

                    } elseif ($distance[$neighbour] == $distance[$node] + 1) {

                        $parentsList[$neighbour][] = $node;

                    }
                }
            }

            return [
                'parents_list' => $parentsList,
                'distances' => $distance,
            ];
        });
    }

    private function setRoutes($parentsList)
    {
        $paths = [];

        $this->trackPaths($parentsList, $this->to, $path = [], $paths);

        $this->routes = $paths;
    }

    private function trackPaths(array $list, $from, $path, &$paths)
    {
        array_unshift($path, $from);

        if (!$list[$from]) {
            $paths[] = $path;
        }

        if ($list[$from]) {
            foreach ($list[$from] as $node) {
                $this->trackPaths($list, $node, $path, $paths);
            }
        }
    }
}