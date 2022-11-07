<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $route = $this->route()->getName();
        
        if($route == 'login') {
            $rules['username'] = 'required|string';
            $rules['password'] = 'required|string';
            $rules['role'] = 'required|string';
        } else {
            if($method == 'POST' || $method == 'PUT') {
                $rules['username'] = 'required|string|unique:users';
                $rules['password'] = 'required|string';
                $rules['role'] = 'required|string';
            } else if ($method == 'PATCH') {
                $rules['username'] = 'sometimes|required|string|unique:users';
                $rules['password'] = 'sometimes|required|string';
                $rules['role'] = 'sometimes|required|string';
            }
        }

        return $rules;
    }
}
