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
        $platforms = [$request->platform,'both'];
        if ($request->page && $request->search == '') {
            if ($request->platform == 'both') {
                $skins = Skin::where('app_id', $request->app_id)->paginate(10);
            } else {
                $skins = Skin::where('app_id', $request->app_id)->whereIn('platform', $platforms)->paginate(10);
            }
        } elseif ($request->platform == 'both') {
            $skins = Skin::where('app_id', $request->app_id)->paginate(10);
        } elseif ($request->search) {
            if ($request->platform) {
                if ($request->platform == 'both') {
                    $skins = Skin::where('app_id', $request->app_id)->where('name', 'LIKE', '%'.$request->search.'%')->paginate(10);
                } else {
                    $skins = Skin::where('app_id', $request->app_id)->where('name', 'LIKE', '%'.$request->search.'%')->whereIn('platform', $platforms)->paginate(10);
                }
            } else {
                $skins = Skin::where('name', 'LIKE', '%'.$request->search.'%')->paginate(10);
            }
        } else {
            $skins = Skin::where('app_id', $request->app_id)->whereIn('platform', $platforms)->paginate(10);
        }
        return Response::json(array('data' => $skins));
    }
}
