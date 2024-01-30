<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\NewBookingEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreBookingRequest;
use App\Http\Resources\V1\BookingCollection;
use App\Http\Resources\V1\BookingResource;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index(): BookingCollection
    {
        $bookings = Booking::with(['room', 'customer'])->get();
        return new BookingCollection($bookings);
    }

    public function store(StoreBookingRequest $request): BookingResource
    {
        $booking = Booking::createWithTotalPrice($request->all());

        event(new NewBookingEvent($booking));

        return new BookingResource($booking);
    }

    public function show(Booking $booking): BookingResource
    {
        $booking->load(['room', 'customer']);
        return new BookingResource($booking);
    }
}
