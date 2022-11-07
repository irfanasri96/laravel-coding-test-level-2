<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $method = $this->method();

        if($method == 'POST' || $method == 'PUT') {
            $rules['name'] = 'required|string|unique:projects';
        } else if ($method == 'PATCH') {
            $rules['name'] = 'sometimes|required|string|unique:projects';
        }
        return $rules;
    }
}
