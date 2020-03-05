<?php

namespace App\Exports;

use App\Model\coa\coa_detail;
use App\Model\company\company_setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class request_ss_surabaya_balance_sheet implements FromView, ShouldAutoSize
{

    protected $start;
    protected $end;
    protected $startyear;
    protected $endyear;

    function __construct($start, $end, $startyear, $endyear)
    {
        $this->start        = $start;
        $this->end          = $end;
        $this->startyear    = $startyear;
        $this->endyear      = $endyear;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $today2                                     = Carbon::parse($this->start);
        $today                                      = Carbon::now();
        $current_periode                            = new Carbon('first day of ' . $today2->format('F'));
        $coa_detail                                 = coa_detail::whereBetween('date', [$this->start, $this->end])
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();
        $last_periode_coa_detail                    = coa_detail::whereBetween('date', [$this->startyear, $this->endyear])
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();
        return view('admin.reports.overview_export.request_ss_surabaya.balance_sheet', [
            'coa_detail' => $coa_detail,
            'last_periode_coa_detail' => $last_periode_coa_detail,
            'company' => $company,
            'today' => $today,
            'start' => $this->start,
            'end' => $this->end,
        ]);
    }
}
