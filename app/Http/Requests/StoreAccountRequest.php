<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
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
            'user_avatar' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'nickname' => 'required',
            'address' => 'required',
            'date_place_birth' => 'required',
            'region' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required'
        ];
    }
}
