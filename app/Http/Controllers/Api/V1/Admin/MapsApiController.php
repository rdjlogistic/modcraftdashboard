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
    
        $platforms = [$request->platform,'both'];
        if($request->page && $request->search == ''){
            if($request->platform == 'both'){
                $maps = Map::where('app_id', $request->app_id )->paginate(2);
            }
            else{
                $maps = Map::where('app_id', $request->app_id )->whereIn('platform' , $platforms)->paginate(2);
            }
            
        }
        else if($request->platform == 'both'){
            $maps = Map::where('app_id', $request->app_id )->paginate(2);
        
        }
        else if($request->search){
            if($request->platform){
                if($request->platform == 'both'){
                    
                    $maps = Map::where('name','LIKE','%'.$request->search.'%')->paginate(2); 
                }else{

                    $maps = Map::where('name','LIKE','%'.$request->search.'%')->whereIn('platform' , $platforms)->paginate(2);

                }
            }
            else{
            $maps = Map::where('name','LIKE','%'.$request->search.'%')->paginate(2); 
            }
        }
        else{
            
            $maps = Map::where('app_id', $request->app_id )->whereIn('platform' , $platforms)->paginate(2);
        }
        return Response::json(array('data' => $maps));
    }

    
}
