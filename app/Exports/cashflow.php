<?php

namespace App\Exports;

use App\Model\coa\coa_detail;
use App\Model\company\company_setting;
use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class cashflow implements FromView, ShouldAutoSize
{

    protected $start;
    protected $end;

    function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $coa_detail                                 = coa_detail::whereBetween('date', [$this->start, $this->end])
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
        return view('admin.reports.overview_export.cashflow', [
            'start' => $this->start,
            'end' => $this->end,
            'company' => $company,
            'cash_received_from_cust' => $cash_received_from_cust,
            'other_current_asset' => $other_current_asset,
            'cash_paid_to_supplier' => $cash_paid_to_supplier,
            'cc_and_current_liability' => $cc_and_current_liability,
            'other_income' => $other_income,
            'operating_expense' => $operating_expense,
            'net_cash_operating_acti' => $net_cash_operating_acti,
            'purchase_sale_asset' => $purchase_sale_asset,
            'other_investing_asset' => $other_investing_asset,
            'net_cash_by_investing' => $net_cash_by_investing,
            'repayment_proceed_loan' => $repayment_proceed_loan,
            'equity_capital' => $equity_capital,
            'net_cash_finan' => $net_cash_finan,
            'increase_dec_in_cash' => $increase_dec_in_cash,
            'beginning_cash' => $beginning_cash,
            'ending_cash' => $ending_cash,
        ]);
    }
}
