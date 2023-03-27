<?php

namespace App\Http\Requests;

use App\Exceptions\FormValidateException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ResponseTrait;

class BaseRequest extends FormRequest
{
    use ResponseTrait;

    /**
     * failedValidation
     *
     * @param  Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new FormValidateException($errors);
    }
}
