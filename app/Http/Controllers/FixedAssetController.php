<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Support\Facades\DB as IlluminateDB;

use App\User;
use App\Model\asset\asset;
use App\Model\asset\asset_detail;
use App\Model\other\other_transaction;
use Illuminate\Http\Request;
use App\Model\coa\coa;
use App\Model\coa\coa_detail;
use App\Model\journal_opening_balance\journal_entry;
use App\Model\journal_opening_balance\journal_entry_item;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class FixedAssetController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(asset::with('coa')->where('status', 7)->get())
                ->make(true);
        }

        return view('admin.asset_managements.index');
    }

    public function index_disposed()
    {
        if (request()->ajax()) {
            return datatables()->of(asset::with('coa')->where('status', 8)->orWhere('status', 9)->get())
                ->make(true);
        }

        return view('admin.asset_managements.index');
    }

    public function index_depreciation()
    {
        if (request()->ajax()) { //asset::with('coa')->where('is_depreciable', 1)->get()
            return datatables()->of(asset::with(['asset_detail' => function ($asset) {
                $asset->get();
            }])->where([
                ['is_depreciable', '=', 1],
                ['is_depreciated', '=', 1]
            ])->get())
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="apply" id="' . $data->id . '" class="apply btn btn-success btn-sm">Apply</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.asset_managements.index');
    }

    public function create()
    {
        $fixed_accounts                             = coa::where('coa_category_id', 5)->get();
        $accounts                                   = coa::all();
        $expense_accounts                           = coa::where('coa_category_id', 16)->get();
        $depreciation_accounts                      = coa::where('coa_category_id', 7)->get();
        $depreciation_accumulated_accounts          = coa::whereIn('coa_category_id', [16, 17, 15])->get();
        $today                                      = Carbon::today()->toDateString();
        $user                                       = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = asset::latest()->first();
            if ($number != null) {
                $misahm             = explode("/", $number->number);
                $misahy             = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1                    = $misahy[1] + 1;
            $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;
        } else {
            $number             = asset::max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }

        return view('admin.asset_managements.create', compact(
            [
                'fixed_accounts',
                'accounts',
                'depreciation_accounts',
                'depreciation_accumulated_accounts',
                'expense_accounts',
                'today',
                'trans_no'
            ]
        ));
    }

    public function store(Request $request)
    {
        $user                           = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number_journal             = journal_entry::latest()->first();
            if ($number_journal != null) {
                $misahm_journal         = explode("/", $number_journal->number);
                $misahy_journal         = explode(".", $misahm_journal[1]);
            }
            if (isset($misahy_journal[1]) == 0) {
                $misahy_journal[1]      = 10000;
            }
            $number_journal1            = $misahy_journal[1] + 1;
            $trans_no_journal           = now()->format('m') . '/' . now()->format('y') . '.' . $number_journal1;
            // JOURNAL ENTRY
            $number_asset               = asset::latest()->first();
            if ($number_asset != null) {
                $misahm_asset           = explode("/", $number_asset->number);
                $misahy_asset           = explode(".", $misahm_asset[1]);
            }
            if (isset($misahy_asset[1]) == 0) {
                $misahy_asset[1]        = 10000;
            }
            $number_asset1              = $misahy_asset[1] + 1;
            $trans_no_asset             = now()->format('m') . '/' . now()->format('y') . '.' . $number_asset1;
        } else {
            // JOURNAL ENTRY
            $number_journal             = journal_entry::max('number');
            if ($number_journal == 0)
                $number_journal         = 10000;
            $trans_no_journal           = $number_journal + 1;
            // ASSET
            $number_asset               = asset::max('number');
            if ($number_asset == 0)
                $number_asset           = 10000;
            $trans_no_asset             = $number_asset + 1;
        }

        //validasi form yang wajib di isi
        $rules                  = array(
            'asset_name'        => 'required',
            'asset_number'      => 'required',
            'asset_account'     => 'required',
        );

        $error                  = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        IlluminateDB::beginTransaction();
        try {
            if ($request->is_depreciable) {
                $is_depreciable                     = 0;
                $is_depreciated                     = 0;
            } else {
                $is_depreciable                     = 1;
                $is_depreciated                     = 1;
            };
            // STORE IN OTHER TRASACTION
            $transactions = other_transaction::create([
                'company_id'                        => $user->company_id,
                'user_id'                           => Auth::id(),
                'transaction_date'                  => $request->get('asset_date'),
                'number'                            => $trans_no_journal,
                'number_complete'                   => 'Journal Entry #' . $trans_no_journal,
                'type'                              => 'journal entry',
                'memo'                              => $request->get('asset_desc'),
                'status'                            => 2,
                'balance_due'                       => 0,
                'total'                             => 0,
            ]);

            $transactions_asset = other_transaction::create([
                'company_id'                        => $user->company_id,
                'user_id'                           => Auth::id(),
                'transaction_date'                  => $request->get('asset_date'),
                'number'                            => $trans_no_journal,
                'number_complete'                   => 'Fixed Asset #' . $trans_no_journal,
                'type'                              => 'asset',
                'memo'                              => $request->get('asset_desc'),
                'status'                            => 2,
                'balance_due'                       => 0,
                'total'                             => 0,
            ]);

            $cd1 = new coa_detail([
                'company_id'                        => $user->company_id,
                'user_id'                           => Auth::id(),
                'coa_id'                            => $request->get('asset_account'),
                'date'                              => $request->get('asset_date'),
                'type'                              => 'journal entry',
                'number'                            => 'Journal Entry #' . $trans_no_journal,
                'debit'                             => $request->get('asset_cost'),
                'credit'                            => 0,
            ]);
            $transactions->coa_detail()->save($cd1);

            $cd2 = new coa_detail([
                'company_id'                        => $user->company_id,
                'user_id'                           => Auth::id(),
                'coa_id'                            => $request->get('asset_account_credited'),
                'date'                              => $request->get('asset_date'),
                'type'                              => 'journal entry',
                'number'                            => 'Journal Entry #' . $trans_no_journal,
                'debit'                             => 0,
                'credit'                            => $request->get('asset_cost'),
            ]);
            $transactions->coa_detail()->save($cd2);

            $je = journal_entry::create([
                'company_id'                        => $user->company_id,
                'user_id'                           => Auth::id(),
                'ref_id'                            => 0,
                'other_transaction_id'              => $transactions->id,
                'number'                            => 'Journal Entry #' . $trans_no_journal,
                'transaction_date'                  => $request->get('asset_date'),
                'status'                            => 2,
                'total_debit'                       => $request->get('asset_cost'),
                'total_credit'                      => $request->get('asset_cost'),
            ]);
            other_transaction::find($transactions->id)->update([
                'ref_id'                                => $je->id,
            ]);

            $jei1 = new journal_entry_item([
                'coa_id'                            => $request->get('asset_account'),
                'debit'                             => $request->get('asset_cost'),
            ]);
            $je->journal_entry_item()->save($jei1);

            $jei2 = new journal_entry_item([
                'coa_id'                            => $request->get('asset_account_credited'),
                'credit'                            => $request->get('asset_cost'),
            ]);
            $je->journal_entry_item()->save($jei2);

            $asset = asset::create([
                'company_id'                        => $user->company_id,
                'user_id'                           => Auth::id(),
                'journal_entry_id'                  => $je->id,
                'name'                              => $request->get('asset_name'),
                'number'                            => $trans_no_asset,
                'asset_account'                     => $request->get('asset_account'),
                'description'                       => $request->get('asset_desc'),
                'date'                              => $request->get('asset_date'),
                'cost'                              => $request->get('asset_cost'),
                'actual_cost'                       => $request->get('asset_cost'),
                'credited_account'                  => $request->get('asset_account_credited'),
                'is_depreciable'                    => $is_depreciable, // ini yang di centang apakah ini deprecate atau ga
                'is_depreciated'                    => $is_depreciated, // ini buat apply
                'status'                            => 7,
            ]);
            other_transaction::find($transactions_asset->id)->update([
                'ref_id'                                => $asset->id,
            ]);

            if ($is_depreciable == 1) {
                $depreciate = new asset_detail([
                    'method'                            => $request->get('depreciate_method'),
                    'life'                              => $request->get('depreciate_life'),
                    'rate'                              => $request->get('depreciate_rate'),
                    'depreciate_account'                => $request->get('depreciate_account'),
                    'accumulated_depreciate_account'    => $request->get('depreciate_accumulated_account'),
                    'accumulated_depreciate'            => $request->get('depreciate_accumulated'),
                    'date'                              => $request->get('depreciate_date'),
                ]);
                $asset->asset_detail()->save($depreciate);
            }

            journal_entry::find($je->id)->update([
                'ref_id'                            => $asset->id,
            ]);
            //
            IlluminateDB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $asset->id]);
        } catch (\Exception $e) {
            IlluminateDB::rollback();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $assets         = asset::find($id);
        $journals       = journal_entry::with('journal_entry_item')->where('ref_id', $assets->id)->get();

        if ($assets->is_depreciable == 1) {
            $details    = asset_detail::where('asset_id', $id)->first();
        } else {
            $details    = null;
        }

        return view('admin.asset_managements.show', compact(['assets', 'details', 'journals']));
    }

    public function apply_depreciation($id)
    {
        $user                                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number                             = journal_entry::latest()->first();
            if ($number != null) {
                $misahm                         = explode("/", $number->number);
                $misahy                         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]                      = 10000;
            }
            $number1                            = $misahy[1] + 1;
            $trans_no                           = now()->format('m') . '/' . now()->format('y') . '.' . $number1;
        } else {
            $number                             = journal_entry::max('number');
            if ($number == 0)
                $number                         = 10000;
            $trans_no                           = $number + 1;
        }
        $today                                  = Carbon::today()->toDateString();
        $asset                                  = asset::find($id);

        IlluminateDB::beginTransaction();
        try {
            $asset->update([
                'is_depreciated'                => 0,
            ]);
            $asset_detail                       = asset_detail::where('asset_id', $asset->id)->first();
            $asset_detail->update([
                'accumulated_depreciate'        => $asset_detail->accumulated_depreciate + ($asset->cost / ($asset_detail->life * 12))
            ]);

            $depreciate                         = $asset->cost / ($asset_detail->life * 12);
            $asset->actual_cost                 = $asset->actual_cost - $depreciate;
            $asset->save();

            $transactions = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'transaction_date'              => $today,
                'number'                        => $trans_no,
                'number_complete'               => 'Journal Entry #' . $trans_no,
                'type'                          => 'journal entry',
                'status'                        => 2,
                'balance_due'                   => 0,
                'total'                         => 0,
            ]);

            $cd1 = new coa_detail([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'coa_id'                        => $asset_detail->depreciate_account,
                'date'                          => $today,
                'type'                          => 'journal entry',
                'number'                        => 'Journal Entry #' . $trans_no,
                'debit'                         => $depreciate,
                'credit'                        => 0,
            ]);
            $transactions->coa_detail()->save($cd1);

            $cd2 = new coa_detail([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'coa_id'                        => $asset_detail->accumulated_depreciate_account,
                'date'                          => $today,
                'type'                          => 'journal entry',
                'number'                        => 'Journal Entry #' . $trans_no,
                'debit'                         => 0,
                'credit'                        => $depreciate,
            ]);
            $transactions->coa_detail()->save($cd2);

            $je = journal_entry::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'ref_id'                        => $asset->id,
                'other_transaction_id'          => $transactions->id,
                'number'                        => 'Journal Entry #' . $trans_no,
                'transaction_date'              => $today,
                'status'                        => 2,
                'total_debit'                   => $depreciate,
                'total_credit'                  => $depreciate,
            ]);

            $jei1 = new journal_entry_item([
                'coa_id'                        => $asset_detail->depreciate_account,
                'debit'                         => $depreciate,
            ]);
            $je->journal_entry_item()->save($jei1);

            $jei2 = new journal_entry_item([
                'coa_id'                        => $asset_detail->accumulated_depreciate_account,
                'credit'                        => $depreciate,
            ]);
            $je->journal_entry_item()->save($jei2);
            IlluminateDB::commit();
            return response()->json(['success' => 'Data is successfully applied', 'id' => $id]);
        } catch (\Exception $e) {
            IlluminateDB::rollback();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $asset                                      = asset::find($id);
        if ($asset->is_depreciable == 1) {
            $detail                                 = asset_detail::where('asset_id', $id)->first();
        } else {
            $detail                                 = null;
        }
        $fixed_accounts                             = coa::where('coa_category_id', 5)->get();
        $accounts                                   = coa::all();
        $expense_accounts                           = coa::where('coa_category_id', 16)->get();
        $depreciation_accounts                      = coa::where('coa_category_id', 7)->get();
        $depreciation_accumulated_accounts          = coa::whereIn('coa_category_id', [16, 17, 15])->get();
        $today                                      = Carbon::today()->toDateString();

        return view('admin.asset_managements.edit', compact([
            'asset',
            'detail',
            'fixed_accounts',
            'accounts',
            'depreciation_accounts',
            'depreciation_accumulated_accounts',
            'expense_accounts',
            'today',
        ]));
    }

    public function update_non_depreciable(Request $request)
    {
        $user                                       = User::find(Auth::id());
        $rules = array(
            'asset_name'                            => 'required',
            'asset_number'                          => 'required',
            'asset_account'                         => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        IlluminateDB::beginTransaction();
        try {
            $id                                     = $request->hidden_id;
            $asset                                  = asset::find($id);
            $number_complete                        = 'Journal Entry #' . $asset->number;
            asset::find($id)->update([
                'name'                              => $request->get('asset_name'),
                'asset_account'                     => $request->get('asset_account'),
                'description'                       => $request->get('asset_desc'),
                'date'                              => $request->get('asset_date'),
                'cost'                              => $request->get('asset_cost'),
                'actual_cost'                       => $request->get('asset_cost'),
                'credited_account'                  => $request->get('asset_account_credited'),
            ]);
            $transactions = other_transaction::where('type', 'journal entry')
                ->where('number', $asset->number)
                ->where('number_complete', $number_complete)->first();
            other_transaction::where('type', 'journal entry')
                ->where('number', $asset->number)
                ->where('number_complete', $number_complete)
                ->update([
                    'transaction_date'              => $request->get('asset_date'),
                    'memo'                          => $request->get('asset_desc'),
                ]);
            coa_detail::where('type', 'journal entry')
                ->where('number', $number_complete)
                ->delete();
            coa_detail::create([
                'company_id'                        => $user->company_id,
                'user_id'                           => Auth::id(),
                'other_transaction_id'              => $transactions->id,
                'coa_id'                            => $request->get('asset_account'),
                'date'                              => $request->get('asset_date'),
                'type'                              => 'journal entry',
                'number'                            => 'Journal Entry #' . $asset->number,
                'debit'                             => $request->get('asset_cost'),
                'credit'                            => 0,
            ]);

            coa_detail::create([
                'company_id'                        => $user->company_id,
                'user_id'                           => Auth::id(),
                'other_transaction_id'              => $transactions->id,
                'coa_id'                            => $request->get('asset_account_credited'),
                'date'                              => $request->get('asset_date'),
                'type'                              => 'journal entry',
                'number'                            => 'Journal Entry #' . $asset->number,
                'debit'                             => 0,
                'credit'                            => $request->get('asset_cost'),
            ]);
            $journal_entry = journal_entry::where('number', $number_complete)
                ->where('ref_id', $id)
                ->first();
            journal_entry::where('number', $number_complete)
                ->where('ref_id', $id)
                ->update([
                    'transaction_date'              => $request->get('asset_date'),
                    'total_debit'                   => $request->get('asset_cost'),
                    'total_credit'                  => $request->get('asset_cost'),
                ]);
            journal_entry_item::where('journal_entry_id', $journal_entry->id)
                ->where('credit', 'null')
                ->update([
                    'coa_id'                            => $request->get('asset_account'),
                    'debit'                             => $request->get('asset_cost'),
                ]);
            journal_entry_item::where('journal_entry_id', $journal_entry->id)
                ->where('debit', 'null')
                ->update([
                    'coa_id'                            => $request->get('asset_account_credited'),
                    'credit'                            => $request->get('asset_cost'),
                ]);
            IlluminateDB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
        } catch (\Exception $e) {
            IlluminateDB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function update_depreciable(Request $request)
    {
        $user                                       = User::find(Auth::id());
        $id                                         = $request->hidden_id;
        $asset                                      = asset::find($id);
        $number_complete                            = 'Journal Entry #' . $asset->number;
        if ($asset->is_depreciated == 1) {
            $rules = array(
                'asset_name'                            => 'required',
                'asset_number'                          => 'required',
                'asset_account'                         => 'required',
            );
        } else {
            $rules = array(
                'asset_name'                            => 'required',
            );
        }

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        IlluminateDB::beginTransaction();
        try {
            if ($asset->is_depreciated == 1) {
                asset::find($id)->update([
                    'name'                              => $request->asset_name,
                    'asset_account'                     => $request->asset_account,
                    'description'                       => $request->asset_desc,
                    'date'                              => $request->asset_date,
                    'cost'                              => $request->asset_cost,
                    'actual_cost'                       => $request->asset_cost,
                    'credited_account'                  => $request->asset_account_credited,
                ]);
                $transactions = other_transaction::where('type', 'journal entry')
                    ->where('number', $asset->number)
                    ->where('number_complete', $number_complete)->first();
                other_transaction::where('type', 'journal entry')
                    ->where('number', $asset->number)
                    ->where('number_complete', $number_complete)
                    ->update([
                        'transaction_date'              => $request->asset_date,
                        'memo'                          => $request->asset_desc,
                    ]);
                coa_detail::where('type', 'journal entry')
                    ->where('number', $number_complete)
                    ->delete();
                coa_detail::create([
                    'company_id'                        => $user->company_id,
                    'user_id'                           => Auth::id(),
                    'other_transaction_id'              => $transactions->id,
                    'coa_id'                            => $request->asset_account,
                    'date'                              => $request->asset_date,
                    'type'                              => 'journal entry',
                    'number'                            => 'Journal Entry #' . $asset->number,
                    'debit'                             => $request->asset_cost,
                    'credit'                            => 0,
                ]);

                coa_detail::create([
                    'company_id'                        => $user->company_id,
                    'user_id'                           => Auth::id(),
                    'other_transaction_id'              => $transactions->id,
                    'coa_id'                            => $request->asset_account_credited,
                    'date'                              => $request->asset_date,
                    'type'                              => 'journal entry',
                    'number'                            => 'Journal Entry #' . $asset->number,
                    'debit'                             => 0,
                    'credit'                            => $request->asset_cost,
                ]);
                $journal_entry = journal_entry::where('number', $number_complete)
                    ->where('ref_id', $id)
                    ->first();
                journal_entry::where('number', $number_complete)
                    ->where('ref_id', $id)
                    ->update([
                        'transaction_date'              => $request->asset_date,
                        'total_debit'                   => $request->asset_cost,
                        'total_credit'                  => $request->asset_cost,
                    ]);
                journal_entry_item::where('journal_entry_id', $journal_entry->id)
                    ->where('credit', null)
                    ->update([
                        'coa_id'                        => $request->asset_account,
                        'debit'                         => $request->asset_cost,
                        'credit'                        => 0,
                    ]);
                journal_entry_item::where('journal_entry_id', $journal_entry->id)
                    ->where('debit', null)
                    ->update([
                        'coa_id'                        => $request->asset_account_credited,
                        'debit'                         => 0,
                        'credit'                        => $request->asset_cost,
                    ]);
                asset_detail::where('asset_id', $id)->update([
                    'method'                            => $request->depreciate_method,
                    'life'                              => $request->depreciate_life,
                    'rate'                              => $request->depreciate_rate,
                    'depreciate_account'                => $request->depreciate_account,
                    'accumulated_depreciate_account'    => $request->depreciate_accumulated_account,
                    'accumulated_depreciate'            => $request->depreciate_accumulated,
                    'date'                              => $request->depreciate_date,
                ]);
            } else {
                asset::find($id)->update([
                    'name'                              => $request->asset_name,
                    'description'                       => $request->asset_desc,
                ]);
                other_transaction::where('type', 'journal entry')
                    ->where('number', $asset->number)
                    ->where('number_complete', $number_complete)
                    ->update([
                        'memo'                          => $request->asset_desc,
                    ]);
            }
            IlluminateDB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
        } catch (\Exception $e) {
            IlluminateDB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $user       = User::find(Auth::id());
        $cs         = company_setting::where('company_id', $user->company_id)->first();
        if ($cs->company_id == 5) {
            if(Auth::id() != 999999){
                return redirect('/dashboard');
            }
        }
        IlluminateDB::beginTransaction();
        try {
            $asset                                      = asset::find($id);
            $number_complete                            = 'Journal Entry #' . $asset->number;
            if ($asset->is_depreciable == 1) {
                $detail                                 = asset_detail::where('asset_id', $id)->first();
            } else {
                $detail                                 = null;
            }
            if ($detail) {
                // JOURNAL ENTRY
                other_transaction::where('type', 'journal entry')->where('number', $asset->number)->where('number_complete', $number_complete)->delete();
                coa_detail::where('type', 'journal entry')->where('number', $number_complete)->delete();
                journal_entry::where('number', $number_complete)->where('ref_id', $id)->delete();
                // ASSET
                other_transaction::where('type', 'asset')->where('number', $asset->number)->where('number_complete', $number_complete)->delete();
                // ASSET DETAIL
                $detail->delete();
                $asset->delete();
            } else {
                other_transaction::where('type', 'journal entry')->where('number', $asset->number)->where('number_complete', $number_complete)->delete();
                coa_detail::where('type', 'journal entry')->where('number', $number_complete)->delete();
                journal_entry::where('number', $number_complete)->where('ref_id', $id)->delete();
                // ASSET
                other_transaction::where('type', 'asset')->where('number', $asset->number)->where('number_complete', $number_complete)->delete();
                $asset->delete();
            }
            IlluminateDB::commit();
            return response()->json(['success' => 'Data is successfully deleted']);
        } catch (\Exception $e) {
            IlluminateDB::rollback();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }
}
