<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class BookingTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCreateBooking(): void
    {
        $data = [
            'roomId' => 1,
            'customerId' => 1,
            'checkInDate' => '2024-01-30',
            'checkOutDate' => '2024-02-05',
        ];

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->json('POST', '/api/v1/bookings', $data);
        $response->assertStatus(201);
    }
}
