<?php

use App\BusinessService;
use App\Category;
use App\Location;
use App\Page;
use App\UniversalSearch;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniversalSearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universal_searches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('searchable_id');
            $table->string('searchable_type');
            $table->string('title');
            $table->string('route_name');
            $table->timestamps();
        });

        // add customer searchable entries
        $customers = User::select('id', 'name', 'email')->where(['is_admin' => 0, 'is_employee' => 0])->get();

        if ($customers->count() > 0) {
            foreach ($customers as $customer) {
                $universal_search = new UniversalSearch();

                $universal_search->searchable_id = $customer->id;
                $universal_search->searchable_type = 'Customer';
                $universal_search->title = $customer->name;
                $universal_search->route_name = 'admin.customers.show';

                $universal_search->save();

                $universal_search = new UniversalSearch();

                $universal_search->searchable_id = $customer->id;
                $universal_search->searchable_type = 'Customer';
                $universal_search->title = $customer->email;
                $universal_search->route_name = 'admin.customers.show';

                $universal_search->save();
            }
        }

        // add employee seachable entries
        $employees = User::select('id', 'name', 'email')->where('is_employee', 1)->get();
        if ($employees->count() > 0) {
            foreach ($employees as $employee) {
                $universal_search = new UniversalSearch();

                $universal_search->searchable_id = $employee->id;
                $universal_search->searchable_type = 'Employee';
                $universal_search->title = $employee->name;
                $universal_search->route_name = 'admin.employee.edit';

                $universal_search->save();

                $universal_search = new UniversalSearch();

                $universal_search->searchable_id = $employee->id;
                $universal_search->searchable_type = 'Employee';
                $universal_search->title = $employee->email;
                $universal_search->route_name = 'admin.employee.edit';

                $universal_search->save();
            }
        }

        // add categories searchable entries
        $categories = Category::select('id', 'name')->get();
        if ($categories->count() > 0) {
            foreach ($categories as $category) {
                $universal_search = new UniversalSearch();

                $universal_search->searchable_id = $category->id;
                $universal_search->searchable_type = 'Category';
                $universal_search->title = $category->name;
                $universal_search->route_name = 'admin.categories.edit';

                $universal_search->save();
            }
        }

        // add services searchable entries
        $services = BusinessService::select('id', 'name')->get();
        if ($services->count() > 0) {
            foreach ($services as $service) {
                $universal_search = new UniversalSearch();

                $universal_search->searchable_id = $service->id;
                $universal_search->searchable_type = 'Service';
                $universal_search->title = $service->name;
                $universal_search->route_name = 'admin.business-services.edit';

                $universal_search->save();
            }
        }

        $location = new \App\Location();
        $location->name = 'Jaipur, India';
        $location->save();

        $pages = [
            'aboutUs' => [
                'title' => 'About Us',
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                'slug' => 'about-us'
            ],
            'contactUs' => [
                'title' => 'Contact Us',
                'content' => '<h2>Contact Us</h2>

                <p>How can we help you? We will try to get back to you as soon as possible.</p>',
                'slug' => 'contact-us'
            ],
            'howItWorks' => [
                'title' => 'How It Works',
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                'slug' => 'how-it-works'
            ],
            'privacyPolicy' => [
                'title' => 'Privacy Policy',
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                'slug' => 'privacy-policy'
            ],
        ];

        foreach ($pages as $page) {
            $page_detail = new Page();

            $page_detail->title = $page['title'];
            $page_detail->content = $page['content'];
            $page_detail->slug = $page['slug'];

            $page_detail->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('universal_searches', function (Blueprint $table) {
            $table->drop('universal_searches');
        });
    }
}
