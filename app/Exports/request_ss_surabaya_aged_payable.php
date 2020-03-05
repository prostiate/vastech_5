<?php

namespace App\Exports;

use App\Model\company\company_setting;
use App\Model\contact\contact;
use App\Model\purchase\purchase_invoice;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class request_ss_surabaya_aged_payable implements FromView, ShouldAutoSize
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
        $user                       = User::find(Auth::id());
        $today                      = Carbon::now();
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $days                           = Carbon::parse($this->start);
        $sesi1_start                    = $days->toDateString();
        $sesi1_end                      = $days->addDay(29)->toDateString();
        $sesi2_start                    = $days->addDay(1)->toDateString();
        $sesi2_end                      = $days->addDay(29)->toDateString();
        $sesi3_start                    = $days->addDay(1)->toDateString();
        $sesi3_end                      = $days->addDay(29)->toDateString();
        $sesi4_start                    = $days->addDay(1)->toDateString();
        $sesi4_end                      = $this->end;

        //dd($sesi1_start, $sesi1_end, $sesi2_start, $sesi2_end, $sesi3_start, $sesi3_end);
        if ($this->end <= $sesi1_end) {
            $start1 = $sesi1_start;
            $start2 = null;
            $start3 = null;
            $start4 = null;
            $end1 = $this->end;
            $end2 = null;
            $end3 = null;
            $end4 = null;
        } elseif ($this->end <= $sesi2_end) {
            $start1 = $sesi1_start;
            $start2 = $sesi2_start;
            $start3 = null;
            $start4 = null;
            $end1 = $sesi1_end;
            $end2 = $this->end;
            $end3 = null;
            $end4 = null;
        } elseif ($this->end <= $sesi3_end) {
            $start1 = $sesi1_start;
            $start2 = $sesi2_start;
            $start3 = $sesi3_start;
            $start4 = null;
            $end1 = $sesi1_end;
            $end2 = $sesi2_end;
            $end3 = $this->end;
            $end4 = null;
        } else {
            $start1 = $sesi1_start;
            $start2 = $sesi2_start;
            $start3 = $sesi3_start;
            $start4 = $sesi4_start;
            $end1 = $sesi1_end;
            $end2 = $sesi2_end;
            $end3 = $sesi3_end;
            $end4 = $this->end;
        }

        $month1                              = purchase_invoice::with('purchase_invoice_item', 'contact')
            ->whereBetween('transaction_date', [$start1, $end1])
            ->get();

        $group1                                = $month1
            ->groupBy(function ($contact) {
                return $contact->contact->display_name;
            })
            ->map(function ($item) {
                return $item
                    ->map(function ($item) {
                        return $item;
                    });
            });
        $month2                              = purchase_invoice::with('purchase_invoice_item', 'contact')
            ->whereBetween('transaction_date', [$start2, $end2])
            ->get();

        $group2                                = $month2
            ->groupBy(function ($contact) {
                return $contact->contact->display_name;
            })
            ->map(function ($item) {
                return $item
                    ->map(function ($item) {
                        return $item;
                    });
            });
        $month3                              = purchase_invoice::with('purchase_invoice_item', 'contact')
            ->whereBetween('transaction_date', [$start3, $end3])
            ->get();

        $group3                                = $month3
            ->groupBy(function ($contact) {
                return $contact->contact->display_name;
            })
            ->map(function ($item) {
                return $item
                    ->map(function ($item) {
                        return $item;
                    });
            });
        $month4                              = purchase_invoice::with('purchase_invoice_item', 'contact')
            ->whereBetween('transaction_date', [$start4, $end4])
            ->get();

        $group4                                = $month4
            ->groupBy(function ($contact) {
                return $contact->contact->display_name;
            })
            ->map(function ($item) {
                return $item
                    ->map(function ($item) {
                        return $item;
                    });
            });

        $si                             = purchase_invoice::with('purchase_invoice_item', 'contact')
            ->whereBetween('transaction_date', [$this->start, $this->end])
            ->groupBy('contact_id')
            ->selectRaw('SUM(balance_due) as balance_due, contact_id')
            ->get();

        //dd($pi);
        $contact                    = contact::get();
        //dd($group1, $group2, $group3, $group4);
        //dd($start1, $start2, $start3, $start4);
        return view('admin.reports.purchases_export.request_ss_surabaya.aged_payable', [
            'start' => $this->start,
            'end' => $this->end,
            'company' => $company,
            'today' => $today,
            'si' => $si,
            'contact' => $contact,
            'month1' => $month1,
            'month2' => $month2,
            'month3' => $month3,
            'month4' => $month4,
            'group1' => $group1,
            'group2' => $group2,
            'group3' => $group3,
            'group4' => $group4,
        ]);
    }
}
