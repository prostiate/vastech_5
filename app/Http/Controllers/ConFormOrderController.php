<?php

namespace App\Http\Controllers;

use App\bill_quantities_con;
use App\bill_quantities_detail_con;
use App\budget_plan_con;
use App\budget_plan_detail_con;
use App\other_tax;
use Illuminate\Http\Request;
use Validator;
use App\coa;
use App\form_order_con;
use App\form_order_detail_con;
use App\offering_letter_con;
use App\offering_letter_detail_con;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;

class ConFormOrderController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(form_order_con::where('id', '>', 0)->get())
                /*->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                    return $button;
                })
                ->rawColumns(['action'])*/
                ->make(true);
        }

        return view('admin.construction.form_order.index');
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

        $header_bp                      = budget_plan_con::find($header_bq->budget_plan_id)->get();
        $item_bp                        = budget_plan_detail_con::where('budget_plan_id', $header_bq->budget_plan_id)->get();

        $header_ol                      = 1;
        $item_ol                        = 2;

        $grouped                        = collect($item_bp)
            ->groupBy('offering_letter_detail_id')
            ->map(function ($item) {
                return ($item);
            });
        //$item_ol_page                   = offering_letter_detail_con::where('offering_letter_id', $ol)->simplePaginate(1);
        return view('admin.construction.form_order.create', compact(['today', 'trans_no', 'header_bq', 'item_bq', 'header_bp', 'item_bp', 'header_ol', 'item_ol', 'grouped']));
    }

    public function store(Request $request)
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
            $header = new form_order_con([
                'tenant_id'             => $user->tenant_id,
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'bill_quantities_id'    => $request->bill_quantities_id,
                'number'                => $trans_no,
                'address'               => $request->address,
                'name'                  => $request->name,
                'date'                  => $request->date,
                'is_approved'           => false,
                'grandtotal'            => $request->grandtotal,
                'status'                => 1,
            ]);
            $header->save();

            foreach ($request->budget_plan_detail_id as $i => $detail) {
                // INI FUNGSINYA BUAT NGECEK SUBTOTAL GABOLE LEBIH DI SETIAP WORKING DESCRIPTION
                //if ($request->subtotal[$i] > $request->offering_letter_detail_price[$j]) {
                //    DB::rollBack();
                //    return response()->json(['errors' => 'Sub total cannot be more than the price that already assigned.']);
                //}
                $item[$i] = new form_order_detail_con([
                    'tenant_id'                     => $user->tenant_id,
                    'company_id'                    => $user->company_id,
                    'user_id'                       => Auth::id(),
                    'budget_plan_detail_id'         => $request->budget_plan_detail_id[$i],
                    'status'                        => 1,
                    //'progress_lateness_in_month' => 0,
                    //'amount'                        => $request->price[$i],
                    //'amountsub'         => $request->subtotal[$i], //GA KEBACA KARENA BANYAKNYA subtotal TIDAK SEBANYAK working_detail
                ]);
                $header->form_order_detail()->save($item[$i]);
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
        $header                             = form_order_con::find($id);
        $item                               = form_order_detail_con::with('budget_plan_detail')->where('form_order_id', $id)->get();
        $grouped                            = collect($item)
            ->groupBy('budget_plan_detail.offering_letter_detail_id')
            ->map(function ($item) {
                return ($item);
            });
        $check_progress                     = form_order_con::where('bill_quantities_id', $id)->first();

        //dd($grouped);

        return view('admin.construction.form_order.show', compact(['header', 'item', 'grouped', 'check_progress']));
    }

    public function edit($id)
    {
        $header                             = form_order_con::where('bill_quantities_id', $id)->first();
        $item                               = form_order_detail_con::with('budget_plan_detail')->where('form_order_id', $header->id)->get();
        $grouped                            = collect($item)
            ->groupBy('budget_plan_detail.offering_letter_detail_id')
            ->map(function ($item) {
                return ($item);
            });
        return view('admin.construction.form_order.edit', compact(['header', 'item', 'grouped']));
    }

    public function update(Request $request)
    {
        $user                           = User::find(Auth::id());
        $rules = array(
            'name'                      => 'required',
            'date'                      => 'required',
            'address'                   => 'required',
            'product.*'                 => 'required',
            'unit.*'                    => 'required',
            'quantity.*'                => 'required',
            'price_display.*'           => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        //CEK JIKA ADA SUBTOTAL YANG MELEBIHI OFFERING LETTER
        foreach ($request->subtotal as $j => $subtotal) {
            if ($subtotal > $request->budget_plan_detail_price[$j]) {
                return response()->json(['errors' => 'Sub total cannot be more than the price that already assigned.']);
            }
        }

        DB::beginTransaction();
        try {
            $id                                     = $request->hidden_id;
            bill_quantities_detail_con::where('bill_quantities_id', $id)->delete();
            foreach ($request->product2 as $i => $detail) {
                $item[$i] = new bill_quantities_detail_con([
                    'tenant_id'                 => $user->tenant_id,
                    'company_id'                => $user->company_id,
                    'user_id'                   => Auth::id(),
                    'bill_quantities_id'        => $id,
                    'budget_plan_detail_id'     => $request->item_budget_plan_id[$i],
                    'offering_letter_detail_id' => $request->item_offering_letter_id[$i],
                    'product_id'                => $request->product2[$i],
                    'unit_id'                   => $request->unit[$i],
                    'qty'                       => $request->quantity[$i],
                    'amount'                    => $request->price[$i],
                    'amounttotal'               => $request->total_price[$i],
                    //'amountsub'         => $request->subtotal[$i], //GA KEBACA KARENA BANYAKNYA subtotal TIDAK SEBANYAK working_detail
                    'status'                    => 1,
                ]);
                $item[$i]->save();
            }

            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $header                 = form_order_con::find($id);
            $id_budget_plan         = $header->budget_plan_id;
            bill_quantities_detail_con::where('bill_quantities_id', $id)->delete();
            $header->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted', 'id' => $id_budget_plan]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function approval($id)
    {
        DB::beginTransaction();
        try {
            $header                             = bill_quantities_con::find($id);
            $header->update(['is_approved' => 1]);
            DB::commit();
            return response()->json(['success' => 'Data is successfully approved', 'id' => $header->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }
}
