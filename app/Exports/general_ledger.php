<?php

namespace App\Exports;

use App\Model\coa\coa;
use App\Model\coa\coa_detail;
use App\Model\company\company_setting;
use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class general_ledger implements FromView, ShouldAutoSize
{

    protected $start;
    protected $end;
    protected $id;

    function __construct($start, $end, $id)
    {
        $this->start = $start;
        $this->end = $end;
        $this->id = $id;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $ids                                        = explode(',', $this->id);
        //dd(array($explode_id));
        if ($this->id == 'null') {
            //dd('if');
            $coa                                    = coa::get();
            $coa2                                   = coa::get();
            $coa_detail                             = coa_detail::orderBy('date')->whereBetween('date', [$this->start, $this->end])
                ->orderBy('coa_id', 'asc')
                ->get()
                ->groupBy('coa_id');
        } else {
            //dd('else');
            $coa                                    = coa::whereIn('id', $ids)->get();
            $coa2                                   = coa::get();
            $coa_detail                             = coa_detail::orderBy('date')->whereIn('coa_id', $ids)->whereBetween('date', [$this->start, $this->end])
                ->orderBy('coa_id', 'asc')
                ->get()
                ->groupBy('coa_id');
        }
        //dd($this->id);
        return view('admin.reports.overview_export.general_ledger', [
            'start' => $this->start,
            'end' => $this->end,
            'company' => $company,
            'id' => $this->id,
            'ids' => $ids,
            'coa' => $coa,
            'coa2' => $coa2,
            'coa_detail' => $coa_detail,
        ]);
    }
}
