<?php

namespace App\Exports;

use App\coa_detail;
use App\company_setting;
use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class profit_loss implements FromView, ShouldAutoSize
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
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();

        $total_primary_income               = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 13) {
                $total_primary_income       += abs($cd->total);
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
                $total_other_income         += $cd->total;
            }
        }

        $total_other_expense                = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 17) {
                $total_other_expense        += $cd->total;
            }
        }
        $net_income                         = $net_operating_income + $total_other_income - $total_other_expense;
        return view('admin.reports.overview_export.profit_loss', [
            'start' => $this->start,
            'end' => $this->end,
            'company' => $company,
            'coa_detail' => $coa_detail,
            'total_primary_income' => $total_primary_income,
            'total_cost_of_sales' => $total_cost_of_sales,
            'gross_profit' => $gross_profit,
            'total_operational_expense' => $total_operational_expense,
            'net_operating_income' => $net_operating_income,
            'total_other_income' => $total_other_income,
            'total_other_expense' => $total_other_expense,
            'net_income' => $net_income,
        ]);
    }
}
