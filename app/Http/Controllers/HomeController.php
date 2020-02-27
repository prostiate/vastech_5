<?php

namespace App\Http\Controllers;

use App\coa;
use App\coa_detail;
use App\other_transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $day                    = Carbon::now()->format('d');
        $month                  = Carbon::now()->addMonth(1)->format('m');
        $year                   = Carbon::now()->format('Y');
        $last_year              = Carbon::now()->subYear()->format('Y');
        $startday_of_year       = Carbon::parse($year)->firstOfYear();
        $lastday_of_year        = Carbon::parse($year)->lastOfYear();
        $startday_of_l_year     = Carbon::parse($last_year)->firstOfYear();
        $lastday_of_l_year      = Carbon::parse($last_year)->lastOfYear();
        $i = 1;

        //UwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwU//
        //                                             BUAT ACCOUNT PAYABLE

        $coa_ap_total = 0;
        $coa_id_ap                         = coa::where('coa_category_id', 8)->get();
        $coa_ap_last_periode_1             = coa_detail::whereIn('coa_id', $coa_id_ap)
            ->whereRaw('YEAR(date) = ' . $last_year)
            ->get();
        $coa_ap_current_periode_1          = coa_detail::whereIn('coa_id', $coa_id_ap)
            ->whereRaw('YEAR(date) = ' . $year)
            ->get();
        for ($i = 1; $i <= 12; $i++) {
            //LAST PERIOD
            $coa_ap_debit_last_periode_1[$i]    = coa_detail::whereIn('coa_id', $coa_id_ap->pluck('id'))
                ->whereRaw('YEAR(date) = ' . $last_year)
                ->whereRaw('MONTH(date) = ' . $i)
                ->sum('debit');
            $coa_ap_credit_last_periode_1[$i]   = coa_detail::whereIn('coa_id', $coa_id_ap->pluck('id'))
                ->whereRaw('YEAR(date) = ' . $last_year)
                ->whereRaw('MONTH(date) = ' . $i)
                ->sum('credit');
            //CURRENT PERIOD
            $coa_ap_debit[$i]   = coa_detail::whereIn('coa_id', $coa_id_ap->pluck('id'))
                ->whereRaw('YEAR(date) = ' . $year)
                ->whereRaw('MONTH(date) = ' . $i)
                ->sum('debit');
            $coa_ap_credit[$i]  = coa_detail::whereIn('coa_id', $coa_id_ap->pluck('id'))
                ->whereRaw('YEAR(date) = ' . $year)
                ->whereRaw('MONTH(date) = ' . $i)
                ->sum('credit');
            //TOTAL CURRENT PERIOD
            $coa_ap_balance_last_year[$i]            =  $coa_ap_credit_last_periode_1[$i] - $coa_ap_debit_last_periode_1[$i];
            $coa_ap_balance[$i]                      =  $coa_ap_credit[$i] - $coa_ap_debit[$i];
            $coa_ap_total                           += $coa_ap_balance[$i];
        }

        //UwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwU//
        //                                             BUAT ACCOUNT RECEIVABLE

        $coa_ar_total = 0;
        $coa_id_ar                         = coa::where('coa_category_id', 1)->get();
        $coa_ar_last_periode_1             = coa_detail::whereIn('coa_id', $coa_id_ar)
            ->whereRaw('YEAR(date) = ' . $last_year)
            ->get();
        $coa_ar_current_periode_1          = coa_detail::whereIn('coa_id', $coa_id_ar)
            ->whereRaw('YEAR(date) = ' . $year)
            ->get();
        for ($i = 1; $i <= 12; $i++) {
            //LAST PERIOD
            $coa_ar_debit_last_periode_1[$i]    = coa_detail::whereIn('coa_id', $coa_id_ar->pluck('id'))
                ->whereRaw('YEAR(date) = ' . $last_year)
                ->whereRaw('MONTH(date) = ' . $i)
                ->sum('debit');
            $coa_ar_credit_last_periode_1[$i]   = coa_detail::whereIn('coa_id', $coa_id_ar->pluck('id'))
                ->whereRaw('YEAR(date) = ' . $last_year)
                ->whereRaw('MONTH(date) = ' . $i)
                ->sum('credit');
            //CURRENT PERIOD
            $coa_ar_debit[$i]   = coa_detail::whereIn('coa_id', $coa_id_ar->pluck('id'))
                ->whereRaw('YEAR(date) = ' . $year)
                ->whereRaw('MONTH(date) = ' . $i)
                ->sum('debit');
            $coa_ar_credit[$i]  = coa_detail::whereIn('coa_id', $coa_id_ar->pluck('id'))
                ->whereRaw('YEAR(date) = ' . $year)
                ->whereRaw('MONTH(date) = ' . $i)
                ->sum('credit');
            //TOTAL CURRENT PERIOD
            $coa_ar_balance_last_year[$i]            =  $coa_ar_debit_last_periode_1[$i] - $coa_ar_credit_last_periode_1[$i];
            $coa_ar_balance[$i]                      =  $coa_ar_debit[$i] - $coa_ar_credit[$i];
            $coa_ar_total                           += $coa_ar_balance[$i];
        }



        //UwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwU//
        //                                             BUAT EXPENSE

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
        //                                              BUAT CASHFLOW
        $iterasi            = 1;
        $total_cash_flow    = 0;

        for ($i = 1; $i <= 24; $i++) {
            if ($i <= 12) {
                $coa_detail                               = coa_detail::whereRaw('YEAR(date) = ' . $last_year)
                    ->whereRaw('MONTH(date) = ' . $i)
                    ->selectRaw('SUM(debit) as debit, SUM(credit) as credit, coa_id, type')
                    ->groupBy('number')
                    ->groupBy('coa_id')
                    ->get();
            } else {
                $coa_detail                               = coa_detail::whereRaw('YEAR(date) = ' . $year)
                    ->whereRaw('MONTH(date) = ' . $iterasi)
                    ->selectRaw('SUM(debit) as debit, SUM(credit) as credit, coa_id, type')
                    ->groupBy('number')
                    ->groupBy('coa_id')
                    ->get();
                $iterasi++;
            }

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
                    $cc_and_current_liability           += $cd->debit - $cd->credit;
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
            $ending_cash[$i]            = $beginning_cash + $increase_dec_in_cash;
            if ($i >= 12)
                $total_cash_flow            +=  $ending_cash[$i];
        }


        //UwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwU//
        //                                                  BUAT ACCOUNT PROFIT & LOSS
        $iterasi_net    = 1;
        $total_profit   = 0;

        for ($i = 1; $i <= 24; $i++) {
            if ($i <= 12) {
                $coa_detail                               = coa_detail::whereRaw('YEAR(date) = ' . $last_year)
                    ->whereRaw('MONTH(date) = ' . $i)
                    ->selectRaw('SUM(debit - credit) as total, coa_id')
                    ->groupBy('number')
                    ->groupBy('coa_id')
                    ->get();
            } else {
                $coa_detail                               = coa_detail::whereRaw('YEAR(date) = ' . $year)
                    ->whereRaw('MONTH(date) = ' . $iterasi_net)
                    ->selectRaw('SUM(debit - credit) as total, coa_id')
                    ->groupBy('number')
                    ->groupBy('coa_id')
                    ->get();
                $iterasi_net++;
            }
            $total_primary_income       = 0;
            foreach ($coa_detail as $cd) {
                if ($cd->coa->coa_category_id == 13) {
                    $total_primary_income                   += abs($cd->total);
                }
            }
            $total_cost_of_sales        = 0;
            foreach ($coa_detail as $cd) {
                if ($cd->coa->coa_category_id == 15) {
                    $total_cost_of_sales                   += $cd->total;
                }
            }
            $gross_profit               = $total_primary_income - $total_cost_of_sales;

            $total_operational_expense  = 0;
            foreach ($coa_detail as $cd) {
                if ($cd->coa->coa_category_id == 16) {
                    $total_operational_expense                   += $cd->total;
                }
            }
            $net_operating_income       = $gross_profit - $total_operational_expense;

            $total_other_income         = 0;
            foreach ($coa_detail as $cd) {
                if ($cd->coa->coa_category_id == 14) {
                    $total_other_income                   += $cd->total;
                }
            }

            $total_other_expense        = 0;
            foreach ($coa_detail as $cd) {
                if ($cd->coa->coa_category_id == 17) {
                    $total_other_expense                   += $cd->total;
                }
            }
            $net_income[$i]                        = $net_operating_income + $total_other_income - $total_other_expense;
            if ($i >= 12)
                $total_profit                          += $net_income[$i];
        }

        //UwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwUUwU//
        //                                                  BUAT SALES RECEIVABLE DAN PAY T
        $total_sales_invoice = 0;
        $total_purchase_invoice = 0;
        for ($i = 1; $i <= 12; $i++) {
            $sales_invoice[$i] = other_transaction::where('type', 'sales invoice')->whereIn('status', [1, 4])
                ->whereRaw('YEAR(transaction_date) = ' . $year)
                ->whereRaw('MONTH(transaction_date) = ' . $i)
                ->sum('balance_due');
            $purchase_invoice[$i] = other_transaction::where('type', 'purchase invoice')->whereIn('status', [1, 4])
                ->whereRaw('YEAR(transaction_date) = ' . $year)
                ->whereRaw('MONTH(transaction_date) = ' . $i)
                ->sum('balance_due');

            $total_pay[$i] =  $sales_invoice[$i] + $purchase_invoice[$i];
            $total_sales_invoice += $sales_invoice[$i];
            $total_purchase_invoice += $purchase_invoice[$i];
        }


        return view('admin.index', compact([
            'coa_ar_balance_last_year', 'coa_ar_balance', 'coa_ap_balance_last_year', 'coa_ap_balance', 'coa_ap_total',  'coa_ar_total', 'coa_ex_balance', 'coa_ex_id',
            'total_pay', 'total_sales_invoice', 'total_purchase_invoice', 'sales_invoice', 'purchase_invoice',
            'last_year', 'year', 'net_income', 'total_cash_flow', 'ending_cash', 'total_profit'
        ]));
    }

    public function bahasa()
    {
        App::setLocale('id');
        return redirect()->back();
    }
}
