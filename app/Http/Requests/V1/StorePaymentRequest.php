<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user != null && $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bookingId' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:0',
            'paymentDate' => 'required|date',
            'status' => 'required|in:pending,completed,failed,refunded',
        ];
    }

    public function messages()
    {
        return [
            'bookingId.required' => 'Номерът на резервация е задължителен',
            'bookingId.exists' => 'Номерът на резервация не съществува',
            'amount.required' => 'Сумата е задължителна',
            'amount.min' => 'Минималната сумата е :min',
            'paymentDate.required' => 'Датата на плащане е задължителна',
            'paymentDate.date' => 'Датата на плащане е невалидна',
            'status.required' => 'Статусът е задължителен',
            'status.in' => 'Валидни опции са :in',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'booking_id' => $this->bookingId,
            'payment_date' => $this->paymentDate
        ]);
    }
}
