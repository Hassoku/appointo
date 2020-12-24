<?php

namespace App\Http\Controllers\Admin;

use App\BusinessService;
use App\Category;
use App\EmployeeGroup;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\Employee\StoreRequest;
use App\Http\Requests\Employee\UpdateRequest;
use App\Http\Requests\Service\StoreService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\ChangeRoleRequest;
use App\Role;
use Illuminate\Support\Facades\Artisan;

class EmployeeController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        view()->share('pageTitle', __('menu.employee'));

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
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('read_employee'), 403);

        if(\request()->ajax()){
            $employee = User::otherThanCustomers()->get();
            $roles = Role::all();

            return \datatables()->of($employee)
                ->addColumn('action', function ($row) {
                    $action = '';
                    if (($this->user->is_admin || $this->user->can('update_employee'))&& $row->id !== $this->user->id && !$row->is_admin) {
                        $action.= '<a href="' . route('admin.employee.edit', [$row->id]) . '" class="btn btn-primary btn-circle"
                          data-toggle="tooltip" data-original-title="'.__('app.edit').'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                    }
                    if (($this->user->is_admin || $this->user->can('delete_employee'))&& $row->id !== $this->user->id && !$row->is_admin) {
                        $action.= ' <a href="javascript:;" class="btn btn-danger btn-circle delete-row"
                            data-toggle="tooltip" data-row-id="' . $row->id . '" data-original-title="'.__('app.delete').'"><i class="fa fa-times" aria-hidden="true"></i></a>';
                    }

                    return $action;
                })
                ->addColumn('image', function ($row) {
                    return '<img src="'.$row->user_image_url.'" class="img img-fluid iw-60" /> ';
                })
                ->editColumn('name', function ($row) {
                    return ucfirst($row->name);
                })
                ->editColumn('group_id', function ($row) {
                    return !is_null($row->group_id) ? ucfirst($row->employeeGroup->name) : '--';
                })
                ->addColumn('role_name', function ($row) use ($roles){
                    if (($row->id === $this->user->id) || !$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('update_employee') || $row->is_admin) {
                        return $row->role->display_name;
                    }

                    $roleOption = '<select name="role_id" class="form-control role_id" data-user-id="'.$row->id.'">';

                    foreach ($roles as $role){
                        $roleOption.= '<option ';

                        if($row->role->id == $role->id){
                            $roleOption.= ' selected ';
                        }

                        $roleOption.= 'value="'.$role->id.'">'.ucwords($role->display_name).'</option>';
                    }
                    $roleOption.= '</select>';

                    return $roleOption;
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'image', 'role_name'])
                ->toJson();
        }

        return view('admin.employees.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_employee'), 403);

        $groups = EmployeeGroup::all();
        $roles = Role::all();

        return view('admin.employees.create', compact('groups', 'roles'));
    }

    /**
     * @param StoreRequest $request
     * @return array
     */
    public function store(StoreRequest $request)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_employee'), 403);

        $user = new User();

        $user->name     = $request->name;
        $user->email    = $request->email;
        if ($request->group_id !== '0') {
            $user->group_id = $request->group_id;
        }
        $user->calling_code = $request->calling_code;
        $user->mobile = $request->mobile;

        if($request->password != ''){
            $user->password = $request->password;
        }

        if ($request->hasFile('image')) {
            $user->image = Files::upload($request->image,'avatar');
        }

        $user->save();

        // add default employee role
        $user->attachRole($request->role_id);

        return Reply::redirect(route('admin.employee.index'), __('messages.createdSuccessfully'));

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
        $employee = User::where('id', $id)->first();
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('update_employee') || $employee->is_admin || $employee->is_customer || $this->user->id === $employee->id, 403);

        $groups = EmployeeGroup::all();
        $roles = Role::all();

        return view('admin.employees.edit', compact('employee', 'groups', 'roles'));
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
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('update_employee'), 403);

        $user = User::findOrFail($id);

        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->group_id     = $request->group_id;

        if($request->password != ''){
            $user->password = $request->password;
        }

        if (($request->mobile != $user->mobile || $request->calling_code != $user->calling_code) && $user->mobile_verified == 1) {
            $user->mobile_verified = 0;
        }

        $user->mobile       = $request->mobile;
        $user->calling_code = $request->calling_code;

        if ($request->hasFile('image')) {
            $user->image = Files::upload($request->image,'avatar');
        }

        $user->save();

        $user->syncRoles([$request->role_id]);

        return Reply::redirect(route('admin.employee.index'), __('messages.updatedSuccessfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('delete_employee') || $user->is_admin, 403);

        $user->delete();
        return Reply::success(__('messages.recordDeleted'));
    }

    public function changeRole(ChangeRoleRequest $request)
    {
        $user = User::findOrFail($request->user_id);

        $user->roles()->sync($request->role_id);

        Artisan::call('cache:clear');

        return Reply::success(__('messages.roleChangedSuccessfully'));
    }
}
