<?php

namespace App\Exports;

use App\Model\company\company_setting;
use App\Model\spk\spk;
use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class spk_details implements FromView, ShouldAutoSize
{

    protected $start;
    protected $end;
    protected $prod;
    protected $war;

    function __construct($start, $end, $prod, $war)
    {
        $this->start = $start;
        $this->end = $end;
        $this->prod = $prod;
        $this->war = $war;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $product                                    = explode(',', $this->prod);
        $warehouse                                  = explode(',', $this->war);
        if ($this->war == 'null') {
            //dd('if');
            if ($this->prod == 'null') {
                $spk                                       = spk::whereBetween('transaction_date', [$this->start, $this->end])
                    ->with(['spk_item' => function ($spk_item) {
                        $spk_item->get();
                    }])->get();
            } else {
                $spk                                       = spk::whereBetween('transaction_date', [$this->start, $this->end])
                    ->with(['spk_item' => function ($spk_item) use ($product) {
                        $spk_item->whereIn('product_id', $product);
                    }])->get();
            }
        } else {
            //dd('else');
            if ($this->prod == 'null') {
                $spk                                       = spk::whereBetween('transaction_date', [$this->start, $this->end])
                    ->whereIn('warehouse_id', $warehouse)
                    ->with(['spk_item' => function ($spk_item) {
                        $spk_item->get();
                    }])->get();
            } else {
                $spk                                       = spk::whereBetween('transaction_date', [$this->start, $this->end])
                    ->whereIn('warehouse_id', $warehouse)
                    ->with(['spk_item' => function ($spk_item) use ($product) {
                        $spk_item->whereIn('product_id', $product);
                    }])->get();
            }
        }
        return view('admin.reports.production_export.spk_details', [
            'start' => $this->start,
            'end' => $this->end,
            'company' => $company,
            'spk' => $spk,
        ]);
    }
}
