<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'nickname' => ['required', 'string', 'unique:'.User::class],
            'role' => ['in:super_admin,admin,user'],
            'password' => ['required', 'confirmed', 'min:4'],
            'foundation_id' => ['nullable', 'exists:foundation,id'],
            'avatar_id' => ['nullable', 'exists:avatar,id']
        ];
    }
}
