<?php

namespace Tests\Feature;

use App\Station;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddTrainTest extends TestCase
{
    function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $database = $this->app->make('db');
        $database->dropCollection('stations');
    }

    protected function setStationsData()
    {
        factory(Station::class)->create([
            'name' => 'poznań',
            'destinations' => []
        ]);

        factory(Station::class)->create([
            'name' => 'wadowice',
            'destinations' => []
        ]);
    }

    /** @test */

    function user_can_add_train_route()
    {
        $this->setStationsData();

        $payload = ["train" => [
            'Poznań', 'Wadowice'
        ]];

        $response = $this->json('POST','/api/trains', $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('stations', ['name' => 'poznań', 'destinations' => ['wadowice']]);
    }
    
    /** @test */
    
    function user_can_not_add_the_same_route_twice()
    {
        $this->setStationsData();

        $payload = ["train" => [
            'Poznań', 'Wadowice'
        ]];

        $this->json('POST','/api/trains', $payload);

        $response = $this->json('POST','/api/trains', $payload);

        $response->assertStatus(409);
    }

    /** @test */

    function user_can_not_add_train_route_where_destination_is_equal_to_start_station()
    {
        $this->setStationsData();

        $payload = ["train" => [
            'Poznań', 'Poznań'
        ]];

        $response = $this->json('POST','/api/trains', $payload);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('stations', ['name' => 'Poznań', 'destinations' => ['Poznań']]);
    }

    /** @test */

    function added_elements_are_turned_to_lowercase()
    {
        $this->setStationsData();

        $payload = ["train" => [
            'Poznań', 'Wadowice'
        ]];

        $response = $this->json('POST','/api/trains', $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('stations', ['name' => 'poznań', 'destinations' => ['wadowice']]);
    }

    /** @test */

    function user_can_add_multiple_destinations_to_given_station()
    {
        $this->setStationsData();

        factory(Station::class)->create([
            'name' => 'środa wielkopolska'
        ]);

        factory(Station::class)->create([
            'name' => 'środa śląska'
        ]);

        $payload = ["train" => [
            'Poznań', 'Środa Wielkopolska'
        ]];

        $this->json('POST','/api/trains', $payload);

        $payload = ["train" => [
            'Poznań', 'Środa Śląska'
        ]];

        $this->json('POST','/api/trains', $payload);

        $payload = ["train" => [
            'Poznań', 'Wadowice'
        ]];

        $this->json('POST','/api/trains', $payload);

        $result = Station::where('name', 'poznań')->get()->map(function($item) {
            return $item->destinations;
        });

        $this->assertCount(3, $result[0]);
    }
    
    /** @test */
    
    function payload_must_be_a_train_array()
    {
        $payload = ['Poznań', 'Środa Śląska'];

        $response = $this->json('POST','/api/trains', $payload);

        $response->assertStatus(422);
    }

    /** @test */

    function payload_train_array_must_have_two_elements()
    {
        $payload = ["train" => [
            'Poznań', 'Środa Wielkopolska', 'Krotoszyn'
        ]];

        $response = $this->json('POST','/api/trains', $payload);

        $response->assertStatus(422);

        $payload = ["train" => [
            'Poznań',
        ]];

        $response = $this->json('POST','/api/trains', $payload);

        $response->assertStatus(422);
    }

    /** @test */

    function payload_train_array_element_must_be_a_string()
    {
        $payload = ["train" => [
            1, 2
        ]];

        $response = $this->json('POST','/api/trains', $payload);

        $response->assertStatus(422);
    }

    /** @test */

    function payload_train_array_elements_must_be_unique()
    {
        $payload = ["train" => [
            'Poznań', 'Poznań'
        ]];

        $response = $this->json('POST','/api/trains', $payload);

        $response->assertStatus(422);
    }

    /** @test */

    function payload_train_array_elements_must_be_already_existing_station()
    {
        $payload = ["train" => [
            'Poznań', 'Kraków'
        ]];

        $response = $this->json('POST','/api/trains', $payload);

        $response->assertStatus(422);
    }
}