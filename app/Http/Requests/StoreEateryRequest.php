<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEateryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * There is no login in this project, so everyone is allowed.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * Arrays are used instead of "a|b|c" strings so the regex is safe.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', 'unique:eateries,name'],
            'district_id' => ['required', 'exists:districts,id'],
            'address' => ['required', 'string', 'max:255'],
            'price_range' => ['required', 'in:budget,mid,splurge'],
            'specialty' => ['nullable', 'string', 'max:100'],
            'is_open' => ['boolean'],

            // features must be an array with at least 1 checked box,
            // and every id inside must exist in the features table
            'features' => ['required', 'array', 'min:1'],
            'features.*' => ['exists:features,id'],

            // e.g. DVO-2026-0904
            'permit_no' => ['required', 'regex:/^DVO-\d{4}-\d{4,5}$/', 'unique:permits,permit_no'],
            'expires_on' => ['required', 'date', 'after:today'],
        ];
    }

    /**
     * Custom error messages (key = field.rule).
     */
    public function messages(): array
    {
        return [
            'name.unique' => 'Kaon Ta Perez already lists an eatery with this name.',
            'features.required' => 'Pick at least one feature.',
            'features.min' => 'Pick at least one feature.',
            'permit_no.regex' => 'Permit number must look like DVO-2026-0415.',
            'expires_on.after' => 'The permit must not be expired.',
        ];
    }
}
