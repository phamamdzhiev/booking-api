<?php

namespace Tests\Feature;

use App\Enum\PaymentStatusEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $data = [
            'bookingId' => 1,
            'amount' => 250.50,
            'paymentDate' => '2024-01-30',
            'status' => PaymentStatusEnum::COMPLETED,
        ];

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->json('POST', '/api/v1/payments', $data);
        $response->assertStatus(201);
    }
}
