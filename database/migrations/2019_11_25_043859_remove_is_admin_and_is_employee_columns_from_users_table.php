<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveIsAdminAndIsEmployeeColumnsFromUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumns('users', ['is_admin', 'is_employee'])) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_admin');
                $table->dropColumn('is_employee');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(0)->after('remember_token');
            $table->boolean('is_employee')->default(0)->after('is_admin');
        });
    }
}
