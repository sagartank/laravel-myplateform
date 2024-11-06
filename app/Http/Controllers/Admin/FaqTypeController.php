<?php

namespace App\Http\Controllers\Admin;

use App\Models\FaqType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FaqTypeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:faq-type-list|add-faq-type|edit-faq-type|delete-faq-type', ['only' => ['index','show']]);
        $this->middleware('permission:add-faq-type', ['only' => ['create','store']]);
        $this->middleware('permission:edit-faq-type', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-faq-type', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.faq-types.index', ['faqTypes' => FaqType::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faq-types.create');
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
            'name.*' => ['required', 'string'],
        ], [] , [
            'name.*' => 'name',
        ])->validate();

        $faqType = FaqType::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('admin.faq-types.index')->with('success', 'FAQ type added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FaqType  $faqType
     * @return \Illuminate\Http\Response
     */
    public function show(FaqType $faqType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FaqType  $faqType
     * @return \Illuminate\Http\Response
     */
    public function edit(FaqType $faqType)
    {
        return view('admin.faq-types.edit', ['faqType' => $faqType]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FaqType  $faqType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FaqType $faqType)
    {
        Validator::make($request->all(), [
            'name.*' => ['required', 'string'],
        ], [] , [
            'name.*' => 'name',
        ])->validate();

        $faqType->name = $request->input('name');
        $faqType->is_active = $request->has('is_active') ? 1 : 0;
        $faqType->save();

        return redirect()->route('admin.faq-types.index')->with('success', 'FAQ type updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FaqType  $faqType
     * @return \Illuminate\Http\Response
     */
    public function destroy(FaqType $faqType)
    {
        //
    }

    public function forceDelete(Request $request, $slug)
    {
        if($request->ajax())
        {
            $faqType = FaqType::where('slug', $slug)->first();
            if($faqType)
            {
                $faqType->forceDelete();
                $response = [
                    'status' => true,
                    'message' => 'FAQ type deleted successfully.',
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
}
