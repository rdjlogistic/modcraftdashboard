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
        if($request->page && $request->search == ''){
            if($request->platform == 'both'){
                $mods = Mod::where('app_id', $request->app_id )->paginate(10);
            }
            else{
                $mods = Mod::where('app_id', $request->app_id )->whereIn('platform' , $platforms)->paginate(10);
            }
            
        }
        else if($request->platform == 'both'){
            $mods = Mod::where('app_id', $request->app_id )->paginate(10);
        
        }
        else if($request->search){
            if($request->platform){
                if($request->platform == 'both'){
                    
                    $mods = Mod::where('name','LIKE','%'.$request->search.'%')->paginate(10); 
                }else{

                    $mods = Mod::where('name','LIKE','%'.$request->search.'%')->whereIn('platform' , $platforms)->paginate(10);

                }
            }
            else{
            $mods = Mod::where('name','LIKE','%'.$request->search.'%')->paginate(10); 
            }
        }
        else{
            
            $mods = Mod::where('app_id', $request->app_id )->whereIn('platform' , $platforms)->paginate(10);
        }
        return Response::json(array('data' => $mods));
    }

    
}
