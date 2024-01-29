<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'customer_id', 'check_in_date', 'check_out_date', 'total_price'];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public static function createWithTotalPrice($attributes)
    {
        $room = Room::findOrFail($attributes['room_id']);
        $pricePerNight = $room->price_per_night;

        $checkInDate = new \DateTime($attributes['check_in_date']);
        $checkOutDate = new \DateTime($attributes['check_out_date']);
        $numberOfNights = $checkInDate->diff($checkOutDate)->days;

        $attributes['total_price'] = $pricePerNight * $numberOfNights;

        return self::create($attributes);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function (Booking $booking) {
            // When booking is made, payment row is created with status PENDING and payment day null.
            $booking->createPendingPayment();
        });
    }

    public function createPendingPayment(?float $amount = null): void
    {
        $totalAmount = $amount ?? $this->total_price;

        $this->payments()->create([
            'amount' => $totalAmount,
        ]);
    }
}
