<?php

namespace App\Http\Requests;

use App\App;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAppRequest extends FormRequest
{
    public function authorize()
    {

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:apps,id',
        ];
    }
}
