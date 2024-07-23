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
            'mac_address' => 'required|string|max:255|unique:ip_management,mac_address,' . $this->route('id'),
            'label' => 'nullable|string|max:255',
        ];
    }
}
