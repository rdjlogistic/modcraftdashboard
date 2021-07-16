<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Map;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMapRequest;
use App\Http\Requests\UpdateMapRequest;
use App\Http\Resources\Admin\MapResource;
use Gate;
use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;
use Response;

class MapsApiController extends Controller
{
    // public function index()
    // {
    //     return new ModResource(Mod::all());
    // }

    public function index()
    {
        $map = Map::all();
    
        return $this->sendResponse(MapResource::collection($maps), 'Maps retrieved successfully.');
    }

    public function getMapsByApp(Request $request)
    {
       
        $maps = Map::where('app_id', $request->app_id)->get();
        
        return Response::json(array('data' => $maps));
    }

    
}
