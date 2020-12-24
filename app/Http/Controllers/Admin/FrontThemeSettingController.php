<?php

namespace App\Http\Controllers\Admin;

use App\FrontThemeSetting;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\FrontTheme\StoreImagesRequest;
use App\Http\Requests\FrontTheme\StoreTheme;
use App\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class FrontThemeSettingController extends Controller
{

    public function update(StoreTheme $request, $id){
        $theme = FrontThemeSetting::first();
        $theme->primary_color = $request->primary_color;
        $theme->secondary_color = $request->secondary_color;

        if ($request->hasFile('front_logo')) {
            $theme->logo = Files::upload($request->front_logo,'front-logo');
        }

        $theme->save();

        return Reply::redirect(route('admin.settings.index'), __('messages.updatedSuccessfully'));
    }

    public function store(StoreImagesRequest $request) {
        if (sizeof($request->images) == 0) {
            return;
        }

        foreach ($request->images as $image) {
            $media = new Media();
            $media->file_name = Files::upload($image,'carousel-images');
            $media->save();
        }

        $images = Media::select('id', 'file_name')->latest()->get();
        $view = view('partials.carousel_images', compact('images'))->render();

        return Reply::successWithData(__('messages.imageUploadedSuccessfully'), ['view' => $view]);
    }

    public function destroy(Request $request, $id) {
        $req_image = Media::select('id', 'file_name')->where('id', $id)->first();

        if($req_image) {
            Files::deleteFile($req_image->file_name,'carousel-images');
            $req_image->delete();
        }

        $images = Media::select('id', 'file_name')->latest()->get();

        $view = view('partials.carousel_images', compact('images'))->render();

        return Reply::successWithData(__('messages.imageDeletedSuccessfully'), ['view' => $view]);
    }
}
