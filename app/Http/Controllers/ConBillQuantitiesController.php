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
use App\other_unit;
use App\product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class ConBillQuantitiesController extends Controller
{
    public function select_product()
    {
        if (request()->ajax()) {
            $page = Input::get('page');
            $resultCount = 10;

            $offset = ($page - 1) * $resultCount;

            $breeds = product::where('name', 'LIKE',  '%' . Input::get("term") . '%')->orWhere('code', 'LIKE',  '%' . Input::get("term") . '%')
                ->where('is_buy', 1)
                //->where('is_bundle', 0)
                ->orderBy('name')
                ->skip($offset)
                ->take($resultCount)
                ->get(['id', DB::raw('name as text'), 'code', 'other_unit_id']);

            $count = product::where('is_buy', 1)->count();
            $endCount = $offset + $resultCount;
            $morePages = $endCount > $count;

            $results = array(
                "results" => $breeds,
                "pagination" => array(
                    "more" => $morePages,
                ),
                "total_count" => $count,
            );

            return response()->json($results);
        }
    }

    public function index()
    {
            if (request()->ajax()) {
                return datatables()->of(bill_quantities_con::get())
                    /*->addColumn('action', function ($data) {
                        $button = '<button type="button" name="edit" id="' . $data->id . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])*/
                    ->make(true);
            };
            return view('admin.construction.bill_quantities.index');
        
    }

    public function create($bp)
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
        $today                          = Carbon::today()->toDateString();
        $header_bp                      = budget_plan_con::find($bp);
        $item_bp                        = budget_plan_detail_con::where('budget_plan_id', $bp)->get();
        $unit                           = other_unit::get();
        //$item_ol_page                   = offering_letter_detail_con::where('offering_letter_id', $ol)->simplePaginate(1);
        return view('admin.construction.bill_quantities.create', compact(['today', 'trans_no', 'header_bp', 'item_bp', 'unit']));
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
