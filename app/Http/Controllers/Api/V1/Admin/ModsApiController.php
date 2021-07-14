<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Mod;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreModRequest;
use App\Http\Requests\UpdateModRequest;
use App\Http\Resources\Admin\ModResource;
use Gate;
use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;
use Response;

class ModsApiController extends Controller
{
    // public function index()
    // {
    //     return new ModResource(Mod::all());
    // }

    public function index()
    {
        $mods = Mod::all();
    
        return $this->sendResponse(ModResource::collection($mods), 'Mods retrieved successfully.');
    }

    public function getModsByApp(Request $request)
    {
       
        $mods = Mod::where('app_id', $request->app_id)->get();
        
        return Response::json(array('data' => $mods));
    }

    
}
