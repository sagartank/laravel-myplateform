<?php

namespace App\Http\Controllers\Admin;

use App\Models\HomeSlide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomeSlideController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:home-side-list', ['only' => ['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home-slides.index', ['homeSlides' => HomeSlide::orderBy('step_number')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.home-slides.create');
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
            'text.*' => ['required', 'string'],
            'svg_image' => ['required', 'file', 'image'],
        ], [] , [
            'title.*' => 'title',
            'text.*' => 'text',
        ])->validate();

        $stepNumber = HomeSlide::max('step_number') ?? 0;

        $extension = $request->file('svg_image')->extension();
        if ($extension == 'heif') {
            $name = str_replace(' ', '_', $request->file('svg_image')->getClientOriginalName());
            $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
            $path = 'homepartnerimages/'.$fileName;
            $getImageBlob = app('common')->heicToBlob($request->file('svg_image')->getPathName());
            Storage::put($path, $getImageBlob);
        }else{                       
            $path =  $request->file('svg_image')->store('homeslideimages');
        }   

        $homeSlide = HomeSlide::create([
            'title' => $request->input('title'),
            'text' => $request->input('text'),
            'step_number' => $stepNumber + 1,
            'svg_image' => $path,
        ]);

        return redirect()->route('admin.home-slides.index')->with('success', __('Home slide added successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomeSlide  $homeSlide
     * @return \Illuminate\Http\Response
     */
    public function show(HomeSlide $homeSlide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeSlide  $homeSlide
     * @return \Illuminate\Http\Response
     */
    public function edit(HomeSlide $homeSlide)
    {
        return view('admin.home-slides.edit', ['homeSlide' => $homeSlide]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomeSlide  $homeSlide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomeSlide $homeSlide)
    {
        Validator::make($request->all(), [
            'title.*' => ['required', 'string'],
            'text.*' => ['required', 'string'],
            'svg_image' => ['nullable', 'file', 'image'],
        ], [] , [
            'title.*' => 'title',
            'text.*' => 'text',
        ])->validate();

        $homeSlide->title = $request->input('title');
        $homeSlide->text = $request->input('text');
        $homeSlide->is_active = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('svg_image') && $request->file('svg_image')->isValid()) {
            Storage::delete($homeSlide->svg_image);
            $extension = $request->file('svg_image')->extension();
            if ($extension == 'heif') {
                $name = str_replace(' ', '_', $request->file('svg_image')->getClientOriginalName());
                $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                $path = 'homepartnerimages/'.$fileName;
                $getImageBlob = app('common')->heicToBlob($request->file('svg_image')->getPathName());
                Storage::put($path, $getImageBlob);
            }else{                       
                $path =  $request->file('svg_image')->store('homeslideimages');
            }   
            
            $homeSlide->svg_image = $path;
        }
        $homeSlide->save();

        return redirect()->route('admin.home-slides.index')->with('success', __('Home slide updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomeSlide  $homeSlide
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomeSlide $homeSlide)
    {
        //
    }

    public function forceDelete(Request $request, $slug)
    {
        if($request->ajax())
        {
            $homeSlide = HomeSlide::where('slug', $slug)->first();
            if($homeSlide)
            {
                Storage::delete($homeSlide->svg_image);
                $homeSlide->forceDelete();
                $response = [
                    'status' => true,
                    'message' => __('Home slide deleted successfully'),
                    'data' => '',
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => __('Something went wrong, please try again!'),
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
            foreach ($request->input('slider_steps') as $key => $value) {
                DB::table('home_slides')->where('slug', $value)->update([
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
            'message' => __('Home slide steps updated successfully'),
        ];
        return response()->json($response);
    }
}
