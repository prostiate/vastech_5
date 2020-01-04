<?php

namespace App\Exports;

use App\coa_detail;
use App\company_setting;
use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class balance_sheet implements FromView, ShouldAutoSize
{

    protected $today;
    protected $startyear;
    protected $endyear;

    function __construct($today, $startyear, $endyear)
    {
        $this->today = $today;
        $this->startyear = $startyear;
        $this->endyear = $endyear;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $current_periode                            = new Carbon('first day of January ' . date('Y', strtotime($this->today)));
        $coa_detail                                 = coa_detail::whereBetween('date', [$current_periode->toDateString(), $this->today])
            ->orderBy('date')
            ->selectRaw('SUM(debit - credit) as total, coa_id')
            ->groupBy('coa_id')
            ->get();
        $last_periode_coa_detail                    = coa_detail::whereBetween('date', [$this->startyear, $this->endyear])
            ->orderBy('date')
            ->selectRaw('SUM(debit - credit) as total, coa_id')
            ->groupBy('coa_id')
            ->get();
        return view('admin.reports.overview_export.balance_sheet', [
            'coa_detail' => $coa_detail,
            'last_periode_coa_detail' => $last_periode_coa_detail,
            'company' => $company,
            'today' => $this->today,
        ]);
    }
}
