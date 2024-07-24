<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class IpManagementRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422));
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('id');
        return [
            'ip_address' => $id ? 'sometimes|required|string|max:255|unique:ip_management,ip_address,' . $id : 'required|string|max:255|unique:ip_management,ip_address',
            'label' => 'nullable|string|max:255',
        ];
    }
}
