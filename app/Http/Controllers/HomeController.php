<?php

namespace App\Http\Controllers;

use App\coa;
use App\coa_detail;
use App\other_transaction;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $day = Carbon::now()->format('d');
        $month = Carbon::now()->addMonth(1)->format('m');
        $year = Carbon::now()->format('Y');
        $i = 1;

        $coa_ap_total = 0;
        $coa_ap    = coa::where('coa_category_id', 8)->get();
        for ($i = 1; $i <= 12; $i++) {
            $coa_ap_debit[$i] = coa_detail::whereIn('coa_id', $coa_ap->pluck('id'))
                ->whereRaw('MONTH(date) = ' . $i)
                ->sum('debit');
            $coa_ap_credit[$i] = coa_detail::whereIn('coa_id', $coa_ap->pluck('id'))
                ->whereRaw('MONTH(date) = ' . $i)
                ->sum('credit');
            $coa_ap_balance[$i] =  $coa_ap_credit[$i] - $coa_ap_debit[$i];
            $coa_ap_total += $coa_ap_balance[$i];
        }

        $coa_ar_total = 0;
        $coa_ar    = coa::where('coa_category_id', 1)->get();
        for ($i = 1; $i <= 12; $i++) {
            $coa_ar_debit[$i] = coa_detail::whereIn('coa_id', $coa_ar->pluck('id'))
                ->whereRaw('MONTH(date) = ' . $i)
                ->sum('debit');
            $coa_ar_credit[$i] = coa_detail::whereIn('coa_id', $coa_ar->pluck('id'))
                ->whereRaw('MONTH(date) = ' . $i)
                ->sum('credit');
            $coa_ar_balance[$i] =  $coa_ar_debit[$i] - $coa_ar_credit[$i];
            $coa_ar_total += $coa_ar_balance[$i];
        }


        $coa_ex    = coa::where('coa_category_id', 16)->get();
        $coa_ex_d  = coa_detail::whereIn('coa_id', $coa_ex->pluck('id'))->get();
        if (isset($coa_ex_d)) {
            foreach ($coa_ex as $i => $k) {
                $coa_ex_debit[$i] = coa_detail::where('coa_id', $k->id)
                    ->sum('debit');
                $coa_ex_credit[$i] = coa_detail::where('coa_id', $k->id)
                    ->sum('credit');

                $coa_ex_balance[$i] =  $coa_ex_debit[$i] - $coa_ex_credit[$i];
            }
        } else {
            $coa_ex_balance = 0;
        }

        rsort($coa_ex_balance);
        $coa_ex_balance = array_slice($coa_ex_balance, 0, 5);
        $coa_ex_id      = coa_detail::whereIn('coa_id', $coa_ex->pluck('id'))
            ->orderBy('debit', 'desc')
            ->take(5)
            ->get();
        //UwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwU//
        $total_primary_income       = coa::whereIn('coa_category_id', [13])->sum('balance');
        $total_primary_income_d     = coa_detail::whereIn('coa_id', [13])->sum('balance');
        $total_cost_of_sales        = coa::whereIn('coa_category_id', [15])->sum('balance');
        $gross_profit               = $total_primary_income - $total_cost_of_sales;

        $total_operational_expense  = coa::whereIn('coa_category_id', [16])->sum('balance');
        $net_operating_income       = $gross_profit - $total_operational_expense;

        $total_other_income         = coa::whereIn('coa_category_id', [14])->sum('balance');

        $total_other_expense        = coa::whereIn('coa_category_id', [17])->sum('balance');
        $net_income                 = $net_operating_income + $total_other_income - $total_other_expense;

        //UwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwU//
        $cash_received_from_cust    = coa_detail::where('coa_id', 4)->sum('credit');
        //$other_current_asset        = coa_detail::where('type', 'bankwithdrawalaccount')->sum('credit');
        $other_current_asset        = coa::whereIn('coa_category_id', [2])->sum('balance');
        $cash_paid_to_supplier      = coa_detail::where('coa_id', 40)->sum('debit');
        $cc_and_current_liability   = coa::whereIn('coa_category_id', [9, 10])
            ->where('id', '!=', 50)
            ->where('id', '!=', 51)
            ->where('id', '!=', 52)
            ->where('id', '!=', 53)
            ->where('id', '!=', 54)
            ->where('id', '!=', 55)
            ->sum('balance');
        $other_income               = coa::whereIn('coa_category_id', [14])->sum('balance');
        $operating_expense          = coa_detail::where('type', 'expense')->sum('debit');
        $net_cash_operating_acti    = $cash_received_from_cust + $other_current_asset - $cash_paid_to_supplier - $cc_and_current_liability + $other_income - $operating_expense;

        $purchase_sale_asset        = coa::whereIn('coa_category_id', [5])->sum('balance');
        $other_investing_asset      = coa::whereIn('coa_category_id', [6])->sum('balance');
        $net_cash_by_investing      = $purchase_sale_asset + $other_investing_asset;

        $repayment_proceed_loan     = coa::whereIn('id', [49, 56])->sum('balance');
        $equity_capital             = coa::whereIn('coa_category_id', [12])->sum('balance');
        $net_cash_finan             = $repayment_proceed_loan + $equity_capital;

        $increase_dec_in_cash       = $net_cash_operating_acti + $net_cash_by_investing + $net_cash_finan;
        $beginning_cash             = 0;
        $ending_cash                = $beginning_cash + $increase_dec_in_cash;
        /*
        $coa    = coa::get();
        foreach($coa_detail as $cd){
            foreach($coa as $c){
                if($cd->coa_id== $c->id){

                }
            }
        }
        dd($coa_detail);        
        */
        //UwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwU//
        $total_sales_invoice = 0;
        $total_purchase_invoice = 0;
        for ($i = 1; $i <= 12; $i++) {
            $sales_invoice[$i] = other_transaction::where('type', 'sales invoice')->whereIn('status', [1, 4])
                ->whereRaw('MONTH(transaction_date) = ' . $i)
                ->sum('balance_due');
            $purchase_invoice[$i] = other_transaction::where('type', 'purchase invoice')->whereIn('status', [1, 4])
                ->whereRaw('MONTH(transaction_date) = ' . $i)
                ->sum('balance_due');

            $total_pay[$i] =  $sales_invoice[$i] + $purchase_invoice[$i];
            $total_sales_invoice += $sales_invoice[$i];
            $total_purchase_invoice += $purchase_invoice[$i];
        }


        return view('admin.index', compact([
            'coa_ap_balance', 'coa_ap_total', 'coa_ar_balance', 'coa_ar_total', 'coa_ex_balance', 'coa_ex_id',
            'net_income', 'ending_cash', 'total_pay', 'total_sales_invoice', 'total_purchase_invoice', 'sales_invoice', 'purchase_invoice'
        ]));
    }
}
