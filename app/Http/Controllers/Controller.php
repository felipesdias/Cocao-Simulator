<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Corrige redicionamento quando a validação falha
     *
     * @param Request $request
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     * @return void
     */
    public function validate(array $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = $this->getValidationFactory()->make($request, $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            throw new ValidationException($validator);
        }
    }
}
