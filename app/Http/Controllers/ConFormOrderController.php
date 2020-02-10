<?php

namespace App\Http\Controllers;

use App\bill_quantities_con;
use App\bill_quantities_detail_con;
use App\other_tax;
use Illuminate\Http\Request;
use Validator;
use App\coa;
use App\form_order_con;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;

class ConFormOrderController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(other_tax::with('coa_sell', 'coa_buy')->where('id', '>', 0)->get())
                /*->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                    return $button;
                })
                ->rawColumns(['action'])*/
                ->make(true);
        }

        return view('admin.other.taxes.index');
    }

    public function create($bq)
    {
        $user                           = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number                     = form_order_con::latest()->first();
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
            $number                     = form_order_con::max('number');
            if ($number == 0)
                $number                 = 10000;
            $trans_no                   = $number + 1;
        }
        $today                          = Carbon::today()->toDateString();
        $header_bq                      = bill_quantities_con::find($bq);
        $item_bq                        = bill_quantities_detail_con::where('bill_quantities_id', $bq)->get();
        //$item_ol_page                   = offering_letter_detail_con::where('offering_letter_id', $ol)->simplePaginate(1);
        return view('admin.construction.form_order.create', compact(['today', 'trans_no', 'header_bq', 'item_bq']));
    }

    public function store(Request $request)
    {
        $user                           = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number                     = bill_quantities_con::latest()->first();
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
            $number                     = bill_quantities_con::max('number');
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
            $header = new bill_quantities_con([
                'tenant_id'             => $user->tenant_id,
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'budget_plan_id'        => $request->budget_plan_id,
                'number'                => $trans_no,
                //'address'               => $request->address,
                'name'                  => $request->name,
                'date'                  => $request->date,
                'grandtotal'            => $request->grandtotal,
                'status'                => 1,
            ]);
            $header->save();
            foreach ($request->budget_plan_detail_id as $j => $ol_detail) {
                foreach ($request->product as $i => $detail) {
                    // INI FUNGSINYA BUAT NGECEK SUBTOTAL GABOLE LEBIH DI SETIAP WORKING DESCRIPTION
                    //if ($request->subtotal[$i] > $request->offering_letter_detail_price[$j]) {
                    //    DB::rollBack();
                    //    return response()->json(['errors' => 'Sub total cannot be more than the price that already assigned.']);
                    //}
                    $item[$i] = new bill_quantities_detail_con([
                        'tenant_id'         => $user->tenant_id,
                        'company_id'        => $user->company_id,
                        'user_id'           => Auth::id(),
                        'budget_plan_detail_id'           => $request->budget_plan_detail_id[$j],
                        'product_id'        => $request->product[$i],
                        'unit_id'           => $request->unit[$i],
                        'qty'               => $request->quantity[$i],
                        'amount'            => $request->price[$i],
                        //'amountsub'         => $request->subtotal[$i], //GA KEBACA KARENA BANYAKNYA subtotal TIDAK SEBANYAK working_detail
                        'status'            => 1,
                    ]);
                    $header->bill_quantities_detail()->save($item[$i]);
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
        $header                             = bill_quantities_con::find($id);
        $item                               = bill_quantities_detail_con::with('budget_plan_detail', 'product', 'other_unit')->where('bill_quantities_id', $id)->get();
        return view('admin.construction.bill_quantities.show', compact(['header', 'item']));
    }

    public function edit($id)
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
