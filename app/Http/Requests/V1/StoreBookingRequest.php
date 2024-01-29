<?php

namespace App\Http\Requests\V1;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
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
            'roomId' => [
                'required',
                'exists:rooms,id',
                Rule::unique('bookings', 'room_id')->where(function ($query) {
                    $query->where('room_id', $this->input('roomId'))
                        ->where(function (Builder $query) {
                            $query->whereBetween(
                                'check_in_date',
                                [$this->input('checkInDate'), $this->input('checkOutDate')]
                            )
                                ->orWhereBetween(
                                    'check_out_date',
                                    [$this->input('checkInDate'), $this->input('checkOutDate')]
                                );
                        });
                }),
            ],
            'customerId' => 'required|exists:customers,id',
            'checkInDate' => 'required|date|after_or_equal:today',
            'checkOutDate' => 'required|date|after:checkInDate'
        ];
    }

    public function messages()
    {
        return [
            'roomId.required' => 'Стаята е задължително поле',
            'roomId.exists' => 'Стаята не съществува',
            'roomId.unique' => 'Стаята е заета за избрания от Вас период',

            'customerId.required' => 'Клиентът е задължително поле',
            'customerId.exists' => 'Клиентът не съществува',

            'checkInDate.required' => 'Датата на настаняване е задължителна',
            'checkInDate.date' => 'Датата на настаняване е невалидна',
            'checkInDate.after_or_equal' => 'Датата на настаняване не може да бъде преди днешна дата',

            'checkOutDate.required' => 'Датата на напускане е задължителна',
            'checkOutDate.date' => 'Датата на напускане е невалидна',
            'checkOutDate.after' => 'Датата на напускане трябва да бъде по-късна от датана на настаняване',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'room_id' => $this->roomId,
            'customer_id' => $this->customerId,
            'check_in_date' => $this->checkInDate,
            'check_out_date' => $this->checkOutDate,
        ]);
    }
}
