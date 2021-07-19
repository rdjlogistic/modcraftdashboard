<?php

namespace App\Http\Controllers\Api\V1\Admin;
// namespace Illuminate\Pagination;

use App\Mod;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreModRequest;
use App\Http\Requests\UpdateModRequest;
use App\Http\Resources\Admin\ModResource;
use Gate;
use Illuminate\Http\Request;
// use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
// use Symfony\Component\HttpFoundation\Response;
use Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

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
        $platforms = [$request->platform,'both'];
        if($request->page){
            if($request->platform == 'both'){
                $mods = Mod::where('app_id', $request->app_id )->paginate(2);
            }
            else{
                $mods = Mod::where('app_id', $request->app_id )->whereIn('platform' , $platforms)->paginate(2);
            }
            
        }
        else if($request->platform == 'both'){
            $mods = Mod::where('app_id', $request->app_id )->paginate(2);
        
        }
        else{
            
            $mods = Mod::where('app_id', $request->app_id )->whereIn('platform' , $platforms)->paginate(2);
        }
        return Response::json(array('data' => $mods));
    }

    
}
