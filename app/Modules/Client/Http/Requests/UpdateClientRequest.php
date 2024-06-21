<?php

namespace App\Modules\Client\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            'name' => 'required|string|max:150',
            'email' => 'required|string|email|max:150|unique:clients,email,' . $this->client,
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:100|unique:clients,phone,' . $this->client,
            'specialties' => 'required|string',
            'description' => 'required|string',
            'source' => 'required|string|max:100',
            'is_active' => 'required|boolean',
            'location' => 'required|string|max:255',
            'country_id' => 'required|integer|exists:countries,id',
            'city_id' => 'required|integer|exists:cities,id',
            'state_id' => 'required|integer|exists:states,id',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
            'deleted_by' => 'nullable|exists:users,id',

        ];
    }
}
