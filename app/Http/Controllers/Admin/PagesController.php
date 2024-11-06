<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('id', 'desc')->get();
        return view('admin.pages.index', ['pages' => $pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:pages,name'],
            ]);
    
            $create = Page::create($request->all());
            return redirect()->route('admin.pages.index')->with('success', 'Page added successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('admin.pages.index')->with('error', $th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', ['edit' => $page]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        try {
            if($page->default_page == 'Yes') {
                $request->validate([
                    'name' => ['string', 'max:255', 'unique:pages,name,'.$page->id],
                    'description' => ['required']
                ]);
            } else {
                $request->validate([
                    'name' => ['required', 'string', 'max:255', 'unique:pages,name,'.$page->id],
                    'description' => ['required']
                ]);
            }
    
            $update_req = $request->except(['_token', '_method']);
            $update = Page::where('slug', $page->slug)->update($update_req );
    
            return redirect()->route('admin.pages.index')->with('success', 'Page Updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('admin.pages.index')->with('error', $th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Page $page)
    {
        $page->where('default_page', 'No')->delete();
        
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully!');
    }

    public function forceDelete(Request $request, $slug)
    {
        if($request->ajax())
        {
            $result = Page::where('slug', $slug)->where('default_page', 'No')->first();
            if($result)
            {
                $result->forceDelete();
                $response = [
                    'status' => true,
                    'message' => 'Page deleted successfully',
                    'data' => ''
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'This record not delete associated table',
                    'data' => ''
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'File not found!');
        }
    }
}
