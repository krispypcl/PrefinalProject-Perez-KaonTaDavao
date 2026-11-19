<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    /**
     * Only open eateries can receive reviews.
     * If this returns false, Laravel stops the request with 403 Forbidden
     * before validation, so nothing gets saved.
     */
    public function authorize(): bool
    {
        $eatery = $this->route('eatery');

        return $eatery->is_open == true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'body' => ['required', 'string', 'min:10', 'max:1000'],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'Choose who is writing this review.',
            'rating.between' => 'Ratings go from 1 to 5 stars only.',
            'body.min' => 'Kaon Ta Perez: reviews need at least 10 characters.',
        ];
    }
}
