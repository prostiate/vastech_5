<?php

namespace App\Exports;

use App\Model\company\company_setting;
use App\Model\contact\contact;
use App\Model\sales\sale_invoice;
use App\Model\sales\sale_invoice_item;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class customer_balance implements FromView, ShouldAutoSize
{

    protected $mulaidari;
    protected $con;

    function __construct($mulaidari, $con)
    {
        $this->mulaidari = $mulaidari;
        $this->con = $con;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $user                       = User::find(Auth::id());
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $contact2                   = explode(',', $this->con);
        $mulaidar_parse             = Carbon::parse($this->mulaidari);
        $get_this_month             = new Carbon('first day of ' . $mulaidar_parse->format('F'));
        $today                      = $get_this_month->toDateString();
        $today2                     = $this->mulaidari;
        if ($this->con == 'null') {
            $si                         = sale_invoice::orderBy('transaction_date')
                ->whereBetween('transaction_date', [$get_this_month, $today2])
                ->get();
        } else {
            $si                         = sale_invoice::orderBy('transaction_date')
                ->whereIn('contact_id', $contact2)
                ->whereBetween('transaction_date', [$get_this_month, $today2])
                ->get();
        }
        $contact                    = contact::get();
        $sid                        = sale_invoice_item::get();
        return view('admin.reports.sales_export.customer_balance', [
            'today' => $today, 'today2' => $today2, 'contact' => $contact, 'si' => $si, 'sid' => $sid, 'con' => $this->con,
            'company' => $company,
        ]);
    }
}
