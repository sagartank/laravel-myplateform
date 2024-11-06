<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Rating;
use App\Models\Issuer;
use App\Models\User;
use App\Models\Offer;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax())
        {
            $this->validate($request, [
                'user_rating_by' => ['required', 'in:Buyer,Seller'],
                'sell_feedback_rate' => ['required', 'min:1'],
                'pay_issuer_rate' => ['required', 'min:1'],
                'rate_user_id' => ['required'],
                'offer_id' => ['required', 'integer'],
                'offer_slug' => ['required'],
            ],[
                'sell_feedback_rate' => __('Feedback rating is required'),
                'pay_issuer_rate' =>  __('Issuer rating is required'),
                'rate_user_id' =>  __('User is required')
            ],
        );

            DB::beginTransaction();
            try {

                $user_rating_by = $request->user_rating_by;
                
                if(Offer::where('id', $request->offer_id)->where('slug', $request->offer_slug)->count() == 0) {
                    $response = [
                        'status' => false,
                        'message' => __('record not found'),
                        'data' => []
                    ];
                    return response()->json($response);
                }

                $user = User::where('id', $request->get('rate_user_id'))->select('id', 'slug', 'name')->first();

                if($user && $request->get('sell_feedback_rate') > 0) 
                {
                    $save = new Rating();
                    $save->ratingable_type = get_class($user);
                    $save->ratingable_id = $user->id;
                    $save->rating_number = $request->get('sell_feedback_rate');
                    $save->feedback_transaction = $request->get('sell_trans_doctype');
                    $save->feedback_document = $request->get('sell_doc_doctype');
                    $save->feedback_cashing = $request->get('sell_auto_expire', 'No');
                    $save->feedback_title = 1;
                    // $save->feedback_title = $request->get('sell_title');
                    $save->feedback_description = $request->get('sell_description');
                    $save->save();
                } else {
                    $response = [
                        'status' => false,
                        'message' => __('Feedback rating field require'),
                        'data' => []
                    ];
                    return response()->json($response);
                }
        
                if($request->has('rate_issuer_id') && $request->get('pay_issuer_rate') > 0)
                {
                    $issuer = Issuer::where('id',  $request->get('rate_issuer_id'))->first();
                    if($issuer)
                    {
                        $save = new Rating();
                        $save->ratingable_type = get_class($issuer);
                        $save->ratingable_id = $issuer->id;
                        $save->rating_number = $request->get('pay_issuer_rate');
                        $save->issuers_transaction = $request->get('pay_trans_doctype');
                        $save->issuers_document = $request->get('pay_doc_doctype');
                        $save->issuers_cashing = $request->get('pay_auto_expire', 'No');
                        $save->issuers_title = 1;
                        // $save->issuers_title = $request->get('pay_title');
                        $save->issuers_description = $request->get('pay_description');
                        $save->save();
                    }
                } else {
                    $response = [
                        'status' => false,
                        'message' => __('Issuer rating field require'),
                        'data' => []
                    ];
                    return response()->json($response);
                }

                $offer_result = Offer::where('id', $request->offer_id)->first();

                if($user_rating_by == 'Buyer') {

                    /* if($offer_result->is_cashed_buyer == 'Yes') {
                        $offer_result->offer_status  = 'Completed';
                    } */
                    
                    $offer_result->is_rated_buyer = 'Yes';
                    $offer_result->save();
                    $valid = true;
                } else if($user_rating_by == 'Seller') {
                    
                    /* if($offer_result->is_cashed_seller == 'Yes') {
                        $offer_result->offer_status  = 'Completed';
                    } */
                    
                    $offer_result->is_rated_seller = 'Yes';
                    $offer_result->save();
                    $valid = true;
                }

                DB::commit();
                $response = [
                    'status' => true,
                    'message' => __('Rating added successfully'),
                    'data' => []
                ];
            } catch (\Throwable $th) {
                DB::rollBack();
                $response = [
                    'status' => false,
                    'message' => $th->getMessage() . ' Line No  :' . $th->getLine(),
                    'data' => []
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
