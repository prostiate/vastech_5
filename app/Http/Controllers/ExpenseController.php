<?php

namespace App\Http\Controllers;

use App\cashbank_item;
use App\expense;
use App\coa;
use App\coa_detail;
use App\contact;
use App\other_payment_method;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\other_tax;
use App\other_transaction;
use App\expense_item;
use App\other_term;
use App\User;
use PDF;
use App\default_account;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $open_po            = expense::whereIn('status', [1, 4])->count();
        $payment_last       = expense::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->count();
        $overdue            = expense::where('status', 5)->count();
        $open_po_total            = expense::whereIn('status', [1, 4])->sum('grandtotal');
        $payment_last_total       = expense::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->sum('grandtotal');
        $overdue_total            = expense::where('status', 5)->sum('grandtotal');
        if (request()->ajax()) {
            return datatables()->of(expense::with('expense_contact', 'status', 'coa')->get())
                ->make(true);
        }

        return view('admin.expenses.index', compact(['open_po', 'payment_last', 'overdue', 'open_po_total', 'payment_last_total', 'overdue_total']));
    }

    public function create()
    {
        $accounts               = coa::where('coa_category_id', '!=', 16)
            ->orWhere('coa_category_id', '!=', 17)
            ->get();
        $vendors                = contact::get();
        $expenses               = coa::where('coa_category_id', 16)
            ->orWhere('coa_category_id', 17)
            ->orWhere('coa_category_id', 15)
            ->get();
        $taxes                  = other_tax::all();
        $today                  = Carbon::today()->toDateString();
        $payment_method         = other_payment_method::get();
        $terms                  = other_term::get();
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = expense::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                if ($dt->isSameMonth($number->transaction_date)) {
                    $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.EX';
                } else {
                    $check_number   = expense::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.EX';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.EX';
                    }
                }
            } else {
                $check_number   = expense::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                if ($check_number) {
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.EX';
                } else {
                    $number1    = 10001;
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.EX';
                }
            }
        } else {
            $number             = expense::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }

        return view('admin.expenses.create', compact(['accounts', 'vendors', 'expenses', 'taxes', 'today', 'trans_no', 'payment_method', 'terms']));
    }

    public function store(Request $request)
    {
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = expense::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                $check_number   = expense::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.EX';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.EX';
                }
            } else {
                $check_number   = expense::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.EX';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.EX';
                }
            }
        } else {
            $number             = expense::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }
        $rules = array(
            'vendor_name'                   => 'required',
            'trans_date'                    => 'required',
            'expense_acc'                   => 'required|array|min:1',
            'expense_acc.*'                 => 'required',
            'tax_acc'                       => 'required|array|min:1',
            'tax_acc.*'                     => 'required',
            'amount_acc'                    => 'required|array|min:1',
            'amount_acc.*'                  => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $default_trade_payable                  = default_account::find(16);
            if ($request->pay_later == 1) {
                $transactions = other_transaction::create([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'transaction_date'      => $request->get('trans_date'),
                    'number'                => $trans_no,
                    'number_complete'       => 'Expense #' . $trans_no,
                    'type'                  => 'expense',
                    'memo'                  => $request->get('memo'),
                    'contact'               => $request->get('vendor_name'),
                    'due_date'              => $request->get('due_date'),
                    'status'                => 1,
                    'balance_due'           => $request->get('balance'),
                    'total'                 => $request->get('balance'),
                ]);

                $ex = new expense([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'number'                => $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'payment_method_id'     => $request->get('payment_method'),
                    'pay_from_coa_id'       => $default_trade_payable->account_id,
                    'address'               => $request->get('address'),
                    'transaction_date'      => $request->get('trans_date'),
                    'due_date'              => $request->get('due_date'),
                    'term_id'               => $request->get('term'),
                    'memo'                  => $request->get('memo'),
                    'amount_paid'           => 0,
                    'subtotal'              => $request->get('subtotal'),
                    'taxtotal'              => $request->get('taxtotal'),
                    'balance_due'           => $request->get('balance'),
                    'grandtotal'            => $request->get('balance'),
                    'status'                => 1,
                ]);
            } else {
                $transactions = other_transaction::create([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'transaction_date'      => $request->get('trans_date'),
                    'number'                => $trans_no,
                    'number_complete'       => 'Expense #' . $trans_no,
                    'type'                  => 'expense',
                    'memo'                  => $request->get('memo'),
                    'contact'               => $request->get('vendor_name'),
                    'status'                => 3,
                    'balance_due'           => 0,
                    'total'                 => $request->get('balance'),
                ]);

                $ex = new expense([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'number'                => $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'payment_method_id'     => $request->get('payment_method'),
                    'pay_from_coa_id'       => $request->get('pay_from'),
                    'address'               => $request->get('address'),
                    'transaction_date'      => $request->get('trans_date'),
                    'memo'                  => $request->get('memo'),
                    'amount_paid'           => $request->get('balance'),
                    'subtotal'              => $request->get('subtotal'),
                    'taxtotal'              => $request->get('taxtotal'),
                    'balance_due'           => 0,
                    'grandtotal'            => $request->get('balance'),
                    'status'                => 3,
                ]);
            }
            $transactions->expense()->save($ex);
            other_transaction::find($transactions->id)->update([
                'ref_id'                    => $ex->id,
            ]);

            if ($request->taxtotal > 0) {
                $default_tax                    = default_account::find(14);
                coa_detail::create([
                    'company_id'                => $user->company_id,
                    'user_id'                   => Auth::id(),
                    'ref_id'                    => $ex->id,
                    'other_transaction_id'      => $transactions->id,
                    'coa_id'                    => $default_tax->account_id,
                    'date'                      => $request->get('trans_date'),
                    'type'                      => 'expense',
                    'number'                    => 'Expense #' . $trans_no,
                    'contact_id'                => $request->get('vendor_name'),
                    'debit'                     => $request->get('taxtotal'),
                    'credit'                    => 0,
                ]);
            }

            foreach ($request->expense_acc as $i => $keys) {
                $pp[$i] = new expense_item([
                    'coa_id'                    => $request->expense_acc[$i],
                    'desc'                      => $request->desc_acc[$i],
                    'tax_id'                    => $request->tax_acc[$i],
                    'amountsub'                 => $request->total_amount_sub[$i],
                    'amounttax'                 => $request->total_amount_tax[$i],
                    'amountgrand'               => $request->total_amount_grand[$i],
                    'amount'                    => $request->amount_acc[$i],
                ]);
                $ex->expense_item()->save($pp[$i]);

                coa_detail::create([
                    'company_id'                => $user->company_id,
                    'user_id'                   => Auth::id(),
                    'ref_id'                    => $ex->id,
                    'other_transaction_id'      => $transactions->id,
                    'coa_id'                    => $request->expense_acc[$i],
                    'date'                      => $request->get('trans_date'),
                    'type'                      => 'expense',
                    'number'                    => 'Expense #' . $trans_no,
                    'contact_id'                => $request->get('vendor_name'),
                    'debit'                     => $request->amount_acc[$i],
                    'credit'                    => 0,
                ]);
            };

            // CREATE COA DETAIL YANG DARI PAY FROM
            //$get_current_contact_data           = contact::find($request->vendor_name);
            if ($request->pay_later == 1) {
                coa_detail::create([
                    'company_id'                => $user->company_id,
                    'user_id'                   => Auth::id(),
                    'ref_id'                    => $ex->id,
                    'other_transaction_id'      => $transactions->id,
                    'coa_id'                    => $default_trade_payable->account_id,
                    'date'                      => $request->get('trans_date'),
                    'type'                      => 'expense',
                    'number'                    => 'Expense #' . $trans_no,
                    'contact_id'                => $request->get('vendor_name'),
                    'debit'                     => 0,
                    'credit'                    => $request->get('balance'),
                ]);
            } else {
                coa_detail::create([
                    'company_id'                => $user->company_id,
                    'user_id'                   => Auth::id(),
                    'ref_id'                    => $ex->id,
                    'other_transaction_id'      => $transactions->id,
                    'coa_id'                    => $request->pay_from,
                    'date'                      => $request->get('trans_date'),
                    'type'                      => 'expense',
                    'number'                    => 'Expense #' . $trans_no,
                    'contact_id'                => $request->get('vendor_name'),
                    'debit'                     => 0,
                    'credit'                    => $request->get('balance'),
                ]);
            }
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $ex->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $pi                         = expense::find($id);
        $products                   = expense_item::where('expense_id', $id)->get();
        $checknumberpd              = expense::whereId($id)->first();
        $numbercoadetail            = 'Expense #' . $checknumberpd->number;
        $numberothertransaction     = $checknumberpd->number;
        $get_all_detail             = coa_detail::where('number', $numbercoadetail)->where('type', 'expense')->with('coa')->get();
        $total_debit                = $get_all_detail->sum('debit');
        $total_credit               = $get_all_detail->sum('credit');
        $bank_withdrawal            = cashbank_item::where('expense_id', $id)->get();
        if ($pi->due_date == null) {
            return view('admin.expenses.showNull', compact(['pi', 'products', 'get_all_detail', 'total_debit', 'total_credit']));
        } else {
            return view('admin.expenses.showNotNull', compact(['pi', 'products', 'get_all_detail', 'total_debit', 'total_credit', 'bank_withdrawal']));
        }
    }

    public function edit($id)
    {
        $ex         = expense::find($id);
        $ex_item    = expense_item::where('expense_id', $id)->get();
        $accounts = coa::where('coa_category_id', '!=', 16)
            ->orWhere('coa_category_id', '!=', 17)
            ->get();
        $vendors = contact::get();
        $expenses = coa::where('coa_category_id', 16)
            ->orWhere('coa_category_id', 17)
            ->orWhere('coa_category_id', 15)
            ->get();
        $taxes  = other_tax::all();
        $payment_method     = other_payment_method::get();
        $terms  = other_term::get();
        if ($ex->due_date == null) {
            return view('admin.expenses.editNull', compact(['ex', 'ex_item', 'accounts', 'vendors', 'expenses', 'taxes', 'payment_method', 'terms']));
        } else {
            return view('admin.expenses.editNotNull', compact(['ex', 'ex_item', 'accounts', 'vendors', 'expenses', 'taxes', 'payment_method', 'terms']));
        }
    }

    public function updateNotNull(Request $request)
    {
        $user               = User::find(Auth::id());
        DB::beginTransaction();
        try {
            $id                                                 = $request->hidden_id;
            $pp                                                 = expense_item::where('expense_id', $id)->get();
            $default_tax                                        = default_account::find(14);
            $ex                                                 = expense::find($id);

            coa_detail::where('type', 'expense')->where('number', 'Expense #' . $ex->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'expense')->where('number', 'Expense #' . $ex->number)->where('credit', 0)->delete();
            expense_item::where('expense_id', $id)->delete();

            // BARU BIKIN BARU LAGI
            $transactions                                       = other_transaction::where('type', 'expense')->where('number', $ex->number)->first();
            other_transaction::where('type', 'expense')->where('number', $ex->number)->update([
                'transaction_date'                              => $request->get('trans_date'),
                'memo'                                          => $request->get('memo'),
                'contact'                                       => $request->get('vendor_name'),
                'due_date'                                      => $request->get('due_date'),
                'balance_due'                                   => $request->get('balance'),
                'total'                                         => $request->get('balance'),
            ]);
            expense::find($id)->update([
                'contact_id'                                    => $request->get('vendor_name'),
                'payment_method_id'                             => $request->get('payment_method'),
                'pay_from_coa_id'                               => $request->get('pay_from'),
                'address'                                       => $request->get('address'),
                'transaction_date'                              => $request->get('trans_date'),
                'due_date'                                      => $request->get('due_date'),
                'term_id'                                       => $request->get('term'),
                'memo'                                          => $request->get('memo'),
                'subtotal'                                      => $request->get('subtotal'),
                'taxtotal'                                      => $request->get('taxtotal'),
                'balance_due'                                   => $request->get('balance'),
                'grandtotal'                                    => $request->get('balance'),
                'amount_paid'           => $request->get('balance'),
            ]);
            if ($request->taxtotal > 0) {
                $default_tax                                    = default_account::find(14);
                coa_detail::create([
                    'company_id'                                => $user->company_id,
                    'user_id'                                   => Auth::id(),
                    'ref_id'                                    => $ex->id,
                    'other_transaction_id'                      => $transactions->id,
                    'coa_id'                                    => $default_tax->account_id,
                    'date'                                      => $request->get('trans_date'),
                    'type'                                      => 'expense',
                    'number'                                    => 'Expense #' . $ex->number,
                    'contact_id'                                => $request->get('vendor_name'),
                    'debit'                                     => $request->get('taxtotal'),
                    'credit'                                    => 0,
                ]);
            }

            foreach ($request->expense_acc as $i => $keys) {
                $pp[$i] = new expense_item([
                    'expense_id'                                => $id,
                    'coa_id'                                    => $request->expense_acc[$i],
                    'desc'                                      => $request->desc_acc[$i],
                    'tax_id'                                    => $request->tax_acc[$i],
                    'amountsub'                                 => $request->total_amount_sub[$i],
                    'amounttax'                                 => $request->total_amount_tax[$i],
                    'amountgrand'                               => $request->total_amount_grand[$i],
                    'amount'                                    => $request->amount_acc[$i],
                ]);
                $ex->expense_item()->save($pp[$i]);

                coa_detail::create([
                    'company_id'                                => $user->company_id,
                    'user_id'                                   => Auth::id(),
                    'ref_id'                                    => $ex->id,
                    'other_transaction_id'                      => $transactions->id,
                    'coa_id'                                    => $request->expense_acc[$i],
                    'date'                                      => $request->get('trans_date'),
                    'type'                                      => 'expense',
                    'number'                                    => 'Expense #' . $ex->number,
                    'contact_id'                                => $request->get('vendor_name'),
                    'debit'                                     => $request->amount_acc[$i],
                    'credit'                                    => 0,
                ]);
            };

            // CREATE COA DETAIL YANG DARI PAY FROM
            //$get_current_contact_data           = contact::find($request->vendor_name);
            $default_trade_payable                              = default_account::find(16);
            coa_detail::create([
                'company_id'                                    => $user->company_id,
                'user_id'                                       => Auth::id(),
                'ref_id'                                        => $ex->id,
                'other_transaction_id'                          => $transactions->id,
                'coa_id'                                        => $default_trade_payable->account_id,
                'date'                                          => $request->get('trans_date'),
                'type'                                          => 'expense',
                'number'                                        => 'Expense #' . $ex->number,
                'contact_id'                                    => $request->get('vendor_name'),
                'debit'                                         => 0,
                'credit'                                        => $request->get('balance'),
            ]);
            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function updateNull(Request $request)
    {
        $user               = User::find(Auth::id());
        DB::beginTransaction();
        try {
            $id                                                 = $request->hidden_id;
            $checknumberpd                                      = expense::find($id);
            $pp                                                 = expense_item::where('expense_id', $id)->get();
            $rp                                                 = $request->expense_acc;
            $default_tax                                        = default_account::find(14);
            $ex                                                 = expense::find($id);

            coa_detail::where('type', 'expense')->where('number', 'Expense #' . $ex->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'expense')->where('number', 'Expense #' . $ex->number)->where('credit', 0)->delete();
            expense_item::where('expense_id', $id)->delete();

            // BARU BIKIN BARU LAGI
            $transactions                                       = other_transaction::where('type', 'expense')->where('number', $ex->number)->first();
            other_transaction::where('type', 'expense')->where('number', $ex->number)->update([
                'transaction_date'                              => $request->get('trans_date'),
                'memo'                                          => $request->get('memo'),
                'contact'                                       => $request->get('vendor_name'),
                'due_date'                                      => $request->get('due_date'),
                'balance_due'                                   => 0,
                'total'                                         => $request->get('balance'),
            ]);
            expense::find($id)->update([
                'contact_id'                                    => $request->get('vendor_name'),
                'payment_method_id'                             => $request->get('payment_method'),
                'pay_from_coa_id'                               => $request->get('pay_from'),
                'address'                                       => $request->get('address'),
                'transaction_date'                              => $request->get('trans_date'),
                'due_date'                                      => $request->get('due_date'),
                'term_id'                                       => $request->get('term'),
                'memo'                                          => $request->get('memo'),
                'subtotal'                                      => $request->get('subtotal'),
                'taxtotal'                                      => $request->get('taxtotal'),
                'balance_due'                                   => 0,
                'grandtotal'                                    => $request->get('balance'),
                'amount_paid'           => $request->get('balance'),
            ]);
            if ($request->taxtotal > 0) {
                $default_tax                                    = default_account::find(14);
                coa_detail::create([
                    'company_id'                                => $user->company_id,
                    'user_id'                                   => Auth::id(),
                    'ref_id'                                    => $ex->id,
                    'other_transaction_id'                      => $transactions->id,
                    'coa_id'                                    => $default_tax->account_id,
                    'date'                                      => $request->get('trans_date'),
                    'type'                                      => 'expense',
                    'number'                                    => 'Expense #' . $ex->number,
                    'contact_id'                                => $request->get('vendor_name'),
                    'debit'                                     => $request->get('taxtotal'),
                    'credit'                                    => 0,
                ]);
            }

            foreach ($request->expense_acc as $i => $keys) {
                $pp[$i] = new expense_item([
                    'expense_id'                                => $id,
                    'coa_id'                                    => $request->expense_acc[$i],
                    'desc'                                      => $request->desc_acc[$i],
                    'tax_id'                                    => $request->tax_acc[$i],
                    'amountsub'                                 => $request->total_amount_sub[$i],
                    'amounttax'                                 => $request->total_amount_tax[$i],
                    'amountgrand'                               => $request->total_amount_grand[$i],
                    'amount'                                    => $request->amount_acc[$i],
                ]);
                $ex->expense_item()->save($pp[$i]);

                coa_detail::create([
                    'company_id'                                => $user->company_id,
                    'user_id'                                   => Auth::id(),
                    'ref_id'                                    => $ex->id,
                    'other_transaction_id'                      => $transactions->id,
                    'coa_id'                                    => $request->expense_acc[$i],
                    'date'                                      => $request->get('trans_date'),
                    'type'                                      => 'expense',
                    'number'                                    => 'Expense #' . $ex->number,
                    'contact_id'                                => $request->get('vendor_name'),
                    'debit'                                     => $request->amount_acc[$i],
                    'credit'                                    => 0,
                ]);
            };

            // CREATE COA DETAIL YANG DARI PAY FROM
            //$get_current_contact_data           = contact::find($request->vendor_name);
            coa_detail::create([
                'company_id'                                    => $user->company_id,
                'user_id'                                       => Auth::id(),
                'ref_id'                                        => $ex->id,
                'other_transaction_id'                          => $transactions->id,
                'coa_id'                                        => $request->pay_from,
                'date'                                          => $request->get('trans_date'),
                'type'                                          => 'expense',
                'number'                                        => 'Expense #' . $ex->number,
                'contact_id'                                    => $request->get('vendor_name'),
                'debit'                                         => 0,
                'credit'                                        => $request->get('balance'),
            ]);
            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroyNotNull($id)
    {
        DB::beginTransaction();
        try {
            $check_caba                         = cashbank_item::where('expense_id', $id)->first();
            $ex                                 = expense::find($id);
            $default_tax                        = default_account::find(14);
            if ($check_caba) {
                DB::rollBack();
                return response()->json(['errors' => 'Cannot delete contact with transactions!']);
            } else {
                coa_detail::where('type', 'expense')->where('number', 'Expense #' . $ex->number)->where('debit', 0)->delete();
                coa_detail::where('type', 'expense')->where('number', 'Expense #' . $ex->number)->where('credit', 0)->delete();
                expense_item::where('expense_id', $id)->delete();
                // DELETE ROOT OTHER TRANSACTION
                other_transaction::where('type', 'expense')->where('number', $ex->number)->delete();
                // FINALLY DELETE THE CASHBANK ID
                $ex->delete();
                DB::commit();
                return response()->json(['success' => 'Data is successfully deleted']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroyNull($id)
    {
        DB::beginTransaction();
        try {
            $ex                                     = expense::find($id);
            $default_tax                            = default_account::find(14);
            coa_detail::where('type', 'expense')->where('number', 'Expense #' . $ex->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'expense')->where('number', 'Expense #' . $ex->number)->where('credit', 0)->delete();
            expense_item::where('expense_id', $id)->delete();
            // DELETE ROOT OTHER TRANSACTION
            other_transaction::where('type', 'expense')->where('number', $ex->number)->delete();
            // FINALLY DELETE THE CASHBANK ID
            $ex->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function cetak_pdfNotNull($id)
    {
        $pp                         = expense::find($id);
        $pp_item                    = expense_item::where('expense_id', $id)->get();
        $today                      = Carbon::today()->toDateString();
        $pdf = PDF::loadview('admin.expenses.printExpenseNotNull', compact(['pp', 'pp_item', 'today']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdfNull($id)
    {
        $pp                         = expense::find($id);
        $pp_item                    = expense_item::where('expense_id', $id)->get();
        $today                      = Carbon::today()->toDateString();
        $pdf = PDF::loadview('admin.expenses.printExpenseNull', compact(['pp', 'pp_item', 'today']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
