<?php

namespace App\Http\Controllers\Admin;

use App\Models\{Blog, BlogUsersLink, User};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:blog-list|add-blog|edit-blog|delete-blog', ['only' => ['index','show']]);
        $this->middleware('permission:add-blog', ['only' => ['create','store']]);
        $this->middleware('permission:edit-blog', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-blog', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.blogs.index', ['blogs' => Blog::select('id', 'slug', 'title', 'excerpt', 'is_active')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::select('id','name')->where('is_active', '1')->get();
        return view('admin.blogs.create', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title.*' => ['required', 'string'],
            'excerpt.*' => ['required', 'string'],
            'body.*' => ['required', 'string'],
            'thumbnail' => ['required', 'file', 'image'],
        ], [] , [
            'title.*' => 'title',
            'excerpt.*' => 'excerpt',
            'body.*' => 'body',
        ])->validate();
        $extension = $request->file('thumbnail')->extension();
        if ($extension == 'heif') {
            $name = str_replace(' ', '_', $request->file('thumbnail')->getClientOriginalName());
            $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
            $path = 'blogimages/'.$fileName;
            $getImageBlob = app('common')->heicToBlob($request->file('thumbnail')->getPathName());
            Storage::put($path, $getImageBlob);
        }else{                       
            $path =  $request->file('thumbnail')->store('blogimages');
            // $path =  $request->file('thumbnail')->store('blogimages', 'public');
        }    
        $blog = Blog::create([
            'title' => $request->input('title'),
            'excerpt' => $request->input('excerpt'),
            'body' => $request->input('body'),
            'news_link' => $request->input('news_link'),
            'thumbnail' => $path,
        ]);

        if($request->has('user_ids') && $blog->id > 0) {
            foreach ($request->get('user_ids') as $key => $user_id) {
                $save_blog_user = new BlogUsersLink;
                $save_blog_user->blog_id = $blog->id;
                $save_blog_user->user_id = $user_id;
                $save_blog_user->save();
            }
        }

        return redirect()->route('admin.blogs.index')->with('success', __('Blog added successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        $users = User::select('id', 'name')->where('is_active', '1')->get();
        return view('admin.blogs.edit', ['blog' => $blog->load('blog_users'), 'users' => $users]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        Validator::make($request->all(), [
            'title.*' => ['required', 'string'],
            'excerpt.*' => ['required', 'string'],
            'body.*' => ['required', 'string'],
            'thumbnail' => ['nullable', 'file', 'image'],
        ], [] , [
            'title.*' => 'title',
            'excerpt.*' => 'excerpt',
            'body.*' => 'body',
        ])->validate();

        $blog->title = $request->input('title');
        $blog->excerpt = $request->input('excerpt');
        $blog->body = $request->input('body');
        $blog->news_link = $request->input('news_link');
        $blog->is_active = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            // Storage::disk('public')->delete($blog->thumbnail);
            Storage::delete($blog->thumbnail);
            $extension = $request->file('thumbnail')->extension();
            if ($extension == 'heif') {
                $name = str_replace(' ', '_', $request->file('thumbnail')->getClientOriginalName());
                $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                $path = 'blogimages/'.$fileName;
                $getImageBlob = app('common')->heicToBlob($request->file('thumbnail')->getPathName());
                Storage::put($path, $getImageBlob);
            }else{                       
                $path =  $request->file('thumbnail')->store('blogimages');
                // $path =  $request->file('thumbnail')->store('blogimages', 'public');
            }    
            $blog->thumbnail = $path;
        }

        if($request->has('user_ids') && $blog->id > 0) {
            BlogUsersLink::where('blog_id', $blog->id)->forceDelete();
            foreach ($request->get('user_ids') as $key => $user_id) {
                $save_blog_user = new BlogUsersLink;
                $save_blog_user->blog_id = $blog->id;
                $save_blog_user->user_id = $user_id;
                $save_blog_user->save();
            }
        }
        
        $blog->save();

        return redirect()->route('admin.blogs.index')->with('success', __('Blog updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        //
    }

    public function forceDelete(Request $request, $slug)
    {
        if($request->ajax())
        {
            $blog = Blog::where('slug', $slug)->first();
            if($blog)
            {
                Storage::delete($blog->thumbnail);
                $blog->forceDelete();
                $response = [
                    'status' => true,
                    'message' => __('Blog deleted successfully'),
                    'data' => '',
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => __('Something went wrong please try again!'),
                    'data' => '',
                ];
            }
            return response()->json($response);
        } else {
            abort(404);
        }
    }
}
