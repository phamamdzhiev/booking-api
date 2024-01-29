<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StorePaymentRequest;
use App\Http\Resources\V1\PaymentCollection;
use App\Http\Resources\V1\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    const RELATIONS = ['booking', 'booking.customer', 'booking.room'];

    public function index(): PaymentCollection
    {
        return new PaymentCollection(Payment::with(self::RELATIONS)->get());
    }

    public function show(Payment $payment): PaymentResource
    {
        $payment->load(self::RELATIONS);
        return new PaymentResource($payment);
    }

    public function store(StorePaymentRequest $request): PaymentResource
    {
        return new PaymentResource(Payment::create($request->all()));
    }
}
