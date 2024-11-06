<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IssuerBank;
use Illuminate\Support\Facades\DB;

class IssuerBankController extends Controller
{
    public function index()
    {
        $issuer_banks = IssuerBank::orderBy('id', 'desc')->get();
        return view('admin.issuer-bank.index', ['issuer_banks' => $issuer_banks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.issuer-bank.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:issuer_banks,name'],
        ]);

        $create = IssuerBank::create($request->all());
        return redirect()->route('admin.issuer-bank.index')->with('success', __('Issuer bank added successfully'));
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
    public function edit(IssuerBank $issuer_bank)
    {
        return view('admin.issuer-bank.edit', ['edit' => $issuer_bank]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IssuerBank $issuer_bank)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:issuer_banks,name,'.$issuer_bank->id],
        ]);

        $update_req = $request->except(['_token', '_method']);
        $update = IssuerBank::where('slug', $issuer_bank->slug)->update($update_req );

        return redirect()->route('admin.issuer-bank.index')->with('success', __('Issuer bank updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, IssuerBank $issuer_bank)
    {
        $issuer_bank->doesntHave('operations')->delete();
        
        return redirect()->route('admin.issuer-bank.index')->with('success', __('Issuer bank deleted successfully'));
    }

    public function forceDelete(Request $request, $slug)
    {
        if($request->ajax())
        {
            $result = IssuerBank::where('slug', $slug)->doesntHave('operations')->first();
            if($result)
            {
                $result->forceDelete();
                $response = [
                    'status' => true,
                    'message' => __('Issuer bank deleted successfully'),
                    'data' => ''
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => __('This record not delete associated table'),
                    'data' => ''
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'File not found!');
        }
    }
}
