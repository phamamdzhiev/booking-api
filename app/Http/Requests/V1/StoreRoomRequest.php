<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'number' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'pricePerNight' => 'required|numeric|min:0',
            'status' => 'required|in:available,booked',
        ];
    }

    public function messages()
    {
        return [
            'number.required' => 'Номерът на стаята е задължителен',
            'type.required' => 'Типът на стаята е задължителен',
            'pricePerNight.required' => 'Цена за нощувка е задължителена',
            'pricePerNight.numeric' => 'Цена за нощувка трябва да бъде число',
            //... other rules
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'price_per_night' => $this->pricePerNight
        ]);
    }
}
