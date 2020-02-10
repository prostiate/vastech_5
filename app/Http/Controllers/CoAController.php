<?php

namespace App\Http\Controllers;

use App\coa;
use Illuminate\Http\Request;
use App\coa_category;
use App\tax;
use App\coa_detail;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;

class CoAController extends Controller
{

    public function index()
    {
        $coa            = coa::orderBy('code', 'asc')->get();
        $coa_detail     = coa_detail::selectRaw('SUM(debit) as debit, SUM(credit) as credit, coa_id')->groupBy('coa_id')->get();
        $coa_all        = count(coa::all());;
        /*$coa_detail     = coa_detail::where('coa_id', $id)->get();
        $debit          = coa_detail::where('coa_id', $id)->sum('debit');
        $credit         = coa_detail::where('coa_id', $id)->sum('credit');
        $total          = $debit + $credit;
        for ($i = 1; $i <= $coa_all; $i++) {
            $coa_credit[$i]     = coa_detail::where('coa_id', $i)->sum('credit');
            $coa_debit[$i]      = coa_detail::where('coa_id', $i)->sum('debit');
            $coa_balance[$i]    = $coa_debit[$i] - $coa_credit[$i];
        };
        if (request()->ajax()) {
            return datatables()->of(coa::with('coa_category')->get())
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }*/

        return view('admin.accounts.index', compact(['coa', 'coa_detail']));
    }

    public function create()
    {
        $coac   = coa_category::all();
        $taxes  = tax::all();
        $coa    = coa::get();

        return view('admin.accounts.create', compact(['coa', 'coac', 'taxes']));
    }
    
    public function store(Request $request)
    {
        $user               = User::find(Auth::id());
        $rules                  = array(
            'code'              => 'required',
            'name'              => 'required',
            'coa_category_id'   => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            if($request->get('parent') == 1){
                $parent             = 1;
                $parent_account     = null;
            }else{
                $parent             = 0;
                $parent_account     = $request->get('parent_account');
            }
            if($request->get('coa_category_id') == 3){
                $cashbank           = 1;
            }else{
                $cashbank           = null;
            }
            $accounts               = new coa([
                'company_id'        => $user->company_id,
                'user_id'           => Auth::id(),
                'code'              => $request->get('code'),
                'is_parent'         => $parent,
                'parent_id'         => $parent_account,
                'name'              => $request->get('name'),
                'coa_category_id'   => $request->get('coa_category_id'),
                'cashbank'          => $cashbank,
                'default_tax'       => $request->get('default_tax'),
                'balance'           => $request->get('balance'),
            ]);
            $accounts->save();
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $accounts->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $coa            = coa::find($id);
        $coa_detail     = coa_detail::where('coa_id', $id)->orderBy('date')->get();
        /*$debit          = coa_detail::where('coa_id', $id)->sum('debit');
        $credit         = coa_detail::where('coa_id', $id)->sum('credit');
        $total          = $debit + $credit;
        $coa_detail_id  = coa_detail::where('coa_id', $id)->first();
        $test_pisah     = explode('#', $coa_detail_id->number);

        $contah         = coa_detail::where('coa_id', $id)->get();
        foreach ($contah as $i => $c) {
            $replace1[$i]       = str_replace(' ', '_', $c->type);
            $model_name[$i]     = "'App\'" . $replace1[$i];
            $explo2[$i]         = explode("'", $model_name[$i]);
            $array_explo2[$i]   = array($explo2[$i][1], $explo2[$i][2]);
            $implo2[$i]         = implode('', $array_explo2[$i]);
            $lala[$i]           = $implo2[$i]::get();
            $panggilother[$i]   = other_transaction::where('id', $lala[$i][0]->other_transaction_id)->get();
            $po[$i]             = purchase_order::where('other_transaction_id', $panggilother[$i][0]->id)->get();
            $pd[$i]             = purchase_delivery::where('other_transaction_id', $panggilother[$i][0]->id)->get();
            $pi[$i]             = purchase_invoice::where('other_transaction_id', $panggilother[$i][0]->id)->get();
            $pp[$i]             = purchase_payment::where('other_transaction_id', $panggilother[$i][0]->id)->get();
            $so[$i]             = sale_order::where('other_transaction_id', $panggilother[$i][0]->id)->get();
            $sd[$i]             = sale_delivery::where('other_transaction_id', $panggilother[$i][0]->id)->get();
            $si[$i]             = sale_invoice::where('other_transaction_id', $panggilother[$i][0]->id)->get();
            $sp[$i]             = sale_payment::where('other_transaction_id', $panggilother[$i][0]->id)->get();
        }*/
        //dd($pi);
        /*if (!$coa->cashbank == 1) {
            return view('admin.accounts.showCashbank', compact(['coa', 'coa_detail']));
        } else {*/
            if (request()->ajax()) {
                return datatables()->of(coa_detail::where('coa_id', $id)->orderBy('date')->get())
                    ->addColumn('action', function ($data) {
                        $button = '<button type="button" name="edit" id="' . $data->id . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('admin.accounts.show', compact(['coa', 'coa_detail']));
        /*}*/
    }

    public function edit($id)
    {
        $coac   = coa_category::all();
        $taxes  = tax::all();
        $coa    = coa::get();
        $coa_curr = coa::find($id);

        return view('admin.accounts.edit', compact(['coa', 'coa_curr', 'coac', 'taxes']));
    }

    public function update(Request $request)
    {
        $rules = array(
            'code'      => 'required',
            'name'      => 'required',
            'coa_category_id'   => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            if($request->get('parent') == 1){
                $parent             = 1;
                $parent_account     = null;
            }else{
                $parent             = 0;
                $parent_account     = $request->get('parent_account');
            }
            if($request->get('coa_category_id') == 3){
                $cashbank           = 1;
            }else{
                $cashbank           = null;
            }
            $form_data = array(
                'code'              => $request->get('code'),
                'is_parent'         => $parent,
                'parent_id'         => $parent_account,
                'name'              => $request->get('name'),
                'coa_category_id'   => $request->get('coa_category_id'),
                'cashbank'          => $cashbank,
                'default_tax'       => $request->get('default_tax'),
                'balance'           => $request->get('balance'),
            );
            coa::find($request->hidden_id)->update($form_data);
            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $request->hidden_id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = coa::findOrFail($id);
            $data->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }
}
