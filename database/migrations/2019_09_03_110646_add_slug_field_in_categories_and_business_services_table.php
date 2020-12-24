<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugFieldInCategoriesAndBusinessServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
        });

        Schema::table('business_services', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
        });

        $categories = \App\Category::select('id', 'name', 'slug')->get();

        $services = \App\BusinessService::select('id', 'name')->get();

        foreach ($categories as $category) {
            $category->slug = \Illuminate\Support\Str::slug($category->name);

            $category->save();
        }

        foreach ($services as $service) {
            $service->slug = \Illuminate\Support\Str::slug($service->name);

            $service->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('business_services', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }

}
