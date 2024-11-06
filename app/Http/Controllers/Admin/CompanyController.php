<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:company_types_master|add-company-types|edit-company-types|delete-company-types', ['only' => ['index','show']]);
        $this->middleware('permission:add-company-types', ['only' => ['create','store']]);
        $this->middleware('permission:edit-company-types', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-company-types', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::orderBy('id', 'desc')->get();
        return view('admin.companies.index', ['companies' => $companies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.companies.create');
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
            'name' => ['required', 'string', 'max:255', 'unique:companies,name'],
        ]);
       
        $create = Company::create($request->only('name', 'is_active'));

        return redirect()->route('admin.companies.index')->with('success', 'Company added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('admin.companies.edit', ['edit' => $company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:companies,name,'.$company->id],
        ]);

        $company->name = $request->name;
        $company->is_active = $request->has('is_active') ? 1 : 0;
        $company->save();

        return redirect()->route('admin.companies.index')->with('success', 'Company update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        
        return redirect()->route('admin.companies.index')->with('success', 'Company deleted successfully!');
    }

    public function forceDelete(Request $request, $slug)
    {
        if($request->ajax())
        {
            $result = Company::withTrashed()->where('slug', $slug)->first();
            if($result)
            {
                $result->forceDelete();
                $response = [
                    'status' => true,
                    'message' => 'Company deleted successfully',
                    'data' => ''
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'something went wrong please try again!',
                    'data' => ''
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'File not found!');
        }
    }

}
