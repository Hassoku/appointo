<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RolePermission\AddMembers;
use App\Http\Requests\RolePermission\StoreRole;
use App\Permission;
use App\Role;
use App\User;

class RolePermissionSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.role-permission.create');
    }

    public function data()
    {
        $roles = Role::all();

        return datatables()->of($roles)
            ->addColumn('action', function ($row) {
                $action = '';

                if (!in_array($row->name, config('laratrust_seeder.default_roles'))) {
                    $action .= '<a href="javascript:;" data-role-id="' . $row->id . '"
                        class="btn btn-sm btn-info btn-rounded edit-role">' . __("app.edit") . '</a>
                    <a href="javascript:;" data-role-id="' . $row->id . '"
                        class="btn btn-sm btn-danger btn-rounded delete-role">' . __("app.remove") . '</a>';
                }
                else {
                    $action .= '<span class="text-danger">' . __("messages.defaultRoleCantDelete") . '</span>';

                }

                return $action;
            })
            ->editColumn('display_name', function ($row) {
                return ucfirst($row->display_name);
            })
            ->editColumn('description', function ($row) {
                return $row->description ?? '--';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getMembers($role_id)
    {
        $members = User::whereHas('roles', function ($query) use ($role_id) {
            $query->where('id', $role_id);
        })->with('roles');

        return datatables()->of($members)
            ->addColumn('action', function ($row) {
                $action = '';

                if ($row->role->name !== 'employee') {
                    $action .= '<a href="javascript:;" data-user-id="' . $row->id . '"
                    class="btn btn-sm btn-danger btn-rounded delete-member">' . __("app.remove") . '</a>';
                }

                return $action;
            })
            ->editColumn('name', function ($row) {
                return ucwords($row->name);
            })
            ->editColumn('roles.display_name', function ($row) {
                return $row->role->display_name;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function addRole(StoreRole $request)
    {
        $role = new Role();

        $role->display_name = $request->display_name;
        $role->name = $request->name;
        if (!is_null($request->description)) {
            $role->description = $request->description;
        }

        $role->save();

        return Reply::success(__('messages.roleCreatedSuccessfully'));
    }

    public function addMembers(AddMembers $request, $role_id)
    {
        $users = User::whereIn('id', $request->user_ids)->get();

        foreach ($users as $user) {
            $user->syncRoles([$role_id]);
        }

        return Reply::success(__('messages.membersAddedSuccessfully'));
    }

    public function removeMember(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        if ($user->role->name !== 'employee') {
            $user->syncRoles([2]);
        }

        return Reply::success(__('messages.memberRemovedSuccessfully'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::where('id', $request->roleId)->first();

        if ($request->assignPermission === 'yes') {
            $role->attachPermissions([$request->permissionId]);
        }
        else {
            $role->detachPermissions([$request->permissionId]);
        }

        return Reply::dataOnly(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usersToAdd = User::whereHas('roles', function ($query) use ($id) {
            $query->whereNotIn('id', [$id, '1']);
        })->get();

        return view('admin.role-permission.show', compact('usersToAdd', 'id'));
    }

    public function getMembersToAdd($id)
    {
        $usersToAdd = User::whereHas('roles', function ($query) use ($id) {
            $query->whereNotIn('id', [$id, '1']);
        })->get();

        return Reply::dataOnly(['usersToAdd' => $usersToAdd]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        $view = view('admin.role-permission.edit_form', compact('role'))->render();

        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRole $request, $id)
    {
        $role = Role::findOrFail($id);

        $role->display_name = $request->display_name;
        $role->name = $request->name;
        if (!is_null($request->description)) {
            $role->description = $request->description;
        }

        $role->save();

        return Reply::success(__('messages.roleUpdatedSuccessfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        foreach ($role->users as $user) {
            $user->syncRoles([2]);
        }

        $role->delete();

        return Reply::success(__('messages.roleDeletedSuccessfully'));
    }

    public function toggleAllPermissions(Request $request)
    {
        $role = Role::where('id', $request->roleId)->first();

        if ($request->assignPermission === 'no') {
            $permissions = [];
        }
        else {
            $permissions = Permission::all();
        }

        $role->syncPermissions($permissions);

        return Reply::dataOnly(['status' => 'success']);
    }
}
