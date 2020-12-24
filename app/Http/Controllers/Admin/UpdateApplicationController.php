<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Reply;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use ZanySoft\Zip\Zip;

class UpdateApplicationController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.updateApplication');
        $this->pageIcon = __('ti-settings');
    }

    public function index(){
        return view('admin.update-application.index');
    }

}
