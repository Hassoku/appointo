<?php

namespace App\Http\Controllers\Admin;

use App\BusinessService;
use App\Category;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\Category\StoreCategory;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        view()->share('pageTitle', __('menu.categories'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('read_category'), 403);

        if(\request()->ajax()){
            $categories = Category::all();

            return \datatables()->of($categories)
                ->addColumn('action', function ($row) {
                    $action = '';

                    if ($this->user->roles()->withoutGlobalScopes()->first()->hasPermission('update_category')) {
                        $action.= '<a href="' . route('admin.categories.edit', [$row->id]) . '" class="btn btn-primary btn-circle"
                        data-toggle="tooltip" data-original-title="'.__('app.edit').'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                    }
                    if ($this->user->roles()->withoutGlobalScopes()->first()->hasPermission('delete_category')) {
                        $action.= ' <a href="javascript:;" class="btn btn-danger btn-circle delete-row"
                        data-toggle="tooltip" data-row-id="' . $row->id . '" data-original-title="'.__('app.delete').'"><i class="fa fa-times" aria-hidden="true"></i></a>';
                    }

                    return $action;
                })
                ->addColumn('image', function ($row) {
                    return '<img src="'.$row->category_image_url.'" class="img img-fluid iw-60" /> ';
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
                ->addIndexColumn()
                ->rawColumns(['action', 'image', 'status'])
                ->toJson();
        }
        return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_category'), 403);

        return view('admin.category.create');
    }

    /**
     * @param StoreCategory $request
     * @return array
     * @throws \Exception
     */
    public function store(StoreCategory $request)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_category'), 403);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        if ($request->hasFile('image')) {
            $category->image = Files::upload($request->image,'category');
        }
        $category->save();

        return Reply::redirect($request->redirect_url, __('messages.createdSuccessfully'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('update_category'), 403);

        return view('admin.category.edit', compact('category'));
    }

    /**
     * @param StoreCategory $request
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function update(StoreCategory $request, $id)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('update_category'), 403);

        $category = Category::find($id);
        $category->name = $request->name;
        $category->status = $request->status;
        $category->slug = $request->slug;
        if ($request->hasFile('image')) {
            $category->image = Files::upload($request->image,'category');
        }
        $category->save();

        //update business servicess status for the category
        BusinessService::where('category_id', $id)->update(['status' => $request->status]);

        return Reply::redirect(route('admin.categories.index'), __('messages.updatedSuccessfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('delete_category'), 403);

        Category::destroy($id);
        return Reply::success(__('messages.recordDeleted'));
    }

}
