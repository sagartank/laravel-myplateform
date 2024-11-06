<?php

namespace App\Http\Controllers\Admin;

use App\Models\HowToWork;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HowToWorkMipoController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:home-text-list', ['only' => ['index','update']]);
    }

    public function index()
    {
        return view('admin.how-to-work.index', ['howToWork' => HowToWork::first()]);
    }

    public function update(Request $request, HowToWork $howToWork)
    {
      
        Validator::make($request->all(), [
            'heading_text_buyer.*' => ['required', 'string'],
            'sub_heading_text_buyer.*' => ['required', 'string'],
            'button_text_buyer.*' => ['required', 'string'],
            'heading_text_seller.*' => ['required', 'string'],
            'sub_heading_text_seller.*' => ['required', 'string'],
            'button_text_seller.*' => ['required', 'string'],
            'buyer_image' => ['file', 'image'],
            'seller_image' => ['file', 'image'],
        ], [] , [
            'heading_text_buyer.*' => 'Heading Text',
            'sub_heading_text_buyer.*' => 'Sub Heading Text',
            'button_text_buyer.*' => 'Button Text',
            'heading_text_seller.*' => 'Heading Text',
            'sub_heading_text_seller.*' => 'Sub Heading Text',
            'button_text_seller.*' => 'Button Text',
        ])->validate();

        $howToWork->heading_text_buyer = $request->input('heading_text_buyer');
        $howToWork->sub_heading_text_buyer = $request->input('sub_heading_text_buyer');
        $howToWork->button_text_buyer = $request->input('button_text_buyer');

        if ($request->hasFile('buyer_image')) {
            $extension_ = $request->file('buyer_image')->extension();
            if ($extension_ == 'heif') {
                $name = str_replace(' ', '_', $request->file('buyer_image')->getClientOriginalName());
                $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                $path_buyer = 'how-to-work/'.$fileName;
                $getImageBlob = app('common')->heicToBlob($request->file('buyer_image')->getPathName());
                Storage::put($path, $getImageBlob);
            }else{                       
                $path_buyer =  $request->file('buyer_image')->store('how-to-work');
            } 
            $howToWork->buyer_image = $path_buyer;
        }
        if ($request->hasFile('seller_image')) {
            $extension = $request->file('seller_image')->extension();
            if ($extension == 'heif') {
                $name = str_replace(' ', '_', $request->file('seller_image')->getClientOriginalName());
                $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                $path_seller = 'how-to-work/'.$fileName;
                $getImageBlob = app('common')->heicToBlob($request->file('seller_image')->getPathName());
                Storage::put($path, $getImageBlob);
            }else{                       
                $path_seller =  $request->file('seller_image')->store('how-to-work');
            } 
            $howToWork->seller_image = $path_seller;
        }

        $howToWork->heading_text_seller = $request->input('heading_text_seller');
        $howToWork->sub_heading_text_seller = $request->input('sub_heading_text_seller');
        $howToWork->button_text_seller = $request->input('button_text_seller');
        $howToWork->buyer_link = $request->input('buyer_link');
        $howToWork->seller_link = $request->input('seller_link');
     
        

        $howToWork->save();

        return redirect()->route('admin.how-to-work.index')->with('success', __('Home texts updated successfully'));
    }

}
