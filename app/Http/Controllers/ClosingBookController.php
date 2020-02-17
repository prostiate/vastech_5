<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Validator;
use App\closing_book;
use App\coa;
use App\coa_detail;
use App\journal_entry;
use App\journal_entry_item;
use App\other_transaction;
use App\User;
use App\expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClosingBookController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(closing_book::get())
                ->addColumn('action', function ($data) {
                    $select = '<select class="pilih">
                    <option value="/closing_book/setup"> Change Period </option>
                    <option value="/closing_book/' . $data->id . '/worksheet"> Worksheet </option>
                    <option value="/closing_book/delete"> Delete Draft</option>
                    </select>
                    <button type="button" class="go btn btn-danger btn-sm">Go</button>';
                    return $select;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $last_closing_book      = closing_book::orderBy('end_period', 'desc')->first();

        return view('admin.accounts.closing_book.index')->with(['closing_book' => $last_closing_book]);
    }

    public function setup()
    {
        $id                             = null;
        $ob                             = closing_book::where('status', 8)->latest()->first(); //nanti ditambah company_id
        $now                            = Carbon::today()->toDateString();
        $last_month                     = new Carbon('last day of last month');

        $first_transaction              = other_transaction::get()->first();
        $opening_balance                = other_transaction::where('type', 'opening balance')->get()->first();

        if ($ob) {
            $last_period                = $ob->end_period;
            $next_period                = Carbon::parse($last_period)->add(1, 'day');
            $next_period_after_month    = Carbon::parse($last_period)->add(1, 'day')->add(1, 'month');

            if ($next_period_after_month  < $now) {
                $start_period           = Carbon::parse($last_period)->add(1, 'day');
                $end_period             = $next_period->endOfMonth();
            } else {
                $start_period           = Carbon::parse($last_period)->add(1, 'day');
                $end_period             = $now;
            }
        } else {
            if ($opening_balance) {
                $start_period           = $opening_balance->transaction_date;
                $end_period             = $last_month->toDateString();
            } else {
                $start_period           = $first_transaction->transaction_date;
                $end_period             = $last_month->toDateString();
            }
        }
        return view('admin.accounts.closing_book.setup', compact(['start_period', 'end_period', 'id']));
    }

    public function setup_update($id)
    {
        $ob                     = closing_book::find($id); //nanti ditambah company_id
        $start_period           = $ob->start_period;
        $end_period             = $ob->end_period;

        return view('admin.accounts.closing_book.setup', compact(['start_period', 'end_period', 'id']));
    }

    public function setup_store(Request $request)
    {
        $user                       = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number                 = closing_book::latest()->first();
            if ($number != null) {
                $misahm             = explode("/", $number->number);
                $misahy             = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]          = 0;
                $number1            = $misahy[1] + 1;
            } else {
                $number1            = $misahy[1];
            }
            $trans_no               = now()->format('m') . '/' . now()->format('y') . '.' . $number1;
        } else {
            $number                 = closing_book::max('number');
            $last_closing_book      = closing_book::get()->last()->first();
            if ($last_closing_book && $request->hidden_id == $last_closing_book->id) {
                $trans_no = $last_closing_book->number;
            } else {
                if ($number == 0)
                    $number         = 0;
                $trans_no           = $number + 1;
            }
        }

        $rules = array(
            'end_period'            => 'required'
        );

        $error = Validator::make($request->all(), $rules);
        // CHECK IF INPUT VALIDATED
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        DB::beginTransaction();
        try {
            $transactions               = other_transaction::updateOrCreate([
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'number'                => $trans_no,
                'number_complete'       => 'Journal Entry #' . $trans_no,
                'type'                  => 'closing book',
            ], [
                'transaction_date'      => $request->end_period,
                'status'                => 2,
                'balance_due'           => 0,
                'total'                 => 0,
            ]);

            $header                     = closing_book::updateOrCreate([
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'number'                => $trans_no,
                'other_transaction_id'  => $transactions->id
            ], [
                'transaction_date'      => $request->end_period,
                'start_period'          => $request->start_period,
                'end_period'            => $request->end_period,
                'memo'                  => $request->memo,
                'status'                => 7
            ]);


            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $header->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function worksheet(Request $request, $id)
    {
        $closing_book               = closing_book::find($id);
        $start_period               = closing_book::all()->first()->start_period;
        $end_period                 = $closing_book->end_period;
        $coas                       = coa::get();
        //dd($end_period);
        $coa_detail_debit           = coa_detail::whereBetween('date', [$start_period, $end_period])
            ->orderBy('date')
            ->selectRaw('(SUM(debit) - SUM(credit)) as total, coa_id')
            ->groupBy('coa_id')
            ->get();

        $coa_detail_credit          = coa_detail::whereBetween('date', [$start_period, $end_period])
            ->orderBy('date')
            ->selectRaw('(SUM(credit) - SUM(debit)) as total, coa_id')
            ->groupBy('coa_id')
            ->get();

        //$coa_assets->whereBetween('coa_detail.date', [$start, $end])
        //->selectRaw('SUM(coa_detail.debit) as debit, SUM(coa_detail.credit) as credit');
        $coa_assets                 = $coas->whereIn('coa_category_id', [1, 2, 3, 4, 5, 6, 7]);
        $coa_liabilities            = $coas->whereIn('coa_category_id', [8, 9, 10, 11]);
        $coa_equities               = $coas->whereIn('coa_category_id', [12]);
        $coa_incomes                = $coas->whereIn('coa_category_id', [13, 14]);
        $coa_expenses               = $coas->whereIn('coa_category_id', [15, 16, 17]);

        $coa_tax_expense            = $coas->whereIn('coa_category_id', [16, 17]);
        $coa_tax_payable            = $coas->whereIn('coa_category_id', [9, 10, 11]);

        return view(
            'admin.accounts.closing_book.worksheet',
            compact(
                [
                    'closing_book', 'start_period', 'end_period',
                    'coa_assets', 'coa_liabilities', 'coa_equities', 'coa_incomes', 'coa_expenses',
                    'coa_detail_debit', 'coa_detail_credit', 'coa_tax_payable', 'coa_tax_expense'
                ]
            )
        );
    }

    public function worksheet_store(Request $request)
    {
        $user                       = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number                 = closing_book::latest()->first();
            if ($number != null) {
                $misahm             = explode("/", $number->number);
                $misahy             = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]          = 0;
                $number1            = $misahy[1] + 1;
            } else {
                $number1            = $misahy[1];
            }
            $trans_no               = now()->format('m') . '/' . now()->format('y') . '.' . $number1;
        } else {
            $number                 = closing_book::max('number');
            $last_closing_book      = closing_book::latest()->first();
            if ($last_closing_book && $request->hidden_id == $last_closing_book->id) {
                $trans_no           = $last_closing_book->number;
            } else {
                if ($number == 0)
                    $number         = 0;
                $trans_no           = $number + 1;
            }
        }
        if ($user->company_id == 5) {
            $numberje               = journal_entry::latest()->first();
            if ($numberje != null) {
                $misahmje           = explode("/", $numberje->number);
                $misahyje           = explode(".", $misahmje[1]);
            }
            if (isset($misahyje[1]) == 0) {
                $misahyje[1]        = 0;
                $number1je          = $misahyje[1] + 1;
            } else {
                $number1je          = $misahyje[1];
            }
            $trans_noje             = now()->format('m') . '/' . now()->format('y') . '.' . $number1je;
        } else {
            $numberje               = journal_entry::max('number');
            $last_closing_bookje    = journal_entry::get()->last()->first();
            if ($request->hidden_id == $last_closing_bookje->id && $last_closing_bookje != null) {
                $trans_noje         = $last_closing_bookje->number;
            } else {
                if ($numberje == 0)
                    $numberje       = 1;
                $trans_noje         = $numberje + 1;
            }
        }

        DB::beginTransaction();
        try {

            $transactions               = other_transaction::updateOrCreate([
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'number'                => $trans_no,
                'number_complete'       => 'Journal Entry #' . $trans_no,
                'type'                  => 'closing book',
            ], [
                'transaction_date'      => $request->end_period,
                'status'                => 2,
                'balance_due'           => 0,
                'total'                 => 0,
            ]);

            $journal                             = journal_entry::updateOrCreate([
                'other_transaction_id'          => $transactions->id,
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_noje,
            ], [
                'memo'                          => $request->memo,
                'transaction_date'              => $request->end_period,
                'other_transaction_id'          => $transactions->id,
                'status'                        => 2,
                'total_debit'                   => 0,
                'total_credit'                  => 0,
            ]);

            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $journal->id,
            ]);

            /*
            foreach ($request->in_coa as $key => $coa_id) {
                journal_entry_item::updateOrCreate([
                    'journal_entry_id'          => $journal->id,
                    'coa_id'                    => $coa_id,
                ], [
                    'debit'                     => $request->in_credit[$key],
                    'credit'                    => $request->in_debit[$key],
                ]);

                if ($request->in_debit[$key] > 0) {
                    coa_detail::updateOrCreate([
                        'other_transaction_id'          => $transactions->id,
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'                        => $coa_id,
                        'type'                          => 'journal entry',
                        'number'                        => 'Journal Entry #' . $trans_no,
                    ], [
                        'date'                          => $request->end_period,
                        'debit'                         => 0,
                        'credit'                        => $request->in_debit[$key],
                    ]);
                }
                if ($request->in_credit[$key] > 0) {
                    coa_detail::updateOrCreate([
                        'other_transaction_id'          => $transactions->id,
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'                        => $coa_id,
                        'type'                          => 'journal entry',
                        'number'                        => 'Journal Entry #' . $trans_no,
                    ], [
                        'date'                          => $request->end_period,
                        'debit'                         => $request->in_credit[$key],
                        'credit'                        => 0,
                    ]);
                }

                $total_debit                         += $request->in_debit[$key];
                $total_credit                        += $request->in_credit[$key];
            }
                         
            journal_entry_item::updateOrCreate([
                'journal_entry_id'          => $journal->id,
                'coa_id'                    => $request->retained_earning_acc,
            ], [
                'debit'                    => $request->sub_net_debit,
                'credit'                     => $request->sub_net_credit,
            ]);
            $total_credit                       += $request->sub_net_credit;
            $total_debit                        += $request->sub_net_debit;            
           
            coa_detail::updateOrCreate([
                'other_transaction_id'          => $transactions->id,
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'coa_id'                        => $request->retained_earning_acc,
                'type'                          => 'journal entry',
                'number'                        => 'Journal Entry #' . $trans_no,
            ], [
                'date'                          => $request->end_period,
                'debit'                         => $request->sub_net_credit,
                'credit'                         => $request->sub_net_debit,
            ]);
             */

            $cb = closing_book::updateOrCreate([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'other_transaction_id'          => $transactions->id
            ], [
                'transaction_date'              => $request->end_period,
                'start_period'                  => $request->start_period,
                'end_period'                    => $request->end_period,
                'retained_acc'                  => $request->retained_earning_acc,
                'retained_amt'                  => $request->sub_net_debit - $request->sub_net_credit,
                'memo'                          => $request->memo,
                'net_profit'                    => $request->sub_net_credit - $request->sub_net_credit,
                'status'                        => 7,
            ]);

            closing_book::find($cb->id)->update([
                'ref_id'                    => $transactions->id,
            ]);
            /*
            journal_entry::find($journal->id)->update([                
                'total_debit'                   => $total_debit, 
                'total_credit'                   => $total_credit 
            ]);
             */

            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $cb->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function financial_statement()
    {
        return view('admin.accounts.closing_book.statement');
    }

    public function confirm_close_book(Request $request)
    {
        $user               = User::find(Auth::id());
        $number             = journal_entry::max('number');
        $last_closing_book  = closing_book::get()->last()->first();
        $total_credit       = 0;
        $total_debit        = 0;

        if ($request->hidden_id == $last_closing_book->id) {
            $trans_no = $last_closing_book->number;
        } else {
            if ($number == 0)
                $number = 1;
            $trans_no = $number + 1;
        }

        DB::beginTransaction();
        try {

            $transactions               = other_transaction::updateOrCreate([
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'number'                => $trans_no,
                'number_complete'       => 'Journal Entry #' . $trans_no,
                'type'                  => 'closing book',
            ], [
                'transaction_date'      => $request->end_period,
                'status'                => 2,
                'balance_due'           => 0,
                'total'                 => 0,
            ]);

            $journal                             = journal_entry::updateOrCreate([
                'other_transaction_id'          => $transactions->id,
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
            ], [
                'memo'                          => $request->memo,
                'transaction_date'              => $request->end_period,
                'other_transaction_id'          => $transactions->id,
                'status'                        => 2,
                'total_debit'                   => 0,
                'total_credit'                  => 0,
            ]);

            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $journal->id,
            ]);

            foreach ($request->in_coa as $key => $coa_id) {
                journal_entry_item::updateOrCreate([
                    'journal_entry_id'          => $journal->id,
                    'coa_id'                    => $coa_id,
                ], [
                    'debit'                     => $request->in_credit[$key],
                    'credit'                    => $request->in_debit[$key],
                ]);

                if ($request->in_debit[$key] > 0) {
                    coa_detail::updateOrCreate([
                        'other_transaction_id'          => $transactions->id,
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'                        => $coa_id,
                        'type'                          => 'journal entry',
                        'number'                        => 'Journal Entry #' . $trans_no,
                    ], [
                        'date'                          => $request->end_period,
                        'debit'                         => 0,
                        'credit'                        => $request->in_debit[$key],
                    ]);
                }
                if ($request->in_credit[$key] > 0) {
                    coa_detail::updateOrCreate([
                        'other_transaction_id'          => $transactions->id,
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'                        => $coa_id,
                        'type'                          => 'journal entry',
                        'number'                        => 'Journal Entry #' . $trans_no,
                    ], [
                        'date'                          => $request->end_period,
                        'debit'                         => $request->in_credit[$key],
                        'credit'                        => 0,
                    ]);
                }

                $total_debit                         += $request->in_debit[$key];
                $total_credit                        += $request->in_credit[$key];
            }

            journal_entry_item::updateOrCreate([
                'journal_entry_id'          => $journal->id,
                'coa_id'                    => $request->retained_earning_acc,
            ], [
                'debit'                    => $request->sub_net_debit,
                'credit'                     => $request->sub_net_credit,
            ]);
            $total_credit                       += $request->sub_net_credit;
            $total_debit                        += $request->sub_net_debit;

            coa_detail::updateOrCreate([
                'other_transaction_id'          => $transactions->id,
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'coa_id'                        => $request->retained_earning_acc,
                'type'                          => 'journal entry',
                'number'                        => 'Journal Entry #' . $trans_no,
            ], [
                'date'                          => $request->end_period,
                'debit'                         => $request->sub_net_credit,
                'credit'                         => $request->sub_net_debit,
            ]);


            $cb = closing_book::updateOrCreate([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'other_transaction_id'          => $transactions->id
            ], [
                'transaction_date'              => $request->end_period,
                'start_period'                  => $request->start_period,
                'end_period'                    => $request->end_period,
                'retained_acc'                  => $request->retained_earning_acc,
                'retained_amt'                  => $request->sub_net_debit - $request->sub_net_credit,
                'memo'                          => $request->memo,
                'net_profit'                    => $request->sub_net_credit - $request->sub_net_credit,
                'status'                        => 7,
            ]);

            closing_book::find($cb->id)->update([
                'ref_id'                    => $transactions->id,
            ]);

            journal_entry::find($journal->id)->update([
                'total_debit'                   => $total_debit,
                'total_credit'                   => $total_credit
            ]);


            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $cb->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClosingBook  $closingBook
     * @return \Illuminate\Http\Response
     */
    public function show(ClosingBook $closingBook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClosingBook  $closingBook
     * @return \Illuminate\Http\Response
     */
    public function edit(ClosingBook $closingBook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClosingBook  $closingBook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClosingBook $closingBook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClosingBook  $closingBook
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClosingBook $closingBook)
    {
        //
    }
}
