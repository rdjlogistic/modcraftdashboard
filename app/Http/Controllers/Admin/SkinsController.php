<?php

namespace App\Http\Controllers\Admin;

use App\Skin;
use App\App;
use File;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySkinRequest;
use App\Http\Requests\StoreSkinRequest;
use App\Http\Requests\UpdateSkinRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use URL;

class SkinsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        $skins = Skin::all();

        $apps = App::all()->pluck('name', 'id');

        return view('admin.skins.index', compact('skins' ,'apps'));
    }

    public function create()
    {
        $apps = App::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.skins.create' , compact('apps'));
    }

    public function store(StoreSkinRequest $request)
    {
        $skin = Skin::create($request->all());
       

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
          
        $skin->update($input);

        return redirect()->route('admin.skins.index');
    }

    public function edit(Skin $skin)
    {
        $apps = App::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.skins.edit', compact('apps', 'skin'));
    }

    public function update(UpdateSkinRequest $request, Skin $skin)
    {
        $skin->update($request->all());

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
        

        $skin->update($input);


        return redirect()->route('admin.skins.index');
    }

    // public function show(Mod $mod)
    // {
    //     abort_if(Gate::denies('company_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $company->load('city', 'categories', 'prices');

    //     return view('admin.companies.show', compact('company'));
    // }

    public function destroy(Skin $skin)
    {

        $skin->delete();

        return back();
    }

    public function massDestroy(MassDestroySkinRequest $request)
    {
        Skin::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
