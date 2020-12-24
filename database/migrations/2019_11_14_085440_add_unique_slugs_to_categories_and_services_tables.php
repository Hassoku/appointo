<?php

use App\BusinessService;
use App\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueSlugsToCategoriesAndServicesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->uniqueSlug(new Category());
        $this->uniqueSlug(new BusinessService());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories_and_services_tables', function (Blueprint $table) {
            //
        });
    }

    public function uniqueSlug($model)
    {
        // get slug array
        $slugArr = $model->select('id', 'name', 'slug')->whereNotNull('slug')->get()->map(function ($category) {
            return $category->slug;
        })->toArray();

        $categories = $model->select('id', 'name', 'slug')->whereNull('slug')->get();

        foreach ($categories as $category) {
            // create slug
            $slug = str_slug($category->name);

            $slugNumber = 0;
            while (array_search($slug, $slugArr) !== false) {
                $splitSlug = explode('-', $slug);
                if(!array_key_exists(1, $splitSlug)) {
                    $slug = $slug.'-'.++$slugNumber;
                }
                else {
                    $splitSlug[1] = ++$slugNumber;
                    $slug = implode('-', $splitSlug);
                }
            }

            $category->slug = $slug;
            array_push($slugArr, $slug);

            $category->save();
        }
    }
}
