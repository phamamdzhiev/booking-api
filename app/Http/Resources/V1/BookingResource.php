<?php

namespace App\Http\Resources\V1;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'room' => new RoomResource($this->whenLoaded('room')),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'checkInDate' => $this->check_in_date,
            'checkOutDate' => $this->check_out_date,
            'totalPrice' => $this->total_price
        ];
    }
}
