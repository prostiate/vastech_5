<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Validator;
use App\Model\closing_book\closing_book;
use App\Model\closing_book\closing_book_item;
use App\Model\coa\coa;
use App\Model\coa\coa_detail;
use App\Model\company\company_setting;
use App\Model\journal_opening_balance\journal_entry;
use App\Model\journal_opening_balance\journal_entry_item;
use App\Model\other\other_transaction;
use App\User;
use App\Model\expense\expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClosingBookController extends Controller
{
    public function index()
    {
        $last_closing_book      = closing_book::orderBy('end_period', 'desc')->first();

        if (request()->ajax()) {
            return datatables()->of(closing_book::get())
                ->addColumn('action', function ($data) {
                    $select = '<select class="pilih">
                    <option value="/closing_book/'. $data->id .'/setup"> Change Period </option>
                    <option value="/closing_book/' . $data->id . '/worksheet"> Worksheet </option>
                    <option value="/closing_book/delete"> Delete Draft</option>
                    </select>
                    <button type="button" class="go btn btn-danger btn-sm">Go</button>';
                    return $select;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

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
                $end_period             = Carbon::parse($opening_balance->transaction_date)->endOfMonth()->toDateString();
            } else {
                $start_period           = $first_transaction->transaction_date;
                $end_period             = $last_month->toDateString();
            }
        }
        return view('admin.accounts.closing_book.setup', compact(['start_period', 'end_period', 'id']));
    }

    public function setup_update($id)
    {
        $ob                             = closing_book::find($id); //nanti ditambah company_id
        $start_period                   = $ob->start_period;
        $end_period                     = $ob->end_period;

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
            $last_closing_book      = closing_book::latest()->first();
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
                'number_complete'       => 'Closing Book #' . $trans_no,
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
            other_transaction::find($transactions->id)->update(['ref_id' => $header->id]);

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
            $last_closing_bookje    = journal_entry::latest()->first();
            if ($last_closing_bookje && $request->hidden_id == $last_closing_bookje->id) {
                $trans_noje         = $last_closing_bookje->number;
            } else {
                if ($numberje == 0)
                    $numberje       = 1;
                $trans_noje         = $numberje + 1;
            }
        }

        DB::beginTransaction();
        try {
            /*
            $transactions               = other_transaction::updateOrCreate([
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'number'                => $trans_no,
                'number_complete'       => 'Closing Book #' . $trans_no,
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

            closing_book::find($request->hidden_id)->update([
                'transaction_date'              => $request->end_period,
                'start_period'                  => $request->start_period,
                'end_period'                    => $request->end_period,
                'retained_acc'                  => $request->retained_earning_acc,
                'retained_amt'                  => $request->sub_net_debit - $request->sub_net_credit,
                'memo'                          => $request->memo,
                'net_profit'                    => $request->sub_net_credit - $request->sub_net_credit,
                'status'                        => 7,
            ]);

            foreach ($request->in_coa as $i => $coa) {
                if ($request->in_debit[$i] > 0) {
                    closing_book_item::updateOrCreate(
                        [
                            'company_id'                => $user->company_id,
                            'closing_book_id'           => $request->hidden_id,
                            'coa_id'                    => $coa,
                        ],
                        [
                            'credit'                    => 0,
                            'debit'                     => $request->in_debit[$i],
                        ]
                    );
                }
                if ($request->in_credit[$i] > 0) {
                    closing_book_item::updateOrCreate(
                        [
                            'company_id'                => $user->company_id,
                            'closing_book_id'           => $request->hidden_id,
                            'coa_id'                    => $coa,
                        ],
                        [
                            'credit'                    => $request->in_credit[$i],
                            'debit'                     => 0,
                        ]
                    );
                }
                if ($request->in_debit[$i] == 0 && $request->in_credit[$i] == 0) {
                    closing_book_item::where([
                        'company_id'                  => $user->company_id,
                        'closing_book_id'             => $request->hidden_id,
                        'coa_id'                      => $coa
                    ])->delete();
                }
            }
            /*
            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $cb->id,
            ]);

            closing_book::find($cb->id)->update([
                'ref_id'                    => $transactions->id,
            ]);

            journal_entry::find($journal->id)->update([
                'total_debit'                   => $total_debit,
                'total_credit'                   => $total_credit
            ]);
             */

            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $request->hidden_id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function financial_statement($id)
    {
        $cb                 = closing_book::find($id);
        return view('admin.accounts.closing_book.statement', compact(['id', 'cb']));
    }

    public function confirm_close_book(Request $request)
    {
        //dd($request);
        $user               = User::find(Auth::id());
        $number             = journal_entry::max('number');
        $cb                 = closing_book::find($request->hidden_id);
        $last_closing_book  = closing_book::get()->last()->first();
        $last_closing_book_item     = closing_book_item::whereClosing_book_id($request->hidden_id)->get();
        //dd($last_closing_book_item);
        $total_credit       = 0;
        $total_debit        = 0;

        if ($cb->id == $last_closing_book->id) {
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
                'transaction_date'      => $cb->end_period,
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
                'memo'                          => $cb->memo,
                'transaction_date'              => $cb->end_period,
                'other_transaction_id'          => $transactions->id,
                'status'                        => 2,
                'total_debit'                   => 0,
                'total_credit'                  => 0,
            ]);

            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $journal->id,
            ]);

            foreach ($last_closing_book_item as $key => $lcb) {
                journal_entry_item::updateOrCreate([
                    'journal_entry_id'          => $journal->id,
                    'coa_id'                    => $lcb->coa_id,
                ], [
                    'debit'                     => $lcb->debit,
                    'credit'                    => $lcb->credit,
                ]);

                if ($lcb->debit > 0) {
                    coa_detail::updateOrCreate([
                        'other_transaction_id'          => $transactions->id,
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'                        => $lcb->coa_id,
                        'type'                          => 'journal entry',
                        'number'                        => 'Journal Entry #' . $trans_no,
                    ], [
                        'date'                          => $cb->end_period,
                        'debit'                         => 0,
                        'credit'                        => $lcb->debit,
                    ]);
                }
                if ($lcb->credit > 0) {
                    coa_detail::updateOrCreate([
                        'other_transaction_id'          => $transactions->id,
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'                        => $lcb->coa_id,
                        'type'                          => 'journal entry',
                        'number'                        => 'Journal Entry #' . $trans_no,
                    ], [
                        'date'                          => $cb->end_period,
                        'debit'                         => $lcb->credit,
                        'credit'                        => 0,
                    ]);
                }

                $total_debit                         += $lcb->debit;
                $total_credit                        += $lcb->credit;
            }

            if($cb->retained_amt < 0){
                $debit                     = $cb->retained_amt;
                $credit                    = 0;
                $total_debit               += $cb->retained_amt;
            }elseif($cb->retained_amt > 0){
                $debit                     = 0;
                $credit                    = $cb->retained_amt;
                $total_credit              += $cb->retained_amt;
            }else{
                $debit                     = 0;
                $credit                    = 0;
            }

            journal_entry_item::updateOrCreate([
                'journal_entry_id'          => $journal->id,
                'coa_id'                    => $cb->retained_acc,
            ], [
                'debit'                     => abs($credit),
                'credit'                    => abs($debit),
            ]);

            coa_detail::updateOrCreate([
                'other_transaction_id'          => $transactions->id,
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'coa_id'                        => $cb->retained_acc,
                'type'                          => 'journal entry',
                'number'                        => 'Journal Entry #' . $trans_no,
            ], [
                'date'                          => $cb->end_period,
                'debit'                         => abs($debit),
                'credit'                        => abs($credit),
            ]);

            journal_entry::find($journal->id)->update([
                'total_debit'                   => $total_debit,
                'total_credit'                  => $total_credit
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

    public function balance_sheet($start, $end)
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $today                                      = Carbon::parse($start);
        $current_periode                            = new Carbon('first day of ' . $today->format('F'));
        $coa_detail                                 = coa_detail::whereBetween('date', [$start, $end])
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();
        $last_periode_coa_detail                    = coa_detail::whereBetween('date', [$start, $end])
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();

        return view('admin.accounts.closing_book.preview_report.balance_sheet_pdf', compact([
            'coa_detail', 'last_periode_coa_detail', 'company', 'today', 'start', 'end'
        ]));
    }

    public function cash_flow($start, $end)
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $coa_detail                                 = coa_detail::whereBetween('date', [$start, $end])
            ->selectRaw('SUM(debit) as debit, SUM(credit) as credit, coa_id, type')->groupBy('number')->groupBy('coa_id')
            ->get();
        $cash_received_from_cust                    = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->type == 'sales payment') {
                if ($cd->coa->coa_category_id == 3) {
                    $cash_received_from_cust        += ($cd->debit - $cd->credit);
                }
            }
        }
        $other_current_asset                        = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 2) {
                $other_current_asset                += $cd->debit - $cd->credit;
            }
        }
        $cash_paid_to_supplier                      = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->type == 'purchase payment') {
                if ($cd->coa->coa_category_id == 3) {
                    $cash_paid_to_supplier          += $cd->credit - $cd->debit;
                }
            }
        }
        $cc_and_current_liability                   = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 9 or $cd->coa->coa_category_id == 10 && $cd->coa_id != 50 && $cd->coa_id != 51 && $cd->coa_id != 52 && $cd->coa_id != 53 && $cd->coa_id != 54 && $cd->coa_id != 55) {
                $cc_and_current_liability        += $cd->debit - $cd->credit;
            }
        }
        $other_income                               = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 14) {
                $other_income                       += $cd->debit - $cd->credit;
            }
        }
        $operating_expense                          = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->type == 'expense') {
                $operating_expense                  += $cd->debit;
            }
        }
        $net_cash_operating_acti    = $cash_received_from_cust + $other_current_asset - $cash_paid_to_supplier - $cc_and_current_liability + $other_income - $operating_expense;

        $purchase_sale_asset        = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 5) {
                $purchase_sale_asset                += $cd->debit - $cd->credit;
            }
        }
        $other_investing_asset      = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 6) {
                $other_investing_asset              += $cd->debit - $cd->credit;
            }
        }
        $net_cash_by_investing      = $purchase_sale_asset + $other_investing_asset;

        $repayment_proceed_loan     = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 49 or $cd->coa->coa_category_id == 56) {
                $repayment_proceed_loan             += $cd->debit - $cd->credit;
            }
        }
        $equity_capital             = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 12) {
                $equity_capital             += $cd->debit - $cd->credit;
            }
        }
        $net_cash_finan             = $repayment_proceed_loan + $equity_capital;

        $increase_dec_in_cash       = $net_cash_operating_acti + $net_cash_by_investing + $net_cash_finan;
        $beginning_cash             = 0;
        $ending_cash                = $beginning_cash + $increase_dec_in_cash;
        return view('admin.accounts.closing_book.preview_report.cashflow_pdf', compact([
            'company', 'start',
            'end',
            'cash_received_from_cust',
            'other_current_asset',
            'cash_paid_to_supplier',
            'cc_and_current_liability',
            'other_income',
            'operating_expense',
            'net_cash_operating_acti',
            'purchase_sale_asset',
            'other_investing_asset',
            'net_cash_by_investing',
            'repayment_proceed_loan',
            'equity_capital',
            'net_cash_finan',
            'increase_dec_in_cash',
            'beginning_cash',
            'ending_cash',
        ]));
    }

    public function profit_loss($start, $end)
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $coa_detail                                 = coa_detail::whereBetween('date', [$start, $end])
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();

        $total_primary_income               = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 13) {
                $total_primary_income       += $cd->total2;
            }
        }
        $total_cost_of_sales                = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 15) {
                $total_cost_of_sales        += $cd->total;
            }
        }
        $gross_profit                       = $total_primary_income - $total_cost_of_sales;

        $total_operational_expense          = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 16) {
                $total_operational_expense  += $cd->total;
            }
        }
        $net_operating_income               = $gross_profit - $total_operational_expense;

        $total_other_income                 = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 14) {
                $total_other_income         += $cd->total2;
            }
        }

        $total_other_expense                = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 17) {
                $total_other_expense        += $cd->total;
            }
        }
        $net_income                 = $net_operating_income + $total_other_income - $total_other_expense;
        return view('admin.reports.overview_export.profit_loss_pdf', compact([
            'company', 'start',
            'end',
            'coa_detail',
            'total_primary_income',
            'total_cost_of_sales',
            'gross_profit',
            'total_operational_expense',
            'net_operating_income',
            'total_other_income',
            'total_other_expense',
            'net_income',
        ]));
    }

    public function trial_balance($start, $end)
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $coa_detail2                 = coa_detail::whereBetween('date', [$start, $end])
            ->select('coa_details.*')->groupBy('coa_id')
            ->selectSub(function ($query) {
                return $query->selectRaw('SUM(debit)');
            }, 'debit')
            ->selectSub(function ($query) {
                return $query->selectRaw('SUM(credit)');
            }, 'credit')
            ->orderBy('date')
            ->get()
            ->groupBy('coa_id');
        //dd($coa_detail2);
        $asset                          = coa::whereIn('coa_category_id', [3, 1, 4, 2, 5, 6, 7])->get();
        $liability                      = coa::whereIn('coa_category_id', [8, 9, 10, 11])->get();
        $equity                         = coa::whereIn('coa_category_id', [12])->get();
        $income                         = coa::whereIn('coa_category_id', [13, 14])->get();
        $expense                        = coa::whereIn('coa_category_id', [15, 16, 17])->get();
        $coa_detail                     = coa_detail::orderBy('coa_id', 'asc')->get()->groupBy('coa_id');
        $coa                            = coa::get();
        return view('admin.reports.overview_export.trial_balance_pdf', compact([
            'company', 'start',
            'end',
            'asset',
            'liability',
            'equity',
            'income',
            'expense',
            'coa',
            'coa_detail',
            'coa_detail2'
        ]));
    }
}
