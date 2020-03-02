<?php

namespace App\Exports;

use App\Model\company\company_setting;
use App\Model\spk\spk;
use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class spk_list implements FromView, ShouldAutoSize
{

    protected $start;
    protected $end;
    protected $war;

    function __construct($start, $end, $war)
    {
        $this->start = $start;
        $this->end = $end;
        $this->id = $war;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $warehouse                                      = explode(',', $this->id);
        if ($this->id == 'null') {
            //dd('if');
            $spk                                        = spk::whereBetween('transaction_date', [$this->start, $this->end])->get();
        } else {
            //dd('else');
            $spk                                        = spk::whereBetween('transaction_date', [$this->start, $this->end])
                ->whereIn('warehouse_id', $warehouse)
                ->get();
        }
        return view('admin.reports.production_export.spk_list', [
            'start' => $this->start,
            'end' => $this->end,
            'company' => $company,
            'spk' => $spk,
        ]);
    }
}
