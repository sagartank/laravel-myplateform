<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\OperationProgress;

class OperationProgressController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:progress_master|add-progress|edit-progress|delete-progress', ['only' => ['index','show']]);
        $this->middleware('permission:add-progress', ['only' => ['create','store']]);
        $this->middleware('permission:edit-progress', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-progress', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $progress = OperationProgress::orderBy('order_position', 'asc')->get();
        return view('admin.progress.index', ['progress' => $progress]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.progress.create');
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
            'title_en' => ['required', 'string', 'max:255', 'unique:operation_progress,title_en,NULL,id,step_type,'.$request->get('step_type')],
            'title_es' => ['required', 'string', 'max:255', 'unique:operation_progress,title_es,NULL,id,step_type,'.$request->get('step_type')],
            'step_type' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'order_position' => ['nullable', 'numeric', 'integer'],
            'manual_trigger' => ['required', 'in:Self,User,Admin,None'],
        ]);
        
        $create = OperationProgress::create($request->all());
        
        return redirect()->route('admin.progress.index')->with('success', 'Progress added successfully.');
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
    public function edit(OperationProgress $progress)
    {   
        $progress_steps = OperationProgress::where('is_active', 'Yes')->orderBy('order_position', 'asc')->get();
 
        return view('admin.progress.edit', [
            'edit' => $progress,
            'progress_steps' => $progress_steps,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OperationProgress $progress)
    {
        
        /*$exits =  OperationProgress::where('id', '!=', $progress->id)
                ->where('title','=',  $request->get('title'))
                ->where('step_type', $request->get('step_type'))->count();
        if($exits > 0 )
        {
                return redirect()->back()->with('error', 'Title Already exists.');
        }*/

        $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'title_es' => ['required', 'string', 'max:255'],
            'step_type' => ['required', 'string', 'in:Seller,Buyer'],
            'description' => ['nullable', 'string'],
            'order_position' => ['nullable', 'numeric', 'integer'],
            'manual_trigger' => ['required', 'in:Self,User,Admin,None'],
        ]);
    
        $new_array_ids = collect([]);

        $step_links_ids = $request->has('step_links') ?  ($request->get('step_links')) : [];
        
        /*  code comment  for validation  self move deals flow
        if($request->get('step_type') == "Seller" || $request->get('step_type') == "Buyer" && count($step_links_ids) > 0) {
            $progress_data = OperationProgress::orderBy('order_position', 'asc')->where('id', '!=', $progress->id)->select('id', 'step_links')->get()->pluck('step_links')->toArray();
            foreach ($progress_data as $key => $value) {
                $new_array_ids[] = json_decode($value); 
            }
            $new_array_ids = $new_array_ids->flatten()->whereNotNull()->toArray();

            $is_value_exits = array_intersect($step_links_ids, $new_array_ids);
            
            if(count($is_value_exits) > 0) {
                return redirect()->route('admin.progress.index')->with('error', 'step links alrady exsit.');
            }
        } */

        $req_param ['step_type'] = $request->get('step_type');
        $req_param ['title_en'] = $request->get('title_en');
        $req_param ['title_es'] = $request->get('title_es');
        $req_param ['description'] = $request->get('description');
        $req_param ['order_position'] = $request->get('order_position');
        $req_param ['step_links'] =  $request->has('step_links') ? ($request->get('step_links')) : null;
        $req_param ['cashed'] =  $request->get('cashed');
        $req_param ['rate'] =  $request->get('rate');
        $req_param ['file_upload'] =  $request->get('file_upload');
        $req_param ['qr_code'] =  $request->get('qr_code');
        $req_param ['payment'] =  $request->get('payment');
        $req_param ['manual_trigger'] =  $request->get('manual_trigger');
        $req_param ['mipo_commission_payment'] =  $request->get('mipo_commission_payment');
        $req_param ['is_active'] =  $request->get('is_active');

        $update = $progress::where('slug', $progress->slug)->update($req_param); 

        return redirect()->route('admin.progress.index')->with('success', 'Progress updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(OperationProgress $progress)
    {
        $progress->delete();
        return redirect()->route('admin.progress.index')->with('success', 'Progress deleted successfully!');
    }

    public function forceDelete(Request $request, $slug)
    {
        if($request->ajax())
        {
            $result = OperationProgress::withTrashed()->where('slug', $slug)->first();
            if($result)
            {
                $result->forceDelete();
                $response = [
                    'status' => true,
                    'message' => 'Progress deleted successfully',
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

    public function ajaxProgresSortableUpdate(Request $request)
    {
        if($request->ajax())
        {
            try {
                $orders = $request->order;
                $step_type = $request->step_type;
                $result_data = OperationProgress::where('step_type', $step_type)->where('is_active', 'Yes')->get();
                foreach ($result_data as $result) {
                    foreach ($orders as $order) {
                        if ($order['id'] == $result->id) {
                            $result->update(['order_position' => $order['position']]);
                        }
                    }
                }

                $response = [
                    'status' => true,
                    'message' => 'Progress sortable update successfully.',
                    'data' =>  [],
                ];

            } catch (\Throwable $th) {
                $response = [
                    'status' => false,
                    'message' => $th->getMessage() .' Line No  :'. $th->getLine(),
                    'data' => []
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }
}
