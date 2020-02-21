<?php

namespace App\Exports;

use App\company_setting;
use App\contact;
use App\sale_invoice;
use App\sale_invoice_item;
use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class sales_by_customer implements FromView, ShouldAutoSize
{

    protected $start;
    protected $end;
    protected $con;

    function __construct($start, $end, $con)
    {
        $this->start = $start;
        $this->end = $end;
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
        $contact                    = contact::get();
        if ($this->con == 'null') {
            $si                     = sale_invoice::orderBy('transaction_date')
                ->whereBetween('transaction_date', [$this->start, $this->end])
                ->get();
        } else {
            $si                     = sale_invoice::orderBy('transaction_date')
                ->whereIn('contact_id', $contact2)
                ->whereBetween('transaction_date', [$this->start, $this->end])
                ->get();
        }
        $sid                        = sale_invoice_item::get();
        return view('admin.reports.sales_export.sales_by_customer', [
            'start' => $this->start,
            'end' => $this->end,
            'contact' => $contact,
            'si' => $si,
            'sid' => $sid,
            'company' => $company,
        ]);
    }
}
