<?php

namespace App\Http\Controllers\Admin;

use App\App;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAppRequest;
use App\Http\Requests\StoreAppRequest;
use App\Http\Requests\UpdateAppRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AppsController extends Controller
{
    public function index()
    {

        $apps = App::all();

        return view('admin.apps.index', compact('apps'));
    }

    public function create()
    {

        return view('admin.apps.create');
    }

    public function store(StoreAppRequest $request)
    {
        $app = App::create($request->all());

        return redirect()->route('admin.apps.index');
    }

    public function edit(App $app)
    {

        return view('admin.apps.edit', compact('app'));
    }

    public function update(UpdateAppRequest $request, App $app)
    {
        $app->update($request->all());

        return redirect()->route('admin.apps.index');
    }

    public function show(App $app)
    {

        return view('admin.apps.show', compact('app'));
    }

    public function destroy(App $app)
    {

        $app->delete();

        return back();
    }

    public function massDestroy(MassDestroyAppRequest $request)
    {
        App::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
