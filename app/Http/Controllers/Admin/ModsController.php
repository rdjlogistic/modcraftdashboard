<?php

namespace App\Http\Controllers\Admin;

use App\Mod;
use App\App;
use File;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyModRequest;
use App\Http\Requests\StoreModRequest;
use App\Http\Requests\UpdateModRequest;
use App\Http\Resources\Admin\ModResource;
use Gate;
use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;
use Response;
use URL;

class ModsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        $mods = Mod::all();

        $apps = App::all()->pluck('name', 'id');

        return view('admin.mods.index', compact('mods' ,'apps'));
    }

    public function create()
    {
        $apps = App::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.mods.create' , compact('apps'));
    }

    
    public function store(StoreModRequest $request)
    {

        $input = $request->all();
        $modsliderimagesarray=array();
  
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
          
        if ($modimage = $request->file('image')) {
            $destinationPath = 'uploads/';
            $modprofileImage = date('YmdHis') . "_".  $modimage->getClientOriginalName();
            $modimage->move($destinationPath, $modprofileImage);
            $myPublicFolder = URL::to('/');
            $input['image'] = "$myPublicFolder".'/'."$destinationPath"."$modprofileImage";
        }else{
            unset($input['image']);
        }


        
        if($modsliderimages=$request->file('sliderimages')){
            foreach($modsliderimages as $modsliderimage){
                $destinationPath = 'uploads/';
                $modprofileImage1 = date('YmdHis') . "_".  $modsliderimage->getClientOriginalName();
                $modsliderimage->move($destinationPath, $modprofileImage1);
                $myPublicFolder = URL::to('/');
                $modsliderimagesarray[]="$myPublicFolder".'/'."$destinationPath"."$modprofileImage1";
                
            }
        }
        $input['sliderimages'] = $modsliderimagesarray;

        $mod = Mod::create($request->all());
        $mod->update($input);

        

        return redirect()->route('admin.mods.index');
    }

    public function edit(Mod $mod)
    {
        $apps = App::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.mods.edit', compact('apps', 'mod'));
    }

    public function update(UpdateModRequest $request, Mod $mod)
    {
        $mod->update($request->all());
        $modsliderimagesarray1=array();

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
        
        if ($modimage = $request->file('image')) {
            $destinationPath = 'uploads/';
            $modprofileImage = date('YmdHis') . "_".  $modimage->getClientOriginalName();
            $modimage->move($destinationPath, $modprofileImage);
            $myPublicFolder = URL::to('/');
            $input['image'] = "$myPublicFolder".'/'."$destinationPath"."$modprofileImage";
        }else{
            unset($input['image']);
        }

        
        if($modsliderimages=$request->file('sliderimages')){
            foreach($modsliderimages as $modsliderimage){
                $destinationPath = 'uploads/';
                $modprofileImage1 = date('YmdHis') . "_".  $modsliderimage->getClientOriginalName();
                $modsliderimage->move($destinationPath, $modprofileImage1);
                $myPublicFolder = URL::to('/');
                $modsliderimagesarray1[]="$myPublicFolder".'/'."$destinationPath"."$modprofileImage1";
               
            }
        }
        $input['sliderimages'] = $modsliderimagesarray1;
        $mod->update($input);


        return redirect()->route('admin.mods.index');
    }

    // public function show(Mod $mod)
    // {
    //     abort_if(Gate::denies('company_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $company->load('city', 'categories', 'prices');

    //     return view('admin.companies.show', compact('company'));
    // }

    public function destroy(Mod $mod)
    {

        $mod->delete();

        return back();
    }

    public function massDestroy(MassDestroyModRequest $request)
    {
        Mod::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
