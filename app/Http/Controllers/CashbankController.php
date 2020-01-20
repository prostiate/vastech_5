<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\coa;
use App\coa_detail;
use Illuminate\Support\Carbon;
use App\expense;
use App\cashbank;
use App\cashbank_item;
use App\contact;
use App\other_tax;
use Validator;
use App\other_transaction;
use PDF;
use App\default_account;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CashbankController extends Controller
{
    public function index()
    {
        $coa                        = coa::with('coa_category')->where('coa_category_id', 3)->get();
        $open_po                    = expense::whereIn('status', [1, 4])->count();
        $payment_last               = expense::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->count();
        $overdue                    = expense::where('status', 5)->count();
        $open_po_total              = expense::whereIn('status', [1, 4])->sum('grandtotal');
        $payment_last_total         = expense::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->sum('grandtotal');
        $overdue_total              = expense::where('status', 5)->sum('grandtotal');
        $coa_detail                 = coa_detail::selectRaw('SUM(debit) as debit, SUM(credit) as credit, coa_id')->groupBy('coa_id')->get();
        $coa_all                    = count(coa::all());;
        if (request()->ajax()) {
            return datatables()->of(coa::with('coa_category')->where('coa_category_id', 3)->get())
                ->make(true);
        }

        return view('admin.cashbank.index', compact([
            'coa', 'open_po', 'coa_detail', 'coa_all',
            'payment_last', 'overdue', 'open_po_total', 'payment_last_total', 'overdue_total'
        ]));
    }

    public function indexListTransaction()
    {
        if (request()->ajax()) {
            return datatables()->of(cashbank::with('status', 'coa_transfer_from', 'coa_deposit_to', 'contact')->get())
                ->make(true);
        }
        return view('admin.cashbank.index');
    }

    public function createBankTransfer()
    {
        $coa                = coa::with('coa_category')->where('coa_category_id', 3)->get();
        $today              = Carbon::today()->toDateString();
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = cashbank::where('bank_transfer', 1)->latest()->first();
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
            $number             = cashbank::where('bank_transfer', 1)->max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }

        return view('admin.cashbank.createBankTransfer', compact(['coa', 'trans_no', 'today']));
    }

    public function createBankDeposit()
    {
        $coa                = coa::with('coa_category')->where('coa_category_id', 3)->get();
        $contact            = contact::get();
        $expenses           = coa::get();
        $taxes              = other_tax::get();
        $today              = Carbon::today()->toDateString();
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = cashbank::where('bank_deposit', 1)->latest()->first();
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
            $number             = cashbank::where('bank_deposit', 1)->max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }

        return view('admin.cashbank.createBankDeposit', compact(['coa', 'trans_no', 'today', 'taxes', 'contact', 'expenses']));
    }

    public function createBankWithdrawalAccount()
    {
        $coa                = coa::with('coa_category')->where('coa_category_id', 3)->get();
        $contact            = contact::get();
        $expenses           = coa::get();
        $taxes              = other_tax::get();
        $today              = Carbon::today()->toDateString();
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = cashbank::where('bank_withdrawal_acc', 1)->latest()->first();
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
            $number             = cashbank::where('bank_withdrawal_acc', 1)->max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }

        return view('admin.cashbank.createBankWithdrawalAccount', compact(['coa', 'trans_no', 'today', 'taxes', 'contact', 'expenses']));
    }

    /*public function createBankWithdrawalExpense()
    {
        $coa            = coa::with('coa_category')->where('coa_category_id', 3)->get();
        $contact        = contact::get();
        $expenses       = expense::where('status', 1)->get();
        $taxes          = other_tax::get();
        $number         = cashbank::where('bank_withdrawal', 1)->latest()->first();
        $today          = Carbon::today()->toDateString();
        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;

        return view('admin.cashbank.createBankWithdrawalExpense', compact(['coa', 'trans_no', 'today', 'taxes', 'contact', 'expenses']));
    }*/

    public function createBankWithdrawalFromExpense($id)
    {
        $coa                = coa::with('coa_category')->where('coa_category_id', 3)->get();
        $contact            = contact::get();
        $expenses           = expense::find($id);
        $today              = Carbon::today()->toDateString();
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = cashbank::where('bank_withdrawal_ex', 1)->latest()->first();
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
            $number             = cashbank::where('bank_withdrawal_ex', 1)->max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }

        return view('admin.cashbank.createBankWithdrawalFromExpense', compact(['coa', 'trans_no', 'today', 'contact', 'expenses']));
    }

    public function storeBankTransfer(Request $request)
    {
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = cashbank::where('bank_transfer', 1)->latest()->first();
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
            $number             = cashbank::where('bank_transfer', 1)->max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }
        $rules = array(
            'amount'                   => 'required',
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
                'number_complete'               => 'Bank Transfer #' . $trans_no,
                'type'                          => 'banktransfer',
                'memo'                          => $request->get('memo'),
                'status'                        => 2,
                'balance_due'                   => 0,
                'total'                         => $request->get('amount'),
            ]);

            $ex                                 = new cashbank([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'bank_transfer'                 => 1,
                'date'                          => $request->get('trans_date'),
                'number'                        => $trans_no,
                'transfer_from'                 => $request->get('transfer_from'),
                'deposit_to'                    => $request->get('deposit_to'),
                'memo'                          => $request->get('memo'),
                'amount'                        => $request->get('amount'),
                'status'                        => 2,
            ]);
            $transactions->cashbank()->save($ex);
            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $ex->id,
            ]);
            // CREATE COA DETAIL YANG DEPOSIT TO (DEBIT)
            coa_detail::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'coa_id'                        => $request->deposit_to,
                'date'                          => $request->get('trans_date'),
                'type'                          => 'banktransfer',
                'number'                        => 'Bank Transfer #' . $trans_no,
                'debit'                         => $request->get('amount'),
                'credit'                        => 0,
            ]);
            // CREATE COA DETAIL YANG TRANSFER FROM (CREDIT)
            coa_detail::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'coa_id'                        => $request->transfer_from,
                'date'                          => $request->get('trans_date'),
                'type'                          => 'banktransfer',
                'number'                        => 'Bank Transfer #' . $trans_no,
                'debit'                         => 0,
                'credit'                        => $request->get('amount'),
            ]);
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $ex->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function storeBankDeposit(Request $request)
    {
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = cashbank::where('bank_deposit', 1)->latest()->first();
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
            $number             = cashbank::where('bank_deposit', 1)->max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }
        $rules = array(
            'vendor_name'                   => 'required',
            'expense_acc'                   => 'required|array|min:1',
            'expense_acc.*'                 => 'required',
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
            $transactions                       = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'transaction_date'              => $request->get('trans_date'),
                'number'                        => $trans_no,
                'number_complete'               => 'Bank Deposit #' . $trans_no,
                'type'                          => 'bankdeposit',
                'memo'                          => $request->get('memo'),
                'contact'                       => $request->get('vendor_name'),
                'status'                        => 2,
                'balance_due'                   => 0,
                'total'                         => $request->get('balance'),
            ]);

            $ex                                 = new cashbank([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'bank_deposit'                  => 1,
                'date'                          => $request->get('trans_date'),
                'number'                        => $trans_no,
                'deposit_to'                    => $request->get('deposit_to'),
                'contact_id'                    => $request->get('vendor_name'),
                'memo'                          => $request->get('memo'),
                'subtotal'                      => $request->get('subtotal'),
                'taxtotal'                      => $request->get('taxtotal'),
                'amount'                        => $request->get('balance'),
                'status'                        => 2,
            ]);
            $transactions->cashbank()->save($ex);
            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $ex->id,
            ]);
            // CREATE COA DETAIL YANG DEPOSIT TO (DEBIT)
            coa_detail::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'coa_id'                        => $request->deposit_to,
                'type'                          => 'bankdeposit',
                'date'                          => $request->get('trans_date'),
                'number'                        => 'Bank Deposit #' . $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => $request->get('balance'),
                'credit'                        => 0,
            ]);
            $get_current_balance_on_coa         = coa::find($request->deposit_to);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance + $request->get('balance'),
            ]);

            if ($request->taxtotal > 0) {
                $default_tax                    = default_account::find(8);
                coa_detail::create([
                    'company_id'                    => $user->company_id,
                    'user_id'                       => Auth::id(),
                    'coa_id'                    => $default_tax->account_id,
                    'date'                      => $request->get('trans_date'),
                    'type'                      => 'bankdeposit',
                    'number'                    => 'Bank Deposit #' . $trans_no,
                    'contact_id'                => $request->get('vendor_name'),
                    'debit'                     => 0,
                    'credit'                    => $request->get('taxtotal'),
                ]);
                $get_current_balance_on_coa     = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                   => $get_current_balance_on_coa->balance + $request->get('taxtotal'),
                ]);
            }

            // CREATE CASH BANK DETAILS
            foreach ($request->expense_acc as $i => $keys) {
                $pp[$i] = new cashbank_item([
                    'receive_from'              => $request->expense_acc[$i],
                    'desc'                      => $request->desc_acc[$i],
                    'tax_id'                    => $request->tax_acc[$i],
                    'amountsub'                 => $request->total_amount_sub[$i],
                    'amounttax'                 => $request->total_amount_tax[$i],
                    'amountgrand'               => $request->total_amount_grand[$i],
                    'amount'                    => $request->amount_acc[$i],
                ]);
                $ex->cashbank_item()->save($pp[$i]);

                coa_detail::create([
                    'company_id'                    => $user->company_id,
                    'user_id'                       => Auth::id(),
                    'coa_id'                    => $request->expense_acc[$i],
                    'type'                      => 'bankdeposit',
                    'date'                      => $request->get('trans_date'),
                    'number'                    => 'Bank Deposit #' . $trans_no,
                    'contact_id'                => $request->get('vendor_name'),
                    'debit'                     => 0,
                    'credit'                    => $request->amount_acc[$i],
                ]);
                $get_current_balance_on_coa     = coa::find($request->expense_acc[$i]);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                   => $get_current_balance_on_coa->balance + $request->amount_acc[$i],
                ]);
            };
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $ex->id]);
            //return redirect()->route('showDeposit', ['id' => $ex->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function storeBankWithdrawalAccount(Request $request)
    {
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = cashbank::where('bank_withdrawal_acc', 1)->latest()->first();
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
            $number             = cashbank::where('bank_withdrawal_acc', 1)->max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }
        $rules = array(
            'vendor_name'                   => 'required',
            'expense_acc'                   => 'required|array|min:1',
            'expense_acc.*'                 => 'required',
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
            $transactions                       = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'transaction_date'              => $request->get('trans_date'),
                'number'                        => $trans_no,
                'number_complete'               => 'Bank Withdrawal #' . $trans_no,
                'type'                          => 'bankwithdrawalaccount',
                'memo'                          => $request->get('memo'),
                'contact'                       => $request->get('vendor_name'),
                'status'                        => 2,
                'balance_due'                   => 0,
                'total'                         => $request->get('balance'),
            ]);

            $ex                                 = new cashbank([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'bank_withdrawal_acc'           => 1,
                'contact_id'                    => $request->get('vendor_name'),
                'date'                          => $request->get('trans_date'),
                'number'                        => $trans_no,
                'pay_from'                      => $request->get('pay_from'),
                'memo'                          => $request->get('memo'),
                'subtotal'                      => $request->get('subtotal'),
                'taxtotal'                      => $request->get('taxtotal'),
                'amount'                        => $request->get('balance'),
                'status'                        => 2,
            ]);
            $transactions->cashbank()->save($ex);
            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $ex->id,
            ]);
            // CREATE CASH BANK DETAILS
            foreach ($request->expense_acc as $i => $keys) {
                $pp[$i] = new cashbank_item([
                    'receive_from'              => $request->expense_acc[$i],
                    'desc'                      => $request->desc_acc[$i],
                    'tax_id'                    => $request->tax_acc[$i],
                    'amountsub'                 => $request->total_amount_sub[$i],
                    'amounttax'                 => $request->total_amount_tax[$i],
                    'amountgrand'               => $request->total_amount_grand[$i],
                    'amount'                    => $request->amount_acc[$i],
                ]);
                $ex->cashbank_item()->save($pp[$i]);

                coa_detail::create([
                    'company_id'                    => $user->company_id,
                    'user_id'                       => Auth::id(),
                    'coa_id'                    => $request->expense_acc[$i],
                    'type'                      => 'bankwithdrawalaccount',
                    'date'                      => $request->get('trans_date'),
                    'number'                    => 'Bank Withdrawal #' . $trans_no,
                    'contact_id'                => $request->get('vendor_name'),
                    'debit'                     => $request->amount_acc[$i],
                    'credit'                    => 0,
                ]);
                $get_current_balance_on_coa     = coa::find($request->expense_acc[$i]);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                   => $get_current_balance_on_coa->balance + $request->amount_acc[$i],
                ]);
            };
            if ($request->taxtotal > 0) {
                $default_tax                = default_account::find(14);
                coa_detail::create([
                    'company_id'                    => $user->company_id,
                    'user_id'                       => Auth::id(),
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'bankwithdrawalaccount',
                    'number'                => 'Bank Withdrawal #' . $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => $request->get('taxtotal'),
                    'credit'                => 0,
                ]);
                $get_current_balance_on_coa = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'               => $get_current_balance_on_coa->balance + $request->get('taxtotal'),
                ]);
            }
            // CREATE COA DETAIL YANG DEPOSIT TO (DEBIT)
            coa_detail::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'coa_id'                        => $request->pay_from,
                'type'                          => 'bankwithdrawalaccount',
                'date'                          => $request->get('trans_date'),
                'number'                        => 'Bank Withdrawal #' . $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => 0,
                'credit'                        => $request->get('balance'),
            ]);
            $get_current_balance_on_coa         = coa::find($request->pay_from);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance - $request->get('balance'),
            ]);
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $ex->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function storeBankWithdrawalFromExpense(Request $request)
    {
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = cashbank::where('bank_withdrawal_ex', 1)->latest()->first();
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
            $number             = cashbank::where('bank_withdrawal_ex', 1)->max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }
        $rules = array(
            'vendor_name'                       => 'required',
            'amount_acc'                        => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        DB::beginTransaction();
        try {
            if ($request->amount_acc > $request->balance_due) {
                DB::rollBack();
                return response()->json(['errors' => 'Amount cannot be greater than balance!']);
            }

            $get_ex_data                        = expense::find($request->expense_acc);
            if ($request->amount_acc == $request->balance_due) {
                expense::find($request->expense_acc)->update([
                    'amount_paid'               => $get_ex_data->amount_paid + $request->amount_acc,
                    'balance_due'               => $request->balance_due - $request->amount_acc,
                    'status'                    => 3
                ]);
            } else {
                expense::find($request->expense_acc)->update([
                    'amount_paid'               => $get_ex_data->amount_paid + $request->amount_acc,
                    'balance_due'               => $request->balance_due - $request->amount_acc,
                    'status'                    => 4
                ]);
                other_transaction::where('type', 'expense')->where('ref_id', $request->expense_acc)->update([
                    'balance_due'               => $request->balance_due - $request->amount_acc,
                    'status'                    => 4,
                ]);
            }
            $transactions                       = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'transaction_date'              => $request->get('trans_date'),
                'number'                        => $trans_no,
                'number_complete'               => 'Bank Withdrawal #' . $trans_no,
                'type'                          => 'bankwithdrawalfromexpense',
                'memo'                          => $request->get('memo'),
                'contact'                       => $request->get('vendor_name'),
                'status'                        => 2,
                'balance_due'                   => 0,
                'total'                         => $request->get('amount_acc'),
            ]);

            $ex                                 = new cashbank([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'bank_withdrawal_ex'            => 1,
                'contact_id'                    => $request->get('vendor_name'),
                'date'                          => $request->get('trans_date'),
                'number'                        => $trans_no,
                'pay_from'                      => $request->get('pay_from'),
                'memo'                          => $request->get('memo'),
                'amount'                        => $request->get('amount_acc'),
                'status'                        => 2,
            ]);
            $transactions->cashbank()->save($ex);
            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $ex->id,
            ]);
            // CREATE CASH BANK DETAILS
            $pp = new cashbank_item([
                'expense_id'                    => $request->expense_acc,
                'desc'                          => $request->desc_acc,
                'amount'                        => $request->amount_acc,
            ]);
            $ex->cashbank_item()->save($pp);
            // BIKIN COA DETAIL YANG DARI DEFAULT ACCOUNT
            $expense_account_coa_detail         = $request->expense_pay_from;
            coa_detail::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'coa_id'                        => $expense_account_coa_detail,
                'type'                          => 'bankwithdrawalfromexpense',
                'date'                          => $request->get('trans_date'),
                'number'                        => 'Bank Withdrawal #' . $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => $request->amount_acc,
                'credit'                        => 0,
            ]);
            $get_current_balance_on_coa         = coa::find($expense_account_coa_detail);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance + $request->amount_acc,
            ]);
            // CREATE COA DETAIL YANG DEPOSIT TO (DEBIT)
            coa_detail::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'coa_id'                        => $request->pay_from,
                'type'                          => 'bankwithdrawalfromexpense',
                'date'                          => $request->get('trans_date'),
                'number'                        => 'Bank Withdrawal #' . $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => 0,
                'credit'                        => $request->get('amount_acc'),
            ]);
            $get_current_balance_on_coa         = coa::find($request->pay_from);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance - $request->get('amount_acc'),
            ]);
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $ex->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function showBankTransfer($id)
    {
        $caba                       = cashbank::find($id);
        $checknumberpd              = cashbank::whereId($id)->first();
        $numbercoadetail            = 'Bank Transfer #' . $checknumberpd->number;
        $numberothertransaction     = $checknumberpd->number;
        $get_all_detail             = coa_detail::where('number', $numbercoadetail)->where('type', 'banktransfer')->with('coa')->get();
        $total_debit                = $get_all_detail->sum('debit');
        $total_credit               = $get_all_detail->sum('credit');

        return view('admin.cashbank.showBankTransfer', compact(['caba', 'get_all_detail', 'total_debit', 'total_credit']));
    }

    public function showBankDeposit($id)
    {
        $caba                       = cashbank::find($id);
        $caba_details               = cashbank_item::where('cashbank_id', $id)->get();
        $checknumberpd              = cashbank::whereId($id)->first();
        $numbercoadetail            = 'Bank Deposit #' . $checknumberpd->number;
        $numberothertransaction     = $checknumberpd->number;
        $get_all_detail             = coa_detail::where('number', $numbercoadetail)->where('type', 'bankdeposit')->with('coa')->get();
        $total_debit                = $get_all_detail->sum('debit');
        $total_credit               = $get_all_detail->sum('credit');

        return view('admin.cashbank.showBankDeposit', compact(['caba', 'caba_details', 'get_all_detail', 'total_debit', 'total_credit']));
    }

    public function showBankWithdrawal($id)
    {
        $caba                           = cashbank::find($id);
        if ($caba->bank_withdrawal_acc == 1) {
            $caba_details               = cashbank_item::where('cashbank_id', $id)->get();
            $checknumberpd              = cashbank::whereId($id)->first();
            $numbercoadetail            = 'Bank Withdrawal #' . $checknumberpd->number;
            $numberothertransaction     = $checknumberpd->number;
            $get_all_detail             = coa_detail::where('number', $numbercoadetail)->where('type', 'bankwithdrawalaccount')->with('coa')->get();
            $total_debit                = $get_all_detail->sum('debit');
            $total_credit               = $get_all_detail->sum('credit');

            return view('admin.cashbank.showBankWithdrawalAccount', compact(['caba', 'caba_details', 'get_all_detail', 'total_debit', 'total_credit']));
        } else if ($caba->bank_withdrawal_ex == 1) {
            $caba_details               = cashbank_item::where('cashbank_id', $id)->get();
            $checknumberpd              = cashbank::whereId($id)->first();
            $numbercoadetail            = 'Bank Withdrawal #' . $checknumberpd->number;
            $numberothertransaction     = $checknumberpd->number;
            $get_all_detail             = coa_detail::where('number', $numbercoadetail)->where('type', 'bankwithdrawalfromexpense')->with('coa')->get();
            $total_debit                = $get_all_detail->sum('debit');
            $total_credit               = $get_all_detail->sum('credit');

            return view('admin.cashbank.showBankWithdrawalExpense', compact(['caba', 'caba_details', 'get_all_detail', 'total_debit', 'total_credit']));
        }
    }

    public function editBankTransfer($id)
    {
        $coa            = coa::with('coa_category')->where('coa_category_id', 3)->get();
        $caba           = cashbank::find($id);

        return view('admin.cashbank.editBankTransfer', compact(['caba', 'coa']));
    }

    public function editBankDeposit($id)
    {
        $coa            = coa::with('coa_category')->where('coa_category_id', 3)->get();
        $caba           = cashbank::find($id);
        $caba_details   = cashbank_item::where('cashbank_id', $id)->get();
        $contact        = contact::get();
        $expenses       = coa::get();
        $taxes          = other_tax::get();

        return view('admin.cashbank.editBankDeposit', compact(['caba', 'coa', 'caba_details', 'contact', 'expenses', 'taxes']));
    }

    public function editBankWithdrawalAccount($id)
    {
        $coa            = coa::with('coa_category')->where('coa_category_id', 3)->get();
        $caba           = cashbank::find($id);
        $caba_details   = cashbank_item::where('cashbank_id', $id)->get();
        $contact        = contact::get();
        $expenses       = coa::get();
        $taxes          = other_tax::get();

        return view('admin.cashbank.editBankWithdrawalAccount', compact(['caba', 'coa', 'caba_details', 'contact', 'expenses', 'taxes']));
    }

    public function editBankWithdrawalExpense($id)
    {
        $coa            = coa::with('coa_category')->where('coa_category_id', 3)->get();
        $caba           = cashbank::find($id);
        $caba_details   = cashbank_item::where('cashbank_id', $id)->get();
        $contact        = contact::get();
        $expenses       = coa::get();
        $taxes          = other_tax::get();

        return view('admin.cashbank.editBankWithdrawalFromExpense', compact(['caba', 'coa', 'caba_details', 'contact', 'expenses', 'taxes']));
    }

    public function updateBankTransfer(Request $request)
    {
        $rules = array(
            'amount'                   => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $id                                 = $request->hidden_id;
            $ambil_amount_coa_detail_sebelumnya = cashbank::find($id);
            other_transaction::where('type', 'banktransfer')->where('number', $ambil_amount_coa_detail_sebelumnya->number)->update([
                'transaction_date'              => $request->get('trans_date'),
                'memo'                          => $request->get('memo'),
                'balance_due'                   => 0,
                'total'                         => $request->get('amount'),
            ]);
            // CHECK DULU ACCOUNT DEPOSIT TO CURRENT SAMA TIDAK SEPERTI YANG PREVIOUS
            if ($request->deposit_to == $ambil_amount_coa_detail_sebelumnya->deposit_to) {
                // ACCOUNT DEPOSIT TO SAMA, BERARTI DELETE DULU BALANCE YANG SEBELUMNYA BARU ABIS TUH DI TAMBAH SAMA YANG BARU
                $get_current_balance_on_coa = coa::find($ambil_amount_coa_detail_sebelumnya->deposit_to);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance - $ambil_amount_coa_detail_sebelumnya->amount,
                ]);
                coa_detail::where('type', 'banktransfer')->where('number', 'Bank Transfer #' . $ambil_amount_coa_detail_sebelumnya->number)->where('credit', 0)->update([
                    'date'                          => $request->get('trans_date'),
                    'debit'                         => $request->get('amount'),
                ]);
                $get_current_balance_on_coa = coa::find($ambil_amount_coa_detail_sebelumnya->deposit_to);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance + $request->get('amount'),
                ]);
            } else {
                // ACCOUNT DEPOSIT TO BEDA, BERARTI DELETE DULU BALANCE YANG SEBELUMNYA BARU ABIS TUH DI TAMBAH SAMA YANG BARU
                $get_current_balance_on_coa = coa::find($ambil_amount_coa_detail_sebelumnya->deposit_to);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance - $ambil_amount_coa_detail_sebelumnya->amount,
                ]);
                coa_detail::where('type', 'banktransfer')->where('number', 'Bank Transfer #' . $ambil_amount_coa_detail_sebelumnya->number)->where('credit', 0)->update([
                    'coa_id'                        => $request->deposit_to,
                    'date'                          => $request->get('trans_date'),
                    'debit'                         => $request->get('amount'),
                ]);
                $get_current_balance_on_coa = coa::find($request->deposit_to);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance + $request->get('amount'),
                ]);
            }
            // CHECK DULU ACCOUNT TRANSFER FROM CURRENT SAMA TIDAK SEPERTI YANG PREVIOUS
            if ($request->transfer_from == $ambil_amount_coa_detail_sebelumnya->transfer_from) {
                // ACCOUNT DEPOSIT TO SAMA, BERARTI DELETE DULU BALANCE YANG SEBELUMNYA BARU ABIS TUH DI TAMBAH SAMA YANG BARU
                $get_current_balance_on_coa = coa::find($ambil_amount_coa_detail_sebelumnya->transfer_from);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance + $ambil_amount_coa_detail_sebelumnya->amount,
                ]);
                coa_detail::where('type', 'banktransfer')->where('number', 'Bank Transfer #' . $ambil_amount_coa_detail_sebelumnya->number)->where('debit', 0)->update([
                    'date'                          => $request->get('trans_date'),
                    'credit'                        => $request->get('amount'),
                ]);
                $get_current_balance_on_coa = coa::find($ambil_amount_coa_detail_sebelumnya->transfer_from);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance - $request->get('amount'),
                ]);
            } else {
                // ACCOUNT DEPOSIT TO BEDA, BERARTI DELETE DULU BALANCE YANG SEBELUMNYA BARU ABIS TUH DI TAMBAH SAMA YANG BARU
                $get_current_balance_on_coa = coa::find($ambil_amount_coa_detail_sebelumnya->transfer_from);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance + $ambil_amount_coa_detail_sebelumnya->amount,
                ]);
                coa_detail::where('type', 'banktransfer')->where('number', 'Bank Transfer #' . $ambil_amount_coa_detail_sebelumnya->number)->where('debit', 0)->update([
                    'coa_id'                        => $request->transfer_from,
                    'date'                          => $request->get('trans_date'),
                    'credit'                        => $request->get('amount'),
                ]);
                $get_current_balance_on_coa = coa::find($request->transfer_from);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance - $request->get('amount'),
                ]);
            }
            // UPDATE CABA DI AKHIR CYCLE SOALNYA BIAR GA KETIBAN SAMA YANG BARU SOALNYA CABA DIPAKE PADA SAAT CYCLE
            cashbank::find($id)->update([
                'date'                          => $request->get('trans_date'),
                'transfer_from'                 => $request->get('transfer_from'),
                'deposit_to'                    => $request->get('deposit_to'),
                'memo'                          => $request->get('memo'),
                'amount'                        => $request->get('amount'),
            ]);
            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function updateBankDeposit(Request $request)
    {
        $user               = User::find(Auth::id());
        $rules = array(
            'vendor_name'                   => 'required',
            'expense_acc'                   => 'required|array|min:1',
            'expense_acc.*'                 => 'required',
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
            $id                                 = $request->hidden_id;
            $ambil_amount_coa_detail_sebelumnya = cashbank::find($id);
            $pp                                 = cashbank_item::where('cashbank_id', $id)->get();
            $rp                                 = $request->expense_acc;
            $default_tax                        = default_account::find(8);
            $caba                               = cashbank::find($id);
            coa_detail::where('type', 'bankdeposit')->where('number', 'Bank Deposit #' . $caba->number)->where('debit', 0)->delete();
            //$debit->delete();
            coa_detail::where('type', 'bankdeposit')->where('number', 'Bank Deposit #' . $caba->number)->where('credit', 0)->delete();
            //$credit->delete();

            // DELETE BALANCE DARI YANG PENGEN DI DELETE (DEPOSIT TO)
            $get_current_balance_on_coa = coa::find($caba->deposit_to);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance - $caba->amount,
            ]);
            // HAPUS PAJAK
            if ($caba->taxtotal > 0) {
                $get_current_balance_on_coa = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'               => $get_current_balance_on_coa->balance - $caba->taxtotal,
                ]);
            }
            // HAPUS BALANCE PER ITEM CASHBANK
            $caba_details       = cashbank_item::where('cashbank_id', $id)->get();
            foreach ($caba_details as $a) {
                $get_current_balance_on_coa = coa::find($a->receive_from);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance - $a->amount,
                ]);
            }
            cashbank_item::where('cashbank_id', $id)->delete();
            // BARU BIKIN LAGI
            other_transaction::where('type', 'bankdeposit')->where('number', $caba->number)->update([
                'transaction_date'              => $request->get('trans_date'),
                'memo'                          => $request->get('memo'),
                'contact'                       => $request->get('vendor_name'),
                'balance_due'                   => 0,
                'total'                         => $request->get('balance'),
            ]);
            cashbank::find($id)->update([
                'date'                          => $request->get('trans_date'),
                'deposit_to'                    => $request->get('deposit_to'),
                'contact_id'                    => $request->get('vendor_name'),
                'memo'                          => $request->get('memo'),
                'subtotal'                      => $request->get('subtotal'),
                'taxtotal'                      => $request->get('taxtotal'),
                'amount'                        => $request->get('balance'),
            ]);
            coa_detail::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'coa_id'                        => $request->deposit_to,
                'type'                          => 'bankdeposit',
                'date'                          => $request->get('trans_date'),
                'number'                        => 'Bank Deposit #' . $caba->number,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => $request->get('balance'),
                'credit'                        => 0,
            ]);
            $get_current_balance_on_coa = coa::find($request->deposit_to);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'       => $get_current_balance_on_coa->balance + $request->get('balance'),
            ]);

            if ($request->taxtotal > 0) {
                $default_tax                = default_account::find(8);
                coa_detail::create([
                    'company_id'                    => $user->company_id,
                    'user_id'                       => Auth::id(),
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'bankdeposit',
                    'number'                => 'Bank Deposit #' . $caba->number,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => 0,
                    'credit'                => $request->get('taxtotal'),
                ]);
                $get_current_balance_on_coa = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'               => $get_current_balance_on_coa->balance + $request->get('taxtotal'),
                ]);
            }
            // CREATE CASH BANK DETAILS
            foreach ($request->expense_acc as $i => $keys) {
                $pp[$i] = new cashbank_item([
                    'receive_from'              => $request->expense_acc[$i],
                    'desc'                      => $request->desc_acc[$i],
                    'tax_id'                    => $request->tax_acc[$i],
                    'amountsub'                 => $request->total_amount_sub[$i],
                    'amounttax'                 => $request->total_amount_tax[$i],
                    'amountgrand'               => $request->total_amount_grand[$i],
                    'amount'                    => $request->amount_acc[$i],
                ]);
                $caba->cashbank_item()->save($pp[$i]);

                coa_detail::create([
                    'company_id'                    => $user->company_id,
                    'user_id'                       => Auth::id(),
                    'coa_id'                    => $request->expense_acc[$i],
                    'type'                      => 'bankdeposit',
                    'date'                      => $request->get('trans_date'),
                    'number'                    => 'Bank Deposit #' . $caba->number,
                    'contact_id'                => $request->get('vendor_name'),
                    'debit'                     => 0,
                    'credit'                    => $request->amount_acc[$i],
                ]);
                $get_current_balance_on_coa = coa::find($request->expense_acc[$i]);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'       => $get_current_balance_on_coa->balance + $request->amount_acc[$i],
                ]);
            };
            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function updateBankWithdrawalAccount(Request $request)
    {
        $user               = User::find(Auth::id());
        $rules = array(
            'vendor_name'                   => 'required',
            'expense_acc'                   => 'required|array|min:1',
            'expense_acc.*'                 => 'required',
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
            $id                                 = $request->hidden_id;
            $ambil_amount_coa_detail_sebelumnya = cashbank::find($id);
            $pp                                 = cashbank_item::where('cashbank_id', $id)->get();
            $rp                                 = $request->expense_acc;
            $default_tax                                        = default_account::find(14);
            other_transaction::where('type', 'bankwithdrawalaccount')->where('number', $ambil_amount_coa_detail_sebelumnya->number)->update([
                'transaction_date'              => $request->get('trans_date'),
                'memo'                          => $request->get('memo'),
                'contact'                       => $request->get('vendor_name'),
                'balance_due'                   => 0,
                'total'                         => $request->get('balance'),
            ]);
            cashbank::find($id)->update([
                'date'                          => $request->get('trans_date'),
                'deposit_to'                    => $request->get('deposit_to'),
                'contact_id'                    => $request->get('vendor_name'),
                'memo'                          => $request->get('memo'),
                'subtotal'              => $request->get('subtotal'),
                'taxtotal'              => $request->get('taxtotal'),
                'amount'                        => $request->get('balance'),
            ]);
            if ($ambil_amount_coa_detail_sebelumnya->pay_from == $request->deposit_to) {
                $get_current_balance_on_coa = coa::find($request->deposit_to); // CASH 1
                // NGURANGIN AMOUNT YANG SEBELUMNYA ABIS TUH LANGSUNG DI UPDATE PAKE YANG BARU, SOALNYA KAN GA BERUBAH YANG DEPOSIT TO NYA
                coa::find($get_current_balance_on_coa->id)->update([ // 1
                    'balance'           => ($get_current_balance_on_coa->balance + $ambil_amount_coa_detail_sebelumnya->amount) - $request->get('balance'),
                ]);                                     // (2 - 2) + 4 = 4
                // UPDATE COA DETAIL YANG DEPOSIT TO
                coa_detail::where('type', 'bankwithdrawalaccount')->where('number', 'Bank Withdrawal #' . $ambil_amount_coa_detail_sebelumnya->number)->where('debit', 0)->where('coa_id', $request->deposit_to)->update([
                    'coa_id'                        => $request->deposit_to,
                    'date'                          => $request->get('trans_date'),
                    'contact_id'                    => $request->get('vendor_name'),
                    'credit'                        => $request->get('balance'),
                ]);
            } else {
                $get_current_balance_on_coa = coa::find($ambil_amount_coa_detail_sebelumnya->pay_from);
                // NGURANGIN AMOUNT YANG SEBELUMNYA ABIS TUH LANGSUNG DI UPDATE PAKE YANG BARU, SOALNYA KAN GA BERUBAH YANG DEPOSIT TO NYA
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'           => $get_current_balance_on_coa->balance + $ambil_amount_coa_detail_sebelumnya->amount,
                ]);
                // UPDATE COA DETAIL YANG DEPOSIT TO
                coa_detail::where('type', 'bankwithdrawalaccount')->where('number', 'Bank Withdrawal #' . $ambil_amount_coa_detail_sebelumnya->number)->where('debit', 0)->where('coa_id', $ambil_amount_coa_detail_sebelumnya->pay_from)->update([
                    'coa_id'                        => $request->deposit_to,
                    'date'                          => $request->get('trans_date'),
                    'contact_id'                    => $request->get('vendor_name'),
                    'credit'                        => $request->get('balance'),
                ]);
                $get_current_balance_on_coa = coa::find($request->deposit_to);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'           => $get_current_balance_on_coa->balance - $request->get('balance'),
                ]);
            }
            // HAPUS PAJAK
            if ($ambil_amount_coa_detail_sebelumnya->taxtotal > 0) {
                $get_current_balance_on_coa = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'               => $get_current_balance_on_coa->balance - $ambil_amount_coa_detail_sebelumnya->taxtotal,
                ]);
                coa_detail::where('type', 'bankwithdrawalaccount')
                    ->where('number', 'Bank Withdrawal #' . $ambil_amount_coa_detail_sebelumnya->number)
                    ->where('credit', 0)
                    ->where('coa_id', $default_tax->account_id)
                    ->update([
                        'coa_id'                => $default_tax->account_id,
                        'date'                  => $request->get('trans_date'),
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $request->get('taxtotal'),
                        'credit'                => 0,
                    ]);
                $get_current_balance_on_coa = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'               => $get_current_balance_on_coa->balance + $request->get('taxtotal'),
                ]);
            }
            //UNTUK UPDATE DATA JIKA BANYAKNYA TETAP
            if (count($rp) == count($pp)) {
                foreach ($request->expense_acc as $i => $keys) {
                    if ($pp[$i]->receive_from == $request->expense_acc[$i]) {
                        $ambil_amount_coa_detail_sebelumnya_dalem   = cashbank_item::where('cashbank_id', $id)->where('receive_from', $request->expense_acc[$i])->first();
                        // UPDATE DULU BALANCE COA-NYA YANG DARI SEBELUMNYA, ABIS TUH BARU UPDATE PAKE BALANCE COA YANG BARU
                        $get_current_balance_on_coa = coa::find($request->expense_acc[$i]);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'       => $get_current_balance_on_coa->balance - $ambil_amount_coa_detail_sebelumnya_dalem->amount,
                        ]);
                        // UPDATE CASH BANK ITEMNYA
                        $pp[$i]->update([
                            'receive_from'              => $request->expense_acc[$i],
                            'desc'                      => $request->desc_acc[$i],
                            'tax_id'                    => $request->tax_acc[$i],
                            'amountsub'                 => $request->total_amount_sub[$i],
                            'amounttax'                 => $request->total_amount_tax[$i],
                            'amountgrand'               => $request->total_amount_grand[$i],
                            'amount'                    => $request->amount_acc[$i],
                        ]);
                        // UPDATE PAKE COA DETAIL YANG BARU, SOALNYA KAN KALI AJA ITEMNYA DI GANTI MAKANYA PAKE CARA YANG INI
                        coa_detail::where('type', 'bankwithdrawalaccount')->where('number', 'Bank Withdrawal #' . $ambil_amount_coa_detail_sebelumnya->number)->where('credit', 0)->where('coa_id', $request->expense_acc[$i])->update([
                            'coa_id'                    => $request->expense_acc[$i],
                            'date'                      => $request->get('trans_date'),
                            'contact_id'                => $request->get('vendor_name'),
                            'debit'                     => $request->amount_acc[$i],
                        ]);
                        $get_current_balance_on_coa = coa::find($request->expense_acc[$i]);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'       => $get_current_balance_on_coa->balance + $request->amount_acc[$i],
                        ]);
                    } else {
                        //$ambil_amount_coa_detail_sebelumnya_dalem   = cashbank_item::where('cashbank_id', $id)->where('receive_from', $request->expense_acc[$i])->first();
                        // KURANGIN DULU BALANCE COA DARI YANG SEBELUMNYA
                        $get_current_balance_on_coa = coa::find($pp[$i]->receive_from); // 4
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'       => $get_current_balance_on_coa->balance - $pp[$i]->amount,  // 1 + (-1) = 0
                        ]);
                        // UPDATE PAKE COA DETAIL YANG BARU, SOALNYA KAN KALI AJA ITEMNYA DI GANTI MAKANYA PAKE CARA YANG INI                                       4
                        coa_detail::where('type', 'bankwithdrawalaccount')->where('number', 'Bank Withdrawal #' . $ambil_amount_coa_detail_sebelumnya->number)->where('credit', 0)->where('coa_id', $pp[$i]->receive_from)->update([
                            'coa_id'                    => $request->expense_acc[$i], // 6
                            'date'                      => $request->get('trans_date'),
                            'contact_id'                => $request->get('vendor_name'),
                            'debit'                     => $request->amount_acc[$i], // 2
                        ]);
                        $get_current_balance_on_coa = coa::find($request->expense_acc[$i]); // 6
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'       => $get_current_balance_on_coa->balance + $request->amount_acc[$i], // 0 - 2 = (-2)
                        ]);
                        // UPDATE CASH BANK ITEMNYA
                        $pp[$i]->update([
                            'receive_from'              => $request->expense_acc[$i], // 6
                            'desc'                      => $request->desc_acc[$i],
                            'tax_id'                    => $request->tax_acc[$i],
                            'amountsub'                 => $request->total_amount_sub[$i],
                            'amounttax'                 => $request->total_amount_tax[$i],
                            'amountgrand'               => $request->total_amount_grand[$i],
                            'amount'                    => $request->amount_acc[$i],
                        ]);
                    }
                }
                DB::commit();
                return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
            }
            //UNTUK UPDATE DATA JIKA BERTAMBAH
            else if (count($rp) > count($pp)) {
                //UPDATE DATA SEBANYAK INDEX AWAL
                for ($i = 0; $i < count($pp); $i++) {
                    if ($pp[$i]->receive_from == $request->expense_acc[$i]) {
                        $ambil_amount_coa_detail_sebelumnya_dalem   = cashbank_item::where('cashbank_id', $id)->where('receive_from', $request->expense_acc[$i])->first();
                        // UPDATE DULU BALANCE COA-NYA YANG DARI SEBELUMNYA, ABIS TUH BARU UPDATE PAKE BALANCE COA YANG BARU
                        $get_current_balance_on_coa = coa::find($request->expense_acc[$i]);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'       => $get_current_balance_on_coa->balance - $ambil_amount_coa_detail_sebelumnya_dalem->amount,
                        ]);
                        // UPDATE CASH BANK ITEMNYA
                        $pp[$i]->update([
                            'receive_from'              => $request->expense_acc[$i],
                            'desc'                      => $request->desc_acc[$i],
                            'tax_id'                    => $request->tax_acc[$i],
                            'amountsub'                 => $request->total_amount_sub[$i],
                            'amounttax'                 => $request->total_amount_tax[$i],
                            'amountgrand'               => $request->total_amount_grand[$i],
                            'amount'                    => $request->amount_acc[$i],
                        ]);
                        // UPDATE PAKE COA DETAIL YANG BARU, SOALNYA KAN KALI AJA ITEMNYA DI GANTI MAKANYA PAKE CARA YANG INI
                        coa_detail::where('type', 'bankwithdrawalaccount')->where('number', 'Bank Withdrawal #' . $ambil_amount_coa_detail_sebelumnya->number)->where('credit', 0)->where('coa_id', $request->expense_acc[$i])->update([
                            'coa_id'                    => $request->expense_acc[$i],
                            'date'                      => $request->get('trans_date'),
                            'contact_id'                => $request->get('vendor_name'),
                            'debit'                     => $request->amount_acc[$i],
                        ]);
                        $get_current_balance_on_coa = coa::find($request->expense_acc[$i]);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'       => $get_current_balance_on_coa->balance + $request->amount_acc[$i],
                        ]);
                    } else {
                        //$ambil_amount_coa_detail_sebelumnya_dalem   = cashbank_item::where('cashbank_id', $id)->where('receive_from', $request->expense_acc[$i])->first();
                        // KURANGIN DULU BALANCE COA DARI YANG SEBELUMNYA
                        $get_current_balance_on_coa = coa::find($pp[$i]->receive_from); // 4
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'       => $get_current_balance_on_coa->balance - $pp[$i]->amount,  // 1 + (-1) = 0
                        ]);
                        // UPDATE PAKE COA DETAIL YANG BARU, SOALNYA KAN KALI AJA ITEMNYA DI GANTI MAKANYA PAKE CARA YANG INI                                       4
                        coa_detail::where('type', 'bankwithdrawalaccount')->where('number', 'Bank Withdrawal #' . $ambil_amount_coa_detail_sebelumnya->number)->where('credit', 0)->where('coa_id', $pp[$i]->receive_from)->update([
                            'coa_id'                    => $request->expense_acc[$i], // 6
                            'date'                      => $request->get('trans_date'),
                            'contact_id'                => $request->get('vendor_name'),
                            'debit'                     => $request->amount_acc[$i], // 2
                        ]);
                        $get_current_balance_on_coa = coa::find($request->expense_acc[$i]); // 6
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'       => $get_current_balance_on_coa->balance + $request->amount_acc[$i], // 0 - 2 = (-2)
                        ]);
                        // UPDATE CASH BANK ITEMNYA
                        $pp[$i]->update([
                            'receive_from'              => $request->expense_acc[$i], // 6
                            'desc'                      => $request->desc_acc[$i],
                            'tax_id'                    => $request->tax_acc[$i],
                            'amountsub'                 => $request->total_amount_sub[$i],
                            'amounttax'                 => $request->total_amount_tax[$i],
                            'amountgrand'               => $request->total_amount_grand[$i],
                            'amount'                    => $request->amount_acc[$i],
                        ]);
                    }
                }
                //KEMUDIAN MEMBUAT DATA SEBANYAK INDEX BARU
                for ($i = count($pp); $i < count($rp); $i++) {
                    $pp[$i] = new cashbank_item([
                        'receive_from'              => $request->expense_acc[$i],
                        'desc'                      => $request->desc_acc[$i],
                        'tax_id'                    => $request->tax_acc[$i],
                        'amountsub'                 => $request->total_amount_sub[$i],
                        'amounttax'                 => $request->total_amount_tax[$i],
                        'amountgrand'               => $request->total_amount_grand[$i],
                        'amount'                    => $request->amount_acc[$i],
                    ]);
                    $ambil_amount_coa_detail_sebelumnya->cashbank_item()->save($pp[$i]);

                    coa_detail::create([
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'                    => $request->expense_acc[$i],
                        'type'                      => 'bankwithdrawalaccount',
                        'date'                      => $request->get('trans_date'),
                        'number'                    => 'Bank Withdrawal #' . $ambil_amount_coa_detail_sebelumnya->number,
                        'contact_id'                => $request->get('vendor_name'),
                        'debit'                     => $request->amount_acc[$i],
                        'credit'                    => 0,
                    ]);
                    $get_current_balance_on_coa = coa::find($request->expense_acc[$i]);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'       => $get_current_balance_on_coa->balance + $request->amount_acc[$i],
                    ]);
                };
                DB::commit();
                return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
            }
            //UNTUK UPDATA DATA JIKA BERKURANG
            else if (count($rp) < count($pp)) {
                for ($i = count($rp); $i < count($pp); $i++) {
                    for ($j = 0; $j < count($pp); $j++) {
                        if (isset($pp[$j]->receive_from) == isset($request->expense_acc[$j])) {
                            if ($pp[$j]->receive_from == $request->expense_acc[$j]) {
                                $ambil_amount_coa_detail_sebelumnya_dalem   = cashbank_item::where('cashbank_id', $id)->where('receive_from', $request->expense_acc[$j])->first();
                                // UPDATE DULU BALANCE COA-NYA YANG DARI SEBELUMNYA, ABIS TUH BARU UPDATE PAKE BALANCE COA YANG BARU
                                $get_current_balance_on_coa = coa::find($request->expense_acc[$j]);
                                coa::find($get_current_balance_on_coa->id)->update([
                                    'balance'       => $get_current_balance_on_coa->balance - $ambil_amount_coa_detail_sebelumnya_dalem->amount,
                                ]);
                                // UPDATE CASH BANK ITEMNYA
                                $pp[$j]->update([
                                    'receive_from'              => $request->expense_acc[$j],
                                    'desc'                      => $request->desc_acc[$j],
                                    'tax_id'                    => $request->tax_acc[$j],
                                    'amountsub'                 => $request->total_amount_sub[$j],
                                    'amounttax'                 => $request->total_amount_tax[$j],
                                    'amountgrand'               => $request->total_amount_grand[$j],
                                    'amount'                    => $request->amount_acc[$j],
                                ]);
                                // UPDATE PAKE COA DETAIL YANG BARU, SOALNYA KAN KALI AJA ITEMNYA DI GANTI MAKANYA PAKE CARA YANG INI
                                coa_detail::where('type', 'bankwithdrawalaccount')->where('number', 'Bank Withdrawal #' . $ambil_amount_coa_detail_sebelumnya->number)->where('credit', 0)->where('coa_id', $request->expense_acc[$j])->update([
                                    'coa_id'                    => $request->expense_acc[$j],
                                    'date'                      => $request->get('trans_date'),
                                    'contact_id'                => $request->get('vendor_name'),
                                    'debit'                     => $request->amount_acc[$j],
                                ]);
                                $get_current_balance_on_coa = coa::find($request->expense_acc[$j]);
                                coa::find($get_current_balance_on_coa->id)->update([
                                    'balance'       => $get_current_balance_on_coa->balance + $request->amount_acc[$j],
                                ]);
                            } else {
                                //$ambil_amount_coa_detail_sebelumnya_dalem   = cashbank_item::where('cashbank_id', $jd)->where('receive_from', $request->expense_acc[$j])->first();
                                // KURANGIN DULU BALANCE COA DARI YANG SEBELUMNYA
                                $get_current_balance_on_coa = coa::find($pp[$j]->receive_from); // 4
                                coa::find($get_current_balance_on_coa->id)->update([
                                    'balance'       => $get_current_balance_on_coa->balance - $pp[$j]->amount,  // 1 + (-1) = 0
                                ]);
                                // UPDATE PAKE COA DETAIL YANG BARU, SOALNYA KAN KALI AJA ITEMNYA DI GANTI MAKANYA PAKE CARA YANG INI                                       4
                                coa_detail::where('type', 'bankwithdrawalaccount')->where('number', 'Bank Withdrawal #' . $ambil_amount_coa_detail_sebelumnya->number)->where('credit', 0)->where('coa_id', $pp[$j]->receive_from)->update([
                                    'coa_id'                    => $request->expense_acc[$j], // 6
                                    'date'                      => $request->get('trans_date'),
                                    'contact_id'                => $request->get('vendor_name'),
                                    'debit'                     => $request->amount_acc[$j], // 2
                                ]);
                                $get_current_balance_on_coa = coa::find($request->expense_acc[$j]); // 6
                                coa::find($get_current_balance_on_coa->id)->update([
                                    'balance'       => $get_current_balance_on_coa->balance + $request->amount_acc[$j], // 0 - 2 = (-2)
                                ]);
                                // UPDATE CASH BANK ITEMNYA
                                $pp[$j]->update([
                                    'receive_from'              => $request->expense_acc[$j], // 6
                                    'desc'                      => $request->desc_acc[$j],
                                    'tax_id'                    => $request->tax_acc[$j],
                                    'amountsub'                 => $request->total_amount_sub[$j],
                                    'amounttax'                 => $request->total_amount_tax[$j],
                                    'amountgrand'               => $request->total_amount_grand[$j],
                                    'amount'                    => $request->amount_acc[$j],
                                ]);
                            }
                        } else {
                            // DELETE CREDITNYA
                            $credit             = coa_detail::where('type', 'bankwithdrawalaccount')
                                ->where('number', 'Bank Withdrawal #' . $ambil_amount_coa_detail_sebelumnya->number)
                                ->where('credit', 0)
                                ->where('coa_id', $pp[$j]->receive_from)
                                ->first();
                            $credit->delete();
                            // TAMBAHIN BALANCE DARI YANG PENGEN DI DELETE (TRANSFER FROM)
                            $get_current_balance_on_coa = coa::find($pp[$j]->receive_from);
                            coa::find($get_current_balance_on_coa->id)->update([
                                'balance'                       => $get_current_balance_on_coa->balance - $pp[$j]->amount,
                            ]);
                            // FINALLY DELETE THE CASHBANK ID
                            $pp[$j]->delete();
                        }
                    }
                };
                DB::commit();
                return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function updateBankWithdrawalFromExpense(Request $request)
    {
        $rules = array(
            'vendor_name'                       => 'required',
            'amount_acc'                        => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $id                                 = $request->hidden_id;
            $ambil_amount_coa_detail_sebelumnya = cashbank::find($id);
            // AMBIL TOTAL AMOUNT PAID SELAIN CURRENT ID
            $total_amount_paid_except_current   = cashbank_item::where('cashbank_id', '!=', $id)->where('expense_id', $request->expense_acc)->sum('amount');
            $check_total                        = $request->grandtotal - $total_amount_paid_except_current;
            // NGECEK DULU APAKAH AMOUNTNYA LEBIH DARI GRANDTOTAL APA GA
            if ($request->amount_acc > $check_total) {
                DB::rollBack();
                return response()->json(['errors' => 'Amount cannot be greater than balance!']);
            }
            // AMBIL EXPENSE DATA BUAT UPDATE BALANCE DAN STATUS PADA EXPENSE TERSEBUT
            if ($request->amount_acc == $check_total) {
                expense::find($request->expense_acc)->update([
                    'amount_paid'               => $request->grandtotal,
                    'balance_due'               => 0,
                    'status'                    => 3,
                ]);
                other_transaction::where('type', 'expense')->where('ref_id', $request->expense_acc)->update([
                    'balance_due'               => 0,
                    'status'                    => 3,
                ]);
                // KALAU AMOUNT ITU KURANG DARI GRANDTOTAL
            } else {
                expense::find($request->expense_acc)->update([
                    'amount_paid'               => $total_amount_paid_except_current + $request->amount_acc,
                    'balance_due'               => $check_total - $request->amount_acc,
                    'status'                    => 4,
                ]);
                other_transaction::where('type', 'expense')->where('ref_id', $request->expense_acc)->update([
                    'balance_due'               => $check_total - $request->amount_acc,
                    'status'                    => 4,
                ]);
            }
            // UPDATE OTHER TRANSACTION
            other_transaction::where('type', 'bankwithdrawalfromexpense')->where('number', $ambil_amount_coa_detail_sebelumnya->number)->update([
                'transaction_date'              => $request->get('trans_date'),
                'memo'                          => $request->get('memo'),
                'contact'                       => $request->get('vendor_name'),
                'balance_due'                   => 0,
                'total'                         => $request->get('amount_acc'),
            ]);
            // UPDATE CABA DETAILS
            cashbank_item::where('cashbank_id', $id)->update([
                'desc'                          => $request->desc_acc,
                'amount'                        => $request->amount_acc,
            ]);
            // UPDATE COA DETAIL YANG DARI EXPENSE CONTACT (DEBIT)
            $expense_account_coa_detail         = $request->expense_pay_from;
            coa_detail::where('type', 'bankwithdrawalfromexpense')->where('number', 'Bank Withdrawal #' . $ambil_amount_coa_detail_sebelumnya->number)->where('credit', 0)->where('coa_id', $expense_account_coa_detail)->update([
                'date'                          => $request->get('trans_date'),
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => $request->get('amount_acc'),
            ]);
            $get_current_balance_on_coa         = coa::find($expense_account_coa_detail);
            $get_current_caba_data              = cashbank::find($id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance + ($request->amount_acc - $get_current_caba_data->amount),
            ]);
            // UPDATE COA DETAIL YANG DARI INPUT PAY FROM (CREDIT) KALAU SAMA TIDAK USAH UPDATE COA_ID LAGI TINGGAL UPDATE YANG LAINNYA SAJA
            if ($request->pay_from == $get_current_caba_data->pay_from) {
                // UPDATE DULU BALANCE YANG DARI SEBELUMNYA
                $get_current_balance_on_coa         = coa::find($request->pay_from);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance + $get_current_caba_data->amount,
                ]);
                coa_detail::where('type', 'bankwithdrawalfromexpense')->where('number', 'Bank Withdrawal #' . $ambil_amount_coa_detail_sebelumnya->number)->where('debit', 0)->where('coa_id', $request->pay_from)->update([
                    'date'                          => $request->get('trans_date'),
                    'contact_id'                    => $request->get('vendor_name'),
                    'credit'                        => $request->get('amount_acc'),
                ]);
                $get_current_balance_on_coa         = coa::find($request->pay_from);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance - $request->amount_acc,
                ]);
                // UPDATE COA DETAIL YANG DARI INPUT PAY FROM (CREDIT) KALAU TIDAK SAMA BARU ILANGIN BALANCE DARI PAY_FROM ID SEBELUMNYA ABIS TUH BARU DI TAMBAHIN PAKE YANG BARU
            } else {
                // UPDATE DULU BALANCE YANG DARI SEBELUMNYA
                $get_current_balance_on_coa         = coa::find($get_current_caba_data->pay_from);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance + $get_current_caba_data->amount,
                ]);
                // BARU UPDATE COA DETAIL PAKE YANG BARU
                coa_detail::where('type', 'bankwithdrawalfromexpense')->where('number', 'Bank Withdrawal #' . $ambil_amount_coa_detail_sebelumnya->number)->where('debit', 0)->where('coa_id', $get_current_caba_data->pay_from)->update([
                    'coa_id'                        => $request->pay_from,
                    'date'                          => $request->get('trans_date'),
                    'contact_id'                    => $request->get('vendor_name'),
                    'credit'                        => $request->get('amount_acc'),
                ]);
                // BARY UPDATE BALANCE COA PAKE YANG BARU
                $get_current_balance_on_coa         = coa::find($request->pay_from);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance - $request->get('amount_acc'),
                ]);
            }
            // UPDATE CURRENT CASHBANK
            cashbank::find($id)->update([
                'contact_id'                    => $request->get('vendor_name'),
                'date'                          => $request->get('trans_date'),
                'pay_from'                      => $request->get('pay_from'),
                'memo'                          => $request->get('memo'),
                'amount'                        => $request->get('amount_acc'),
            ]);
            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroyBankTransfer($id)
    {
        DB::beginTransaction();
        try {
            $caba               = cashbank::find($id);
            $debit              = coa_detail::where('type', 'banktransfer')->where('number', 'Bank Transfer #' . $caba->number)->where('debit', 0)->first();
            $debit->delete();
            $credit             = coa_detail::where('type', 'banktransfer')->where('number', 'Bank Transfer #' . $caba->number)->where('credit', 0)->first();
            $credit->delete();

            // TAMBAHIN BALANCE DARI YANG PENGEN DI DELETE (TRANSFER FROM)
            $get_current_balance_on_coa = coa::find($caba->transfer_from);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance + $caba->amount,
            ]);
            // TAMBAHIN BALANCE DARI YANG PENGEN DI DELETE (DEPOSIT TO)
            $get_current_balance_on_coa = coa::find($caba->deposit_to);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance - $caba->amount,
            ]);
            // DELETE ROOT OTHER TRANSACTION
            $other_transaction  = other_transaction::where('type', 'banktransfer')->where('number', $caba->number)->first();
            $other_transaction->delete();
            // FINALLY DELETE THE CASHBANK ID
            $caba->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroyBankDeposit($id)
    {
        DB::beginTransaction();
        try {
            $caba               = cashbank::find($id);
            $default_tax                        = default_account::find(8);
            $debit              = coa_detail::where('type', 'bankdeposit')->where('number', 'Bank Deposit #' . $caba->number)->where('debit', 0)->delete();
            //$debit->delete();
            $credit             = coa_detail::where('type', 'bankdeposit')->where('number', 'Bank Deposit #' . $caba->number)->where('credit', 0)->delete();
            //$credit->delete();

            // DELETE BALANCE DARI YANG PENGEN DI DELETE (DEPOSIT TO)
            $get_current_balance_on_coa = coa::find($caba->deposit_to);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance - $caba->amount,
            ]);
            // HAPUS PAJAK
            if ($caba->taxtotal > 0) {
                $get_current_balance_on_coa = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'               => $get_current_balance_on_coa->balance - $caba->taxtotal,
                ]);
            }
            // HAPUS BALANCE PER ITEM CASHBANK
            $caba_details       = cashbank_item::where('cashbank_id', $id)->get();
            foreach ($caba_details as $a) {
                $get_current_balance_on_coa = coa::find($a->receive_from);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance - $a->amount,
                ]);
            }
            $caba_details = cashbank_item::where('cashbank_id', $id)->delete();
            // DELETE ROOT OTHER TRANSACTION
            $other_transaction  = other_transaction::where('type', 'bankdeposit')->where('number', $caba->number)->delete();
            $other_transaction->delete();
            // FINALLY DELETE THE CASHBANK ID
            $caba->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroyBankWithdrawal($id)
    {
        DB::beginTransaction();
        try {
            $caba                                   = cashbank::find($id);
            $default_tax                            = default_account::find(14);
            $default_trade_payable                  = default_account::find(16);
            if ($caba->bank_withdrawal_acc == 1) {
                coa_detail::where('type', 'bankwithdrawalaccount')->where('number', 'Bank Withdrawal #' . $caba->number)->where('debit', 0)->delete();
                coa_detail::where('type', 'bankwithdrawalaccount')->where('number', 'Bank Withdrawal #' . $caba->number)->where('credit', 0)->delete();
                // DELETE BALANCE DARI YANG PENGEN DI DELETE (DEPOSIT TO)
                $get_current_balance_on_coa = coa::find($caba->pay_from);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance + $caba->amount,
                ]);
                // HAPUS PAJAK
                if ($caba->taxtotal > 0) {
                    $get_current_balance_on_coa = coa::find($default_tax->account_id);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $caba->taxtotal,
                    ]);
                }
                // HAPUS BALANCE PER ITEM CASHBANK
                $caba_details                       = cashbank_item::where('cashbank_id', $id)->get();
                foreach ($caba_details as $a) {
                    $get_current_balance_on_coa = coa::find($a->receive_from);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'                   => $get_current_balance_on_coa->balance - $a->amount,
                    ]);
                }
                $caba_details                       = cashbank_item::where('cashbank_id', $id)->delete();
                // DELETE ROOT OTHER TRANSACTION
                other_transaction::where('type', 'bankwithdrawalfromexpense')->where('number', $caba->number)->delete();
                // FINALLY DELETE THE CASHBANK ID
                $caba->delete();

                return response()->json(['success' => 'Data is successfully deleted']);
            } else if ($caba->bank_withdrawal_ex == 1) {
                coa_detail::where('type', 'bankwithdrawalfromexpense')->where('number', 'Bank Withdrawal #' . $caba->number)->where('debit', 0)->delete();
                coa_detail::where('type', 'bankwithdrawalfromexpense')->where('number', 'Bank Withdrawal #' . $caba->number)->where('credit', 0)->delete();
                // DELETE BALANCE DARI YANG PENGEN DI DELETE (DEPOSIT TO)
                $get_current_balance_on_coa = coa::find($caba->pay_from);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance + $caba->amount,
                ]);
                // HAPUS BALANCE PER ITEM CASHBANK
                $caba_details                   = cashbank_item::where('cashbank_id', $id)->get();
                foreach ($caba_details as $a) {
                    $get_current_balance_on_coa = coa::find($default_trade_payable->account_id);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'                       => $get_current_balance_on_coa->balance - $a->amount,
                    ]);
                    $get_ex_data                = expense::find($a->expense_id);
                    expense::find($a->expense_id)->update([
                        'amount_paid'                   => $get_ex_data->amount_paid - $a->amount,
                        'balance_due'                   => $get_ex_data->balance_due + $a->amount,
                    ]);
                }
                foreach ($caba_details as $a) {
                    $get_ex_data                = expense::find($a->expense_id);
                    if ($get_ex_data->amount_paid == 0) {
                        expense::find($a->expense_id)->update([
                            'status'                   => 1,
                        ]);
                    } else if ($get_ex_data->amount_paid == $get_ex_data->grandtotal) {
                        expense::find($a->expense_id)->update([
                            'status'                   => 3,
                        ]);
                    } else {
                        expense::find($a->expense_id)->update([
                            'status'                   => 4,
                        ]);
                    }
                }
                $caba_details = cashbank_item::where('cashbank_id', $id)->delete();
                // DELETE ROOT OTHER TRANSACTION
                other_transaction::where('type', 'bankwithdrawalfromexpense')->where('number', $caba->number)->delete();
                // FINALLY DELETE THE CASHBANK ID
                $caba->delete();
                DB::commit();
                return response()->json(['success' => 'Data is successfully deleted']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function cetak_pdfBankDeposit($id)
    {
        $pp                         = cashbank::find($id);
        $pp_item                    = cashbank_item::where('cashbank_id', $id)->get();
        $today                      = Carbon::today()->toDateString();
        $pdf = PDF::loadview('admin.cashbank.printBankDeposit', compact(['pp', 'pp_item', 'today']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdfBankWithdrawal($id)
    {
        $pp                         = cashbank::find($id);
        if ($pp->bank_withdrawal_acc == 1) {
            $pp_item                    = cashbank_item::where('cashbank_id', $id)->get();
            $today                      = Carbon::today()->toDateString();
            $pdf = PDF::loadview('admin.cashbank.printBankWithdrawalAccount', compact(['pp', 'pp_item', 'today']))->setPaper('a4', 'portrait');
            return $pdf->stream();
        } else if ($pp->bank_withdrawal_ex == 1) {
            $pp_item                    = cashbank_item::where('cashbank_id', $id)->get();
            $today                      = Carbon::today()->toDateString();
            $address                    = cashbank_item::where('cashbank_id', $id)->first();
            $pdf = PDF::loadview('admin.cashbank.printBankWithdrawalExpense', compact(['pp', 'pp_item', 'today', 'address']))->setPaper('a4', 'portrait');
            return $pdf->stream();
        }
    }
}
