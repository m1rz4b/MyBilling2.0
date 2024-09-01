<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VariablesRequest extends FormRequest
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
            'variable_name' => 'required'
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'variable_name'=> strip_tags($this->variable_name)
        ]);
    }
}
