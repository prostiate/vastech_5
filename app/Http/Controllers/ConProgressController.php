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

class ConProgressController extends Controller
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
            'days.*'                    => 'numeric|min:0',
            'progress.*'                => 'numeric|min:0|max:100',
            'late.*'                    => 'numeric|min:0|max:100',
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
                //'address'               => $request->address,
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
                    'progress_current_in_month'     => $request->days[$i],
                    'progress_current_in_percent'   => $request->progress[$i],
                    'progress_lateness_in_percent'  => $request->late[$i],
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

        //dd($grouped);

        return view('admin.construction.form_order.show', compact(['header', 'item', 'grouped']));
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
