<?php

namespace App\Http\Requests;

use App\Skin;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateSkinRequest extends FormRequest
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
            'modimage'   => [
                'mimes:jpeg,png,svg |max:4096',
              
            ],
        ];
    }
}
