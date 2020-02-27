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
            $header = new bill_quantities_con([
                'tenant_id'             => $user->tenant_id,
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'budget_plan_id'        => $request->budget_plan_id,
                //'offering_letter_id'    => $request->offering_letter_id,
                'number'                => $trans_no,
                'address'               => $request->address,
                'name'                  => $request->name,
                'date'                  => $request->date,
                'is_approved'           => false,
                'grandtotal'            => $request->grandtotal,
                'status'                => 1,
            ]);
            $header->save();
            foreach ($request->product as $i => $detail) {
                $item[$i] = new bill_quantities_detail_con([
                    'tenant_id'                 => $user->tenant_id,
                    'company_id'                => $user->company_id,
                    'user_id'                   => Auth::id(),
                    'budget_plan_detail_id'     => $request->item_budget_plan_id[$i],
                    'offering_letter_detail_id' => $request->item_offering_letter_id[$i],
                    'product_id'                => $request->product[$i],
                    'unit_id'                   => $request->unit[$i],
                    'qty'                       => $request->quantity[$i],
                    'amount'                    => $request->price[$i],
                    'amounttotal'               => $request->total_price[$i],
                    //'amountsub'         => $request->subtotal[$i], //GA KEBACA KARENA BANYAKNYA subtotal TIDAK SEBANYAK working_detail
                    'status'                    => 1,
                ]);
                $header->bill_quantities_detail()->save($item[$i]);
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
        $item                               = bill_quantities_detail_con::with('offering_letter_detail', 'budget_plan_detail', 'product', 'other_unit')->where('bill_quantities_id', $id)->get();
        $grouped                            = collect($item)
            ->groupBy('offering_letter_detail_id')
            ->map(function ($item) {
                return $item
                    ->groupBy('budget_plan_detail_id')
                    ->map(function ($item) {
                        return ($item);
                    });
            });
        $grouped2                            = collect($item)
            ->groupBy('budget_plan_detail_id')
            ->map(function ($item) {
                return ($item);
            });
        $check_form_order                   = form_order_con::where('bill_quantities_id', $id)->first();

        //dd($grouped);

        return view('admin.construction.bill_quantities.show', compact(['header', 'item', 'grouped', 'check_form_order']));
    }

    public function edit($id)
    {
        $header                         = bill_quantities_con::where('budget_plan_id', $id)->first();
        $item                           = bill_quantities_detail_con::where('bill_quantities_id', $header->id)->get();
        $item_grouped                   = collect($item)
            ->groupBy('offering_letter_detail_id')
            ->map(function ($item) {
                return $item
                    ->groupBy('budget_plan_detail_id')
                    ->map(function ($item) {
                        return ($item);
                    });
            });
        $header_bp                      = budget_plan_con::find($id);
        $item_bp                        = budget_plan_detail_con::where('budget_plan_id', $id)->get();
        $unit                           = other_unit::get();
        return view('admin.construction.bill_quantities.edit', compact(['header', 'item', 'item_grouped', 'header_bp', 'item_bp', 'unit']));
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
            $header                 = bill_quantities_con::find($id);
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
