<?php

namespace Tests\Unit;

use App\Exceptions\DestinationException;
use App\Station;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StationTest extends TestCase
{
    function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $database = $this->app->make('db');

        $database->dropCollection('stations');
    }

    /** @test */

    function a_new_destination_can_be_added_to_existing_station()
    {
        $start_station = 'poznań';
        $destination = 'kraków';

        factory(Station::class)->create([
           'name' => 'poznań',
           'destinations' => []
        ]);

        Station::addDestination($start_station, $destination);

        $result = Station::find($start_station);

        $this->assertEquals($start_station, $result->name);
        $this->assertContains($destination, $result->destinations);
    }

    /** @test */

    function a_DestinationException_is_thrown_when_given_destination_already_exist()
    {
        $this->expectException(DestinationException::class);

        $start_station = 'poznań';
        $destination = 'kraków';

        factory(Station::class)->create([
            'name' => 'poznań',
            'destinations' => ['kraków']
        ]);

        Station::addDestination($start_station, $destination);
    }

    /** @test */

    function an_Exception_is_thrown_when_given_start_station_does_not_exists()
    {
        $this->expectException(ModelNotFoundException::class);

        $start_station = 'poznań';
        $destination = 'kraków';

        Station::addDestination($start_station, $destination);
    }

}
