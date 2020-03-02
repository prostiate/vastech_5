<?php

namespace App\Exports;

use App\Model\product\product;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class inventory_summary implements FromView, ShouldAutoSize
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
        $today                                      = Carbon::today()->toDateString();
        if (Carbon::parse($today)->gt(Carbon::now())) {
            $products                               = product::where('is_track', 1)->get();
        } else {
            $products                               = product::where('is_track', 1)->get();
        }
        $products                                   = product::where('is_track', 1)->get();
        return view('admin.reports.products_export.inventory_summary', [
            'products' => $products,
        ]);
    }
}
