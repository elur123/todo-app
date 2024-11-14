<?php

namespace App\Requests\Todo;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:50', Rule::unique('todos')->ignore($this->todo->id)],
            'description' => ['required', 'string', 'max:255'],
            'status' => ['nullable']
        ];
    }

    protected function passedValidation(): void
    {
        $this->replace(['status' => $this->status ? 1 : 0]);
    }
}
