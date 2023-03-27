<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use App\Traits\ResponseTrait;
use Exception;

class FormValidateException extends Exception
{
    use ResponseTrait;

    protected $errors;
    
    /**
     * __construct
     *
     * @param  mixed $errors
     * @return void
     */
    public function __construct($errors)
    {
        $this->errors = $errors;
    }
    
    /**
     * Render exception format
     *
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return $this->responseFail($this->errors);
    }
}
