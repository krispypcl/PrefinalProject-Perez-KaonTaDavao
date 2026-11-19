<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEateryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Same rules as StoreEateryRequest, except name and permit_no
     * ignore the eatery being edited (and its own permit).
     * Without ignore(), saving the form with no changes would fail
     * because the eatery's own name is already "taken" by itself.
     */
    public function rules(): array
    {
        // the {eatery} from the URL (already a model because of route model binding)
        $eatery = $this->route('eatery');

        return [
            'name' => ['required', 'string', 'max:100', Rule::unique('eateries', 'name')->ignore($eatery->id)],
            'district_id' => ['required', 'exists:districts,id'],
            'address' => ['required', 'string', 'max:255'],
            'price_range' => ['required', 'in:budget,mid,splurge'],
            'specialty' => ['nullable', 'string', 'max:100'],
            'is_open' => ['boolean'],
            'features' => ['required', 'array', 'min:1'],
            'features.*' => ['exists:features,id'],
            'permit_no' => ['required', 'regex:/^DVO-\d{4}-\d{4,5}$/', Rule::unique('permits', 'permit_no')->ignore($eatery->permit?->id)],
            'expires_on' => ['required', 'date', 'after:today'],
        ];
    }

    /**
     * Custom error messages (same as the store request).
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
