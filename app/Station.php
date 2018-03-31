<?php

namespace App;

use App\Exceptions\DestinationException;
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

        return $result;
    }
}
