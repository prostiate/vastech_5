<?php

namespace App\Http\Controllers;

use App\asset;
use App\asset_detail;
use App\other_transaction;
use Illuminate\Http\Request;
use App\coa;
use App\coa_detail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Input;

class FixedAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            //return datatables()->of(Product::all())
            return datatables()->of(asset::with('coa')->get())
                /*->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                    return $button;
                })
                ->rawColumns(['action'])*/
                ->make(true);
        }

        return view('admin.asset_managements.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fixed_accounts                             = coa::where('coa_category_id', 5)->get();
        $accounts                                   = coa::all();
        $expense_accounts                           = coa::where('coa_category_id', 16)->get();
        $depreciation_accounts                      = coa::where('coa_category_id', 7)->get();
        $depreciation_accumulated_accounts          = coa::whereIn('coa_category_id', [16,17,15])->get();
        $today                                      = Carbon::today()->toDateString();
        $number                                     = asset::max('number');
        if ($number == 0)
            $number = 10000;
        $trans_no                       = $number + 1;

        return view('admin.asset_managements.create', compact('fixed_accounts', 'accounts', 'depreciation_accounts', 'depreciation_accumulated_accounts', 'expense_accounts', 'today', 'trans_no'));
    }

    public function store(Request $request)
    {
        //validasi form yang wajib di isi
        $request->validate([
            'asset_name' => 'required',
            'asset_number' => 'required',
            'asset_account' => 'required',
        ]);

        $transactions = other_transaction::create([
            'transaction_date'  => $request->get('asset_date'),
            'number'            => $request->get('asset_number'),
            'number_complete'   => 'Asset Managements #' . $request->get('asset_number'),
            'type'              => 'asset',
            'memo'              => $request->get('asset_desc'),
            'status'            => 2,
            'balance_due'       => $request->get('asset_cost'),
            'total'             => $request->get('asset_cost'),
        ]);

        //untuk mencari nomer asset
        if ($request->get('is_depreciable')) {
            $asset = new asset([
                'name' => $request->get('asset_name'),
                'number' =>  $request->get('asset_number'),
                'asset_account' => $request->get('asset_account'),
                'description' => $request->get('asset_desc'),
                'date' => $request->get('asset_date'),
                'cost' => $request->get('asset_cost'),
                'credited_account' => $request->get('asset_account_credited'),
                'isDepreciable' => 0,
            ]);
            $transactions->asset()->save($asset);

            $cd1 = new coa_detail([
                'coa_id'                    => $request->get('asset_account'),
                'date'                      => $request->get('asset_date'),
                'type'                      => 'asset',
                'number'                    => 'Asset Managements #' . $request->get('asset_number'),
                'debit'                     => $request->get('asset_cost'),
                'credit'                    => 0,
            ]);
            $transactions->coa_detail()->save($cd1);
            
            $cd2 = new coa_detail([
                'coa_id'                    => $request->get('asset_account_credited'),
                'date'                      => $request->get('asset_date'),
                'type'                      => 'asset',
                'number'                    => 'Asset Managements #' . $request->get('asset_number'),
                'debit'                     => 0,
                'credit'                    => $request->get('asset_cost'),
            ]);
            $transactions->coa_detail()->save($cd2);

            $get_current_balance_on_coa = coa::find($request->get('asset_account'));
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'       => $get_current_balance_on_coa->balance - $request->get('asset_cost'),
            ]);
            
            $get_current_balance_on_coa = coa::find($request->get('asset_account_credited'));
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'       => $get_current_balance_on_coa->balance + $request->get('asset_cost'),
            ]);

        } else {
            $asset = new asset([
                'name' => $request->get('asset_name'),
                'number' =>  $request->get('asset_number'),
                'asset_account' => $request->get('asset_account'),
                'description' => $request->get('asset_desc'),
                'date' => $request->get('asset_date'),
                'cost' => $request->get('asset_cost'),
                'credited_account' => $request->get('asset_account_credited'),
                'isDepreciable' => 1,
            ]);
            
            $depreciate = new asset_detail([
                'method' => $request->get('depreciate_method'),
                'life' =>  $request->get('depreciate_life'),
                'rate' => $request->get('depreciate_rate'),
                'depreciate_account' => $request->get('depreciate_account'),
                'accumulated_depreciate_account' => $request->get('depreciate_accumulated_account'),
                'accumulated_depreciate' => $request->get('depreciate_accumulated'),
                'date' => $request->get('depreciate_date'),
            ]);

            $transactions->asset()->save($asset);;
            $asset->asset_detail()->save($depreciate);

            $cd1 = new coa_detail([
                'coa_id'                    => $request->get('asset_account'),
                'date'                      => $request->get('asset_date'),
                'type'                      => 'asset',
                'number'                    => 'Asset Managements #' . $request->get('asset_number'),
                'debit'                     => $request->get('asset_cost'),
                'credit'                    => 0,
            ]);
            $transactions->coa_detail()->save($cd1);
            
            $cd2 = new coa_detail([
                'coa_id'                    => $request->get('asset_account_credited'),
                'date'                      => $request->get('asset_date'),
                'type'                      => 'asset',
                'number'                    => 'Asset Managements #' . $request->get('asset_number'),
                'debit'                     => 0,
                'credit'                    => $request->get('asset_cost'),
            ]);
            $transactions->coa_detail()->save($cd2);

            $get_current_balance_on_coa = coa::find($request->get('asset_account'));
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'       => $get_current_balance_on_coa->balance - $request->get('asset_cost'),
            ]);
            
            $get_current_balance_on_coa = coa::find($request->get('asset_account_credited'));
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'       => $get_current_balance_on_coa->balance + $request->get('asset_cost'),
            ]);
        };



        return response()->json(['success' => 'Data is successfully added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fixed_asset  $fixed_asset
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assets = asset::find($id);

        if($assets->isDepreciable == 1){
            $detail = asset_detail::where('asset_id',$id)->first();
        }else{
            $detail = null;
        }
        return view('admin.asset_managements.show', compact('assets','detail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fixed_asset  $fixed_asset
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asset                                      = asset::find($id);

        if ($asset->isDepreciable == 1) {
            $detail                                 = asset_detail::where('asset_id', $id)->first();
        } else {
            $detail                                 = null;
        }

        $fixed_accounts                             = coa::where('coa_category_id', 5)->get();
        $accounts                                   = coa::all();
        $expense_accounts                           = coa::where('coa_category_id', 16)->get();
        $depreciation_accounts                      = coa::where('coa_category_id', 7)->get();
        $depreciation_accumulated_accounts          = coa::whereIn('coa_category_id', [16,17,15])->get();
        $today                                      = Carbon::today();

        $number                                      = asset::max('number');

        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;

        return view('admin.asset_managements.edit', compact('asset', 'detail', 'fixed_accounts', 'accounts', 'depreciation_accounts', 'depreciation_accumulated_accounts', 'expense_accounts', 'today', 'trans_no'));
    }
    /*
    public function edit()
    {
        return view('admin.asset_managements.edit');
    }
    */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fixed_asset  $fixed_asset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //validasi form yang wajib di isi
        $request->validate([
            'asset_name' => 'required',
            'asset_number' => 'required',
            'asset_account' => 'required',
        ]);

        $id = $request->hidden_id;
        //untuk mencari nomer asset
        if ($request->get('is_depreciable')) {
            $asset = asset::find($id)->update([
                'name' => $request->get('asset_name'),
                'number' =>  $request->get('asset_number'),
                'asset_account' => $request->get('asset_account'),
                'description' => $request->get('asset_desc'),
                'date' => $request->get('asset_date'),
                'cost' => $request->get('asset_cost'),
                'credited_account' => $request->get('asset_account_credited'),
                'isDepreciable' => 0,
            ]);

        } else {
            $asset = asset::find($id)->update([
                'name' => $request->get('asset_name'),
                'number' =>  $request->get('asset_number'),
                'asset_account' => $request->get('asset_account'),
                'description' => $request->get('asset_desc'),
                'date' => $request->get('asset_date'),
                'cost' => $request->get('asset_cost'),
                'credited_account' => $request->get('asset_account_credited'),
                'isDepreciable' => 1,
            ]);            
            
            $depreciate = asset_detail::where('asset_id',$id)->updateOrCreate([
                'asset_id' => $id,
                'method' => $request->get('depreciate_method'),
                'life' =>  $request->get('depreciate_life'),
                'rate' => $request->get('depreciate_rate'),
                'depreciate_account' => $request->get('depreciate_account'),
                'accumulated_depreciate_account' => $request->get('depreciate_accumulated_account'),
                'accumulated_depreciate' => $request->get('depreciate_accumulated'),
                'date' => $request->get('depreciate_date'),
            ]);
        };

        return response()->json(['success' => 'Data is successfully added']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fixed_asset  $fixed_asset
     * @return \Illuminate\Http\Response
     */
    public function destroy(fixed_asset $fixed_asset)
    {
        //
    }
}
