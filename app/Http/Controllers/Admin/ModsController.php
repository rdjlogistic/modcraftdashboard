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
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $mod = Mod::create($request->all());
       
        // if ($request->input('logo', false)) {
        //     $mod->addMedia(storage_path('tmp/uploads/' . $request->input('logo')))->toMediaCollection('logo');
        // }

        $input = $request->all();
  
        if ($image = $request->file('filepath')) {
            $destinationPath = 'uploads/';
            $input['filename'] = $image->getClientOriginalName();
            $profileImage = date('YmdHis') . "_".  $image->getClientOriginalName();
            $image->move($destinationPath, $profileImage);
            $input['filepath'] = "$profileImage";
        }else{
            unset($input['filepath']);
        }
          
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
        
        // if ($request->input('logo', false)) {
        //     if (!$mod->logo || $request->input('logo') !== $mod->logo->file_name) {
        //         $mod->addMedia(storage_path('tmp/uploads/' . $request->input('logo')))->toMediaCollection('logo');
        //     }
        // } elseif ($mod->logo) {
        //     $mod->logo->delete();
        // }

        $input = $request->all();
  
        if ($image = $request->file('filepath')) {
            $destinationPath = 'uploads/';
            $input['filename'] = $image->getClientOriginalName();
            $profileImage = date('YmdHis') . "_".  $image->getClientOriginalName();
            $image->move($destinationPath, $profileImage);
            $input['filepath'] = "$profileImage";
            
        }else{
            unset($input['filepath']);
        }
        

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
