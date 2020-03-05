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

class request_ss_surabaya_sales_by_customer implements FromView, ShouldAutoSize
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
        $today                      = Carbon::now();
        if ($this->con == 'null') {
            $si                     = sale_invoice::with('sale_invoice_item')->orderBy('transaction_date')
                ->whereBetween('transaction_date', [$this->start, $this->end])
                ->get();
        } else {
            $si                     = sale_invoice::with('sale_invoice_item')->orderBy('transaction_date')
                ->whereIn('contact_id', $contact2)
                ->whereBetween('transaction_date', [$this->start, $this->end])
                ->get();
        }
        $sid                        = sale_invoice_item::get();
        $customers                   = collect($si)
            ->groupBy('contact_id')
            ->map(function ($item) {
                return $item
                    ->groupBy('id')
                    ->map(function ($item) {
                        return $item;
                    });
            });
        return view('admin.reports.sales_export.request_ss_surabaya.sales_by_customer', [
            'start' => $this->start,
            'end' => $this->end,
            'contact' => $contact,
            'si' => $si,
            'sid' => $sid,
            'con' => $contact2,
            'customers' => $customers,
            'company' => $company,
            'today' => $today,
        ]);
    }
}
