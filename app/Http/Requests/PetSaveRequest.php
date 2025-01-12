<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;

class PetSaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        if ($this->isMethod(Request::METHOD_POST)) {
            return [
                'id' => 'nullable|numeric',
                'name' => 'required|string',
                'category' => 'array',
                'category.id' => 'nullable|numeric',
                'category.name' => 'nullable|string',
                'photoUrls' => 'nullable|array',
                'photoUrls.*' => 'string',
                'tags' => 'nullable|array',
                'status' => 'nullable|string',
            ];
        }

        return [];
    }
}
