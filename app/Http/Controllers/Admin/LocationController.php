<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Reply;
use App\Http\Controllers\Controller;
use App\Http\Requests\Location\StoreLocation;
use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{


    public function __construct()
    {
        parent::__construct();
        view()->share('pageTitle', __('menu.locations'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('read_location'), 403);

        if(request()->ajax()){
            $locations = Location::all();

            return datatables()->of($locations)
                ->addColumn('action', function ($row) {
                    $action = '';

                    if ($this->user->roles()->withoutGlobalScopes()->first()->hasPermission('update_location')) {
                        $action.= '<a href="' . route('admin.locations.edit', [$row->id]) . '" class="btn btn-primary btn-circle"
                          data-toggle="tooltip" data-original-title="'.__('app.edit').'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                    }

                    if ($this->user->roles()->withoutGlobalScopes()->first()->hasPermission('delete_location')) {
                        $action.= ' <a href="javascript:;" class="btn btn-danger btn-circle delete-row"
                        data-toggle="tooltip" data-row-id="' . $row->id . '" data-original-title="'.__('app.delete').'"><i class="fa fa-times" aria-hidden="true"></i></a>';
                    }
                    return $action;
                })
                ->editColumn('name', function ($row) {
                    return ucfirst($row->name);
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('admin.location.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_location'), 403);

        return view('admin.location.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocation $request)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_location'), 403);

        $location = new Location();
        $location->name = $request->name;

        $location->save();

        return Reply::redirect($request->redirect_url, __('messages.createdSuccessfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('update_location'), 403);

        return view('admin.location.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(StoreLocation $request, $id)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('update_location'), 403);

        $location = Location::find($id);
        $location->name = $request->name;
//        $location->status = $request->status;
//        if ($request->hasFile('image')) {
//            $location->image = $request->image->hashName();
//            $request->image->store('user-uploads/category');
//        }
        $location->save();

        //update business servicess status for the category
//        BusinessService::where('category_id', $id)->update(['status' => $request->status]);

        return Reply::redirect(route('admin.locations.index'), __('messages.updatedSuccessfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('delete_location'), 403);

        Location::destroy($id);

        return Reply::success(__('messages.recordDeleted'));
    }
}
