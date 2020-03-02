<?php

namespace App\Http\Controllers;

use App\Model\construction\budget_plan_con;
use Illuminate\Http\Request;
use Validator;
use App\Model\construction\offering_letter_con;
use App\Model\construction\offering_letter_detail_con;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;

class ConOfferingLetterController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(offering_letter_con::get())
                /*->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                    return $button;
                })
                ->rawColumns(['action'])*/
                ->make(true);
        }
        return view('admin.construction.offering_letter.index');
    }

    public function create()
    {
        $user                           = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number                     = offering_letter_con::latest()->first();
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
            $number                     = offering_letter_con::max('number');
            if ($number == 0)
                $number                 = 10000;
            $trans_no                   = $number + 1;
        }
        $today                          = Carbon::today()->toDateString();
        return view('admin.construction.offering_letter.create', compact(['today', 'trans_no']));
    }

    public function store(Request $request)
    {
        $user                           = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number                     = offering_letter_con::latest()->first();
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
            $number                     = offering_letter_con::max('number');
            if ($number == 0)
                $number                 = 10000;
            $trans_no                   = $number + 1;
        }
        $rules = array(
            'name'                      => 'required',
            'date'                      => 'required',
            'address'                   => 'required',
            'working_description.*'     => 'required',
            'specification.*'           => 'required',
            'price_display.*'           => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $header = new offering_letter_con([
                'tenant_id'             => $user->tenant_id,
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'number'                => $trans_no,
                'name'                  => $request->name,
                'date'                  => $request->date,
                'address'               => $request->address,
                'status'                => 1,
                'grandtotal'            => $request->grandtotal,
            ]);
            $header->save();
            foreach ($request->working_description as $i => $detail) {
                $item[$i] = new offering_letter_detail_con([
                    'tenant_id'         => $user->tenant_id,
                    'company_id'        => $user->company_id,
                    'user_id'           => Auth::id(),
                    'name'              => $request->working_description[$i],
                    'specification'     => $request->specification[$i],
                    'amount'            => $request->price[$i],
                    'status'            => 1,
                ]);
                $header->offering_letter_detail()->save($item[$i]);
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
        $header                             = offering_letter_con::find($id);
        $item                               = offering_letter_detail_con::with('other_status')->where('offering_letter_id', $id)->get();
        $check_budget_plan                  = budget_plan_con::where('offering_letter_id', $id)->first();
        return view('admin.construction.offering_letter.show', compact(['header', 'item', 'check_budget_plan']));
    }

    public function edit($id)
    {
        $header                             = offering_letter_con::find($id);
        $item                               = offering_letter_detail_con::with('other_status')->where('offering_letter_id', $id)->get();
        return view('admin.construction.offering_letter.edit', compact(['header', 'item']));
    }

    public function update(Request $request)
    {
        $user                           = User::find(Auth::id());
        $rules = array(
            'name'                      => 'required',
            'date'                      => 'required',
            'address'                   => 'required',
            'working_description.*'     => 'required',
            'specification.*'           => 'required',
            'price_display.*'           => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $id                         = $request->hidden_id;
            offering_letter_con::findOrFail($id)->update([
                'name'                  => $request->name,
                'date'                  => $request->date,
                'address'               => $request->address,
            ]);
            offering_letter_detail_con::where('offering_letter_id', $id)->delete();
            foreach ($request->working_description as $i => $detail) {
                offering_letter_detail_con::create([
                    'tenant_id'         => $user->tenant_id,
                    'company_id'        => $user->company_id,
                    'user_id'           => Auth::id(),
                    'offering_letter_id'           => $id,
                    'name'              => $request->working_description[$i],
                    'specification'     => $request->specification[$i],
                    'amount'            => $request->price[$i],
                    'status'            => 1,
                ]);
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
            $header = offering_letter_con::find($id);
            offering_letter_detail_con::where('offering_letter_id', $id)->delete();
            $header->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function approval($id)
    {
        DB::beginTransaction();
        try {
            $header                             = offering_letter_con::find($id);
            $header->update(['is_approved' => 1]);
            DB::commit();
            return response()->json(['success' => 'Data is successfully approved', 'id' => $header->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }
}
