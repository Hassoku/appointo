<?php

namespace App\Http\Controllers\Admin;

use App\EmployeeGroup;
use App\Helper\Reply;
use App\Http\Requests\EmployeeGroup\StoreRequest;
use App\Http\Requests\EmployeeGroup\UpdateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeGroupController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        view()->share('pageTitle', __('app.employeeGroup'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index()
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('read_employee_group'), 403);

        if(\request()->ajax()){
            $employeeGroup = EmployeeGroup::all();

            return \datatables()->of($employeeGroup)
                ->addColumn('action', function ($row) {
                    $action = '';

                    if ($this->user->roles()->withoutGlobalScopes()->first()->hasPermission('update_employee_group')) {
                        $action.= '<a href="' . route('admin.employee-group.edit', [$row->id]) . '" class="btn btn-primary btn-circle"
                          data-toggle="tooltip" data-original-title="'.__('app.edit').'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                    }

                    if ($this->user->roles()->withoutGlobalScopes()->first()->hasPermission('delete_employee_group')) {
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

        return view('admin.employee-group.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_employee_group'), 403);

        return view('admin.employee-group.create');
    }

    /**
     * @param StoreRequest $request
     * @return array
     */
    public function store(StoreRequest $request)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_employee_group'), 403);

        $user = new EmployeeGroup();
        $user->name = $request->name;
        $user->save();

        return Reply::redirect(route('admin.employee-group.index'), __('messages.createdSuccessfully'));

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
    public function edit(Request $request, $id)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('update_employee_group'), 403);

        $employeeGroup = EmployeeGroup::where('id', $id)->first();
        return view('admin.employee-group.edit', compact('employeeGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('update_employee_group'), 403);

        $user = EmployeeGroup::findOrFail($id);

        $user->name = $request->name;
        $user->save();

        return Reply::redirect(route('admin.employee-group.index'), __('messages.updatedSuccessfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('delete_employee_group'), 403);

        EmployeeGroup::destroy($id);
        return Reply::success(__('messages.recordDeleted'));
    }
}
