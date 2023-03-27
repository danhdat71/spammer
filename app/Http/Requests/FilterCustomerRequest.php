<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class FilterCustomerRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword' => ['nullable', 'string', 'max:100'],
            'is_bad' => ['nullable', 'string', 'max:2'],
            'order_by' => ['nullable', 'string', 'max:30'],
        ];
    }
}
