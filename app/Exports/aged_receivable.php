<?php

namespace App\Exports;

use App\company_setting;
use App\contact;
use App\sale_invoice;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class aged_receivable implements FromView, ShouldAutoSize
{

    protected $mulaidari;

    function __construct($mulaidari)
    {
        $this->mulaidari = $mulaidari;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $user                       = User::find(Auth::id());
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $mulaidar_parse             = Carbon::parse($this->mulaidari);
        $get_this_month             = new Carbon('first day of ' . $mulaidar_parse->format('F'));
        $today                      = $get_this_month->toDateString();
        $today2                     = $this->mulaidari;
        $si                         = sale_invoice::orderBy('transaction_date')
            ->whereBetween('transaction_date', [$today, $today2])
            ->selectRaw('SUM(balance_due) as balance_due, transaction_date, contact_id')
            ->groupBy('contact_id')
            ->get();
        $contact                    = contact::get();
        return view('admin.reports.sales_export.aged_receivable', [
            'today' => $today, 'today2' => $today2, 'contact' => $contact, 'si' => $si,
            'company' => $company,
        ]);
    }
}
