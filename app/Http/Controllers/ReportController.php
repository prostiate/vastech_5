<?php

namespace App\Http\Controllers;

use App\coa;
use App\coa_detail;
use App\company_setting;
use App\contact;
use App\expense;
use App\expense_item;
use App\Exports\balance_sheet;
use App\Exports\cashflow;
use App\Exports\general_ledger;
use App\Exports\journal_report;
use App\Exports\profit_loss;
use App\Exports\trial_balance;
use App\other_transaction;
use App\product;
use App\purchase_delivery;
use App\purchase_delivery_item;
use DB;
use App\purchase_detail;
use App\purchase_invoice;
use App\purchase_invoice_item;
use App\purchase_product;
use App\purchase_return_item;
use App\sale_delivery;
use App\sale_delivery_item;
use App\sale_detail;
use App\sale_invoice;
use App\sale_invoice_item;
use App\sale_order;
use App\sale_payment;
use App\sale_payment_item;
use App\sale_return_item;
use App\User;
use App\warehouse;
use App\warehouse_detail;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    // OVERVIEW
    public function balanceSheet()
    {
        $last_periode                               = new Carbon('first day of last year');
        $startyear_last_periode                     = $last_periode->startOfYear()->toDateString();
        $endyear_last_periode                       = $last_periode->endOfYear()->toDateString();
        $current_periode                            = new Carbon('first day of January ' . date('Y'));
        //dd($last_periode);
        $today                                      = Carbon::today()->toDateString();
        /*
         INI CONTOH UNTUK JOIN COA DETAIL DENGAN COA YANG BENAR
        $view_current_assets4                        = DB::table('coa_details')
                                                        ->join('coas', 'coa_details.id', '=', 'coas.id')
                                                        ->select('coa_details.*', 'coas.coa_category_id')
                                                        ->get();*/
        $coa_detail                                 = coa_detail::whereBetween('date', [$current_periode->toDateString(), $today])
            ->orderBy('date')
            ->selectRaw('SUM(debit - credit) as total, coa_id')
            ->groupBy('coa_id')
            ->get();
        $total_current_assets                       = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 1 or $cd->coa->coa_category_id == 2 or $cd->coa->coa_category_id == 3 or $cd->coa->coa_category_id == 4) {
                $total_current_assets               += $cd->total;
            }
        }
        $total_fixed_assets                         = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 5 or $cd->coa->coa_category_id == 6) {
                $total_fixed_assets                 += $cd->total;
            }
        }
        $total_depreciation                         = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 7) {
                $total_depreciation                   += $cd->total;
            }
        }
        $total_assets                               = $total_current_assets + $total_fixed_assets - $total_depreciation;
        $total_liability                            = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 8 or $cd->coa->coa_category_id == 10 or $cd->coa->coa_category_id == 17) {
                $total_liability                    += $cd->total;
            }
        }
        /*$total_equity                               = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 12) {
                $total_equity                       += $cd->total;
            }
        }*/
        $last_periode_coa_detail                    = coa_detail::whereBetween('date', [$startyear_last_periode, $endyear_last_periode])
            ->orderBy('date')
            ->selectRaw('SUM(debit - credit) as total, coa_id')
            ->groupBy('coa_id')
            ->get();
        $last_periode_total_current_assets                       = 0;
        foreach ($last_periode_coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 1 or $cd->coa->coa_category_id == 2 or $cd->coa->coa_category_id == 3 or $cd->coa->coa_category_id == 4) {
                $last_periode_total_current_assets               += $cd->total;
            }
        }
        $last_periode_total_fixed_assets                         = 0;
        foreach ($last_periode_coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 5 or $cd->coa->coa_category_id == 6) {
                $last_periode_total_fixed_assets                 += $cd->total;
            }
        }
        $last_periode_total_depreciation                         = 0;
        foreach ($last_periode_coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 7) {
                $last_periode_total_depreciation                   += $cd->total;
            }
        }
        $last_periode_total_assets                  = $last_periode_total_current_assets + $last_periode_total_fixed_assets - $last_periode_total_depreciation;
        $last_periode_total_liability                            = 0;
        foreach ($last_periode_coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 8 or $cd->coa->coa_category_id == 10 or $cd->coa->coa_category_id == 17) {
                $last_periode_total_liability                    += $cd->total;
            }
        }
        $last_periode_earning                       = $last_periode_total_assets - $last_periode_total_liability;
        $current_period_earning                     = $total_assets - $total_liability;
        $total_equity2                              = $current_period_earning + $last_periode_earning;
        $total_lia_eq                               = $total_liability + $total_equity2;
        return view('admin.reports.overview.balance_sheet', compact([
            'startyear_last_periode',
            'endyear_last_periode',
            'today',
            'coa_detail',
            'total_current_assets',
            'total_fixed_assets',
            'total_depreciation',
            'total_assets',
            'total_liability',
            'total_equity2',
            'last_periode_earning',
            'current_period_earning',
            'total_lia_eq',
        ]));
    }

    public function balanceSheetInput($mulaidari)
    {
        $last_periode                               = new Carbon('first day of last year');
        $startyear_last_periode                     = $last_periode->startOfYear()->toDateString();
        $endyear_last_periode                       = $last_periode->endOfYear()->toDateString();
        $current_periode                            = new Carbon('first day of January ' . date('Y'));
        $today                                      = Carbon::today()->toDateString();
        $today2                                     = $mulaidari;
        if (Carbon::parse($today)->gt(Carbon::now())) {
            $coa_detail                                 = coa_detail::whereBetween('date', [$current_periode->toDateString(), $today2])
                ->orderBy('coa_id')
                ->selectRaw('SUM(debit - credit) as total, coa_id')
                ->groupBy('coa_id')
                ->get();
        } else {
            $coa_detail                                 = coa_detail::whereBetween('date', [$current_periode->toDateString(), $today2])
                ->orderBy('coa_id')
                ->selectRaw('SUM(debit - credit) as total, coa_id')
                ->groupBy('coa_id')
                ->get();
        }
        $total_current_assets                       = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 1 or $cd->coa->coa_category_id == 2 or $cd->coa->coa_category_id == 3 or $cd->coa->coa_category_id == 4) {
                $total_current_assets                   += $cd->total;
            }
        }
        $total_fixed_assets                         = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 5 or $cd->coa->coa_category_id == 6) {
                $total_fixed_assets                   += $cd->total;
            }
        }
        $total_depreciation                         = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 7) {
                $total_depreciation                   += $cd->total;
            }
        }
        $total_assets                               = $total_current_assets + $total_fixed_assets - $total_depreciation;
        $total_liability                            = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 8 or $cd->coa->coa_category_id == 10 or $cd->coa->coa_category_id == 17) {
                $total_liability                   += $cd->total;
            }
        }
        /*$total_equity                               = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 12) {
                $total_depreciation                   += $cd->total;
            }
        }*/
        $last_periode_coa_detail                    = coa_detail::whereBetween('date', [$last_periode->startOfYear(), $last_periode->endOfYear()])
            ->orderBy('date')
            ->selectRaw('SUM(debit - credit) as total, coa_id')
            ->groupBy('coa_id')
            ->get();
        $last_periode_total_current_assets                       = 0;
        foreach ($last_periode_coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 1 or $cd->coa->coa_category_id == 2 or $cd->coa->coa_category_id == 3 or $cd->coa->coa_category_id == 4) {
                $last_periode_total_current_assets               += $cd->total;
            }
        }
        $last_periode_total_fixed_assets                         = 0;
        foreach ($last_periode_coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 5 or $cd->coa->coa_category_id == 6) {
                $last_periode_total_fixed_assets                 += $cd->total;
            }
        }
        $last_periode_total_depreciation                         = 0;
        foreach ($last_periode_coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 7) {
                $last_periode_total_depreciation                   += $cd->total;
            }
        }
        $last_periode_total_assets                  = $last_periode_total_current_assets + $last_periode_total_fixed_assets - $last_periode_total_depreciation;
        $last_periode_total_liability                            = 0;
        foreach ($last_periode_coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 8 or $cd->coa->coa_category_id == 10 or $cd->coa->coa_category_id == 17) {
                $last_periode_total_liability                    += $cd->total;
            }
        }
        $last_periode_earning                       = $last_periode_total_assets - $last_periode_total_liability;
        $current_period_earning                     = $total_assets - $total_liability;
        $total_equity2                              = $current_period_earning + $last_periode_earning;
        $total_lia_eq                               = $total_liability + $total_equity2;

        return view('admin.reports.overview.balance_sheetInput', compact([
            'startyear_last_periode',
            'endyear_last_periode',
            'today',
            'today2',
            'coa_detail',
            'total_current_assets',
            'total_fixed_assets',
            'total_depreciation',
            'total_assets',
            'total_liability',
            'total_equity2',
            'last_periode_earning',
            'current_period_earning',
            'total_lia_eq',
        ]));
    }

    public function balanceSheet_excel($today, $startyear, $endyear)
    {
        $current_periode                            = new Carbon('first day of January ' . date('Y', strtotime($today)));
        return Excel::download(new balance_sheet($today, $startyear, $endyear), 'balance_sheet_' . $current_periode->toDateString() . '_' . $today . '.xlsx');
    }

    public function balanceSheet_csv($today, $startyear, $endyear)
    {
        $current_periode                            = new Carbon('first day of January ' . date('Y', strtotime($today)));
        return Excel::download(new balance_sheet($today, $startyear, $endyear), 'balance_sheet_' . $current_periode->toDateString() . '_' . $today . '.csv');
    }

    public function balanceSheet_pdf($today, $startyear, $endyear)
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $current_periode                            = new Carbon('first day of January ' . date('Y', strtotime($today)));
        $coa_detail                                 = coa_detail::whereBetween('date', [$current_periode->toDateString(), $today])
            ->orderBy('date')
            ->selectRaw('SUM(debit - credit) as total, coa_id')
            ->groupBy('coa_id')
            ->get();
        $last_periode_coa_detail                    = coa_detail::whereBetween('date', [$startyear, $endyear])
            ->orderBy('date')
            ->selectRaw('SUM(debit - credit) as total, coa_id')
            ->groupBy('coa_id')
            ->get();
        $view = view('admin.reports.overview_export.balance_sheet_pdf')->with(compact(['coa_detail', 'last_periode_coa_detail', 'company', 'today']));
        $html = $view->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('balance_sheet_' . $current_periode->toDateString() . '_' . $today . '.pdf');
    }

    public function generalLedger()
    {
        $today                                      = Carbon::today()->toDateString();
        $coa                                        = coa::get();
        $coa_detail                                 = coa_detail::whereBetween('date', [$today, $today])
            ->orderBy('coa_id', 'asc')
            ->get()
            ->groupBy('coa_id');
        return view('admin.reports.overview.general_ledger', compact(['today', 'coa', 'coa_detail']));
    }

    public function generalLedgerInput($start, $end, $id)
    {
        $ids                                        = explode(',', $id);
        //dd(array($explode_id));
        if ($id == 'null') {
            //dd('if');
            $coa                                    = coa::get();
            $coa2                                   = coa::get();
            $coa_detail                             = coa_detail::whereBetween('date', [$start, $end])
                ->orderBy('coa_id', 'asc')
                ->get()
                ->groupBy('coa_id');
        } else {
            //dd('else');
            $coa                                    = coa::whereIn('id', $ids)->get();
            $coa2                                   = coa::get();
            $coa_detail                             = coa_detail::whereIn('coa_id', $ids)->whereBetween('date', [$start, $end])
                ->orderBy('coa_id', 'asc')
                ->get()
                ->groupBy('coa_id');
        }
        return view('admin.reports.overview.general_ledgerInput', compact(['start', 'end', 'id', 'ids', 'coa', 'coa2', 'coa_detail']));
    }

    public function generalLedger_excel($start, $end, $id)
    {
        return Excel::download(new general_ledger($start, $end, $id), 'general_ledger_' . $start . '_' . $end . '.xlsx');
    }

    public function generalLedger_csv($start, $end, $id)
    {
        return Excel::download(new general_ledger($start, $end, $id), 'general_ledger_' . $start . '_' . $end . '.csv');
    }

    public function generalLedger_pdf($start, $end, $id)
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $ids                                        = explode(',', $id);
        //dd(array($explode_id));
        if ($id == 'null') {
            //dd('if');
            $coa                                    = coa::get();
            $coa2                                   = coa::get();
            $coa_detail                             = coa_detail::whereBetween('date', [$start, $end])
                ->orderBy('coa_id', 'asc')
                ->get()
                ->groupBy('coa_id');
        } else {
            //dd('else');
            $coa                                    = coa::whereIn('id', $ids)->get();
            $coa2                                   = coa::get();
            $coa_detail                             = coa_detail::whereIn('coa_id', $ids)->whereBetween('date', [$start, $end])
                ->orderBy('coa_id', 'asc')
                ->get()
                ->groupBy('coa_id');
        }
        $view = view('admin.reports.overview_export.general_ledger_pdf')->with(compact(['company', 'start', 'end', 'id', 'ids', 'coa', 'coa2', 'coa_detail']));
        $html = $view->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('general_ledger_' . $start . '_' . $end . '.pdf');
    }

    public function profitLoss()
    {
        $today                                      = Carbon::today()->toDateString();
        $coa_detail                                 = coa_detail::whereBetween('date', [$today, $today])
            ->orderBy('date')
            ->selectRaw('SUM(debit - credit) as total, coa_id')
            ->groupBy('coa_id')
            ->get();

        $total_primary_income       = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 13) {
                $total_primary_income                   += abs($cd->total);
            }
        }
        $total_cost_of_sales        = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 15) {
                $total_cost_of_sales                   += $cd->total;
            }
        }
        $gross_profit               = $total_primary_income - $total_cost_of_sales;

        $total_operational_expense  = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 16) {
                $total_operational_expense                   += $cd->total;
            }
        }
        $net_operating_income       = $gross_profit - $total_operational_expense;

        $total_other_income         = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 14) {
                $total_other_income                   += $cd->total;
            }
        }

        $total_other_expense        = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 17) {
                $total_other_expense                   += $cd->total;
            }
        }
        $net_income                 = $net_operating_income + $total_other_income - $total_other_expense;

        return view('admin.reports.overview.profit_loss', compact([
            'today',
            'coa_detail',
            'total_primary_income',
            'total_cost_of_sales',
            'gross_profit',
            'total_operational_expense',
            'net_operating_income',
            'total_other_income',
            'total_other_expense',
            'net_income',
        ]));
    }

    public function profitLossInput($start, $end)
    {
        $coa_detail                                 = coa_detail::whereBetween('date', [$start, $end])
            ->orderBy('date')
            ->selectRaw('SUM(debit - credit) as total, coa_id')
            ->groupBy('coa_id')
            ->get();

        $total_primary_income       = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 13) {
                $total_primary_income                   += abs($cd->total);
            }
        }
        $total_cost_of_sales        = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 15) {
                $total_cost_of_sales                   += $cd->total;
            }
        }
        $gross_profit               = $total_primary_income - $total_cost_of_sales;

        $total_operational_expense  = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 16) {
                $total_operational_expense                   += $cd->total;
            }
        }
        $net_operating_income       = $gross_profit - $total_operational_expense;

        $total_other_income         = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 14) {
                $total_other_income                   += $cd->total;
            }
        }

        $total_other_expense        = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 17) {
                $total_other_expense                   += $cd->total;
            }
        }
        $net_income                 = $net_operating_income + $total_other_income - $total_other_expense;

        return view('admin.reports.overview.profit_lossInput', compact([
            'start',
            'end',
            'coa_detail',
            'total_primary_income',
            'total_cost_of_sales',
            'gross_profit',
            'total_operational_expense',
            'net_operating_income',
            'total_other_income',
            'total_other_expense',
            'net_income',
        ]));
    }

    public function profitLoss_excel($start, $end)
    {
        return Excel::download(new profit_loss($start, $end), 'profit_loss_' . $start . '_' . $end . '.xlsx');
    }

    public function profitLoss_csv($start, $end)
    {
        return Excel::download(new profit_loss($start, $end), 'profit_loss_' . $start . '_' . $end . '.csv');
    }

    public function profitLoss_pdf($start, $end)
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $coa_detail                                 = coa_detail::whereBetween('date', [$start, $end])
            ->orderBy('date')
            ->selectRaw('SUM(debit - credit) as total, coa_id')
            ->groupBy('coa_id')
            ->get();

        $total_primary_income       = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 13) {
                $total_primary_income                   += abs($cd->total);
            }
        }
        $total_cost_of_sales        = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 15) {
                $total_cost_of_sales                   += $cd->total;
            }
        }
        $gross_profit               = $total_primary_income - $total_cost_of_sales;

        $total_operational_expense  = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 16) {
                $total_operational_expense                   += $cd->total;
            }
        }
        $net_operating_income       = $gross_profit - $total_operational_expense;

        $total_other_income         = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 14) {
                $total_other_income                   += $cd->total;
            }
        }

        $total_other_expense        = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 17) {
                $total_other_expense                   += $cd->total;
            }
        }
        $net_income                 = $net_operating_income + $total_other_income - $total_other_expense;
        $view = view('admin.reports.overview_export.profit_loss_pdf')->with(compact([
            'company', 'start',
            'end',
            'coa_detail',
            'total_primary_income',
            'total_cost_of_sales',
            'gross_profit',
            'total_operational_expense',
            'net_operating_income',
            'total_other_income',
            'total_other_expense',
            'net_income',
        ]));
        $html = $view->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('profit_loss_' . $start . '_' . $end . '.pdf');
    }

    public function journal_report()
    {
        $today                      = Carbon::today()->toDateString();
        $coa_detail                 = coa_detail::whereBetween('date', [$today, $today])
            ->orderBy('date')
            ->get()
            ->groupBy('number');
        return view('admin.reports.overview.journal_report', compact(['today', 'coa_detail']));
    }

    public function journal_reportInput($start, $end)
    {
        $coa_detail                 = coa_detail::whereBetween('date', [$start, $end])
            ->select('coa_details.*')->groupBy('number')->groupBy('coa_id')
            ->selectSub(function ($query) {
                return $query->selectRaw('SUM(debit)');
            }, 'debit')
            ->selectSub(function ($query) {
                return $query->selectRaw('SUM(credit)');
            }, 'credit')
            ->orderBy('date')
            ->get()
            ->groupBy('number');
        //dd($coa_detail);
        return view('admin.reports.overview.journal_reportInput', compact(['start', 'end', 'coa_detail']));
    }

    public function journal_report_excel($start, $end)
    {
        return Excel::download(new journal_report($start, $end), 'journal_report_' . $start . '_' . $end . '.xlsx');
    }

    public function journal_report_csv($start, $end)
    {
        return Excel::download(new journal_report($start, $end), 'journal_report_' . $start . '_' . $end . '.csv');
    }

    public function journal_report_pdf($start, $end)
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $coa_detail                 = coa_detail::whereBetween('date', [$start, $end])
            ->select('coa_details.*')->groupBy('number')->groupBy('coa_id')
            ->selectSub(function ($query) {
                return $query->selectRaw('SUM(debit)');
            }, 'debit')
            ->selectSub(function ($query) {
                return $query->selectRaw('SUM(credit)');
            }, 'credit')
            ->orderBy('date')
            ->get()
            ->groupBy('number');
        $view = view('admin.reports.overview_export.journal_report_pdf')->with(compact([
            'company', 'start',
            'end',
            'coa_detail',
        ]));
        $html = $view->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('profit_loss_' . $start . '_' . $end . '.pdf');
    }

    public function trial_balance()
    {
        $today                      = Carbon::today()->toDateString();
        $coa_detail2                 = coa_detail::whereBetween('date', [$today, $today])
            ->select('coa_details.*')->groupBy('coa_id')
            ->selectSub(function ($query) {
                return $query->selectRaw('SUM(debit)');
            }, 'debit')
            ->selectSub(function ($query) {
                return $query->selectRaw('SUM(credit)');
            }, 'credit')
            ->orderBy('date')
            ->get()
            ->groupBy('coa_id');
        //dd($coa_detail2);
        $asset                          = coa::whereIn('coa_category_id', [3, 1, 4, 2, 5, 6, 7])->get();
        $liability                      = coa::whereIn('coa_category_id', [8, 9, 10, 11])->get();
        $equity                         = coa::whereIn('coa_category_id', [12])->get();
        $income                         = coa::whereIn('coa_category_id', [13, 14])->get();
        $expense                        = coa::whereIn('coa_category_id', [15, 16, 17])->get();
        $coa_detail                     = coa_detail::orderBy('coa_id', 'asc')->get()->groupBy('coa_id');
        $coa                            = coa::get();
        return view('admin.reports.overview.trial_balance', compact([
            'today',
            'asset',
            'liability',
            'equity',
            'income',
            'expense',
            'coa',
            'coa_detail',
            'coa_detail2'
        ]));
    }

    public function trial_balanceInput($start, $end)
    {
        $coa_detail2                 = coa_detail::whereBetween('date', [$start, $end])
            ->select('coa_details.*')->groupBy('coa_id')
            ->selectSub(function ($query) {
                return $query->selectRaw('SUM(debit)');
            }, 'debit')
            ->selectSub(function ($query) {
                return $query->selectRaw('SUM(credit)');
            }, 'credit')
            ->orderBy('date')
            ->get()
            ->groupBy('coa_id');
        //dd($coa_detail2);
        $asset                          = coa::whereIn('coa_category_id', [3, 1, 4, 2, 5, 6, 7])->get();
        $liability                      = coa::whereIn('coa_category_id', [8, 9, 10, 11])->get();
        $equity                         = coa::whereIn('coa_category_id', [12])->get();
        $income                         = coa::whereIn('coa_category_id', [13, 14])->get();
        $expense                        = coa::whereIn('coa_category_id', [15, 16, 17])->get();
        $coa_detail                     = coa_detail::orderBy('coa_id', 'asc')->get()->groupBy('coa_id');
        $coa                            = coa::get();
        return view('admin.reports.overview.trial_balanceInput', compact([
            'start',
            'end',
            'asset',
            'liability',
            'equity',
            'income',
            'expense',
            'coa',
            'coa_detail',
            'coa_detail2'
        ]));
    }

    public function trial_balance_excel($start, $end)
    {
        return Excel::download(new trial_balance($start, $end), 'trial_balance_' . $start . '_' . $end . '.xlsx');
    }

    public function trial_balance_csv($start, $end)
    {
        return Excel::download(new trial_balance($start, $end), 'trial_balance_' . $start . '_' . $end . '.csv');
    }

    public function trial_balance_pdf($start, $end)
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $coa_detail2                 = coa_detail::whereBetween('date', [$start, $end])
            ->select('coa_details.*')->groupBy('coa_id')
            ->selectSub(function ($query) {
                return $query->selectRaw('SUM(debit)');
            }, 'debit')
            ->selectSub(function ($query) {
                return $query->selectRaw('SUM(credit)');
            }, 'credit')
            ->orderBy('date')
            ->get()
            ->groupBy('coa_id');
        //dd($coa_detail2);
        $asset                          = coa::whereIn('coa_category_id', [3, 1, 4, 2, 5, 6, 7])->get();
        $liability                      = coa::whereIn('coa_category_id', [8, 9, 10, 11])->get();
        $equity                         = coa::whereIn('coa_category_id', [12])->get();
        $income                         = coa::whereIn('coa_category_id', [13, 14])->get();
        $expense                        = coa::whereIn('coa_category_id', [15, 16, 17])->get();
        $coa_detail                     = coa_detail::orderBy('coa_id', 'asc')->get()->groupBy('coa_id');
        $coa                            = coa::get();
        $view = view('admin.reports.overview_export.trial_balance_pdf')->with(compact([
            'company', 'start',
            'end',
            'asset',
            'liability',
            'equity',
            'income',
            'expense',
            'coa',
            'coa_detail',
            'coa_detail2'
        ]));
        $html = $view->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('trial_balance_' . $start . '_' . $end . '.pdf');
    }

    public function cashflowLAMA()
    {
        /*$coa                        = coa::where('balance', '!=', 0)->get();
        $coa_detail                 = coa_detail::get();
        $cash_received_from_cust    = coa_detail::where('type', 'sales payment')->sum('debit');
        $other_current_asset        = coa::where('coa_category_id', 2)->sum('balance');
        $cash_paid_to_supplier      = coa_detail::where('type', 'purchase payment')->sum('debit');
        $cc_and_current_liability   = coa::whereIn('coa_category_id', [9, 10])->sum('balance');
        $other_income               = coa::whereIn('coa_category_id', [14])->sum('balance');
        $operating_expense          = coa::whereIn('coa_category_id', [16])->sum('balance');
        return view('admin.reports.overview.cashflow', compact([
            'coa',
            'coa_detail',
            'cash_received_from_cust',
            'other_current_asset',
            'cash_paid_to_supplier',
            'cc_and_current_liability',
            'other_income',
            'operating_expense',
        ]));*/
        $coa                        = coa::where('balance', '!=', 0)->get();
        $coa_detail                 = coa_detail::get();

        $cash_received_from_cust    = coa_detail::where('coa_id', 4)->sum('credit');
        //$other_current_asset        = coa_detail::where('type', 'bankwithdrawalaccount')->sum('credit');
        $other_current_asset        = coa::whereIn('coa_category_id', [2])->sum('balance');
        $cash_paid_to_supplier      = coa_detail::where('coa_id', 40)->sum('debit');
        $cc_and_current_liability   = coa::whereIn('coa_category_id', [9, 10])
            ->where('id', '!=', 50)
            ->where('id', '!=', 51)
            ->where('id', '!=', 52)
            ->where('id', '!=', 53)
            ->where('id', '!=', 54)
            ->where('id', '!=', 55)
            ->sum('balance');
        $other_income               = coa::whereIn('coa_category_id', [14])->sum('balance');
        $operating_expense          = coa_detail::where('type', 'expense')->sum('debit');
        $net_cash_operating_acti    = $cash_received_from_cust + $other_current_asset - $cash_paid_to_supplier - $cc_and_current_liability + $other_income - $operating_expense;

        $purchase_sale_asset        = coa::whereIn('coa_category_id', [5])->sum('balance');
        $other_investing_asset      = coa::whereIn('coa_category_id', [6])->sum('balance');
        $net_cash_by_investing      = $purchase_sale_asset + $other_investing_asset;

        $repayment_proceed_loan     = coa::whereIn('id', [49, 56])->sum('balance');
        $equity_capital             = coa::whereIn('coa_category_id', [12])->sum('balance');
        $net_cash_finan             = $repayment_proceed_loan + $equity_capital;

        $increase_dec_in_cash       = $net_cash_operating_acti + $net_cash_by_investing + $net_cash_finan;
        $beginning_cash             = 0;
        $ending_cash                = $beginning_cash + $increase_dec_in_cash;

        return view('admin.reports.overview.cashflow', compact([
            'coa',
            'coa_detail',
            'cash_received_from_cust',
            'other_current_asset',
            'cash_paid_to_supplier',
            'cc_and_current_liability',
            'other_income',
            'operating_expense',
            'net_cash_operating_acti',
            'purchase_sale_asset',
            'other_investing_asset',
            'net_cash_by_investing',
            'repayment_proceed_loan',
            'equity_capital',
            'net_cash_finan',
            'increase_dec_in_cash',
            'beginning_cash',
            'ending_cash',
        ]));
    }

    public function cashflow()
    {
        $today                                      = Carbon::today()->toDateString();
        $coa_detail                                 = coa_detail::whereBetween('date', [$today, $today])
            ->selectRaw('SUM(debit) as debit, SUM(credit) as credit, coa_id, type')->groupBy('number')->groupBy('coa_id')
            ->get();
        $cash_received_from_cust                    = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->type == 'sales payment') {
                if ($cd->coa->coa_category_id == 3) {
                    $cash_received_from_cust        += ($cd->debit - $cd->credit);
                }
            }
        }
        $other_current_asset                        = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 2) {
                $other_current_asset                += $cd->debit - $cd->credit;
            }
        }
        $cash_paid_to_supplier                      = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->type == 'purchase payment') {
                if ($cd->coa->coa_category_id == 3) {
                    $cash_paid_to_supplier          += $cd->credit - $cd->debit;
                }
            }
        }
        $cc_and_current_liability                   = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 9 or $cd->coa->coa_category_id == 10 && $cd->coa_id != 50 && $cd->coa_id != 51 && $cd->coa_id != 52 && $cd->coa_id != 53 && $cd->coa_id != 54 && $cd->coa_id != 55) {
                $cc_and_current_liability        += $cd->debit - $cd->credit;
            }
        }
        $other_income                               = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 14) {
                $other_income                       += $cd->debit - $cd->credit;
            }
        }
        $operating_expense                          = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->type == 'expense') {
                $operating_expense                  += $cd->debit;
            }
        }
        $net_cash_operating_acti    = $cash_received_from_cust + $other_current_asset - $cash_paid_to_supplier - $cc_and_current_liability + $other_income - $operating_expense;

        $purchase_sale_asset        = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 5) {
                $purchase_sale_asset                += $cd->debit - $cd->credit;
            }
        }
        $other_investing_asset      = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 6) {
                $other_investing_asset              += $cd->debit - $cd->credit;
            }
        }
        $net_cash_by_investing      = $purchase_sale_asset + $other_investing_asset;

        $repayment_proceed_loan     = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 49 or $cd->coa->coa_category_id == 56) {
                $repayment_proceed_loan             += $cd->debit - $cd->credit;
            }
        }
        $equity_capital             = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 12) {
                $equity_capital             += $cd->debit - $cd->credit;
            }
        }
        $net_cash_finan             = $repayment_proceed_loan + $equity_capital;

        $increase_dec_in_cash       = $net_cash_operating_acti + $net_cash_by_investing + $net_cash_finan;
        $beginning_cash             = 0;
        $ending_cash                = $beginning_cash + $increase_dec_in_cash;

        return view('admin.reports.overview.cashflow', compact([
            'today',
            'cash_received_from_cust',
            'other_current_asset',
            'cash_paid_to_supplier',
            'cc_and_current_liability',
            'other_income',
            'operating_expense',
            'net_cash_operating_acti',
            'purchase_sale_asset',
            'other_investing_asset',
            'net_cash_by_investing',
            'repayment_proceed_loan',
            'equity_capital',
            'net_cash_finan',
            'increase_dec_in_cash',
            'beginning_cash',
            'ending_cash',
        ]));
    }

    public function cashflowInput($start, $end)
    {
        $coa_detail                                 = coa_detail::whereBetween('date', [$start, $end])
            ->selectRaw('SUM(debit) as debit, SUM(credit) as credit, coa_id, type')->groupBy('number')->groupBy('coa_id')
            ->get();
        $cash_received_from_cust                    = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->type == 'sales payment') {
                if ($cd->coa->coa_category_id == 3) {
                    $cash_received_from_cust        += ($cd->debit - $cd->credit);
                }
            }
        }
        $other_current_asset                        = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 2) {
                $other_current_asset                += $cd->debit - $cd->credit;
            }
        }
        $cash_paid_to_supplier                      = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->type == 'purchase payment') {
                if ($cd->coa->coa_category_id == 3) {
                    $cash_paid_to_supplier          += $cd->credit - $cd->debit;
                }
            }
        }
        $cc_and_current_liability                   = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 9 or $cd->coa->coa_category_id == 10 && $cd->coa_id != 50 && $cd->coa_id != 51 && $cd->coa_id != 52 && $cd->coa_id != 53 && $cd->coa_id != 54 && $cd->coa_id != 55) {
                $cc_and_current_liability        += $cd->debit - $cd->credit;
            }
        }
        $other_income                               = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 14) {
                $other_income                       += $cd->debit - $cd->credit;
            }
        }
        $operating_expense                          = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->type == 'expense') {
                $operating_expense                  += $cd->debit;
            }
        }
        $net_cash_operating_acti    = $cash_received_from_cust + $other_current_asset - $cash_paid_to_supplier - $cc_and_current_liability + $other_income - $operating_expense;

        $purchase_sale_asset        = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 5) {
                $purchase_sale_asset                += $cd->debit - $cd->credit;
            }
        }
        $other_investing_asset      = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 6) {
                $other_investing_asset              += $cd->debit - $cd->credit;
            }
        }
        $net_cash_by_investing      = $purchase_sale_asset + $other_investing_asset;

        $repayment_proceed_loan     = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 49 or $cd->coa->coa_category_id == 56) {
                $repayment_proceed_loan             += $cd->debit - $cd->credit;
            }
        }
        $equity_capital             = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 12) {
                $equity_capital             += $cd->debit - $cd->credit;
            }
        }
        $net_cash_finan             = $repayment_proceed_loan + $equity_capital;

        $increase_dec_in_cash       = $net_cash_operating_acti + $net_cash_by_investing + $net_cash_finan;
        $beginning_cash             = 0;
        $ending_cash                = $beginning_cash + $increase_dec_in_cash;

        return view('admin.reports.overview.cashflowInput', compact([
            'start',
            'end',
            'cash_received_from_cust',
            'other_current_asset',
            'cash_paid_to_supplier',
            'cc_and_current_liability',
            'other_income',
            'operating_expense',
            'net_cash_operating_acti',
            'purchase_sale_asset',
            'other_investing_asset',
            'net_cash_by_investing',
            'repayment_proceed_loan',
            'equity_capital',
            'net_cash_finan',
            'increase_dec_in_cash',
            'beginning_cash',
            'ending_cash',
        ]));
    }

    public function cashflow_excel($start, $end)
    {
        return Excel::download(new cashflow($start, $end), 'cashflow_' . $start . '_' . $end . '.xlsx');
    }

    public function cashflow_csv($start, $end)
    {
        return Excel::download(new cashflow($start, $end), 'cashflow_' . $start . '_' . $end . '.csv');
    }

    public function cashflow_pdf($start, $end)
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $coa_detail                                 = coa_detail::whereBetween('date', [$start, $end])
            ->selectRaw('SUM(debit) as debit, SUM(credit) as credit, coa_id, type')->groupBy('number')->groupBy('coa_id')
            ->get();
        $cash_received_from_cust                    = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->type == 'sales payment') {
                if ($cd->coa->coa_category_id == 3) {
                    $cash_received_from_cust        += ($cd->debit - $cd->credit);
                }
            }
        }
        $other_current_asset                        = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 2) {
                $other_current_asset                += $cd->debit - $cd->credit;
            }
        }
        $cash_paid_to_supplier                      = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->type == 'purchase payment') {
                if ($cd->coa->coa_category_id == 3) {
                    $cash_paid_to_supplier          += $cd->credit - $cd->debit;
                }
            }
        }
        $cc_and_current_liability                   = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 9 or $cd->coa->coa_category_id == 10 && $cd->coa_id != 50 && $cd->coa_id != 51 && $cd->coa_id != 52 && $cd->coa_id != 53 && $cd->coa_id != 54 && $cd->coa_id != 55) {
                $cc_and_current_liability        += $cd->debit - $cd->credit;
            }
        }
        $other_income                               = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 14) {
                $other_income                       += $cd->debit - $cd->credit;
            }
        }
        $operating_expense                          = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->type == 'expense') {
                $operating_expense                  += $cd->debit;
            }
        }
        $net_cash_operating_acti    = $cash_received_from_cust + $other_current_asset - $cash_paid_to_supplier - $cc_and_current_liability + $other_income - $operating_expense;

        $purchase_sale_asset        = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 5) {
                $purchase_sale_asset                += $cd->debit - $cd->credit;
            }
        }
        $other_investing_asset      = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 6) {
                $other_investing_asset              += $cd->debit - $cd->credit;
            }
        }
        $net_cash_by_investing      = $purchase_sale_asset + $other_investing_asset;

        $repayment_proceed_loan     = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 49 or $cd->coa->coa_category_id == 56) {
                $repayment_proceed_loan             += $cd->debit - $cd->credit;
            }
        }
        $equity_capital             = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 12) {
                $equity_capital             += $cd->debit - $cd->credit;
            }
        }
        $net_cash_finan             = $repayment_proceed_loan + $equity_capital;

        $increase_dec_in_cash       = $net_cash_operating_acti + $net_cash_by_investing + $net_cash_finan;
        $beginning_cash             = 0;
        $ending_cash                = $beginning_cash + $increase_dec_in_cash;
        $view = view('admin.reports.overview_export.cashflow_pdf')->with(compact([
            'company', 'start',
            'end',
            'cash_received_from_cust',
            'other_current_asset',
            'cash_paid_to_supplier',
            'cc_and_current_liability',
            'other_income',
            'operating_expense',
            'net_cash_operating_acti',
            'purchase_sale_asset',
            'other_investing_asset',
            'net_cash_by_investing',
            'repayment_proceed_loan',
            'equity_capital',
            'net_cash_finan',
            'increase_dec_in_cash',
            'beginning_cash',
            'ending_cash',
        ]));
        $html = $view->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('cashflow_' . $start . '_' . $end . '.pdf');
    }

    public function executive_summaryLAMA()
    {
        /*$coa                        = coa::where('balance', '!=', 0)->get();
        $coa_detail                 = coa_detail::get();
        $total_coa_aktiva                   = coa::whereIn('coa_category_id', [1, 2, 3, 4])->sum('balance');
        $total_coa_fixed_account            = coa::whereIn('coa_category_id', [5])->sum('balance');
        $total_coa_depreciation             = coa::whereIn('coa_category_id', [7])->sum('balance');
        $total_coa_liabilities              = coa::whereIn('coa_category_id', [8, 10, 11])->sum('balance');
        $total_coa_equity                   = coa::whereIn('coa_category_id', [12])->sum('balance');
        // PROFIT & LOSS
        $revenues                           = coa::whereIn('coa_category_id', [13])->sum('balance');
        $cost_of_sales                      = coa::whereIn('coa_category_id', [15])->sum('balance');
        $expenses                           = coa::whereIn('coa_category_id', [16])->sum('balance');
        $other_income                       = coa::whereIn('coa_category_id', [14])->sum('balance');
        $operating_profit                   = abs($revenues) - $cost_of_sales - $expenses;
        $net_profit                         = $operating_profit + $other_income;

        // BALANCE SHEET
        $current_assets                     = coa::whereIn('coa_category_id', [1, 2, 3, 4])->sum('balance');
        $non_current_assets                 = coa::whereIn('coa_category_id', [5, 7])->sum('balance');
        $current_liability                  = coa::whereIn('coa_category_id', [8, 10])->sum('balance');
        $non_current_liability              = coa::whereIn('coa_category_id', [11])->sum('balance');
        $equity                             = abs($current_assets) - abs($current_liability);

        return view('admin.reports.overview.executive_summary', compact([
            'coa',
            'coa_detail',
            'total_coa_aktiva',
            'total_coa_fixed_account',
            'total_coa_depreciation',
            'total_coa_liabilities',
            'total_coa_equity',
            'revenues',
            'cost_of_sales',
            'expenses',
            'operating_profit',
            'net_profit',
            'current_assets',
            'non_current_assets',
            'current_liability',
            'non_current_liability',
            'equity',
        ]));*/
        // PROFIT LOSS
        $revenues                   = coa::whereIn('coa_category_id', [13])->sum('balance');
        $cost_of_sales              = coa::whereIn('coa_category_id', [15])->sum('balance');
        $gross_profit               = $revenues - $cost_of_sales;
        $operational_expense        = coa::whereIn('coa_category_id', [16])->sum('balance');
        $net_operating_income       = $gross_profit - $operational_expense;
        $other_income               = coa::whereIn('coa_category_id', [14])->sum('balance');
        $other_expense              = coa::whereIn('coa_category_id', [17])->sum('balance');
        $operating_profit           = $revenues - $cost_of_sales - $operational_expense;
        $net_profit                 = $operating_profit + $other_income - $other_expense;

        // BALANCE SHEET
        $current_assets                       = coa::whereIn('coa_category_id', [1, 3, 4])->sum('balance');
        $other_current_assets                 = coa::whereIn('coa_category_id', [2])->sum('balance');
        $fixed_assets                         = coa::whereIn('coa_category_id', [5, 6])->sum('balance');
        $depreciation                         = coa::whereIn('coa_category_id', [7])->sum('balance');
        $assets                               = $current_assets + $fixed_assets - $depreciation;
        $current_liability                    = coa::whereIn('coa_category_id', [8, 16, 17])->sum('balance');
        $other_current_liability              = coa::whereIn('coa_category_id', [10, 11])->sum('balance');
        $equity                               = coa::whereIn('coa_category_id', [12])->sum('balance');
        $equity2                              = $equity + $assets - $current_liability;
        $current_period_earning               = $assets - $current_liability;
        $lia_eq                               = $current_liability + $equity;

        // CASH FLOW
        $cash_received_from_cust    = coa_detail::where('coa_id', 4)->sum('credit');
        //$other_current_asset        = coa_detail::where('type', 'bankwithdrawalaccount')->sum('credit');
        $other_current_asset        = coa::whereIn('coa_category_id', [2])->sum('balance');
        $cash_paid_to_supplier      = coa_detail::where('coa_id', 40)->sum('debit');
        $cc_and_current_liability   = coa::whereIn('coa_category_id', [9, 10])
            ->where('id', '!=', 50)
            ->where('id', '!=', 51)
            ->where('id', '!=', 52)
            ->where('id', '!=', 53)
            ->where('id', '!=', 54)
            ->where('id', '!=', 55)
            ->sum('balance');
        $other_income               = coa::whereIn('coa_category_id', [14])->sum('balance');
        $operating_expense          = coa_detail::where('type', 'expense')->sum('debit');
        $net_cash_operating_acti    = $cash_received_from_cust + $other_current_asset - $cash_paid_to_supplier - $cc_and_current_liability + $other_income - $operating_expense;

        $purchase_sale_asset        = coa::whereIn('coa_category_id', [5])->sum('balance');
        $other_investing_asset      = coa::whereIn('coa_category_id', [6])->sum('balance');
        $net_cash_by_investing      = $purchase_sale_asset + $other_investing_asset;

        $repayment_proceed_loan     = coa::whereIn('id', [49, 56])->sum('balance');
        $equity_capital             = coa::whereIn('coa_category_id', [12])->sum('balance');
        $net_cash_finan             = $repayment_proceed_loan + $equity_capital;

        $non_operating_activities   = $net_cash_by_investing + $net_cash_finan;
        $net_cash_movement          = $net_cash_operating_acti + $non_operating_activities;
        $increase_dec_in_cash       = $net_cash_operating_acti + $net_cash_by_investing + $net_cash_finan;
        $beginning_cash             = 0;
        $ending_cash                = $beginning_cash + $increase_dec_in_cash;

        $gross_profit_margin        = (isset($gross_profit) / isset($revenues)) * 100;
        $net_profit2                = $gross_profit - $operational_expense;
        $operating_profit_margin    = (isset($net_profit2) / isset($revenues)) * 100;
        $net_profit_margin          = (isset($net_profit2) / isset($revenues)) * 100;

        $current_ratio              = isset($current_assets) / isset($current_liability);
        $total_liability            = $current_liability + $other_current_liability;
        $debt_to_equity_ratio       = isset($total_liability) / isset($equity);

        $total_asset                = coa::whereIn('coa_category_id', [2, 3, 4, 5, 6, 7])->sum('balance');
        $avg_total_asset            = isset($total_asset) / 2;
        $roa                        = isset($revenues) / isset($avg_total_asset);

        $roe                        = isset($revenues) / isset($equity);
        $total_ar                   = coa::whereIn('coa_category_id', [1])->sum('balance');
        $total_ap                   = coa::whereIn('coa_category_id', [8])->sum('balance');
        $avg_debtor                 = isset($total_ar) / 365;
        $avg_crebtor                = isset($total_ap) / 365;
        return view('admin.reports.overview.executive_summary', compact([
            'revenues',
            'cost_of_sales',
            'gross_profit',
            'operational_expense',
            'net_operating_income',
            'other_income',
            'other_expense',
            'operating_profit',
            'net_profit',
            'current_assets',
            'other_current_assets',
            'current_liability',
            'other_current_liability',
            'equity2',
            'net_cash_operating_acti',
            'non_operating_activities',
            'net_cash_movement',
            'ending_cash',
            'gross_profit_margin',
            'operating_profit_margin',
            'net_profit_margin',
            'current_ratio',
            'debt_to_equity_ratio',
            'roa',
            'roe',
            'avg_debtor',
            'avg_crebtor',
        ]));
    }

    public function executive_summary()
    {
        // start PROFIT LOSS
        $today                                      = Carbon::today()->toDateString();
        $coa_detailPL                                 = coa_detail::whereBetween('date', [$today, $today])
            ->orderBy('date')
            ->selectRaw('SUM(debit - credit) as total, coa_id')
            ->groupBy('coa_id')
            ->get();

        $total_primary_income       = 0;
        foreach ($coa_detailPL as $cd) {
            if ($cd->coa->coa_category_id == 13) {
                $total_primary_income                   += abs($cd->total);
            }
        }
        $total_cost_of_sales        = 0;
        foreach ($coa_detailPL as $cd) {
            if ($cd->coa->coa_category_id == 15) {
                $total_cost_of_sales                   += $cd->total;
            }
        }
        $gross_profit               = $total_primary_income - $total_cost_of_sales;

        $total_operational_expense  = 0;
        foreach ($coa_detailPL as $cd) {
            if ($cd->coa->coa_category_id == 16) {
                $total_operational_expense                   += $cd->total;
            }
        }
        $net_operating_income       = $gross_profit - $total_operational_expense;

        $total_other_income         = 0;
        foreach ($coa_detailPL as $cd) {
            if ($cd->coa->coa_category_id == 14) {
                $total_other_income                   += $cd->total;
            }
        }

        $total_other_expense        = 0;
        foreach ($coa_detailPL as $cd) {
            if ($cd->coa->coa_category_id == 17) {
                $total_other_expense                   += $cd->total;
            }
        }
        $net_income                 = $net_operating_income + $total_other_income - $total_other_expense;
        // end PROFIT LOSS

        // start BALANCE SHEET
        $coa_detailBS                                 = coa_detail::whereBetween('date', [$today, $today])->orderBy('date')->selectRaw('SUM(debit - credit) as total, coa_id')->groupBy('coa_id')->get();
        $total_current_assets                       = 0;
        foreach ($coa_detailBS as $cd) {
            if ($cd->coa->coa_category_id == 1 or $cd->coa->coa_category_id == 2 or $cd->coa->coa_category_id == 3 or $cd->coa->coa_category_id == 4) {
                $total_current_assets                   += $cd->total;
            }
        }
        $total_fixed_assets                         = 0;
        foreach ($coa_detailBS as $cd) {
            if ($cd->coa->coa_category_id == 5 or $cd->coa->coa_category_id == 6) {
                $total_fixed_assets                   += $cd->total;
            }
        }
        $total_depreciation                         = 0;
        foreach ($coa_detailBS as $cd) {
            if ($cd->coa->coa_category_id == 7) {
                $total_depreciation                   += $cd->total;
            }
        }
        $total_assets                               = $total_current_assets + $total_fixed_assets - $total_depreciation;
        $total_liability                            = 0;
        foreach ($coa_detailBS as $cd) {
            if ($cd->coa->coa_category_id == 8 or $cd->coa->coa_category_id == 10 or $cd->coa->coa_category_id == 17) {
                $total_liability                   += $cd->total;
            }
        }
        $total_other_liability                            = 0;
        foreach ($coa_detailBS as $cd) {
            if ($cd->coa->coa_category_id == 11) {
                $total_other_liability                   += $cd->total;
            }
        }
        $total_equity                               = 0;
        foreach ($coa_detailBS as $cd) {
            if ($cd->coa->coa_category_id == 12) {
                $total_equity                   += $cd->total;
            }
        }
        $total_equity2                              = $total_assets - $total_liability;
        $current_period_earning                     = $total_assets - $total_liability;
        $total_lia_eq                               = $total_liability + $total_equity2;
        // end BALANCE SHEET

        // start CASH FLOW
        $coa_detailCF                                 = coa_detail::whereBetween('date', [$today, $today])
            ->selectRaw('SUM(debit) as debit, SUM(credit) as credit, coa_id, type')->groupBy('number')->groupBy('coa_id')
            ->get();
        $cash_received_from_cust                    = 0;
        foreach ($coa_detailCF as $cd) {
            if ($cd->type == 'sales payment') {
                if ($cd->coa->coa_category_id == 3) {
                    $cash_received_from_cust        += ($cd->debit - $cd->credit);
                }
            }
        }
        $other_current_asset                        = 0;
        foreach ($coa_detailCF as $cd) {
            if ($cd->coa->coa_category_id == 2) {
                $other_current_asset                += $cd->debit - $cd->credit;
            }
        }
        $cash_paid_to_supplier                      = 0;
        foreach ($coa_detailCF as $cd) {
            if ($cd->type == 'purchase payment') {
                if ($cd->coa->coa_category_id == 3) {
                    $cash_paid_to_supplier          += $cd->credit - $cd->debit;
                }
            }
        }
        $cc_and_current_liability                   = 0;
        foreach ($coa_detailCF as $cd) {
            if ($cd->coa->coa_category_id == 9 or $cd->coa->coa_category_id == 10 && $cd->coa_id != 50 && $cd->coa_id != 51 && $cd->coa_id != 52 && $cd->coa_id != 53 && $cd->coa_id != 54 && $cd->coa_id != 55) {
                $cc_and_current_liability        += $cd->debit - $cd->credit;
            }
        }
        $other_income                               = 0;
        foreach ($coa_detailCF as $cd) {
            if ($cd->coa->coa_category_id == 14) {
                $other_income                       += $cd->debit - $cd->credit;
            }
        }
        $operating_expense                          = 0;
        foreach ($coa_detailCF as $cd) {
            if ($cd->type == 'expense') {
                $operating_expense                  += $cd->debit;
            }
        }
        $net_cash_operating_acti    = $cash_received_from_cust + $other_current_asset - $cash_paid_to_supplier - $cc_and_current_liability + $other_income - $operating_expense;

        $purchase_sale_asset        = 0;
        foreach ($coa_detailCF as $cd) {
            if ($cd->coa->coa_category_id == 5) {
                $purchase_sale_asset                += $cd->debit - $cd->credit;
            }
        }
        $other_investing_asset      = 0;
        foreach ($coa_detailCF as $cd) {
            if ($cd->coa->coa_category_id == 6) {
                $other_investing_asset              += $cd->debit - $cd->credit;
            }
        }
        $net_cash_by_investing      = $purchase_sale_asset + $other_investing_asset;

        $repayment_proceed_loan     = 0;
        foreach ($coa_detailCF as $cd) {
            if ($cd->coa->coa_category_id == 49 or $cd->coa->coa_category_id == 56) {
                $repayment_proceed_loan             += $cd->debit - $cd->credit;
            }
        }
        $equity_capital             = 0;
        foreach ($coa_detailCF as $cd) {
            if ($cd->coa->coa_category_id == 12) {
                $equity_capital             += $cd->debit - $cd->credit;
            }
        }
        $net_cash_finan             = $repayment_proceed_loan + $equity_capital;

        $increase_dec_in_cash       = $net_cash_operating_acti + $net_cash_by_investing + $net_cash_finan;
        $beginning_cash             = 0;
        $ending_cash                = $beginning_cash + $increase_dec_in_cash;
        // end CASH FLOW

        return view('admin.reports.overview.executive_summary', compact([
            'today',
            'coa_detailPL',
            'total_primary_income',
            'total_cost_of_sales',
            'gross_profit',
            'total_operational_expense',
            'net_operating_income',
            'total_other_income',
            'total_other_expense',
            'net_income',
            'coa_detailBS',
            'total_current_assets',
            'total_fixed_assets',
            'total_depreciation',
            'total_assets',
            'total_liability',
            'total_other_liability',
            'total_equity2',
            'current_period_earning',
            'total_lia_eq',
            'cash_received_from_cust',
            'other_current_asset',
            'cash_paid_to_supplier',
            'cc_and_current_liability',
            'other_income',
            'operating_expense',
            'net_cash_operating_acti',
            'purchase_sale_asset',
            'other_investing_asset',
            'net_cash_by_investing',
            'repayment_proceed_loan',
            'equity_capital',
            'net_cash_finan',
            'increase_dec_in_cash',
            'beginning_cash',
            'ending_cash',
        ]));
    }

    public function executive_summaryInput($start, $end)
    {
        // start PROFIT LOSS
        $coa_detailPL                                 = coa_detail::whereBetween('date', [$start, $end])
            ->orderBy('date')
            ->selectRaw('SUM(debit - credit) as total, coa_id')
            ->groupBy('coa_id')
            ->get();

        $total_primary_income       = 0;
        foreach ($coa_detailPL as $cd) {
            if ($cd->coa->coa_category_id == 13) {
                $total_primary_income                   += abs($cd->total);
            }
        }
        $total_cost_of_sales        = 0;
        foreach ($coa_detailPL as $cd) {
            if ($cd->coa->coa_category_id == 15) {
                $total_cost_of_sales                   += $cd->total;
            }
        }
        $gross_profit               = $total_primary_income - $total_cost_of_sales;

        $total_operational_expense  = 0;
        foreach ($coa_detailPL as $cd) {
            if ($cd->coa->coa_category_id == 16) {
                $total_operational_expense                   += $cd->total;
            }
        }
        $net_operating_income       = $gross_profit - $total_operational_expense;

        $total_other_income         = 0;
        foreach ($coa_detailPL as $cd) {
            if ($cd->coa->coa_category_id == 14) {
                $total_other_income                   += $cd->total;
            }
        }

        $total_other_expense        = 0;
        foreach ($coa_detailPL as $cd) {
            if ($cd->coa->coa_category_id == 17) {
                $total_other_expense                   += $cd->total;
            }
        }
        $net_income                 = $net_operating_income + $total_other_income - $total_other_expense;
        // end PROFIT LOSS

        // start BALANCE SHEET
        $coa_detailBS                                 = coa_detail::whereBetween('date', [$start, $end])->orderBy('date')->selectRaw('SUM(debit - credit) as total, coa_id')->groupBy('coa_id')->get();
        $total_current_assets                       = 0;
        foreach ($coa_detailBS as $cd) {
            if ($cd->coa->coa_category_id == 1 or $cd->coa->coa_category_id == 2 or $cd->coa->coa_category_id == 3 or $cd->coa->coa_category_id == 4) {
                $total_current_assets                   += $cd->total;
            }
        }
        $total_fixed_assets                         = 0;
        foreach ($coa_detailBS as $cd) {
            if ($cd->coa->coa_category_id == 5 or $cd->coa->coa_category_id == 6) {
                $total_fixed_assets                   += $cd->total;
            }
        }
        $total_depreciation                         = 0;
        foreach ($coa_detailBS as $cd) {
            if ($cd->coa->coa_category_id == 7) {
                $total_depreciation                   += $cd->total;
            }
        }
        $total_assets                               = $total_current_assets + $total_fixed_assets - $total_depreciation;
        $total_liability                            = 0;
        foreach ($coa_detailBS as $cd) {
            if ($cd->coa->coa_category_id == 8 or $cd->coa->coa_category_id == 10 or $cd->coa->coa_category_id == 17) {
                $total_liability                   += $cd->total;
            }
        }
        $total_other_liability                            = 0;
        foreach ($coa_detailBS as $cd) {
            if ($cd->coa->coa_category_id == 11) {
                $total_other_liability                   += $cd->total;
            }
        }
        $total_equity                               = 0;
        foreach ($coa_detailBS as $cd) {
            if ($cd->coa->coa_category_id == 12) {
                $total_equity                   += $cd->total;
            }
        }
        $total_equity2                              = $total_assets - $total_liability;
        $current_period_earning                     = $total_assets - $total_liability;
        $total_lia_eq                               = $total_liability + $total_equity2;
        // end BALANCE SHEET

        // start CASH FLOW
        $coa_detailCF                                 = coa_detail::whereBetween('date', [$start, $end])
            ->selectRaw('SUM(debit) as debit, SUM(credit) as credit, coa_id, type')->groupBy('number')->groupBy('coa_id')
            ->get();
        $cash_received_from_cust                    = 0;
        foreach ($coa_detailCF as $cd) {
            if ($cd->type == 'sales payment') {
                if ($cd->coa->coa_category_id == 3) {
                    $cash_received_from_cust        += ($cd->debit - $cd->credit);
                }
            }
        }
        $other_current_asset                        = 0;
        foreach ($coa_detailCF as $cd) {
            if ($cd->coa->coa_category_id == 2) {
                $other_current_asset                += $cd->debit - $cd->credit;
            }
        }
        $cash_paid_to_supplier                      = 0;
        foreach ($coa_detailCF as $cd) {
            if ($cd->type == 'purchase payment') {
                if ($cd->coa->coa_category_id == 3) {
                    $cash_paid_to_supplier          += $cd->credit - $cd->debit;
                }
            }
        }
        $cc_and_current_liability                   = 0;
        foreach ($coa_detailCF as $cd) {
            if ($cd->coa->coa_category_id == 9 or $cd->coa->coa_category_id == 10 && $cd->coa_id != 50 && $cd->coa_id != 51 && $cd->coa_id != 52 && $cd->coa_id != 53 && $cd->coa_id != 54 && $cd->coa_id != 55) {
                $cc_and_current_liability        += $cd->debit - $cd->credit;
            }
        }
        $other_income                               = 0;
        foreach ($coa_detailCF as $cd) {
            if ($cd->coa->coa_category_id == 14) {
                $other_income                       += $cd->debit - $cd->credit;
            }
        }
        $operating_expense                          = 0;
        foreach ($coa_detailCF as $cd) {
            if ($cd->type == 'expense') {
                $operating_expense                  += $cd->debit;
            }
        }
        $net_cash_operating_acti    = $cash_received_from_cust + $other_current_asset - $cash_paid_to_supplier - $cc_and_current_liability + $other_income - $operating_expense;

        $purchase_sale_asset        = 0;
        foreach ($coa_detailCF as $cd) {
            if ($cd->coa->coa_category_id == 5) {
                $purchase_sale_asset                += $cd->debit - $cd->credit;
            }
        }
        $other_investing_asset      = 0;
        foreach ($coa_detailCF as $cd) {
            if ($cd->coa->coa_category_id == 6) {
                $other_investing_asset              += $cd->debit - $cd->credit;
            }
        }
        $net_cash_by_investing      = $purchase_sale_asset + $other_investing_asset;

        $repayment_proceed_loan     = 0;
        foreach ($coa_detailCF as $cd) {
            if ($cd->coa->coa_category_id == 49 or $cd->coa->coa_category_id == 56) {
                $repayment_proceed_loan             += $cd->debit - $cd->credit;
            }
        }
        $equity_capital             = 0;
        foreach ($coa_detailCF as $cd) {
            if ($cd->coa->coa_category_id == 12) {
                $equity_capital             += $cd->debit - $cd->credit;
            }
        }
        $net_cash_finan             = $repayment_proceed_loan + $equity_capital;

        $increase_dec_in_cash       = $net_cash_operating_acti + $net_cash_by_investing + $net_cash_finan;
        $beginning_cash             = 0;
        $ending_cash                = $beginning_cash + $increase_dec_in_cash;
        // end CASH FLOW

        return view('admin.reports.overview.executive_summaryInput', compact([
            'start',
            'end',
            'coa_detailPL',
            'total_primary_income',
            'total_cost_of_sales',
            'gross_profit',
            'total_operational_expense',
            'net_operating_income',
            'total_other_income',
            'total_other_expense',
            'net_income',
            'coa_detailBS',
            'total_current_assets',
            'total_fixed_assets',
            'total_depreciation',
            'total_assets',
            'total_liability',
            'total_other_liability',
            'total_equity2',
            'current_period_earning',
            'total_lia_eq',
            'cash_received_from_cust',
            'other_current_asset',
            'cash_paid_to_supplier',
            'cc_and_current_liability',
            'other_income',
            'operating_expense',
            'net_cash_operating_acti',
            'purchase_sale_asset',
            'other_investing_asset',
            'net_cash_by_investing',
            'repayment_proceed_loan',
            'equity_capital',
            'net_cash_finan',
            'increase_dec_in_cash',
            'beginning_cash',
            'ending_cash',
        ]));
    }
    // OVERVIEW

    // SALES
    public function sales_list()
    {
        $today                                      = Carbon::today()->toDateString();
        $other_transaction                          = other_transaction::with('ot_contact', 'ot_status')
            ->whereBetween('transaction_date', [$today, $today])
            ->get();
        return view(
            'admin.reports.sales.sales_list',
            compact([
                'today',
                'other_transaction'
            ])
        );
    }

    public function sales_listInput($start, $end)
    {
        $other_transaction                          = other_transaction::with('ot_contact', 'ot_status')
            ->whereBetween('transaction_date', [$start, $end])
            ->get();
        return view(
            'admin.reports.sales.sales_listInput',
            compact([
                'start',
                'end',
                'other_transaction'
            ])
        );
    }

    public function sales_by_customer()
    {
        $today                      = Carbon::today()->toDateString();
        $contact                    = contact::get();
        $si                         = sale_invoice::whereBetween('transaction_date', [$today, $today])->get();
        $sid                        = sale_invoice_item::get();
        return view(
            'admin.reports.sales.sales_by_customer',
            compact([
                'today',
                'contact',
                'si',
                'sid'
            ])
        );
    }

    public function sales_by_customerInput($start, $end)
    {
        $contact                    = contact::get();
        $si                         = sale_invoice::whereBetween('transaction_date', [$start, $end])->get();
        $sid                        = sale_invoice_item::get();
        return view(
            'admin.reports.sales.sales_by_customerInput',
            compact([
                'start',
                'end',
                'contact',
                'si',
                'sid'
            ])
        );
    }

    public function customer_balance()
    {
        $today                      = Carbon::today()->toDateString();
        $contact                    = contact::get();
        $si                         = sale_invoice::whereBetween('transaction_date', [$today, $today])->get();
        $sid                        = sale_invoice_item::get();
        return view(
            'admin.reports.sales.customer_balance',
            compact([
                'today', 'contact', 'si', 'sid'
            ])
        );
    }

    public function customer_balanceInput($mulaidari)
    {
        $today                      = Carbon::today()->toDateString();
        $today2                     = $mulaidari;
        if (Carbon::parse($today2)->gt(Carbon::now())) {
            $si                         = sale_invoice::whereBetween('transaction_date', [$today, $today2])->get();
        } else {
            $si                         = sale_invoice::whereBetween('transaction_date', [$today2, $today])->get();
        }
        $contact                    = contact::get();
        $sid                        = sale_invoice_item::get();
        return view(
            'admin.reports.sales.customer_balanceInput',
            compact([
                'today', 'today2', 'contact', 'si', 'sid'
            ])
        );
    }

    public function aged_receivable()
    {
        $today                      = Carbon::today()->toDateString();
        $contact                    = contact::get();
        $si                         = sale_invoice::whereBetween('transaction_date', [$today, $today])
            ->selectRaw('SUM(balance_due) as balance_due, transaction_date, contact_id')
            ->groupBy('contact_id')
            ->get();
        return view(
            'admin.reports.sales.aged_receivable',
            compact([
                'today',
                'contact',
                'si'
            ])
        );
    }

    public function aged_receivableInput($mulaidari)
    {
        $today                      = Carbon::today()->toDateString();
        $today2                     = $mulaidari;
        if (Carbon::parse($today)->gt(Carbon::now())) {
            $si                         = sale_invoice::whereBetween('transaction_date', [$today, $today2])
                ->selectRaw('SUM(balance_due) as balance_due, transaction_date, contact_id')
                ->groupBy('contact_id')
                ->get();
        } else {
            $si                         = sale_invoice::whereBetween('transaction_date', [$today2, $today])
                ->selectRaw('SUM(balance_due) as balance_due, transaction_date, contact_id')
                ->groupBy('contact_id')
                ->get();
        }
        $contact                    = contact::get();
        return view(
            'admin.reports.sales.aged_receivableInput',
            compact([
                'today',
                'today2',
                'contact',
                'si'
            ])
        );
    }

    public function sales_delivery()
    {
        $today                      = Carbon::today()->toDateString();
        $contact                    = contact::get();
        $sd                         = sale_delivery::whereBetween('transaction_date', [$today, $today])->get();
        $sditem                     = sale_delivery_item::get();
        return view('admin.reports.sales.sales_delivery', compact([
            'today',
            'contact',
            'sd',
            'sditem',
        ]));
    }

    public function sales_deliveryInput($start, $end)
    {
        $contact                    = contact::get();
        $sd                         = sale_delivery::whereBetween('transaction_date', [$start, $end])->get();
        $sditem                     = sale_delivery_item::get();
        return view('admin.reports.sales.sales_deliveryInput', compact([
            'start',
            'end',
            'contact',
            'sd',
            'sditem',
        ]));
    }

    public function sales_by_product()
    {
        $today                      = Carbon::today()->toDateString();
        $si                         = sale_invoice::whereBetween('transaction_date', [$today, $today])->get();
        $sid                        = sale_invoice_item::get();
        $sirr                       = sale_return_item::first();
        if ($sirr == null) {
            $sir                    = 0;
        } else {
            $sir                    = sale_return_item::get();
        }
        return view('admin.reports.sales.sales_by_product', compact(['today', 'si', 'sid', 'sir']));
    }

    public function sales_by_productInput($start, $end)
    {
        $si                         = sale_invoice::whereBetween('transaction_date', [$start, $end])->get();
        $sid                        = sale_invoice_item::get();
        $sirr                       = sale_return_item::first();
        if ($sirr == null) {
            $sir                    = 0;
        } else {
            $sir                    = sale_return_item::get();
        }
        return view('admin.reports.sales.sales_by_productInput', compact(['start', 'end', 'si', 'sid', 'sir']));
    }

    public function sales_order_completion()
    {
        $today                      = Carbon::today()->toDateString();
        $so                         = sale_order::get();
        $si                         = sale_invoice::selectRaw('SUM(grandtotal) as grandtotal, selected_so_id')
            ->groupBy('grandtotal')
            ->get();
        $sd                         = sale_delivery::selectRaw('SUM(grandtotal) as grandtotal, selected_so_id')
            ->groupBy('grandtotal')
            ->get();
        $spi                        = sale_payment_item::selectRaw('SUM(payment_amount) as payment_amount, sale_invoice_id')
            ->groupBy('payment_amount')
            ->get();
        //dd($spi);
        return view('admin.reports.sales.sales_order_completion', compact(['today', 'so', 'si', 'sd', 'spi']));
    }
    //SALES
    // PURCHASES
    public function purchases_list()
    {
        $today                                      = Carbon::today()->toDateString();
        $other_transaction                          = other_transaction::with('ot_contact', 'ot_status')
            ->whereBetween('transaction_date', [$today, $today])
            ->get();
        return view(
            'admin.reports.purchases.purchases_list',
            compact([
                'today',
                'other_transaction'
            ])
        );
    }

    public function purchases_listInput($start, $end)
    {
        $other_transaction                          = other_transaction::with('ot_contact', 'ot_status')
            ->whereBetween('transaction_date', [$start, $end])
            ->get();
        return view(
            'admin.reports.purchases.purchases_listInput',
            compact([
                'start',
                'end',
                'other_transaction'
            ])
        );
    }

    public function purchases_by_vendor()
    {
        $today                      = Carbon::today()->toDateString();
        $contact                    = contact::get();
        $si                         = purchase_invoice::whereBetween('transaction_date', [$today, $today])->get();
        $sid                        = purchase_invoice_item::get();
        return view(
            'admin.reports.purchases.purchases_by_vendor',
            compact([
                'today',
                'contact',
                'si',
                'sid'
            ])
        );
    }

    public function purchases_by_vendorInput($start, $end)
    {
        $contact                    = contact::get();
        $si                         = purchase_invoice::whereBetween('transaction_date', [$start, $end])->get();
        $sid                        = purchase_invoice_item::get();
        return view(
            'admin.reports.purchases.purchases_by_vendorInput',
            compact([
                'start',
                'end',
                'contact',
                'si',
                'sid'
            ])
        );
    }

    public function vendor_balance()
    {
        $today                      = Carbon::today()->toDateString();
        $contact                    = contact::get();
        $si                         = purchase_invoice::whereBetween('transaction_date', [$today, $today])->get();
        $sid                        = purchase_invoice_item::get();
        return view(
            'admin.reports.purchases.vendor_balance',
            compact([
                'today', 'contact', 'si', 'sid'
            ])
        );
    }

    public function vendor_balanceInput($mulaidari)
    {
        $today                      = Carbon::today()->toDateString();
        $today2                     = $mulaidari;
        if (Carbon::parse($today)->gt(Carbon::now())) {
            $si                         = purchase_invoice::whereBetween('transaction_date', [$today, $today2])->get();
        } else {
            $si                         = purchase_invoice::whereBetween('transaction_date', [$today2, $today])->get();
        }
        $contact                    = contact::get();
        $sid                        = purchase_invoice_item::get();
        return view(
            'admin.reports.purchases.vendor_balanceInput',
            compact([
                'today', 'today2', 'contact', 'si', 'sid'
            ])
        );
    }

    public function aged_payable()
    {
        $today                      = Carbon::today()->toDateString();
        $contact                    = contact::get();
        $si                         = purchase_invoice::whereBetween('transaction_date', [$today, $today])
            ->selectRaw('SUM(balance_due) as balance_due, transaction_date, contact_id')
            ->groupBy('contact_id')
            ->get();
        return view(
            'admin.reports.purchases.aged_payable',
            compact([
                'today',
                'contact',
                'si'
            ])
        );
    }

    public function aged_payableInput($mulaidari)
    {
        $today                      = Carbon::today()->toDateString();
        $today2                     = $mulaidari;
        if (Carbon::parse($today)->gt(Carbon::now())) {
            $si                         = purchase_invoice::whereBetween('transaction_date', [$today, $today2])
                ->selectRaw('SUM(balance_due) as balance_due, transaction_date, contact_id')
                ->groupBy('contact_id')
                ->get();
        } else {
            $si                         = purchase_invoice::whereBetween('transaction_date', [$today2, $today])
                ->selectRaw('SUM(balance_due) as balance_due, transaction_date, contact_id')
                ->groupBy('contact_id')
                ->get();
        }
        $contact                    = contact::get();
        return view(
            'admin.reports.purchases.aged_payableInput',
            compact([
                'today',
                'today2',
                'contact',
                'si'
            ])
        );
    }

    public function purchases_delivery()
    {
        $today                      = Carbon::today()->toDateString();
        $contact                    = contact::get();
        $sd                         = purchase_delivery::whereBetween('transaction_date', [$today, $today])->get();
        $sditem                     = purchase_delivery_item::get();
        return view('admin.reports.purchases.purchases_delivery', compact([
            'today',
            'contact',
            'sd',
            'sditem',
        ]));
    }

    public function purchases_deliveryInput($start, $end)
    {
        $contact                    = contact::get();
        $sd                         = purchase_delivery::whereBetween('transaction_date', [$start, $end])->get();
        $sditem                     = purchase_delivery_item::get();
        return view('admin.reports.purchases.purchases_deliveryInput', compact([
            'start',
            'end',
            'contact',
            'sd',
            'sditem',
        ]));
    }

    public function purchases_by_product()
    {
        $today                      = Carbon::today()->toDateString();
        $si                         = purchase_invoice::whereBetween('transaction_date', [$today, $today])->get();
        $sid                        = purchase_invoice_item::get();
        $sirr                       = purchase_return_item::first();
        if ($sirr == null) {
            $sir                    = 0;
        } else {
            $sir                    = purchase_return_item::get();
        }
        return view('admin.reports.purchases.purchases_by_product', compact(['today', 'si', 'sid', 'sir']));
    }

    public function purchases_by_productInput($start, $end)
    {
        $si                         = purchase_invoice::whereBetween('transaction_date', [$start, $end])->get();
        $sid                        = purchase_invoice_item::get();
        $sirr                       = purchase_return_item::first();
        if ($sirr == null) {
            $sir                    = 0;
        } else {
            $sir                    = purchase_return_item::get();
        }
        return view('admin.reports.purchases.purchases_by_productInput', compact(['start', 'end', 'si', 'sid', 'sir']));
    }

    public function purchases_order_completion()
    {
        $today                      = Carbon::today()->toDateString();
        $so                         = purchase_order::get();
        $si                         = purchase_invoice::selectRaw('SUM(grandtotal) as grandtotal, selected_po_id')
            ->groupBy('grandtotal')
            ->get();
        $sd                         = purchase_delivery::selectRaw('SUM(grandtotal) as grandtotal, selected_po_id')
            ->groupBy('grandtotal')
            ->get();
        $spi                        = purchase_payment_item::selectRaw('SUM(payment_amount) as payment_amount, purchase_invoice_id')
            ->groupBy('payment_amount')
            ->get();
        //dd($spi);
        return view('admin.reports.purchases.purchases_order_completion', compact(['today', 'so', 'si', 'sd', 'spi']));
    }
    // PURCHASES

    // EXPENSES
    public function expenses_list()
    {
        $today                      = Carbon::today()->toDateString();
        $ex                         = expense::whereBetween('transaction_date', [$today, $today])->get();
        $exi                        = expense_item::with('expense_id')->get();
        return view('admin.reports.expenses.expenses_list', compact(['today', 'ex', 'exi']));
    }

    public function expenses_listInput($start, $end)
    {
        $ex                         = expense::whereBetween('transaction_date', [$start, $end])->get();
        $exi                        = expense_item::with('expense_id')->get();
        return view('admin.reports.expenses.expenses_listInput', compact(['start', 'end', 'ex', 'exi']));
    }
    // EXPENSES

    // PRODUCTS
    public function inventory_summary()
    {
        $today                      = Carbon::today()->toDateString();
        $products                   = product::where('is_track', 1)->get();
        return view('admin.reports.products.inventory_summary', compact(['today', 'products']));
    }

    public function inventory_summaryInput($mulaidari)
    {
        $today                      = Carbon::today()->toDateString();
        $today2                     = $mulaidari;
        if (Carbon::parse($today)->gt(Carbon::now())) {
            $products               = product::where('is_track', 1)->get();
        } else {
            $products               = product::where('is_track', 1)->get();
        }
        $products                   = product::where('is_track', 1)->get();
        return view('admin.reports.products.inventory_summaryInput', compact(['today', 'today2', 'products']));
    }

    public function warehouse_stock_quantity()
    {
        $today                      = Carbon::today()->toDateString();
        $product                    = product::get();
        $warehouse                  = warehouse::get();
        $warehouse_detail           = warehouse_detail::whereBetween('created_at', [Carbon::parse($today)->startOfYear(), Carbon::parse($today)])
            ->select('warehouse_details.*')->groupBy('product_id')
            ->selectSub(function ($query) {
                return $query->selectRaw('SUM(qty_in - qty_out)');
            }, 'totalqty')
            ->orderBy('created_at')
            ->get()
            ->groupBy('product_id');
        return view('admin.reports.products.warehouse_stock_quantity', compact(['today', 'product', 'warehouse_detail', 'warehouse']));
    }

    public function warehouse_stock_quantityInput($mulaidari)
    {
        $today                      = Carbon::today()->toDateString();
        $today2                     = $mulaidari;
        $product                    = product::get();
        $warehouse                  = warehouse::get();
        if (Carbon::parse($today2)->startOfYear()->gt(Carbon::now())) {
            $warehouse_detail           = warehouse_detail::whereBetween('created_at', [Carbon::parse($today)->startOfYear(), Carbon::parse($today2)])
                ->select('warehouse_details.*')->groupBy('product_id')
                ->selectSub(function ($query) {
                    return $query->selectRaw('SUM(qty_in - qty_out)');
                }, 'totalqty')
                ->orderBy('created_at')
                ->get()
                ->groupBy('product_id');
        } else {
            $warehouse_detail           = warehouse_detail::whereBetween('created_at', [Carbon::parse($today2)->startOfYear(), Carbon::parse($today)])
                ->select('warehouse_details.*')->groupBy('product_id')
                ->selectSub(function ($query) {
                    return $query->selectRaw('SUM(qty_in - qty_out)');
                }, 'totalqty')
                ->orderBy('created_at')
                ->get()
                ->groupBy('product_id');
        }
        return view('admin.reports.products.warehouse_stock_quantityInput', compact(['today', 'today2', 'product', 'warehouse_detail', 'warehouse']));
    }

    public function inventory_valuation()
    {
        $today                      = Carbon::today()->toDateString();
        $products                   = product::where('is_track', 1)->get();
        $pi                         = purchase_invoice::whereBetween('transaction_date', [$today, $today])->get();
        $si                         = sale_invoice::whereBetween('transaction_date', [$today, $today])->get();
        $pip                        = purchase_invoice_item::get();
        $sis                        = sale_invoice_item::get();
        return view('admin.reports.products.inventory_valuation', compact(['today', 'products', 'pi', 'si', 'pip', 'sis']));
    }

    public function inventory_valuationInput($start, $end)
    {
        $products                   = product::where('is_track', 1)->get();
        $pi                         = purchase_invoice::whereBetween('transaction_date', [$start, $end])->get();
        $si                         = sale_invoice::whereBetween('transaction_date', [$start, $end])->get();
        $pip                        = purchase_invoice_item::get();
        $sis                        = sale_invoice_item::get();
        return view('admin.reports.products.inventory_valuationInput', compact(['start', 'end', 'products', 'pi', 'si', 'pip', 'sis']));
    }

    public function warehouse_items_valuation()
    {
        $today                      = Carbon::today()->toDateString();
        $warehouse_detail           = warehouse_detail::whereBetween('created_at', [Carbon::parse($today), Carbon::parse($today)])
            ->select('warehouse_details.*')->groupBy('product_id')
            ->selectSub(function ($query) {
                return $query->selectRaw('SUM(qty_in - qty_out)');
            }, 'totalqty')
            ->orderBy('created_at')
            ->get()
            ->groupBy('product_id');
        $warehouse                  = warehouse::get();
        return view('admin.reports.products.warehouse_items_valuation', compact(['today', 'warehouse_detail', 'warehouse']));
    }

    public function warehouse_items_valuationInput($mulaidari)
    {
        $today                      = Carbon::today()->toDateString();
        $today2                     = $mulaidari;
        if (Carbon::parse($today2)->startOfYear()->gt(Carbon::now())) {
            $warehouse_detail           = warehouse_detail::whereBetween('created_at', [Carbon::parse($today), Carbon::parse($today2)])
                ->select('warehouse_details.*')->groupBy('product_id')
                ->selectSub(function ($query) {
                    return $query->selectRaw('SUM(qty_in - qty_out)');
                }, 'totalqty')
                ->orderBy('created_at')
                ->get()
                ->groupBy('product_id');
        } else {
            $warehouse_detail           = warehouse_detail::whereBetween('created_at', [Carbon::parse($today2), Carbon::parse($today)])
                ->select('warehouse_details.*')->groupBy('product_id')
                ->selectSub(function ($query) {
                    return $query->selectRaw('SUM(qty_in - qty_out)');
                }, 'totalqty')
                ->orderBy('created_at')
                ->get()
                ->groupBy('product_id');
        }
        $warehouse                  = warehouse::get();
        return view('admin.reports.products.warehouse_items_valuationInput', compact(['today', 'today2', 'warehouse_detail', 'warehouse']));
    }

    public function inventory_details()
    {
        $products                   = product::where('is_track', 1)->get();
        return view('admin.reports.products.inventory_details', compact(['products']));
    }

    public function warehouse_items_stock_movement()
    {
        $products                   = product::where('is_track', 1)->get();
        $warehouse                  = warehouse::get();
        return view('admin.reports.products.warehouse_items_stock_movement', compact(['products', 'warehouse']));
    }
    // PRODUCTS
}
