<?php

namespace App\Http\Controllers\Admin;

use App\BusinessService;
use App\Category;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\Service\StoreService;
use App\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BusinessServiceController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        view()->share('pageTitle', __('menu.services'));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('read_business_service'), 403);

        if(\request()->ajax()){
            $services = BusinessService::all();

            return \datatables()->of($services)
                ->addColumn('action', function ($row) {
                    $action = '';

                    if ($this->user->roles()->withoutGlobalScopes()->first()->hasPermission('update_business_service')) {
                        $action.= '<a href="' . route('admin.business-services.edit', [$row->id]) . '" class="btn btn-primary btn-circle"
                          data-toggle="tooltip" data-original-title="'.__('app.edit').'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                    }

                    if ($this->user->roles()->withoutGlobalScopes()->first()->hasPermission('delete_business_service')) {
                        $action.= ' <a href="javascript:;" class="btn btn-danger btn-circle delete-row"
                          data-toggle="tooltip" data-row-id="' . $row->id . '" data-original-title="'.__('app.delete').'"><i class="fa fa-times" aria-hidden="true"></i></a>';
                    }

                    return $action;
                })
                ->addColumn('image', function ($row) {
                    return '<img src="'.$row->service_image_url.'" class="img img-fluid iw-60" /> ';
                })
                ->editColumn('name', function ($row) {
                    return ucfirst($row->name);
                })
                ->editColumn('status', function ($row) {
                    if($row->status == 'active'){
                        return '<label class="badge badge-success">'.__("app.active").'</label>';
                    }
                    elseif($row->status == 'deactive'){
                        return '<label class="badge badge-danger">'.__("app.deactive").'</label>';
                    }
                })
                ->editColumn('location_id', function ($row) {
                    return ucfirst($row->location->name);
                })
                ->editColumn('category_id', function ($row) {
                    return ucfirst($row->category->name);
                })
                ->editColumn('price', function ($row) {
                    return $row->price;
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'image', 'status'])
                ->toJson();
        }

        return view('admin.business_service.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_business_service'), 403);

        $categories = Category::orderBy('name', 'ASC')->get();
        $locations = Location::orderBy('name', 'ASC')->get();
        return view('admin.business_service.create', compact('categories', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreService $request)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_business_service'), 403);

        $service = new BusinessService();
        $service->name = $request->name;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->time = $request->time;
        $service->time_type = $request->time_type;
        $service->discount = $request->discount;
        $service->discount_type = $request->discount_type;
        $service->location_id = $request->location_id;
        $service->category_id = $request->category_id;
        $service->slug = $request->slug;
        if ($request->hasFile('image')) {
            $service->image = Files::upload($request->image,'service');
        }
        $service->save();

        return Reply::redirect(route('admin.business-services.index'), __('messages.createdSuccessfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BusinessService $businessService)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('update_business_service'), 403);

        $categories = Category::orderBy('name', 'ASC')->get();
        $locations = Location::orderBy('name', 'ASC')->get();

        return view('admin.business_service.edit', compact('businessService', 'categories', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreService $request, $id)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('update_business_service'), 403);

        $service = BusinessService::find($id);
        $service->name = $request->name;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->time = $request->time;
        $service->time_type = $request->time_type;
        $service->discount = $request->discount;
        $service->discount_type = $request->discount_type;
        $service->category_id = $request->category_id;
        $service->location_id = $request->location_id;
        $service->status = $request->status;
        $service->slug = $request->slug;
        if ($request->hasFile('image')) {
            $service->image = Files::upload($request->image,'service',400,null);
        }
        $service->save();

        return Reply::redirect(route('admin.business-services.index'), __('messages.updatedSuccessfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('delete_business_service'), 403);

        BusinessService::destroy($id);
        return Reply::success(__('messages.recordDeleted'));
    }
}
