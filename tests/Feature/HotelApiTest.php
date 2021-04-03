<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Hotel;
use Tests\ApiTestTrait;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HotelApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions, HasFactory;

    /**
     * @test
     */
    public function test_create_hotel()
    {
        $hotel = Hotel::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/hotels', $hotel
        );

        $this->assertApiResponse($hotel);
    }

    /**
     * @test
     */
    public function test_read_hotel()
    {
        $hotel = Hotel::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/hotels/'.$hotel->id
        );

        $this->assertApiResponse($hotel->toArray());
    }

    /**
     * @test
     */
    public function test_update_hotel()
    {
        $hotel = Hotel::factory()->create();
        $editedHotel = Hotel::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/hotels/'.$hotel->id,
            $editedHotel
        );

        $this->assertApiResponse($editedHotel);
    }

    /**
     * @test
     */
    public function test_delete_hotel()
    {
        $hotel = Hotel::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/hotels/'.$hotel->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/hotels/'.$hotel->id
        );

        $this->response->assertStatus(404);
    }
}
