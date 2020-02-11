<?php

namespace App\Http\Controllers;

use App\coa;
use App\coa_detail;
use App\journal_entry;
use App\journal_entry_item;
use App\journal_opening_balance;
use App\journal_opening_balance_item;
use App\opening_balance;
use App\opening_balance_detail;
use App\other_transaction;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class JournalEntryController extends Controller
{

    public function index()
    {
        return view('admin.accounts.index');
    }

    public function create()
    {
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = journal_entry::latest()->first();
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
            $number             = journal_entry::max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }
        $today  = Carbon::today()->toDateString();
        $coa    = coa::get();
        return view('admin.journal_entries.create', compact(['today', 'trans_no', 'coa']));
    }

    public function store(Request $request)
    {
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = journal_entry::latest()->first();
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
            $number             = journal_entry::max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }
        $rules = array(
            'account'           => 'required|array|min:1',
            'account.*'         => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        DB::beginTransaction();
        try {
            $transactions                       = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'transaction_date'              => $request->get('trans_date'),
                'number'                        => $trans_no,
                'number_complete'               => 'Journal Entry #' . $trans_no,
                'type'                          => 'journal entry',
                'memo'                          => $request->get('memo'),
                'status'                        => 2,
                'balance_due'                   => 0,
                'total'                         => 0,
            ]);
            $transactions->save();

            $header                             = journal_entry::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'memo'                          => $request->memo,
                'transaction_date'              => $request->trans_date,
                'other_transaction_id'          => $transactions->id,
                'status'                        => 2,
                'total_debit'                   => $request->total_debit,
                'total_credit'                  => $request->total_credit,
            ]);
            $header->save();
            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $header->id,
            ]);

            foreach ($request->account as $key => $item_name) {
                if ($request->debit[$key] != 0 && $request->credit[$key] != 0) {
                    return response()->json(['errors' => 'Debit value and Credit value may not be filled together, one of which must be filled.']);
                } else if ($request->debit[$key] == 0 && $request->credit[$key] == 0) {
                    return response()->json(['errors' => 'Debit value or Credit value must be more than zero.']);
                }
                if ($request->total_debit != $request->total_credit) {
                    return response()->json(['errors' => 'Transaction is not balanced. Debit value must be equal to Credit value.']);
                }
                $item[$key]                     = new journal_entry_item([
                    'coa_id'                    => $request->account[$key],
                    'desc'                      => $request->desc[$key],
                    'debit'                     => $request->debit[$key],
                    'credit'                    => $request->credit[$key],
                ]);
                $header->journal_entry_item()->save($item[$key]);
                if ($request->debit[$key] == 0) {
                    coa_detail::create([
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'                        => $request->account[$key],
                        'date'                          => $request->trans_date,
                        'type'                          => 'journal entry',
                        'number'                        => 'Journal Entry #' . $trans_no,
                        'debit'                         => 0,
                        'credit'                        => $request->credit[$key],
                    ]);
                } else if ($request->credit[$key] == 0) {
                    coa_detail::create([
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'                        => $request->account[$key],
                        'date'                          => $request->trans_date,
                        'type'                          => 'journal entry',
                        'number'                        => 'Journal Entry #' . $trans_no,
                        'debit'                         => $request->debit[$key],
                        'credit'                        => 0,
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $header->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $je                 = journal_entry::find($id);
        $je_item            = journal_entry_item::where('journal_entry_id', $id)->get();
        return view('admin.journal_entries.show', compact(['je', 'je_item']));
    }

    public function edit()
    {
        $number = journal_entry::latest()->first();
        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;
        $today  = Carbon::today()->toDateString();
        $coa    = coa::get();
        return view('admin.journal_entries.edit', compact(['today', 'trans_no', 'coa']));
    }


    public function update(Request $request)
    { }


    public function destroy($id)
    { }

    public function setup()
    {
        $now            = new Carbon('first day of this year');
        $ob             = opening_balance::where('status', 'draft')->first(); //nanti ditambah company_id 

        return view('admin.accounts.setup', compact(['now', 'ob']));
    }

    public function setup_store(Request $request)
    {
        $user               = User::find(Auth::id());
        $date               = $request->date;
        $carbon             = Carbon::parse($date);

        $rules = array(
            'date'           => 'required'
        );

        $error = Validator::make($request->all(), $rules);
        // CHECK IF INPUT VALIDATED
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        DB::beginTransaction();
        try {
            $header                     = opening_balance::updateOrCreate(
                [
                    'company_id'                    => $user->company_id,
                    'user_id'                       => Auth::id(),
                ],
                [
                    'opening_date'                  => $carbon,
                    'status'                        => 'Draft'
                ]
            );

            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $header->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function edit_balance($id)
    {
        $ob     = opening_balance::whereId($id)->with('opening_balance_detail')->first();
        $obd    = opening_balance_detail::where('opening_balance_id', $ob->id)->get();
        $coas   = coa::get();

        return view('admin.accounts.balance', compact(['coas', 'ob', 'obd']));
    }

    public function update_balance_drafted(Request $request)
    {
        $id                 = $request->hidden_id;
        $user               = User::find(Auth::id());
        $coas               = coa::get();
        $date               = $request->date;
        $carbon             = Carbon::parse($date);
        $balance            = $request->total_debit + $request->total_credit;
        DB::beginTransaction();

        //dd($request);
        try {
            foreach ($request->coa_id as $i => $coa) {
                if ($request->debit_opening_balance[$i] >= 0) {
                    opening_balance_detail::updateOrCreate(
                        [
                            'opening_balance_id'        => $id,
                            'account_id'                => $coa,
                        ],
                        [
                            'debit'                     => $request->debit_opening_balance[$i]
                        ]
                    );
                }
                if ($request->credit_opening_balance[$i] >= 0) {
                    opening_balance_detail::updateOrCreate(
                        [
                            'opening_balance_id'        => $id,
                            'account_id'                => $coa,
                        ],
                        [
                            'credit'                    => $request->credit_opening_balance[$i]
                        ]
                    );
                }
                if ($request->debit_opening_balance[$i] == 0 && $request->credit_opening_balance[$i] == 0) {
                    opening_balance_detail::where([
                        'opening_balance_id'        => $id,
                        'account_id'                => $coa
                    ])->delete();
                }
            }

            DB::commit();
            return response()->json(['success' => 'Data is successfully added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function update_balance_published(Request $request)
    {
        $id                 = $request->hidden_id;
        $user               = User::find(Auth::id());
        $coas               = coa::get();
        $date               = $request->date;
        $carbon             = Carbon::parse($date);
        $balance            = $request->total_debit + $request->total_credit;
        DB::beginTransaction();

        //dd($request);
        try {
            opening_balance::find($id)->update([
                'status'    => "Publish"
            ]);

            foreach ($request->coa_id as $i => $coa) {
                if ($request->debit_opening_balance[$i] >= 0) {
                    opening_balance_detail::updateOrCreate(
                        [
                            'opening_balance_id'        => $id,
                            'account_id'                => $coa,
                        ],
                        [
                            'debit'                     => $request->debit_opening_balance[$i]
                        ]
                    );
                }
                if ($request->credit_opening_balance[$i] >= 0) {
                    opening_balance_detail::updateOrCreate(
                        [
                            'opening_balance_id'        => $id,
                            'account_id'                => $coa,
                        ],
                        [
                            'credit'                    => $request->credit_opening_balance[$i]
                        ]
                    );
                }
                if ($request->debit_opening_balance[$i] == 0 && $request->credit_opening_balance[$i] == 0) {
                    opening_balance_detail::where([
                        'opening_balance_id'        => $id,
                        'account_id'                => $coa
                    ])->forceDelete();
                }
            }

            //dd('0');
            if ($user->company_id == 5) {
                $number             = journal_opening_balance::latest()->first();
                if ($number != null) {
                    //dd('1.2');
                    $misahm             = explode("/", $number->number);
                    $misahy             = explode(".", $misahm[0]);
                }
                if (isset($misahy[0]) == 0) {
                    //dd('1.3');
                    $misahy[0]      = 0;
                }
                $number1                    = $misahy[1] + 1;
                $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;
            } else {
                //dd('1.4');
                $number             = journal_opening_balance::max('number');
                if ($number == 0)
                    $number = 0;
                $trans_no = $number + 1;
            }
            //dd('1');

            $transactions                       = other_transaction::updateOrCreate([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'type'                          => 'Opening Balance',
                'number_complete'               => 'Opening Balance #' . $trans_no
            ], [
                'transaction_date'              => $date,
                'memo'                          => $request->get('memo'),
                'status'                        => 2,
                'balance_due'                   => $balance, //sum total debit + total credit
                'total'                         => $balance,
            ]);
            //$transactions->save();
            $header                             = journal_opening_balance::updateOrCreate([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'other_transaction_id'          => $transactions->id
            ], [
                'transaction_date'              => $date,
                'memo'                          => "Opening Balance",
                'status'                        => 2,
                'total_debit'                   => $request->total_debit,
                'total_credit'                  => $request->total_credit,
            ]);
            //$header->save();
            //dd('3');
            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $header->id,
            ]);
            //dd('4');
            foreach ($request->coa_id as $key => $coa_id) {
                if ($request->debit_opening_balance[$key] >= 0) {
                    journal_opening_balance_item::updateOrCreate([
                        'coa_id'                    => $coa_id,
                        'journal_opening_balance_id' => $header->id,
                    ], [
                        'desc'                      => $request->desc[$key],
                        'debit'                     => $request->debit_opening_balance[$key]
                    ]);
                }
                if ($request->credit_opening_balance[$key] >= 0) {
                    journal_opening_balance_item::updateOrCreate([
                        'coa_id'                    => $coa_id,
                        'journal_opening_balance_id' => $header->id,
                    ], [
                        'desc'                      => $request->desc[$key],
                        'credit'                    => $request->credit_opening_balance[$key]
                    ]);
                }
                if ($request->debit_opening_balance[$key] == 0 && $request->credit_opening_balance[$key] == 0) {
                    journal_opening_balance_item::where([
                        'coa_id'                    => $coa_id,
                        'journal_opening_balance_id' => $header->id,
                    ])->forceDelete();
                }

                //dd('5');

                if ($request->debit_opening_balance[$key] >= 0) {
                    coa_detail::updateOrCreate([
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'                        => $coa_id,
                        'type'                          => 'Opening Balance',
                        'number'                        => 'Opening Balance #' . $trans_no,
                    ], [
                        'date'                          => $date,
                        'debit'                         => $request->debit_opening_balance[$key]
                    ]);
                }
                if ($request->credit_opening_balance[$key] >= 0) {
                    coa_detail::updateOrCreate([
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'                        => $coa_id,
                        'type'                          => 'Opening Balance',
                        'number'                        => 'Opening Balance #' . $trans_no,
                    ], [
                        'date'                          => $date,
                        'credit'                        => $request->credit_opening_balance[$key],
                    ]);
                }
                if ($request->debit_opening_balance[$key] == 0 && $request->credit_opening_balance[$key] == 0) {
                    coa_detail::where([
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'type'                          => 'Opening Balance',
                        'number'                        => 'Opening Balance #' . $trans_no,
                        'coa_id'                        => $coa_id,
                    ])->forceDelete();
                };
                //dd($trans_no, $request->coa_id[$key]);
            }


            DB::commit();
            return response()->json(['success' => 'Data is successfully added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }
}
