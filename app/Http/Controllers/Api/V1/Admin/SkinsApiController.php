<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Skin;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSkinRequest;
use App\Http\Requests\UpdateSkinRequest;
use App\Http\Resources\Admin\SkinResource;
use Gate;
use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;
use Response;

class SkinsApiController extends Controller
{
    // public function index()
    // {
    //     return new ModResource(Mod::all());
    // }

    public function index()
    {
        $skins = Skin::all();
    
        return $this->sendResponse(SkinResource::collection($skins), 'Skins retrieved successfully.');
    }

    public function getSkinsByApp(Request $request)
    {
       
        $skins = Skin::where('app_id', $request->app_id)->get();
        
        return Response::json(array('data' => $skins));
    }

    
}
