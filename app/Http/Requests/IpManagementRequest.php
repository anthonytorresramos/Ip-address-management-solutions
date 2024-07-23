<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IpManagementRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'mac_address' => 'required|string|max:255',
            'label' => 'required|string|max:255',
        ];
    }
}
