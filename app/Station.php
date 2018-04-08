<?php

namespace App;

use App\Exceptions\DestinationException;
use Illuminate\Support\Facades\Cache;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Station extends Eloquent
{
    protected $primaryKey = 'name';

    public $incrementing = false;

    public $timestamps = false;

    protected $guarded = [];

    public static function addDestination($start_station, $destination) {

        $result = self::findOrFail($start_station)->push('destinations', $destination, true);

        if(!$result) {
            throw new DestinationException;
        }

        Cache::flush();

        return $result;
    }

    public static function getAllRoutesMatrix()
    {
        return Cache::rememberForever('all_routes', function() {
            return self::all()
                    ->mapWithKeys(function ($item) {
                        return [$item['name'] => $item['destinations']];
                    })->toArray();
        });
    }
}
