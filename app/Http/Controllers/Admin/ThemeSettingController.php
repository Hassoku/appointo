<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Reply;
use App\Http\Requests\Theme\StoreImagesRequest;
use App\Http\Requests\Theme\StoreTheme;
use App\Media;
use App\ThemeSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ThemeSettingController extends Controller
{

    public function update(StoreTheme $request, $id){
        $theme = ThemeSetting::first();
        $theme->primary_color = $request->primary_color;
        $theme->secondary_color = $request->secondary_color;
        $theme->sidebar_bg_color = $request->sidebar_bg_color;
        $theme->sidebar_text_color = $request->sidebar_text_color;
        $theme->topbar_text_color = $request->topbar_text_color;
        $theme->save();
        return Reply::redirect(route('admin.settings.index'), __('messages.updatedSuccessfully'));
    }

//    public function store(StoreImagesRequest $request) {
//        if (sizeof($request->images) == 0) {
//            return;
//        }
//
//        foreach ($request->images as $image) {
//            $media = new Media();
//
//            $media->file_name = $image->hashName();
//            $image->store('user-uploads/carousel-images');
//
//            $media->save();
//        }
//
//        $images = Media::select('id', 'file_name')->latest()->get();
//        $view = view('partials.carousel_images', compact('images'))->render();
//
//        return Reply::successWithData(__('messages.imageUploadedSuccessfully'), ['view' => $view]);
//    }
//
//    public function destroy(Request $request, $id) {
//        $req_image = Media::select('id', 'file_name')->where('id', $id)->first();
//
//        if($req_image) {
//            File::delete('user-uploads/carousel-images/'.$req_image->file_name);
//            $req_image->delete();
//        }
//
//        $images = Media::select('id', 'file_name')->latest()->get();
//
//        $view = view('partials.carousel_images', compact('images'))->render();
//
//        return Reply::successWithData(__('messages.imageDeletedSuccessfully.'), ['view' => $view]);
//    }
}
