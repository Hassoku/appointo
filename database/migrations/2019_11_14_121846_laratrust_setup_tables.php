<?php

use App\Role;
use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class LaratrustSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // create default roles
        $config = Config::get('laratrust_seeder.role_structure');
        $roles = array_keys($config);
        foreach ($roles as $role) {
            $role = Role::create([
                'name' => $role,
                'display_name' => ucwords(str_replace('_', ' ', $role)),
                'description' => ucwords(str_replace('_', ' ', $role))
            ]);
        }

        // Create table for storing permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('module_id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating roles to users and teams (Many To Many Polymorphic)
        Schema::create('role_user', function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('user_id');
            $table->string('user_type');

            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'role_id', 'user_type']);
        });

        // Create table for associating permissions to users (Many To Many Polymorphic)
        Schema::create('permission_user', function (Blueprint $table) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('user_id');
            $table->string('user_type');

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'permission_id', 'user_type']);
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });

        // attach roles to users
        $admins = User::select('id', 'is_admin', 'is_employee')->where('is_admin', 1)->get();
        $employees = User::select('id', 'is_admin', 'is_employee')->where('is_employee', 1)->get();
        $customers = User::select('id', 'is_admin', 'is_employee')->where(['is_admin' => 0, 'is_employee' => 0])->get();

        $adminRole = Role::where('name', 'administrator')->withoutGlobalScopes()->first();
        $employeeRole = Role::where('name', 'employee')->withoutGlobalScopes()->first();
        $customerRole = Role::where('name', 'customer')->withoutGlobalScopes()->first();

        foreach ($admins as $admin) {
            $admin->attachRole($adminRole);
        }
        foreach ($employees as $employee) {
            $employee->attachRole($employeeRole);
        }
        foreach ($customers as $customer) {
            $customer->attachRole($customerRole);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('permission_user');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
    }
}
