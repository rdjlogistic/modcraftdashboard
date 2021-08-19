<?php

namespace App\Http\Requests;

use App\Mod;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Validator;

class StoreModRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $result = [
            'name' => 'required',
            'app_id' => 'required',
            'platform' => 'required',
            'createdby' => 'required',
            'filepath' => 'required',
            'image' => 'mimes:jpeg,png,svg'
        ];

        return $result;
        // return [
        //     'name' => [
        //         'required',
        //     ],
        //     'platform' => [
        //         'required'
        //     ],
        //     'filepath'   => [
        //         'required',
        //     ],
        //     'image'   => [
        //         'mimes:jpeg,png,svg|max:5120',

        //     ],
        // ];
    }
}
