<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Reply;
use App\Http\Controllers\Controller;
use App\Http\Requests\Page\StorePage;
use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        view()->share('pageTitle', __('menu.pages'));
    }

    public function index()
    {
        if(request()->ajax()){
            $pages = Page::all();

            return datatables()->of($pages)
                ->addColumn('action', function ($row) {
                    $action = '';

                    $action.= '<a href="javascript:;" data-slug="' . $row->slug . '" class="btn btn-primary btn-circle edit-page"
                      data-toggle="tooltip" data-original-title="'.__('app.edit').'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';

                    if ($row->id !== 2) {
                        $action.= ' <a href="javascript:;" class="btn btn-danger btn-circle delete-row"
                          data-toggle="tooltip" data-row-id="' . $row->id . '" data-original-title="'.__('app.delete').'"><i class="fa fa-times" aria-hidden="true"></i></a>';
                    }
                    return $action;
                })
                ->editColumn('title', function ($row) {
                    return ucfirst($row->title);
                })
                ->editColumn('slug', function ($row) {
                    return $row->slug;
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('admin.page.index');
    }

    public function create()
    {
        return view('admin.page.create');
    }

    public function store(StorePage $request)
    {
        $page = new Page();

        $page->title = $request->title;
        $page->content = $request->content;
        $page->slug = $request->slug;

        $page->save();

        return Reply::success(__('messages.createdSuccessfully'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        if (request()->ajax()) {
            return view('admin.page.edit_modal', compact('page'));
        }

        return view('admin.page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePage $request, $slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        $page->title = $request->title;
        $page->content = $request->content;
        $page->slug = $request->slug;

        $page->save();

        return Reply::success(__('messages.updatedSuccessfully'));
    }

    public function destroy($id)
    {
        if ($id !== 2) {
            Page::destroy($id);
        }

        return Reply::success(__('messages.recordDeleted'));
    }
}
