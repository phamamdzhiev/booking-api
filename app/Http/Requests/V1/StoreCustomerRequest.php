<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email',
            'phoneNumber' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Името е задължително',
            'email.email' => 'Имелът е невалиден',
            'email.unique' => 'Клиент с този имейл вече съществува',
            'phoneNumber.required' => 'Мобилният номер е задължителен',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone_number' => $this->phoneNumber
        ]);
    }
}
