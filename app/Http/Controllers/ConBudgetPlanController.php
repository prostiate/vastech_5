<?php

namespace App\Http\Controllers;

use App\budget_plan_con;
use App\budget_plan_detail_con;
use App\other_tax;
use Illuminate\Http\Request;
use Validator;
use App\coa;
use App\offering_letter_con;
use App\offering_letter_detail_con;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;

class ConBudgetPlanController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(budget_plan_con::get())
                /*->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                    return $button;
                })
                ->rawColumns(['action'])*/
                ->make(true);
        }
        return view('admin.construction.budget_plan.index');
    }

    public function create($ol)
    {
        $user                           = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number                     = budget_plan_con::latest()->first();
            if ($number != null) {
                $misahm                 = explode("/", $number->number);
                $misahy                 = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]              = 10000;
            }
            $number1                    = $misahy[1] + 1;
            $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;
        } else {
            $number                     = budget_plan_con::max('number');
            if ($number == 0)
                $number                 = 10000;
            $trans_no                   = $number + 1;
        }
        $today                          = Carbon::today()->toDateString();
        $header_ol                      = offering_letter_con::find($ol);
        $item_ol                        = offering_letter_detail_con::where('offering_letter_id', $ol)->get();
        //$item_ol_page                   = offering_letter_detail_con::where('offering_letter_id', $ol)->simplePaginate(1);
        return view('admin.construction.budget_plan.create', compact(['today', 'trans_no', 'header_ol', 'item_ol']));
    }

    public function store(Request $request)
    {
        $user                           = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number                     = budget_plan_con::latest()->first();
            if ($number != null) {
                $misahm                 = explode("/", $number->number);
                $misahy                 = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]              = 10000;
            }
            $number1                    = $misahy[1] + 1;
            $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;
        } else {
            $number                     = budget_plan_con::max('number');
            if ($number == 0)
                $number                 = 10000;
            $trans_no                   = $number + 1;
        }
        $rules = array(
            'name'                      => 'required',
            'date'                      => 'required',
            'address'                   => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {

            dd($request->all() );


            $header = new budget_plan_con([
                'tenant_id'             => $user->tenant_id,
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'offering_letter_id'    => $request->offering_letter_id,
                'number'                => $trans_no,
                'address'               => $request->address,
                'name'                  => $request->name,
                'date'                  => $request->date,
                'grandtotal'            => $request->grandtotal,
                'status'                => 1,
            ]);
            $header->save();           
         
            foreach ($request->offering_letter_detail_id as $j => $ol_detail) {
                //var_dump("aku item ke- ". $j);
                foreach ($request->working_detail as $i => $detail) {
                    //var_dump("barang ke- ". $i);
                    // INI FUNGSINYA BUAT NGECEK SUBTOTAL GABOLE LEBIH DI SETIAP WORKING DESCRIPTION
                    //if ($request->subtotal[$i] > $request->offering_letter_detail_price[$j]) {
                    //    DB::rollBack();
                    //    return response()->json(['errors' => 'Sub total cannot be more than the price that already assigned.']);
                    //}

                    /**
                    $item[$i] = new budget_plan_detail_con([
                        'tenant_id'         => $user->tenant_id,
                        'company_id'        => $user->company_id,
                        'user_id'           => Auth::id(),
                        'offering_letter_detail_id'           => $request->offering_letter_detail_id[$j],
                        'name'              => $request->working_detail[$i],
                        'duration'          => $request->duration[$i],
                        'amount'            => $request->price[$i],
                        //'amountsub'         => $request->subtotal[$i], //GA KEBACA KARENA BANYAKNYA subtotal TIDAK SEBANYAK working_detail
                        'status'            => 1,
                        ]);
                        $header->budget_plan_detail()->save($item[$i]);
                    }
                    
                    */
                }
                }
                
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $header->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $header                             = budget_plan_con::find($id);
        $item                               = budget_plan_detail_con::with('offering_letter_detail')->where('budget_plan_id', $id)->get();
        return view('admin.construction.budget_plan.show', compact(['header', 'item']));
    }

    public function edit()
    {
        //
    }

    public function update(Request $request)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
