<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'booking' => new BookingResource($this->whenLoaded('booking')),
            'amount' => $this->amount,
            'paymentDate' => $this->payment_date,
            'status' => $this->status
        ];
    }
}
