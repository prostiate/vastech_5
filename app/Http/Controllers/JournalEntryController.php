<?php

namespace App\Http\Controllers;

use App\coa;
use App\coa_detail;
use App\journal_entry;
use App\journal_entry_item;
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
}
