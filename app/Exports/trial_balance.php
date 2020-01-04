<?php

namespace App\Exports;

use App\coa;
use App\coa_detail;
use App\company_setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class trial_balance implements FromView, ShouldAutoSize
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
        $coa_detail2                                = coa_detail::whereBetween('date', [$this->start, $this->end])
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
        return view('admin.reports.overview_export.trial_balance', [
            'start' => $this->start,
            'end' => $this->end,
            'company' => $company,
            'asset' => $asset,
            'liability' => $liability,
            'equity' => $equity,
            'income' => $income,
            'expense' => $expense,
            'coa' => $coa,
            'coa_detail' => $coa_detail,
            'coa_detail2' => $coa_detail2,
        ]);
    }
}
