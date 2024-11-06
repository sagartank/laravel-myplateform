<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\SocialMedia;

class SocialMediaController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:social-media-list|add-social-media|edit-social-media|delete-social-media', ['only' => ['index','show']]);
        $this->middleware('permission:add-social-media', ['only' => ['create','store']]);
        $this->middleware('permission:edit-social-media', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-social-media', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.social-media.index', ['social_media' => SocialMedia::get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.social-media.create');
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
            'name' => ['required', 'string', 'max:255'],
            'link' => ['required', 'string', 'max:255', 'url'],
            // 'icon_image' => ['nullable', 'file', 'image'],
        ], [] , [
        ])->validate();

        $stepNumber = SocialMedia::max('step_number') ?? 0;

       /*  $extension = $request->file('icon_image')->extension();
        if ($extension == 'heif') {
            $name = str_replace(' ', '_', $request->file('icon_image')->getClientOriginalName());
            $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
            $path = 'socialmediaicons/'.$fileName;
            $getImageBlob = app('common')->heicToBlob($request->file('icon_image')->getPathName());
            Storage::put($path, $getImageBlob);
        }else{                       
            $path =  $request->file('icon_image')->store('socialmediaicons', 'public');
        }  */

        $socialMedia = SocialMedia::create([
            'name' => $request->input('name'),
            'link' => $request->input('link'),
            'step_number' => $stepNumber + 1,
            'icon_image' => 'no image',
            // 'icon_image' => $path,
        ]);

        return redirect()->route('admin.social-media.index')->with('success', 'Social media added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SocialMedia  $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function show(SocialMedia $socialMedia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SocialMedia  $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
      
        return view('admin.social-media.edit', ['socialMedia' => SocialMedia::where('slug', $slug)->first() ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SocialMedia  $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'link' => ['required', 'string', 'max:255'],
            // 'icon_image' => ['nullable', 'file', 'image'],
        ], [] , [
        ])->validate();

        $socialMedia = SocialMedia::where('slug', $slug)->first();

        $socialMedia->name = $request->input('name');
        $socialMedia->link = $request->input('link');
        $socialMedia->is_active = $request->has('is_active') ? 1 : 0;
        $socialMedia->icon_image = 'no image';
        

       /*  if ($request->hasFile('icon_image') && $request->file('icon_image')->isValid()) {
            Storage::disk('public')->delete($socialMedia->icon_image);

            $extension = $request->file('icon_image')->extension();
            if ($extension == 'heif') {
                $name = str_replace(' ', '_', $request->file('icon_image')->getClientOriginalName());
                $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                $path = 'socialmediaicons/'.$fileName;
                $getImageBlob = app('common')->heicToBlob($request->file('icon_image')->getPathName());
                Storage::put($path, $getImageBlob);
            }else{                       
                $path =  $request->file('icon_image')->store('socialmediaicons', 'public');
            } 
            $socialMedia->icon_image = $path;
        } */
        $socialMedia->save();

        return redirect()->route('admin.social-media.index')->with('success', 'Social media updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SocialMedia  $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function destroy(SocialMedia $socialMedia)
    {
        //
    }

    public function forceDelete(Request $request, $slug)
    {
        if($request->ajax())
        {
            $socialMedia = SocialMedia::where('slug', $slug)->first();
            if($socialMedia)
            {
              /*   if (Storage::exists($socialMedia->image)) {
                    Storage::delete($socialMedia->image);
                } */

                $socialMedia->forceDelete();
                $response = [
                    'status' => true,
                    'message' => 'Social media deleted successfully.',
                    'data' => '',
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Something went wrong, please try again!',
                    'data' => '',
                ];
            }
            return response()->json($response);
        } else {
            abort(404);
        }
    }

    public function ajaxUpdateStepNumber(Request $request)
    {
        DB::beginTransaction();
        try {
            foreach ($request->input('step_numbers') as $key => $value) {
                DB::table('home_partners')->where('slug', $value)->update([
                    'step_number' => $key + 1,
                ]);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
            $response = [
                'success' => 0,
                'line' => $th->getLine(),
                'message' => $th->getMessage(),
            ];
            return response()->json($response);
        }

        $response = [
            'success' => 1,
            'message' => 'Social media steps updated successfully.',
        ];
        return response()->json($response);
    }
}
