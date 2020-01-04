<?php

namespace App\Exports;

use App\coa_detail;
use App\company_setting;
use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class journal_report implements FromView, ShouldAutoSize
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
        $coa_detail                 = coa_detail::whereBetween('date', [$this->start, $this->end])
            ->select('coa_details.*')->groupBy('number')->groupBy('coa_id')
            ->selectSub(function ($query) {
                return $query->selectRaw('SUM(debit)');
            }, 'debit')
            ->selectSub(function ($query) {
                return $query->selectRaw('SUM(credit)');
            }, 'credit')
            ->orderBy('date')
            ->get()
            ->groupBy('number');
        return view('admin.reports.overview_export.journal_report', [
            'start' => $this->start,
            'end' => $this->end,
            'company' => $company,
            'coa_detail' => $coa_detail,
        ]);
    }
}
