<?php

use App\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('display_name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        $modules = config('laratrust_seeder.role_structure.administrator');

        foreach ($modules as $module => $value) {
            $newModule = new Module();

            $newModule->name = $module;
            $newModule->display_name = ucwords(str_replace('_', ' ', $module));
            $newModule->description = $value['description'];

            $newModule->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
}
