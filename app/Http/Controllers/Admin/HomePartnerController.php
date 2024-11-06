<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HomePartner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HomePartnerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:home-partner-list', ['only' => ['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home-partners.index', ['homePartners' => HomePartner::orderBy('step_number')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.home-partners.create');
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
            'name' => ['required', 'string', 'max:255', 'unique:home_partners'],
            'image' => ['required', 'file', 'image'],
        ], [] , [
            // 'name.*' => 'name',
        ])->validate();

        $stepNumber = HomePartner::max('step_number') ?? 0;

        $extension = $request->file('image')->extension();
        if ($extension == 'heif') {
            $name = str_replace(' ', '_', $request->file('image')->getClientOriginalName());
            $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
            $path = 'homepartnerimages/'.$fileName;
            $getImageBlob = app('common')->heicToBlob($request->file('image')->getPathName());
            Storage::put($path, $getImageBlob);
        }else{                       
            $path =  $request->file('image')->store('homepartnerimages');
        }   

        $homePartner = HomePartner::create([
            'name' => $request->input('name'),
            'step_number' => $stepNumber + 1,
            'image' => $path,
        ]);

        return redirect()->route('admin.home-partners.index')->with('success', __('Home partner added successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomePartner  $homePartner
     * @return \Illuminate\Http\Response
     */
    public function show(HomePartner $homePartner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomePartner  $homePartner
     * @return \Illuminate\Http\Response
     */
    public function edit(HomePartner $homePartner)
    {
        return view('admin.home-partners.edit', ['homePartner' => $homePartner]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomePartner  $homePartner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomePartner $homePartner)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('home_partners')->ignore($homePartner)],
            'image' => ['nullable', 'file', 'image'],
        ], [] , [
            // 'name.*' => 'name',
        ])->validate();

        $homePartner->name = $request->input('name');
        $homePartner->is_active = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            Storage::delete($homePartner->image);

            $extension = $request->file('image')->extension();
            if ($extension == 'heif') {
                $name = str_replace(' ', '_', $request->file('image')->getClientOriginalName());
                $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                $path = 'homepartnerimages/'.$fileName;
                $getImageBlob = app('common')->heicToBlob($request->file('image')->getPathName());
                Storage::put($path, $getImageBlob);
            }else{                       
                $path =  $request->file('image')->store('homepartnerimages');
            }  
            $homePartner->image = $path;
        }
        $homePartner->save();

        return redirect()->route('admin.home-partners.index')->with('success', __('Home partner updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomePartner  $homePartner
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomePartner $homePartner)
    {
        //
    }

    public function forceDelete(Request $request, $slug)
    {
        if($request->ajax())
        {
            $homePartner = HomePartner::where('slug', $slug)->first();
            if($homePartner)
            {
                Storage::delete($homePartner->image);
                $homePartner->forceDelete();
                $response = [
                    'status' => true,
                    'message' => __('Home partner deleted successfully'),
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
            foreach ($request->input('partner_steps') as $key => $value) {
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
            'message' => __('Home partner steps updated successfully'),
        ];
        return response()->json($response);
    }
}
