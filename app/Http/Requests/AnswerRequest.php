<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
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
            'description' => ['required', 'string'],
            'is_correct' => ['in:waiting,correct,wrong,partially'],
            'alternative_id' => ['nullable', 'exists:alternative,id'],
            'user_id' => ['exists:user,id'],
            'question_id' => ['required', 'exists:question,id']
        ];
    }
}
