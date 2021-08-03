<?php

namespace App\Http\Requests;

use App\Map;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateMapRequest extends FormRequest
{
    public function authorize()
    {

        return true;
    }

    public function rules()
    {
        return [
            'name'         => [
                'required',
            ],
            'image'   => [
                'mimes:jpeg,png,svg |max:50000',
              
            ],
        ];
    }
}
