<?php

namespace App\Http\Controllers\Admin;

use App\Map;
use App\App;
use File;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyMapRequest;
use App\Http\Requests\StoreMapRequest;
use App\Http\Requests\UpdateMapRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use URL;

class MapsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        $maps = Map::all();

        $apps = App::all()->pluck('name', 'id');

        return view('admin.maps.index', compact('maps' ,'apps'));
    }

    public function create()
    {
        $apps = App::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.maps.create' , compact('apps'));
    }

    public function store(StoreMapRequest $request)
    {
        $map = Map::create($request->all());
       

        $input = $request->all();
  
        if ($image = $request->file('filepath')) {
            $destinationPath = 'uploads/';
            $input['filename'] = $image->getClientOriginalName();
            $profileImage = date('YmdHis') . "_".  $image->getClientOriginalName();
            $image->move($destinationPath, $profileImage);
            $myPublicFolder = URL::to('/');
            $input['filepath'] = "$myPublicFolder".'/'."$destinationPath"."$profileImage";
        }else{
            unset($input['filepath']);
        }
          
        $map->update($input);

        return redirect()->route('admin.maps.index');
    }

    public function edit(Map $map)
    {
        $apps = App::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.maps.edit', compact('apps', 'map'));
    }

    public function update(UpdateMapRequest $request, Map $map)
    {
        $map->update($request->all());

        $input = $request->all();
  
        if ($image = $request->file('filepath')) {
            $destinationPath = 'uploads/';
            $input['filename'] = $image->getClientOriginalName();
            $profileImage = date('YmdHis') . "_".  $image->getClientOriginalName();
            $image->move($destinationPath, $profileImage);
            $myPublicFolder = URL::to('/');
            $input['filepath'] = "$myPublicFolder".'/'."$destinationPath"."$profileImage";
            
        }else{
            unset($input['filepath']);
        }
        

        $map->update($input);


        return redirect()->route('admin.maps.index');
    }

    // public function show(Mod $mod)
    // {
    //     abort_if(Gate::denies('company_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $company->load('city', 'categories', 'prices');

    //     return view('admin.companies.show', compact('company'));
    // }

    public function destroy(Map $map)
    {

        $map->delete();

        return back();
    }

    public function massDestroy(MassDestroyMapRequest $request)
    {
        Map::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
