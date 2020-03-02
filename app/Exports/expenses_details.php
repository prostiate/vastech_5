<?php

namespace App\Exports;

use App\Model\company\company_setting;
use App\Model\expense\expense;
use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class expenses_details implements FromView, ShouldAutoSize
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
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $contacts                                   = explode(',', $this->con);
        if ($this->con == 'null') {
            $expense                    = expense::whereBetween('transaction_date', [$this->start, $this->end])
                ->with(['expense_item' => function ($expense_item){
                    $expense_item->get();
                }])->get();
        } else {
            $expense                    = expense::whereBetween('transaction_date', [$this->start, $this->end])
                ->whereIn('contact_id', $contacts)
                ->with(['expense_item' => function ($expense_item){
                    $expense_item->get();
                }])->get();
        }
        return view('admin.reports.expenses_export.expenses_details', [
            'start' => $this->start,
            'end' => $this->end,
            'company' => $company,
            'expense' => $expense,
        ]);
    }
}
