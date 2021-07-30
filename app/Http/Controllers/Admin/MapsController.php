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
// use Symfony\Component\HttpFoundation\Response;
use Response;
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

        $input = $request->all();
        $mapsliderimagesarray=array();
  
        if ($image = $request->file('filepath')) {
            $destinationPath = 'uploads/';
            $input['filename'] = $image->getClientOriginalName();
            $getfilename =  str_replace(' ', '_', $image->getClientOriginalName());
            $profileImage = date('YmdHis') . "_".  $getfilename;
            $image->move($destinationPath, $profileImage);
            $myPublicFolder = URL::to('/');
            $input['filepath'] = "$myPublicFolder".'/'."$destinationPath"."$profileImage";
        }else{
            unset($input['filepath']);
        }
        
        if ($mapimage = $request->file('image')) {
            $destinationPath = 'uploads/';
            $mapprofileImage = date('YmdHis') . "_".  $mapimage->getClientOriginalName();
            $mapimage->move($destinationPath, $mapprofileImage);
            $myPublicFolder = URL::to('/');
            $input['image'] = "$myPublicFolder".'/'."$destinationPath"."$mapprofileImage";
        }else{
            unset($input['image']);
        }


        
        if($mapsliderimages=$request->file('sliderimages')){
            foreach($mapsliderimages as $mapsliderimage){
                $destinationPath = 'uploads/';
                $mapprofileImage1 = date('YmdHis') . "_".  $mapsliderimage->getClientOriginalName();
                $mapsliderimage->move($destinationPath, $mapprofileImage1);
                $myPublicFolder = URL::to('/');
                $mapsliderimagesarray[]="$myPublicFolder".'/'."$destinationPath"."$mapprofileImage1";
                
            }
        }
        $input['sliderimages'] = $mapsliderimagesarray;

        $map = Map::create($request->all());
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
        $mapsliderimagesarray1=array();

        $input = $request->all();
  
        if ($image = $request->file('filepath')) {
            $destinationPath = 'uploads/';
            $input['filename'] = $image->getClientOriginalName();
            $getfilename =  str_replace(' ', '_', $image->getClientOriginalName());
            $profileImage = date('YmdHis') . "_".  $getfilename;
            $image->move($destinationPath, $profileImage);
            $myPublicFolder = URL::to('/');
            $input['filepath'] = "$myPublicFolder".'/'."$destinationPath"."$profileImage";
            
        }else{
            unset($input['filepath']);
        }
        

        if ($mapimage = $request->file('image')) {
            $destinationPath = 'uploads/';
            $mapprofileImage = date('YmdHis') . "_".  $mapimage->getClientOriginalName();
            $mapimage->move($destinationPath, $mapprofileImage);
            $myPublicFolder = URL::to('/');
            $input['image'] = "$myPublicFolder".'/'."$destinationPath"."$mapprofileImage";
        }else{
            unset($input['image']);
        }

        
        if($mapsliderimages=$request->file('sliderimages')){
            foreach($mapsliderimages as $mapsliderimage){
                $destinationPath = 'uploads/';
                $mapprofileImage1 = date('YmdHis') . "_".  $mapsliderimage->getClientOriginalName();
                $mapsliderimage->move($destinationPath, $mapprofileImage1);
                $myPublicFolder = URL::to('/');
                $mapsliderimagesarray1[]="$myPublicFolder".'/'."$destinationPath"."$mapprofileImage1";
               
            }
        }
        $input['sliderimages'] = $mapsliderimagesarray1;
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
