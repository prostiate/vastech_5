<?php

namespace App\Http\Controllers;

use App\Model\construction\bill_quantities_con;
use App\Model\construction\budget_plan_con;
use App\Model\construction\budget_plan_detail_con;
use App\Model\other\other_tax;
use Illuminate\Http\Request;
use Validator;
use App\Model\coa\coa;
use App\Model\construction\budget_plan_area_con;
use App\Model\construction\offering_letter_con;
use App\Model\construction\offering_letter_detail_con;
use App\Model\construction\project_con;
use App\Model\other\other_unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;

class ConBudgetPlanController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(budget_plan_con::with('project')->get())
                /*->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                    return $button;
                })
                ->rawColumns(['action'])*/
                ->make(true);
        }
        //dd(budget_plan_con::with('project')->get());
        return view('admin.construction.budget_plan.index');
    }

    public function createArea($id)
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
        $header_project                 = project_con::find($id);
        //$item_ol_page                   = offering_letter_detail_con::where('offering_letter_id', $ol)->simplePaginate(1);
        return view('admin.construction.budget_plan.createArea', compact(['today', 'trans_no', 'header_project']));
    }

    public function create($id)
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
        $header_area                    = budget_plan_area_con::find($id);
        $unit                           = other_unit::get();
        $get_area                       = budget_plan_area_con::where('budget_plan_id', $header_area->budget_plan_id)->get();
        $header_detail                  = budget_plan_detail_con::where('budget_plan_area_id', $id)->get();
        //$item_ol_page                   = offering_letter_detail_con::where('offering_letter_id', $ol)->simplePaginate(1);
        return view('admin.construction.budget_plan.create', compact(['today', 'trans_no', 'header_area', 'header_detail', 'get_area', 'unit']));
    }

    public function storeArea(Request $request)
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
            'date'                      => 'required',
            'address'                   => 'required',
            'name.*'                    => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        DB::beginTransaction();
        try {
            $header = new budget_plan_con([
                'tenant_id'             => $user->tenant_id,
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'project_id'            => $request->hidden_project_id,
                'number'                => $trans_no,
                'address'               => $request->address,
                'date'                  => $request->date,
                'status'                => 1,
            ]);
            $header->save();
            foreach ($request->name as $i => $detail) {
                $item[$i] = new budget_plan_area_con([
                    'tenant_id'         => $user->tenant_id,
                    'company_id'        => $user->company_id,
                    'user_id'           => Auth::id(),
                    'name'              => $request->name[$i],
                ]);
                $header->budget_plan_area()->save($item[$i]);
            }
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $header->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        $user                           = User::find(Auth::id());
        $rules = array(
            'product.*'                 => 'required',
            'unit.*'                    => 'required',
            'price.*'                   => 'required',
            'total_price.*'             => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        DB::beginTransaction();
        try {
            $id_area                    = $request->hidden_area_id;
            $get_area                   = budget_plan_area_con::findOrFail($id_area);
            $get_header                 = budget_plan_con::findOrFail($get_area->budget_plan_id);
            $get_detail                 = budget_plan_detail_con::where('budget_plan_area_id', $id_area)->get();
            if ($get_detail->count() > 0) {
                budget_plan_detail_con::where('budget_plan_area_id', $id_area)->delete();
            }
            $get_header->update([
                'grandtotal'            => $request->subtotal,
            ]);
            foreach ($request->product as $i => $detail) {
                $item[$i] = new budget_plan_detail_con([
                    'tenant_id'             => $user->tenant_id,
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'budget_plan_area_id'   => $id_area,
                    'product_id'            => $request->product2[$i],
                    'unit_id'               => $request->unit[$i],
                    'qty'                   => $request->quantity[$i],
                    'amount'                => $request->price[$i],
                    'amounttotal'           => $request->total_price[$i],
                ]);
                $item[$i]->save();
            }
            DB::commit();
            return response()->json(['success' => 'Data is successfully saved', 'id' => $id_area]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function store222222222222222222222222_BACA_COMMENT(Request $request) // INI YANG LAMA BUATAN RANGGA BENER
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
            'working_detail.*'          => 'required',
            'duration.*'                => 'required',
            'price_display.*'           => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        //CEK JIKA ADA SUBTOTAL YANG MELEBIHI OFFERING LETTER
        foreach ($request->subtotal as $j => $subtotal) {
            if ($subtotal > $request->offering_letter_detail_price[$j]) {
                return response()->json(['errors' => 'Sub total cannot be more than the price that already assigned.']);
            }
        }

        DB::beginTransaction();
        try {
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
            foreach ($request->working_detail as $i => $detail) {
                //var_dump("aku item ke- ". $j);

                //var_dump("barang ke- ".  $i);

                // INI FUNGSINYA BUAT NGECEK SUBTOTAL GABOLE LEBIH DI SETIAP WORKING DESCRIPTION
                //if ($request->subtotal[$i] > $request->offering_letter_detail_price[$j]) {
                //    DB::rollBack();
                //    return response()->json(['errors' => 'Sub total cannot be more than the price that already assigned.']);
                //}


                //var_dump("barang ke- ".  $request->working_detail[$j][$i]);
                $item[$i] = new budget_plan_detail_con([
                    'tenant_id'         => $user->tenant_id,
                    'company_id'        => $user->company_id,
                    'user_id'           => Auth::id(),
                    'offering_letter_detail_id'           => $request->offering_letter_detail_id[$i],
                    'name'              => $request->working_detail[$i],
                    'duration'          => $request->duration[$i],
                    'amount'            => $request->price[$i],
                    //'amountsub'         => $request->subtotal[$i], //GA KEBACA KARENA BANYAKNYA subtotal TIDAK SEBANYAK working_detail
                    'status'            => 1,
                ]);
                $header->budget_plan_detail()->save($item[$i]);
            }
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $header->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function showArea($id)
    {
        $header                         = budget_plan_con::with('budget_plan_area')->find($id);
        return view('admin.construction.budget_plan.showArea', compact(['header']));
    }

    public function show($id)
    {
        $header                         = budget_plan_con::with('budget_plan_detail')->find($id);
        /*$item                               = budget_plan_detail_con::with('offering_letter_detail')->where('budget_plan_id', $id)->get();
        $grouped                            = $item->groupBy('offering_letter_detail_id');
        $grouped                            = collect($item)
            ->groupBy('offering_letter_detail_id')
            ->map(function ($item) {
                return ($item);
            });
        $check_bill_quantities                  = bill_quantities_con::where('budget_plan_id', $id)->first();*/

        return view('admin.construction.budget_plan.show', compact(['header']));
    }

    public function editArea($id)
    {
        $header                         = budget_plan_con::with('budget_plan_area')->findOrFail($id);
        /*$item                           = budget_plan_detail_con::where('budget_plan_id', $header->id)->get();
        $item_grouped                   = collect($item)
            ->groupBy('offering_letter_detail_id')
            ->map(function ($item) {
                return ($item);
            });
        //dd($item);
        $header_ol                      = offering_letter_con::find($id);
        $item_ol                        = offering_letter_detail_con::where('offering_letter_id', $id)->get();*/
        return view('admin.construction.budget_plan.editArea', compact(['header']));
    }

    public function edit($id)
    {
        $header                         = budget_plan_con::where('offering_letter_id', $id)->first();
        /*$item                           = budget_plan_detail_con::where('budget_plan_id', $header->id)->get();
        $item_grouped                   = collect($item)
            ->groupBy('offering_letter_detail_id')
            ->map(function ($item) {
                return ($item);
            });
        //dd($item);
        $header_ol                      = offering_letter_con::find($id);
        $item_ol                        = offering_letter_detail_con::where('offering_letter_id', $id)->get();*/
        return view('admin.construction.budget_plan.edit', compact(['header', 'item', 'item_grouped', 'header_ol', 'item_ol']));
    }

    public function updateArea(Request $request)
    {
        $user                           = User::find(Auth::id());
        $rules = array(
            'date'                      => 'required',
            'address'                   => 'required',
            'name.*'                    => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        DB::beginTransaction();
        try {
            $id                          = $request->hidden_id;
            budget_plan_con::findOrFail($id)->update([
                'address'               => $request->address,
                'date'                  => $request->date,
            ]);
            budget_plan_area_con::where('budget_plan_id', $id)->delete();
            foreach ($request->name as $i => $detail) {
                $item[$i] = new budget_plan_area_con([
                    'tenant_id'         => $user->tenant_id,
                    'company_id'        => $user->company_id,
                    'user_id'           => Auth::id(),
                    'budget_plan_id'    => $id,
                    'name'              => $request->name[$i],
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

    public function update(Request $request)
    {
        $user                           = User::find(Auth::id());
        $rules = array(
            'name'                      => 'required',
            'date'                      => 'required',
            'address'                   => 'required',
            'working_detail.*'          => 'required',
            'duration.*'                => 'required',
            'price_display.*'           => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        //CEK JIKA ADA SUBTOTAL YANG MELEBIHI OFFERING LETTER
        foreach ($request->subtotal as $j => $subtotal) {
            if ($subtotal > $request->offering_letter_detail_price[$j]) {
                return response()->json(['errors' => 'Sub total cannot be more than the price that already assigned.']);
            }
        }

        DB::beginTransaction();
        try {
            $id                             = $request->hidden_id;
            budget_plan_con::findOrFail($id)->update([
                'address'               => $request->address,
                'name'                  => $request->name,
                'date'                  => $request->date,
            ]);
            budget_plan_detail_con::where('budget_plan_id', $id)->delete();
            foreach ($request->working_detail as $i => $detail) {
                $item[$i] = new budget_plan_detail_con([
                    'tenant_id'         => $user->tenant_id,
                    'company_id'        => $user->company_id,
                    'user_id'           => Auth::id(),
                    'budget_plan_id'    => $id,
                    'offering_letter_detail_id'           => $request->offering_letter_detail_id[$i],
                    'name'              => $request->working_detail[$i],
                    'duration'          => $request->duration[$i],
                    'amount'            => $request->price[$i],
                    //'amountsub'         => $request->subtotal[$i], //GA KEBACA KARENA BANYAKNYA subtotal TIDAK SEBANYAK working_detail
                    'status'            => 1,
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

    public function destroyArea($id)
    {
        DB::beginTransaction();
        try {
            $header                 = budget_plan_area_con::find($id);
            $id_bp                  = $header->budget_plan_id;
            $header->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted', 'id' => $id_bp]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $header                 = budget_plan_con::find($id);
            $id_offering_letter     = $header->offering_letter_id;
            budget_plan_detail_con::where('budget_plan_id', $id)->delete();
            $header->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted', 'id' => $id_offering_letter]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function approval($id)
    {
        DB::beginTransaction();
        try {
            $header                             = budget_plan_con::find($id);
            $header->update(['is_approved' => 1]);
            DB::commit();
            return response()->json(['success' => 'Data is successfully approved', 'id' => $header->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function addOrUpdateAreaName(Request $request)
    {
        $user                           = User::find(Auth::id());
        $rules = array(
            'name.*'                    => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            if (isset($request->input_id_selected_area)) {
                $id     = $request->input_id_selected_area;
                $area   = budget_plan_area_con::find($id);
                $id_bp  = $area->budget_plan_id;
                $area->update(['name' => $request->input_name_selected_area]);
                DB::commit();
                return response()->json(['success' => 'Data is successfully updated', 'id' => $id_bp]);
            } else {
                $id     = $request->input_id_budget_plan;
                $item = new budget_plan_area_con([
                    'tenant_id'         => $user->tenant_id,
                    'company_id'        => $user->company_id,
                    'user_id'           => Auth::id(),
                    'budget_plan_id'    => $id,
                    'name'              => $request->input_name_selected_area,
                ]);
                $item->save();
                DB::commit();
                return response()->json(['success' => 'Data is successfully added', 'id' => $id]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function emptyArea($id)
    {
        DB::beginTransaction();
        try {
            $header                     = budget_plan_detail_con::with('budget_plan_area')->where('budget_plan_area_id', $id)->get();
            $id_area                    = $header;
            dd($id_area);
            $header->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted', 'id' => $header->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }
}
