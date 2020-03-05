<?php

namespace App\Exports;

use App\Model\company\company_setting;
use App\Model\other\other_transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class request_ss_surabaya_sales_list implements FromView, ShouldAutoSize
{

    protected $start;
    protected $end;
    protected $type;
    protected $con;
    protected $stat;

    function __construct($start, $end, $type, $con, $stat)
    {
        $this->start = $start;
        $this->end = $end;
        $this->type = $type;
        $this->con = $con;
        $this->stat = $stat;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $user                           = User::find(Auth::id());
        $company                        = company_setting::where('company_id', $user->company_id)->first();
        $contact2                       = explode(',', $this->con);
        $status2                        = explode(',', $this->stat);
        $type2                          = explode(',', $this->type);
        $today                          = Carbon::now();

        if ($this->con == 'null') {
            if ($this->stat == 'null') {
                if ($this->type == 'null') {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereBetween('transaction_date', [$this->start, $this->end])
                        ->get();
                } else {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('type', $type2)
                        ->whereBetween('transaction_date', [$this->start, $this->end])
                        ->get();
                }
            } else {
                if ($this->type == 'null') {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('status', $status2)
                        ->whereBetween('transaction_date', [$this->start, $this->end])
                        ->get();
                } else {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('type', $type2)
                        ->whereIn('status', $status2)
                        ->whereBetween('transaction_date', [$this->start, $this->end])
                        ->get();
                }
            }
        } else {
            if ($this->stat == 'null') {
                if ($this->type == 'null') {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('contact', $contact2)
                        ->whereBetween('transaction_date', [$this->start, $this->end])
                        ->get();
                } else {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('type', $type2)
                        ->whereIn('contact', $contact2)
                        ->whereBetween('transaction_date', [$this->start, $this->end])
                        ->get();
                }
            } else {
                if ($this->type == 'null') {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('contact', $contact2)
                        ->whereIn('status', $status2)
                        ->whereBetween('transaction_date', [$this->start, $this->end])
                        ->get();
                } else {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('type', $type2)
                        ->whereIn('contact', $contact2)
                        ->whereIn('status', $status2)
                        ->whereBetween('transaction_date', [$this->start, $this->end])
                        ->get();
                }
            }
        }

        $customer                       = collect($other_transaction)
            ->groupBy('contact');

        return view('admin.reports.sales_export.request_ss_surabaya.sales_list', [
            'user' => $user,
            'start' => $this->start,
            'end' => $this->end,
            'other_transaction' => $other_transaction,
            'company' => $company,
            'customer' => $customer,
            'today' => $today,

        ]);
    }
}
