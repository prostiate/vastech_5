<?php

namespace App\Http\Controllers;

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
        $today              = Carbon::today()->toDateString();
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
        //dd($item);
        return view('admin.construction.offering_letter.show', compact(['header', 'item']));
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
