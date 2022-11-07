<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            $rules['title'] = 'required|string';
            $rules['descriptions'] = 'required|string';
            $rules['project_id'] = 'required|string|exists:projects,id';
            $rules['user_id'] = 'required|string|exists:users,id';
            $rules['status'] = 'string|in:NOT_STARTED,IN_PROGRESS,READY_FOR_TEST,COMPLETED';
        } else if ($method == 'PATCH') {
            $rules['title'] = 'sometimes|string';
            $rules['descriptions'] = 'sometimes|string';
            $rules['project_id'] = 'sometimes|string|exists:projects,id';
            $rules['user_id'] = 'sometimes|string|exists:users,id';
            $rules['status'] = 'sometimes|required|string|in:NOT_STARTED,IN_PROGRESS,READY_FOR_TEST,COMPLETED';
        }

        return $rules;
    }
}
