<?php

namespace App\Http\Controllers\Admin;

use App\Models\HomeText;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HomeTextController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:home-text-list', ['only' => ['index','update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home-texts.index', ['homeText' => HomeText::first()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('admin.home-texts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomeText  $homeText
     * @return \Illuminate\Http\Response
     */
    public function show(HomeText $homeText)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeText  $homeText
     * @return \Illuminate\Http\Response
     */
    public function edit(HomeText $homeText)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomeText  $homeText
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomeText $homeText)
    {
        Validator::make($request->all(), [
            'heading_text.*' => ['required', 'string'],
            'sub_heading_text.*' => ['required', 'string'],
            'footer_text.*' => ['required', 'string'],
            'contact_email' => ['required', 'string', 'max:255', 'email'],
            'contact_phone' => ['required', 'string', 'max:255', 'regex:/^([0-9\ \-\+\(\)]*)$/'],
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['required', 'string', 'max:255'],
        ], [] , [
            'heading_text.*' => 'Heading Text',
            'sub_heading_text.*' => 'Sub Heading Text',
            'footer_text.*' => 'Footer Text',
        ])->validate();

        $homeText->heading_text = $request->input('heading_text');
        $homeText->sub_heading_text = $request->input('sub_heading_text');
        $homeText->footer_text = $request->input('footer_text');
        $homeText->contact_email = $request->input('contact_email');
        $homeText->contact_phone = $request->input('contact_phone');
        $homeText->address_line_1 = $request->input('address_line_1');
        $homeText->address_line_2 = $request->input('address_line_2');
        $homeText->save();

        return redirect()->route('admin.home-texts.index')->with('success', 'Home texts updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomeText  $homeText
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomeText $homeText)
    {
        //
    }
}
