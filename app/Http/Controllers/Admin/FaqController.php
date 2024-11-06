<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FaqType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:faq-list|add-faq|edit-faq|delete-faq', ['only' => ['index','show']]);
        $this->middleware('permission:add-faq', ['only' => ['create','store']]);
        $this->middleware('permission:edit-faq', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-faq', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.faqs.index', ['faqs' => Faq::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faqs.create', ['faqTypes' => FaqType::select('id', 'name')->active()->get()]);
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
            'question.*' => ['required', 'string'],
            'answer.*' => ['required', 'string'],
            'faq_type_id' => ['required', 'numeric', 'integer'],
        ], [] , [
            'question.*' => 'question',
            'answer.*' => 'answer',
            'faq_type_id' => 'faq type',
        ])->validate();

        $faq = Faq::create([
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
            'faq_type_id' => $request->input('faq_type_id'),
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', [
            'faq' => $faq,
            'faqTypes' => FaqType::select('id', 'name')->active()->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        Validator::make($request->all(), [
            'question.*' => ['required', 'string'],
            'answer.*' => ['required', 'string'],
            'faq_type_id' => ['required', 'numeric', 'integer'],
        ], [] , [
            'question.*' => 'question',
            'answer.*' => 'answer',
            'faq_type_id' => 'faq type id',
        ])->validate();

        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->faq_type_id = $request->input('faq_type_id');
        $faq->is_active = $request->has('is_active') ? 1 : 0;
        $faq->save();

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        //
    }

    public function forceDelete(Request $request, $slug)
    {
        if($request->ajax())
        {
            $faq = Faq::where('slug', $slug)->first();
            if($faq)
            {
                $faq->forceDelete();
                $response = [
                    'status' => true,
                    'message' => 'FAQ deleted successfully.',
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
