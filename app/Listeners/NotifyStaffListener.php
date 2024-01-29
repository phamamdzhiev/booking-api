<?php

namespace App\Listeners;

use App\Events\NewBookingEvent;
use Illuminate\Support\Facades\Mail;

class NotifyStaffListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewBookingEvent $event): void
    {
        $booking = $event->booking;

        $staffEmails = ['office@hotel.com', 'manager@hotel.com'];

        foreach ($staffEmails as $email) {
            //notify hotel staff through email
            // Mail::to($email)->send(); // or ->queue()
        }
    }
}
