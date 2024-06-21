<?php

namespace App\Modules\Offer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfferRequest extends FormRequest
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
            //
            'task_type_id' => 'required|exists:task_types,id',
            'offer' => 'required|numeric',
            'description' => 'required|string|max:255',
            'offer_limit' => 'required|string|max:100',
            'is_active' => 'required|boolean',
            'language_id' => 'required|exists:languages,id',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
            'deleted_by' => 'nullable|exists:users,id',
        ];
    }
}
