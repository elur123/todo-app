<?php

namespace App\Requests\Todo;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:50', Rule::unique('todos')],
            'description' => ['required', 'string', 'max:255']
        ];
    }
}
