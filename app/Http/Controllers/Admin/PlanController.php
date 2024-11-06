<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Http\Requests\StorePlanRequest;
use Illuminate\Support\Str;
use App\Models\PlanFeature;
use App\Models\UserLevel;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:plans|add-plans|edit-plans|delete-plans', ['only' => ['index','show']]);
        $this->middleware('permission:add-plans', ['only' => ['create','store']]);
        $this->middleware('permission:edit-plans', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-plans', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.plan.index', ['plans' => Plan::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userLevels = UserLevel::all();
        return view('admin.plan.create',compact('userLevels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slug = Str::slug($request->input('name'), '-');
        $plan = Plan::create([
            'name' => $request->input('name'),
            'slug' => $slug,
            'price' => $request->input('price'),
            'currency' => 'Gs.',
            'offer_price' => $request->input('offer_price'),
            'duration' => $request->input('duration'),
            'sort_order' => $request->input('sort_order'),
            'is_free_plan' => $request->input('is_free_plan'),
            'suitable_for_account_type' => $request->input('suitable_for_account_type'),
            'suitable_for_account_opener' => $request->input('suitable_for_account_opener'),
            'user_level_id' => $request->input('user_level_id'),
            'buy_sell' => $request->input('buy_sell'),
            'basic_dashboard' => $request->input('basic_dashboard'),
            'enterprise_dashboard' => $request->input('enterprise_dashboard'),
            'multi_user_account' => $request->input('multi_user_account'),
            'exportable_pdf' => $request->input('exportable_pdf'),
            'offer_notifications' => $request->input('offer_notifications'),
            'legal_advice' => $request->input('legal_advice'),
            'monthly_reports' => $request->input('monthly_reports'),
            'newsletters' => $request->input('newsletters'),
            'investor_commission' => $request->input('investor_commission'),
            'mipo_commission' => $request->input('mipo_commission'),
        ]);
        
        /*$planFeatures = [];
        $planFeaturesList = Plan::$planFeatures;
        foreach($request->input('plan_features') as $key=>$val){
            foreach($val as $keySub => $valSub){
                $planFeatures[] = ['plan_id' => $plan->id,'name'=> $planFeaturesList[$key],'slug'=> $key,'type'=> $keySub,'value'=> $valSub];
            }
        }
        PlanFeature::insert($planFeatures);*/

        return redirect()->route('admin.plans.index')->with('success', 'Plan added successfully.');
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
    public function edit($id)
    {
        return view('admin.plan.edit', [
            'plan' => Plan::findorfail($id),
            'userLevels' => UserLevel::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plan)
    {
        $slug = Str::slug($request->input('name'), '-');
        $plan->name = $request->input('name');
        $plan->slug = $slug;
        $plan->price = $request->input('price');
        $plan->currency = 'Gs.';
        $plan->offer_price = $request->input('offer_price');
        $plan->duration = $request->input('duration');
        $plan->sort_order = $request->input('sort_order');
        $plan->is_free_plan = $request->input('is_free_plan');
        $plan->suitable_for_account_type = $request->input('suitable_for_account_type');
        $plan->suitable_for_account_opener = $request->input('suitable_for_account_opener');
        $plan->user_level_id = $request->input('user_level_id');
        $plan->buy_sell = $request->input('buy_sell');
        $plan->basic_dashboard = $request->input('basic_dashboard');
        $plan->enterprise_dashboard = $request->input('enterprise_dashboard');
        $plan->multi_user_account = $request->input('multi_user_account');
        $plan->exportable_pdf = $request->input('exportable_pdf');
        $plan->offer_notifications = $request->input('offer_notifications');
        $plan->legal_advice = $request->input('legal_advice');
        $plan->monthly_reports = $request->input('monthly_reports');
        $plan->newsletters = $request->input('newsletters');
        $plan->investor_commission = $request->input('investor_commission');
        $plan->mipo_commission = $request->input('mipo_commission');
        $plan->is_active = $request->input('is_active');
        $plan->save();
        
        /*$planFeatures = [];
        $planFeaturesList = Plan::$planFeatures;
        foreach($request->input('plan_features') as $key=>$val){
            foreach($val as $keySub => $valSub){
                $planFeatures[] = ['plan_id' => $plan->id,'name'=> $planFeaturesList[$key],'slug'=> $key,'type'=> $keySub,'value'=> $valSub];
                $post = PlanFeature::updateOrCreate([
                    'plan_id' => $plan->id,
                    'slug'=> $key
                ], ['name'=> $planFeaturesList[$key],'type'=> $keySub,'value'=> $valSub]);
            }
        }*/

        return redirect()->route('admin.plans.index')->with('success', 'Plan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('admin.plans.index')->with('success', 'Plan deleted successfully!');
    }
}
