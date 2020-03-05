<?php

namespace App\Http\Controllers;

use App\Model\closing_book\closing_book;
use App\Model\coa\coa;
use App\Model\coa\coa_detail;
use App\Model\company\company_setting;
use App\Model\contact\contact;
use App\Model\expense\expense;
use App\Model\expense\expense_item;
use App\Exports\aged_receivable;
use App\Exports\balance_sheet;
use App\Exports\request_ss_surabaya_balance_sheet;
use App\Exports\cashflow;
use App\Exports\customer_balance;
use App\Exports\request_ss_surabaya_customer_balance;
use App\Exports\expenses_details;
use App\Exports\expenses_list;
use App\Exports\general_ledger;
use App\Exports\inventory_summary;
use App\Exports\journal_report;
use App\Exports\profit_loss;
use App\Exports\request_ss_surabaya_aged_payable;
use App\Exports\request_ss_surabaya_profit_loss;
use App\Exports\sales_by_customer;
use App\Exports\request_ss_surabaya_sales_by_customer;
use App\Exports\sales_list;
use App\Exports\request_ss_surabaya_sales_list;
use App\Exports\spk_details;
use App\Exports\spk_list;
use App\Exports\trial_balance;
use App\Model\opening_balance\opening_balance;
use App\Model\opening_balance\opening_balance_detail;
use App\Model\other\other_status;
use App\Model\other\other_transaction;
use App\Model\product\product;
use App\Model\purchase\purchase_delivery;
use App\Model\purchase\purchase_delivery_item;
use App\Model\purchase\purchase_invoice;
use App\Model\purchase\purchase_invoice_item;
use App\Model\purchase\purchase_return_item;
use App\Model\sales\sale_delivery;
use App\Model\sales\sale_delivery_item;
use App\Model\sales\sale_invoice;
use App\Model\sales\sale_invoice_item;
use App\Model\sales\sale_order;
use App\Model\sales\sale_payment_item;
use App\Model\sales\sale_return_item;
use App\Model\spk\spk;
use App\Model\spk\spk_item;
use App\User;
use App\Model\warehouse\warehouse;
use App\Model\warehouse\warehouse_detail;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function select_product()
    {
        if (request()->ajax()) {
            $page = Input::get('page');
            $resultCount = 10;

            $offset = ($page - 1) * $resultCount;

            $breeds = product::where('name', 'LIKE',  '%' . Input::get("term") . '%')->orWhere('code', 'LIKE',  '%' . Input::get("term") . '%')
                ->orderBy('name')
                ->skip($offset)
                ->take($resultCount)
                ->get(['id', DB::raw('name as text'), 'code']);

            $count = product::count();
            $endCount = $offset + $resultCount;
            $morePages = $endCount > $count;

            $results = array(
                "results" => $breeds,
                "pagination" => array(
                    "more" => $morePages,
                ),
                "total_count" => $count,
            );

            return response()->json($results);
        }
    }
    // OVERVIEW
    public function balanceSheet()
    {
        $last_periode                               = new Carbon('first day of last month');
        $start_last_periode                         = $last_periode->toDateString();
        $endmonth_last_periode                      = new Carbon('last day of last month');
        $end_last_periode                           = $endmonth_last_periode->toDateString();
        $current_periode                            = new Carbon('first day of this month');
        //dd($current_periode);
        $today                                      = Carbon::today()->toDateString();
        $today2                                     = $current_periode->toDateString();
        /*
         INI CONTOH UNTUK JOIN COA DETAIL DENGAN COA YANG BENAR
        $view_current_assets4                        = DB::table('coa_details')
                                                        ->join('coas', 'coa_details.id', '=', 'coas.id')
                                                        ->select('coa_details.*', 'coas.coa_category_id')
                                                        ->get();*/
        /*$cek_opening_balance                        = coa_detail::where('type', 'opening balance')->first();
        if ($cek_opening_balance) {
            $coa_detail                             = coa_detail::whereBetween('date', [$cek_opening_balance->date, $today])
                ->orderBy('date', 'ASC')
                ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
                //->selectRaw('debit, credit, SUM(debit - credit) as total1, SUM(credit - debit) as total2, coa_id')
                //->selectRaw('SUM(debit) as debit, SUM(credit) as credit, coa_id')
                ->groupBy('coa_id')
                ->get();
        } else {*/
        $coa_detail                             = coa_detail::whereBetween('date', [$current_periode->toDateString(), $today])
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();
        //}
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
                $total_depreciation                 += $cd->total;
            }
        }
        $total_assets                               = $total_current_assets + $total_fixed_assets - $total_depreciation;
        $total_liability                            = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 8 or $cd->coa->coa_category_id == 10 or $cd->coa->coa_category_id == 17) {
                $total_liability                    += $cd->total2;
            }
        }
        /*$total_equity                               = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 12) {
                $total_equity                       += $cd->total;
            }
        }*/
        // CEK KLO ADA OPENING BALANCE KLO GADA PAKE FIRST COA DETAIL
        // UNTUK LAST PERIODE, KITA PAKE PER BULAN YAITU PAKE BULAN KEMARIN DARI CURRENT
        $last_periode_coa_detail                    = coa_detail::whereBetween('date', [$start_last_periode, $end_last_periode])
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();
        $last_periode_total_current_assets                       = 0;
        foreach ($last_periode_coa_detail as $cd2) {
            if ($cd2->coa->coa_category_id == 1 or $cd2->coa->coa_category_id == 2 or $cd2->coa->coa_category_id == 3 or $cd2->coa->coa_category_id == 4) {
                $last_periode_total_current_assets  += $cd2->total;
            }
        }
        $last_periode_total_fixed_assets                         = 0;
        foreach ($last_periode_coa_detail as $cd2) {
            if ($cd2->coa->coa_category_id == 5 or $cd2->coa->coa_category_id == 6) {
                $last_periode_total_fixed_assets    += $cd2->total;
            }
        }
        $last_periode_total_depreciation                         = 0;
        foreach ($last_periode_coa_detail as $cd2) {
            if ($cd2->coa->coa_category_id == 7) {
                $last_periode_total_depreciation    += $cd2->total;
            }
        }
        $last_periode_total_assets                  = $last_periode_total_current_assets + $last_periode_total_fixed_assets - $last_periode_total_depreciation;
        $last_periode_total_liability               = 0;
        foreach ($last_periode_coa_detail as $cd2) {
            if ($cd2->coa->coa_category_id == 8 or $cd2->coa->coa_category_id == 10 or $cd2->coa->coa_category_id == 17) {
                $last_periode_total_liability       += $cd2->total2;
            }
        }
        $last_periode_earning                       = 0; //$last_periode_total_assets - $last_periode_total_liability;
        //$current_period_earning                     = $total_assets - $total_liability; YANG KATANYA BENER (CUMA SALAH)
        $current_period_earning                     = $total_assets - $total_liability;
        $total_equity2                              = $current_period_earning + $last_periode_earning;
        //$total_lia_eq                               = $total_liability + $total_equity2; YANG KATANYA BENER (CUMA SALAH)
        $total_lia_eq                               = $total_equity2 + $total_liability;
        return view('admin.reports.overview.balance_sheet', compact([
            'start_last_periode',
            'end_last_periode',
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

    public function balanceSheetInput($mulaidari)
    {
        $last_periode                               = new Carbon('first day of last year');
        $startyear_last_periode                     = $last_periode->startOfYear()->toDateString();
        $endyear_last_periode                       = $last_periode->endOfYear()->toDateString();
        $current_periode                            = new Carbon('first day of January ' . date('Y'));
        $today                                      = Carbon::today()->toDateString();
        $today2                                     = $mulaidari;
        $today3                                     = Carbon::parse($mulaidari);
        $mulaidariYear                              = new Carbon('first day of ' . $today3->format('F'));
        //if (Carbon::parse($today)->gt(Carbon::now())) {
        //    $coa_detail                                 = coa_detail::whereBetween('date', [$current_periode->toDateString(), $today])
        //           ->orderBy('coa_id')
        //       ->selectRaw('SUM(debit - credit) as total, coa_id')
        //        ->groupBy('coa_id')
        //        ->get();
        //} else {
        $coa_detail                                 = coa_detail::whereBetween('date', [$mulaidariYear, $today3])
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();
        //}
        $total_current_assets                       = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 1 or $cd->coa->coa_category_id == 2 or $cd->coa->coa_category_id == 3 or $cd->coa->coa_category_id == 4) {
                $total_current_assets               += $cd->total;
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
                $total_liability                   += $cd->total2;
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
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
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
                $last_periode_total_liability                    += $cd->total2;
            }
        }
        $last_periode_earning                       = 0; //$last_periode_total_assets - $last_periode_total_liability;
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
        $today2                                     = Carbon::parse($today);
        $current_periode                            = new Carbon('first day of ' . $today2->format('F'));
        $coa_detail                                 = coa_detail::whereBetween('date', [$current_periode->toDateString(), $today])
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();
        $last_periode_coa_detail                    = coa_detail::whereBetween('date', [$startyear, $endyear])
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
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
        $as_of                                      = coa_detail::where('id', '999999')->pluck('date');
        $coa                                        = coa::get();
        $coa_detail                                 = coa_detail::orderBy('date')->whereBetween('date', [$today, $today])
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
                ->orderBy('date')
                ->get()
                ->groupBy('coa_id');
        } else {
            //dd('else');
            $coa                                    = coa::whereIn('id', $ids)->get();
            $coa2                                   = coa::get();
            $coa_detail                             = coa_detail::whereIn('coa_id', $ids)->whereBetween('date', [$start, $end])
                ->orderBy('coa_id', 'asc')
                ->orderBy('date')
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
            $coa_detail                             = coa_detail::orderBy('date')->whereBetween('date', [$start, $end])
                ->orderBy('coa_id', 'asc')
                ->get()
                ->groupBy('coa_id');
        } else {
            //dd('else');
            $coa                                    = coa::whereIn('id', $ids)->get();
            $coa2                                   = coa::get();
            $coa_detail                             = coa_detail::orderBy('date')->whereIn('coa_id', $ids)->whereBetween('date', [$start, $end])
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
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();

        $total_primary_income               = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 13) {
                $total_primary_income       += $cd->total2;
            }
        }
        $total_cost_of_sales                = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 15) {
                $total_cost_of_sales        += $cd->total;
            }
        }
        $gross_profit                       = $total_primary_income - $total_cost_of_sales;

        $total_operational_expense          = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 16) {
                $total_operational_expense  += $cd->total;
            }
        }
        $net_operating_income               = $gross_profit - $total_operational_expense;

        $total_other_income                 = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 14) {
                $total_other_income         += $cd->total2;
            }
        }

        $total_other_expense                = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 17) {
                $total_other_expense        += $cd->total;
            }
        }
        $net_income                         = $net_operating_income + $total_other_income - $total_other_expense;

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
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();

        $total_primary_income               = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 13) {
                $total_primary_income       += $cd->total2;
            }
        }
        $total_cost_of_sales                = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 15) {
                $total_cost_of_sales        += $cd->total;
            }
        }
        $gross_profit                       = $total_primary_income - $total_cost_of_sales;

        $total_operational_expense          = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 16) {
                $total_operational_expense  += $cd->total;
            }
        }
        $net_operating_income               = $gross_profit - $total_operational_expense;

        $total_other_income                 = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 14) {
                $total_other_income         += $cd->total2;
            }
        }

        $total_other_expense                = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 17) {
                $total_other_expense        += $cd->total;
            }
        }
        $net_income                         = $net_operating_income + $total_other_income - $total_other_expense;

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
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();

        $total_primary_income               = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 13) {
                $total_primary_income       += $cd->total2;
            }
        }
        $total_cost_of_sales                = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 15) {
                $total_cost_of_sales        += $cd->total;
            }
        }
        $gross_profit                       = $total_primary_income - $total_cost_of_sales;

        $total_operational_expense          = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 16) {
                $total_operational_expense  += $cd->total;
            }
        }
        $net_operating_income               = $gross_profit - $total_operational_expense;

        $total_other_income                 = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 14) {
                $total_other_income         += $cd->total2;
            }
        }

        $total_other_expense                = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 17) {
                $total_other_expense        += $cd->total;
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
        $coa_detail                 = coa_detail::orderBy('date')->whereBetween('date', [$today, $today])
            ->orderBy('date')
            ->get()
            ->groupBy('number');
        return view('admin.reports.overview.journal_report', compact(['today', 'coa_detail']));
    }

    public function journal_reportInput($start, $end)
    {
        $coa_detail                 = coa_detail::orderBy('date')->whereBetween('date', [$start, $end])
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
        $coa_detail                 = coa_detail::orderBy('date')->whereBetween('date', [$start, $end])
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
        $today                          = Carbon::today()->toDateString();
        $opening_balance                = opening_balance::latest()->first();
        $coa_detail2                    = coa_detail::whereBetween('date', [$today, $today])
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
        $opening_balance                = opening_balance::latest()->first();
        $last_periode                   = Carbon::parse($start)->subMonth(1)->lastOfMonth()->toDateString();
        if ($opening_balance) {
            if (Carbon::parse($start)->month == Carbon::parse($opening_balance->opening_date)->month) {
                $opening_date                       = $opening_balance->opening_date;
                //COA OPENING BALANCE
                $coa_detail3                    = coa_detail::whereDate('date', $opening_date)
                    ->where('type', 'opening balance')
                    ->select('coa_details.*')->groupBy('coa_id')
                    ->selectSub(function ($query) {
                        return $query->selectRaw('SUM(debit)');
                    }, 'debit')
                    ->selectSub(function ($query) {
                        return $query->selectRaw('SUM(credit)');
                    }, 'credit')
                    ->orderBy('date')
                    ->orderBy('coa_id')
                    ->get()
                    ->groupBy('coa_id');
            } else {
                $start_opening                  = $opening_balance->opening_date;
                $end_opening                    = $last_periode;
                $coa_detail3                    = coa_detail::whereBetween('date', [$start_opening, $end_opening])
                    ->select('coa_details.*')->groupBy('coa_id')
                    ->selectSub(function ($query) {
                        return $query->selectRaw('SUM(debit)');
                    }, 'debit')
                    ->selectSub(function ($query) {
                        return $query->selectRaw('SUM(credit)');
                    }, 'credit')
                    ->orderBy('date')
                    ->orderBy('coa_id')
                    ->get()
                    ->groupBy('coa_id');
            }
        } else {
            $start_opening                  = coa_detail::first();
            $end_opening                    = $last_periode;
            $coa_detail3                    = coa_detail::whereBetween('date', [$start_opening, $end_opening])
                ->select('coa_details.*')->groupBy('coa_id')
                ->selectSub(function ($query) {
                    return $query->selectRaw('SUM(debit)');
                }, 'debit')
                ->selectSub(function ($query) {
                    return $query->selectRaw('SUM(credit)');
                }, 'credit')
                ->orderBy('date')
                ->orderBy('coa_id')
                ->get()
                ->groupBy('coa_id');
        }

        //COA MOVEMENT BALANCE
        $coa_detail2                    = coa_detail::whereBetween('date', [$start, $end])
            ->where('type', '!=', 'opening balance')
            ->select('coa_details.*')->groupBy('coa_id')
            ->selectSub(function ($query) {
                return $query->selectRaw('SUM(debit)');
            }, 'debit')
            ->selectSub(function ($query) {
                return $query->selectRaw('SUM(credit)');
            }, 'credit')
            ->orderBy('date')
            ->orderBy('coa_id')
            ->get()
            ->groupBy('coa_id');


        //dd($coa_detail3);
        $asset                          = coa::whereIn('coa_category_id', [3, 1, 4, 2, 5, 6, 7])->get();
        $liability                      = coa::whereIn('coa_category_id', [8, 9, 10, 11])->get();
        $equity                         = coa::whereIn('coa_category_id', [12])->get();
        $income                         = coa::whereIn('coa_category_id', [13, 14])->get();
        $expense                        = coa::whereIn('coa_category_id', [15, 16, 17])->get();

        return view('admin.reports.overview.trial_balanceInput', compact([
            'start',
            'end',
            'asset',
            'liability',
            'equity',
            'income',
            'expense',
            'coa_detail2',
            'coa_detail3',
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
        $today              = Carbon::today()->toDateString();
        $status             = other_status::get()->except(array(6, 7, 8, 9));
        $contact            = contact::where('type_customer', 1)->get();
        $getcontact                 = contact::where('type_customer', 1)->pluck('id');
        $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
            ->whereIn('contact', $getcontact)
            ->orderBy('transaction_date', 'ASC')
            ->whereBetween('transaction_date', [$today, $today])
            ->get();
        $customer           = collect($other_transaction)
            ->groupBy('contact');

        return view(
            'admin.reports.sales.sales_list',
            compact([
                'today',
                'other_transaction',
                'status',
                'contact',
                'customer'
            ])
        );
    }

    public function sales_listInput($start, $end, $type, $con, $stat)
    {
        $contact2                   = explode(',', $con);
        $status2                    = explode(',', $stat);
        $type2                      = explode(',', $type);
        $status                     = other_status::get()->except(array(6, 7, 8, 9));
        $contact                    = contact::where('type_customer', 1)->get();
        $getcontact                 = contact::where('type_customer', 1)->pluck('id');
        if ($con == 'null') {
            if ($stat == 'null') {
                if ($type == 'null') {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->whereIn('contact', $getcontact)
                        ->orderBy('transaction_date', 'ASC')
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                } else {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('contact', $getcontact)
                        ->whereIn('type', $type2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                }
            } else {
                if ($type == 'null') {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('contact', $getcontact)
                        ->whereIn('status', $status2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                } else {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('contact', $getcontact)
                        ->whereIn('type', $type2)
                        ->whereIn('status', $status2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                }
            }
        } else {
            if ($stat == 'null') {
                if ($type == 'null') {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('contact', $contact2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                } else {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('type', $type2)
                        ->whereIn('contact', $contact2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                }
            } else {
                if ($type == 'null') {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('contact', $contact2)
                        ->whereIn('status', $status2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                } else {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('type', $type2)
                        ->whereIn('contact', $contact2)
                        ->whereIn('status', $status2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                }
            }
        }

        $customer           = collect($other_transaction)
            ->groupBy('contact');
        return view(
            'admin.reports.sales.sales_listInput',
            compact([
                'start',
                'end',
                'type',
                'con',
                'stat',
                'other_transaction',
                'status',
                'contact',
                'customer'
            ])
        );
    }

    public function sales_list_excel($start, $end, $type, $con, $stat)
    {
        return Excel::download(new sales_list($start, $end, $type, $con, $stat), 'sales_list_' . $start . '_' . $end . '.xlsx');
    }

    public function sales_list_csv($start, $end, $type, $con, $stat)
    {
        return Excel::download(new sales_list($start, $end, $type, $con, $stat), 'sales_list_' . $start . '_' . $end . '.csv');
    }

    public function sales_list_pdf($start, $end, $type, $con, $stat)
    {
        $user                           = User::find(Auth::id());
        $company                        = company_setting::where('company_id', $user->company_id)->first();
        $contact2                       = explode(',', $con);
        $status2                        = explode(',', $stat);
        $type2                          = explode(',', $type);
        if ($con == 'null') {
            if ($stat == 'null') {
                if ($type == 'null') {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                } else {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('type', $type2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                }
            } else {
                if ($type == 'null') {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('status', $status2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                } else {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('type', $type2)
                        ->whereIn('status', $status2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                }
            }
        } else {
            if ($stat == 'null') {
                if ($type == 'null') {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('contact', $contact2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                } else {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('type', $type2)
                        ->whereIn('contact', $contact2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                }
            } else {
                if ($type == 'null') {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('contact', $contact2)
                        ->whereIn('status', $status2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                } else {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('type', $type2)
                        ->whereIn('contact', $contact2)
                        ->whereIn('status', $status2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                }
            }
        }
        $view = view('admin.reports.sales_export.sales_list_pdf')->with(compact([
            'company',
            'start',
            'end',
            'other_transaction',
        ]));
        $html = $view->render();
        $pdf = PDF::loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->download('sales_list_' . $start . '_' . $end . '.pdf');
    }

    public function sales_by_customer()
    {
        $today                      = Carbon::today()->toDateString();
        $contact                    = contact::get();
        $si                         = sale_invoice_item::with('sale_invoice')
            ->get();
        $sid                        = sale_invoice::with('sale_invoice_item')
            ->whereBetween('transaction_date', [$today, $today])
            ->get();

        $customers                   = collect($sid)
            ->groupBy('contact_id')
            ->map(function ($item) {
                return $item
                    ->groupBy('id')
                    ->map(function ($item) {
                        return $item;
                    });
            });

        return view(
            'admin.reports.sales.sales_by_customer',
            compact([
                'today',
                'contact',
                'si',
                'sid',
                'customers'
            ])
        );
    }

    public function sales_by_customerInput($start, $end, $con)
    {
        $contact2                   = explode(',', $con);
        $contact                    = contact::get();
        if ($con == 'null') {
            $si                     = sale_invoice::with('sale_invoice_item')->orderBy('transaction_date')
                ->whereBetween('transaction_date', [$start, $end])
                ->get();
        } else {
            $si                     = sale_invoice::with('sale_invoice_item')->orderBy('transaction_date')
                ->whereIn('contact_id', $contact2)
                ->whereBetween('transaction_date', [$start, $end])
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
        return view(
            'admin.reports.sales.sales_by_customerInput',
            compact([
                'start',
                'end',
                'contact',
                'si',
                'sid',
                'con',
                'customers'
            ])
        );
    }

    public function sales_by_customer_excel($start, $end, $con)
    {
        return Excel::download(new sales_by_customer($start, $end, $con), 'sales_by_customer_' . $start . '_' . $end . '.xlsx');
    }

    public function sales_by_customer_csv($start, $end, $con)
    {
        return Excel::download(new sales_by_customer($start, $end, $con), 'sales_by_customer_' . $start . '_' . $end . '.csv');
    }

    public function sales_by_customer_pdf($start, $end, $con)
    {
        $user                       = User::find(Auth::id());
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $contact2                   = explode(',', $con);
        $contact                    = contact::get();
        if ($con == 'null') {
            $si                     = sale_invoice::orderBy('transaction_date')
                ->whereBetween('transaction_date', [$start, $end])
                ->get();
        } else {
            $si                     = sale_invoice::orderBy('transaction_date')
                ->whereIn('contact_id', $contact2)
                ->whereBetween('transaction_date', [$start, $end])
                ->get();
        }
        $sid                        = sale_invoice_item::get();
        $view = view('admin.reports.sales_export.sales_by_customer_pdf')->with(compact([
            'company',
            'start',
            'end',
            'contact',
            'si',
            'sid',
            'con'
        ]));
        $html = $view->render();
        $pdf = PDF::loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->download('sales_by_customer_' . $start . '_' . $end . '.pdf');
    }

    public function customer_balance()
    {
        $this_month                 = new Carbon('first day of this month');
        $get_this_month             = $this_month->toDateString();
        $today                      = Carbon::today()->toDateString();
        $contact                    = contact::get();
        $si                         = sale_invoice::orderBy('transaction_date')
            ->whereBetween('transaction_date', [$get_this_month, $today])
            ->whereIn('status', [1, 4, 5])
            ->get();
        $sid                        = sale_invoice_item::get();
        return view(
            'admin.reports.sales.customer_balance',
            compact([
                'today', 'contact', 'si', 'sid'
            ])
        );
    }

    public function customer_balanceInput($mulaidari, $con)
    {
        $contact2                   = explode(',', $con);
        $mulaidar_parse             = Carbon::parse($mulaidari);
        $get_this_month             = new Carbon('first day of ' . $mulaidar_parse->format('F'));
        $today                      = $get_this_month->toDateString();
        $today2                     = $mulaidari;
        if ($con == 'null') {
            $si                         = sale_invoice::orderBy('transaction_date')
                ->whereBetween('transaction_date', [$get_this_month, $today2])
                ->whereIn('status', [1, 4, 5])
                ->get();
        } else {
            $si                         = sale_invoice::orderBy('transaction_date')
                ->whereBetween('transaction_date', [$get_this_month, $today2])
                ->whereIn('status', [1, 4, 5])
                ->whereIn('contact_id', $contact2)
                ->get();
        }
        $contact                    = contact::get();
        $sid                        = sale_invoice_item::get();
        return view(
            'admin.reports.sales.customer_balanceInput',
            compact([
                'today', 'today2', 'contact', 'si', 'sid', 'con'
            ])
        );
    }

    public function customer_balance_excel($mulaidari, $con)
    {
        return Excel::download(new customer_balance($mulaidari, $con), 'customer_balance_' . $mulaidari . '.xlsx');
    }

    public function customer_balance_csv($mulaidari, $con)
    {
        return Excel::download(new customer_balance($mulaidari, $con), 'customer_balance_' . $mulaidari . '.csv');
    }

    public function customer_balance_pdf($mulaidari, $con)
    {
        $user                       = User::find(Auth::id());
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $contact2                   = explode(',', $con);
        $mulaidar_parse             = Carbon::parse($mulaidari);
        $get_this_month             = new Carbon('first day of ' . $mulaidar_parse->format('F'));
        $today                      = $get_this_month->toDateString();
        $today2                     = $mulaidari;
        if ($con == 'null') {
            $si                         = sale_invoice::orderBy('transaction_date')
                ->whereBetween('transaction_date', [$get_this_month, $today2])
                ->get();
        } else {
            $si                         = sale_invoice::orderBy('transaction_date')
                ->whereIn('contact_id', $contact2)
                ->whereBetween('transaction_date', [$get_this_month, $today2])
                ->get();
        }
        $contact                    = contact::get();
        $sid                        = sale_invoice_item::get();
        $view = view('admin.reports.sales_export.customer_balance_pdf')->with(compact([
            'company',
            'today', 'today2', 'contact', 'si', 'sid', 'con'
        ]));
        $html = $view->render();
        $pdf = PDF::loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->download('customer_balance_' . $mulaidari . '.pdf');
    }

    public function aged_receivable()
    {
        $this_month                 = new Carbon('first day of this month');
        $get_this_month             = $this_month->toDateString();
        $today                      = Carbon::today()->toDateString();
        $contact                    = contact::get();
        $si                         = sale_invoice::orderBy('transaction_date')
            ->whereBetween('transaction_date', [$get_this_month, $today])
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
        $mulaidar_parse             = Carbon::parse($mulaidari);
        $get_this_month             = new Carbon('first day of ' . $mulaidar_parse->format('F'));
        $today                      = $get_this_month->toDateString();
        $today2                     = $mulaidari;
        $si                         = sale_invoice::orderBy('transaction_date')
            ->whereBetween('transaction_date', [$today, $today2])
            ->selectRaw('SUM(balance_due) as balance_due, transaction_date, contact_id')
            ->groupBy('contact_id')
            ->get();
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

    public function aged_receivable_excel($mulaidari)
    {
        return Excel::download(new aged_receivable($mulaidari), 'aged_receivable_' . $mulaidari . '.xlsx');
    }

    public function aged_receivable_csv($mulaidari)
    {
        return Excel::download(new aged_receivable($mulaidari), 'aged_receivable_' . $mulaidari . '.csv');
    }

    public function aged_receivable_pdf($mulaidari)
    {
        $user                       = User::find(Auth::id());
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $mulaidar_parse             = Carbon::parse($mulaidari);
        $get_this_month             = new Carbon('first day of ' . $mulaidar_parse->format('F'));
        $today                      = $get_this_month->toDateString();
        $today2                     = $mulaidari;
        $si                         = sale_invoice::orderBy('transaction_date')
            ->whereBetween('transaction_date', [$today, $today2])
            ->selectRaw('SUM(balance_due) as balance_due, transaction_date, contact_id')
            ->groupBy('contact_id')
            ->get();
        $contact                    = contact::get();
        $view = view('admin.reports.sales_export.aged_receivable_pdf')->with(compact([
            'company',
            'today',
            'today2',
            'contact',
            'si'
        ]));
        $html = $view->render();
        $pdf = PDF::loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->download('aged_receivable_' . $mulaidari . '.pdf');
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
        $contact                    = contact::get();
        $expense                    = expense::whereBetween('transaction_date', [$today, $today])
            ->with(['expense_item' => function ($expense_item) {
                $expense_item->get();
            }])->get();
        return view('admin.reports.expenses.expenses_list', compact(['today', 'expense', 'contact']));
    }

    public function expenses_listInput($start, $end, $con)
    {
        $contacts                   = explode(',', $con);
        $contact                    = contact::get();
        if ($con == 'null') {
            $expense                    = expense::whereBetween('transaction_date', [$start, $end])
                ->with(['expense_item' => function ($expense_item) {
                    $expense_item->get();
                }])->get();
        } else {
            $expense                    = expense::whereBetween('transaction_date', [$start, $end])
                ->whereIn('contact_id', $contacts)
                ->with(['expense_item' => function ($expense_item) {
                    $expense_item->get();
                }])->get();
        }
        return view('admin.reports.expenses.expenses_listInput', compact(['contact', 'start', 'end', 'expense']));
    }

    public function expenses_list_excel($start, $end, $con)
    {
        return Excel::download(new expenses_list($start, $end, $con), 'expenses_list_' . $start . '_' . $end . '.xlsx');
    }

    public function expenses_list_csv($start, $end, $con)
    {
        return Excel::download(new expenses_list($start, $end, $con), 'expenses_list_' . $start . '_' . $end . '.csv');
    }

    public function expenses_list_pdf($start, $end, $con)
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $contacts                                   = explode(',', $con);
        if ($con == 'null') {
            $expense                    = expense::whereBetween('transaction_date', [$start, $end])
                ->with(['expense_item' => function ($expense_item) {
                    $expense_item->get();
                }])->get();
        } else {
            $expense                    = expense::whereBetween('transaction_date', [$start, $end])
                ->whereIn('contact_id', $contacts)
                ->with(['expense_item' => function ($expense_item) {
                    $expense_item->get();
                }])->get();
        }
        $view = view('admin.reports.expenses_export.expenses_list_pdf')->with(compact(['company', 'start', 'end', 'expense']));
        $html = $view->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('expenses_list_' . $start . '_' . $end . '.pdf');
    }

    public function expenses_details()
    {
        $today                      = Carbon::today()->toDateString();
        $contact                    = contact::get();
        $expense                    = expense::whereBetween('transaction_date', [$today, $today])
            ->with(['expense_item' => function ($expense_item) {
                $expense_item->get();
            }])->get();
        return view('admin.reports.expenses.expenses_details', compact(['today', 'expense', 'contact']));
    }

    public function expenses_detailsInput($start, $end, $con)
    {
        $contacts                   = explode(',', $con);
        $contact                    = contact::get();
        if ($con == 'null') {
            $expense                    = expense::whereBetween('transaction_date', [$start, $end])
                ->with(['expense_item' => function ($expense_item) {
                    $expense_item->get();
                }])->get();
        } else {
            $expense                    = expense::whereBetween('transaction_date', [$start, $end])
                ->whereIn('contact_id', $contacts)
                ->with(['expense_item' => function ($expense_item) {
                    $expense_item->get();
                }])->get();
        }
        return view('admin.reports.expenses.expenses_detailsInput', compact(['contact', 'start', 'end', 'expense']));
    }

    public function expenses_details_excel($start, $end, $con)
    {
        return Excel::download(new expenses_details($start, $end, $con), 'expenses_details_' . $start . '_' . $end . '.xlsx');
    }

    public function expenses_details_csv($start, $end, $con)
    {
        return Excel::download(new expenses_details($start, $end, $con), 'expenses_details_' . $start . '_' . $end . '.csv');
    }

    public function expenses_details_pdf($start, $end, $con)
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $contacts                                   = explode(',', $con);
        if ($con == 'null') {
            $expense                    = expense::whereBetween('transaction_date', [$start, $end])
                ->with(['expense_item' => function ($expense_item) {
                    $expense_item->get();
                }])->get();
        } else {
            $expense                    = expense::whereBetween('transaction_date', [$start, $end])
                ->whereIn('contact_id', $contacts)
                ->with(['expense_item' => function ($expense_item) {
                    $expense_item->get();
                }])->get();
        }
        $view = view('admin.reports.expenses_export.expenses_details_pdf')->with(compact(['company', 'start', 'end', 'expense']));
        $html = $view->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('expenses_list_' . $start . '_' . $end . '.pdf');
    }
    // EXPENSES

    // PRODUCTS
    public function inventory_summary()
    {
        $last_periode                               = new Carbon('first day of last year');
        $startyear_last_periode                     = $last_periode->startOfYear()->toDateString();
        $endyear_last_periode                       = $last_periode->endOfYear()->toDateString();
        $current_periode                            = new Carbon('first day of January ' . date('Y'));
        $today                                      = Carbon::today()->toDateString();
        $products                                   = product::where('is_track', 1)->get();
        return view('admin.reports.products.inventory_summary', compact([
            'today', 'startyear_last_periode',
            'endyear_last_periode', 'products'
        ]));
    }

    public function inventory_summaryInput($mulaidari)
    {
        $last_periode                               = new Carbon('first day of last year');
        $startyear_last_periode                     = $last_periode->startOfYear()->toDateString();
        $endyear_last_periode                       = $last_periode->endOfYear()->toDateString();
        $current_periode                            = new Carbon('first day of January ' . date('Y'));
        $today                                      = Carbon::today()->toDateString();
        $today2                                     = $mulaidari;
        if (Carbon::parse($today)->gt(Carbon::now())) {
            $products                               = product::where('is_track', 1)->get();
        } else {
            $products                               = product::where('is_track', 1)->get();
        }
        $products                                   = product::where('is_track', 1)->get();
        return view('admin.reports.products.inventory_summaryInput', compact([
            'today', 'startyear_last_periode',
            'endyear_last_periode', 'products', 'today2'
        ]));
    }

    public function inventory_summary_excel($today, $startyear, $endyear)
    {
        $current_periode                            = new Carbon('first day of January ' . date('Y', strtotime($today)));
        return Excel::download(new inventory_summary($today, $startyear, $endyear), 'inventory_summary_' . $current_periode->toDateString() . '_' . $today . '.xlsx');
    }

    public function inventory_summary_csv($today, $startyear, $endyear)
    {
        $current_periode                            = new Carbon('first day of January ' . date('Y', strtotime($today)));
        return Excel::download(new inventory_summary($today, $startyear, $endyear), 'inventory_summary_' . $current_periode->toDateString() . '_' . $today . '.csv');
    }

    public function inventory_summary_pdf($today, $startyear, $endyear)
    {
        $today                                      = Carbon::today()->toDateString();
        $current_periode                            = new Carbon('first day of January ' . date('Y', strtotime($today)));
        if (Carbon::parse($today)->gt(Carbon::now())) {
            $products                               = product::where('is_track', 1)->get();
        } else {
            $products                               = product::where('is_track', 1)->get();
        }
        $products                                   = product::where('is_track', 1)->get();
        $view = view('admin.reports.products_export.inventory_summary_pdf')->with(compact(['products']));
        $html = $view->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('inventory_summary_' . $current_periode->toDateString() . '_' . $today . '.pdf');
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
    // PRODUCTIONS
    public function spk_list()
    {
        $today                                      = Carbon::today()->toDateString();
        $warehouses                                 = warehouse::get();
        $spk                                        = spk::whereBetween('transaction_date', [$today, $today])->get();
        return view(
            'admin.reports.production.spk_list',
            compact([
                'today',
                'warehouses',
                'spk'
            ])
        );
    }

    public function spk_listInput($start, $end, $war)
    {
        $warehouse                                 = explode(',', $war);
        $warehouses                                = warehouse::get();
        /*$spk                                        = spk::with(['punyaspk_item' => function($spk) use($products) {
            $spk->whereIn('product_id', $products);
        }])
        ->get();
        dd($spk);*/
        if ($war == 'null') {
            //dd('if');
            $spk                                        = spk::whereBetween('transaction_date', [$start, $end])->get();
        } else {
            //dd('else');
            $spk                                        = spk::whereBetween('transaction_date', [$start, $end])
                ->whereIn('warehouse_id', $warehouse)
                ->get();
        }
        return view('admin.reports.production.spk_listInput', compact(['start', 'end', 'warehouse', 'spk', 'warehouses']));
    }

    public function spk_list_excel($start, $end, $war)
    {
        return Excel::download(new spk_list($start, $end, $war), 'spk_list_' . $start . '_' . $end . '.xlsx');
    }

    public function spk_list_csv($start, $end, $war)
    {
        return Excel::download(new spk_list($start, $end, $war), 'spk_list_' . $start . '_' . $end . '.csv');
    }

    public function spk_list_pdf($start, $end, $war)
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $warehouse                                 = explode(',', $war);
        if ($war == 'null') {
            //dd('if');
            $spk                                        = spk::whereBetween('transaction_date', [$start, $end])->get();
        } else {
            //dd('else');
            $spk                                        = spk::whereBetween('transaction_date', [$start, $end])
                ->whereIn('warehouse_id', $warehouse)
                ->get();
        }
        $view = view('admin.reports.production_export.spk_list_pdf')->with(compact(['company', 'start', 'end', 'warehouse', 'spk']));
        $html = $view->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('spk_list_' . $start . '_' . $end . '.pdf');
    }

    public function spk_details()
    {
        $today                                      = Carbon::today()->toDateString();
        $products                                   = product::get();
        $warehouses                                 = warehouse::get();
        $spk                                        = spk::whereBetween('transaction_date', [$today, $today])
            ->with(['spk_item' => function ($spk_item) {
                $spk_item->get();
            }])->get();
        return view(
            'admin.reports.production.spk_details',
            compact([
                'today',
                'warehouses',
                'spk',
                'products'
            ])
        );
    }

    public function spk_detailsInput($start, $end, $prod, $war)
    {
        $product                                    = explode(',', $prod);
        $warehouse                                  = explode(',', $war);
        $warehouses                                 = warehouse::get();
        $products                                   = product::get();
        if ($war == 'null') {
            //dd('if');
            if ($prod == 'null') {
                $spk                                       = spk::whereBetween('transaction_date', [$start, $end])
                    ->with(['spk_item' => function ($spk_item) {
                        $spk_item->get();
                    }])->get();
            } else {
                $spk                                       = spk::whereBetween('transaction_date', [$start, $end])
                    ->with(['spk_item' => function ($spk_item) use ($product) {
                        $spk_item->whereIn('product_id', $product);
                    }])->get();
            }
        } else {
            //dd('else');
            if ($prod == 'null') {
                $spk                                       = spk::whereBetween('transaction_date', [$start, $end])
                    ->whereIn('warehouse_id', $warehouse)
                    ->with(['spk_item' => function ($spk_item) {
                        $spk_item->get();
                    }])->get();
            } else {
                $spk                                       = spk::whereBetween('transaction_date', [$start, $end])
                    ->whereIn('warehouse_id', $warehouse)
                    ->with(['spk_item' => function ($spk_item) use ($product) {
                        $spk_item->whereIn('product_id', $product);
                    }])->get();
            }
        }
        return view('admin.reports.production.spk_detailsInput', compact(['start', 'end', 'warehouse', 'spk', 'products', 'warehouses']));
    }

    public function spk_details_excel($start, $end, $prod, $war)
    {
        return Excel::download(new spk_details($start, $end, $prod, $war), 'spk_details_' . $start . '_' . $end . '.xlsx');
    }

    public function spk_details_csv($start, $end, $prod, $war)
    {
        return Excel::download(new spk_details($start, $end, $prod, $war), 'spk_details_' . $start . '_' . $end . '.csv');
    }

    public function spk_details_pdf($start, $end, $war)
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $warehouse                                 = explode(',', $war);
        if ($war == 'null') {
            //dd('if');
            $spk                                        = spk::whereBetween('transaction_date', [$start, $end])->get();
        } else {
            //dd('else');
            $spk                                        = spk::whereBetween('transaction_date', [$start, $end])
                ->whereIn('warehouse_id', $warehouse)
                ->get();
        }
        $view = view('admin.reports.production_export.spk_details_pdf')->with(compact(['company', 'start', 'end', 'warehouse', 'spk']));
        $html = $view->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('spk_details_' . $start . '_' . $end . '.pdf');
    }
    // PRODUCTIONS
    //* REQUEST SUKSES SURABAYA
    public function sales_list_sukses_surabaya()
    {
        $today              = Carbon::today()->toDateString();
        $status             = other_status::get()->except(array(6, 7, 8, 9));
        $contact            = contact::where('type_customer', 1)->get();
        $getcontact         = contact::where('type_customer', 1)->pluck('id');
        $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
            ->whereIn('contact', $getcontact)
            ->orderBy('transaction_date', 'ASC')
            ->whereBetween('transaction_date', [$today, $today])
            ->get();
        $customer           = collect($other_transaction)
            ->groupBy('contact');

        return view(
            'admin.reports.sales.request_ss_surabaya.sales_list',
            compact([
                'today',
                'other_transaction',
                'status',
                'contact',
                'customer'
            ])
        );
    }

    public function sales_list_sukses_surabayaInput($start, $end, $type, $con, $stat)
    {
        $contact2                   = explode(',', $con);
        $status2                    = explode(',', $stat);
        $type2                      = explode(',', $type);
        $status                     = other_status::get()->except(array(6, 7, 8, 9));
        $contact                    = contact::where('type_customer', 1)->get();
        $getcontact                 = contact::where('type_customer', 1)->pluck('id');
        if ($con == 'null') {
            if ($stat == 'null') {
                if ($type == 'null') {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->whereIn('contact', $getcontact)
                        ->orderBy('transaction_date', 'ASC')
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                } else {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('contact', $getcontact)
                        ->whereIn('type', $type2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                }
            } else {
                if ($type == 'null') {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('contact', $getcontact)
                        ->whereIn('status', $status2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                } else {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('contact', $getcontact)
                        ->whereIn('type', $type2)
                        ->whereIn('status', $status2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                }
            }
        } else {
            if ($stat == 'null') {
                if ($type == 'null') {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('contact', $contact2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                } else {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('type', $type2)
                        ->whereIn('contact', $contact2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                }
            } else {
                if ($type == 'null') {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('contact', $contact2)
                        ->whereIn('status', $status2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                } else {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('type', $type2)
                        ->whereIn('contact', $contact2)
                        ->whereIn('status', $status2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                }
            }
        }

        $customer           = collect($other_transaction)
            ->groupBy('contact');
        return view(
            'admin.reports.sales.request_ss_surabaya.sales_listInput',
            compact([
                'start',
                'end',
                'type',
                'con',
                'stat',
                'other_transaction',
                'status',
                'contact',
                'customer'
            ])
        );
    }

    public function sales_list_sukses_surabaya_excel($start, $end, $type, $con, $stat)
    {
        return Excel::download(new request_ss_surabaya_sales_list($start, $end, $type, $con, $stat), 'sales_list_' . $start . '_' . $end . '.xlsx');
    }

    public function sales_list_sukses_surabaya_csv($start, $end, $type, $con, $stat)
    {
        return Excel::download(new request_ss_surabaya_sales_list($start, $end, $type, $con, $stat), 'sales_list_' . $start . '_' . $end . '.csv');
    }

    public function sales_list_sukses_surabaya_pdf($start, $end, $type, $con, $stat)
    {
        $user                           = User::find(Auth::id());
        $today                          = Carbon::now();
        $company                        = company_setting::where('company_id', $user->company_id)->first();
        $contact2                       = explode(',', $con);
        $status2                        = explode(',', $stat);
        $type2                          = explode(',', $type);
        if ($con == 'null') {
            if ($stat == 'null') {
                if ($type == 'null') {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                } else {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('type', $type2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                }
            } else {
                if ($type == 'null') {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('status', $status2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                } else {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('type', $type2)
                        ->whereIn('status', $status2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                }
            }
        } else {
            if ($stat == 'null') {
                if ($type == 'null') {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('contact', $contact2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                } else {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('type', $type2)
                        ->whereIn('contact', $contact2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                }
            } else {
                if ($type == 'null') {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('contact', $contact2)
                        ->whereIn('status', $status2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                } else {
                    $other_transaction  = other_transaction::with('ot_contact', 'ot_status')
                        ->orderBy('transaction_date', 'ASC')
                        ->whereIn('type', $type2)
                        ->whereIn('contact', $contact2)
                        ->whereIn('status', $status2)
                        ->whereBetween('transaction_date', [$start, $end])
                        ->get();
                }
            }
        }
        $customer           = collect($other_transaction)
            ->groupBy('contact');
        $view = view('admin.reports.sales_export.request_ss_surabaya.sales_list_pdf')->with(compact([
            'company',
            'user',
            'today',
            'start',
            'end',
            'customer',
            'other_transaction',
        ]));
        $html = $view->render();
        $pdf = PDF::loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->download('sales_list_' . $start . '_' . $end . '.pdf');
    }

    public function sales_by_customer_sukses_surabaya()
    {
        $today                      = Carbon::today()->toDateString();
        $contact                    = contact::get();
        $si                         = sale_invoice_item::with('sale_invoice')
            ->get();
        $sid                        = sale_invoice::with('sale_invoice_item')
            ->whereBetween('transaction_date', [$today, $today])
            ->get();

        $customers                   = collect($sid)
            ->groupBy('contact_id')
            ->map(function ($item) {
                return $item
                    ->groupBy('id')
                    ->map(function ($item) {
                        return $item;
                    });
            });

        return view(
            'admin.reports.sales.request_ss_surabaya.sales_by_customer',
            compact([
                'today',
                'contact',
                'si',
                'sid',
                'customers'
            ])
        );
    }

    public function sales_by_customer_sukses_surabayaInput($start, $end, $con)
    {
        $contact2                   = explode(',', $con);
        $contact                    = contact::get();
        if ($con == 'null') {
            $si                     = sale_invoice::with('sale_invoice_item')->orderBy('transaction_date')
                ->whereBetween('transaction_date', [$start, $end])
                ->get();
        } else {
            $si                     = sale_invoice::with('sale_invoice_item')->orderBy('transaction_date')
                ->whereIn('contact_id', $contact2)
                ->whereBetween('transaction_date', [$start, $end])
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
        return view(
            'admin.reports.sales.request_ss_surabaya.sales_by_customerInput',
            compact([
                'start',
                'end',
                'contact',
                'si',
                'sid',
                'con',
                'customers'
            ])
        );
    }

    public function sales_by_customer_sukses_surabaya_excel($start, $end, $con)
    {
        return Excel::download(new request_ss_surabaya_sales_by_customer($start, $end, $con), 'sales_by_customer_' . $start . '_' . $end . '.xlsx');
    }

    public function sales_by_customer_sukses_surabaya_csv($start, $end, $con)
    {
        return Excel::download(new request_ss_surabaya_sales_by_customer($start, $end, $con), 'sales_by_customer_' . $start . '_' . $end . '.csv');
    }

    public function sales_by_customer_sukses_surabaya_pdf($start, $end, $con)
    {
        $user                       = User::find(Auth::id());
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $contact2                   = explode(',', $con);
        $contact                    = contact::get();
        $today                      = Carbon::now();
        if ($con == 'null') {
            $si                     = sale_invoice::orderBy('transaction_date')
                ->whereBetween('transaction_date', [$start, $end])
                ->get();
        } else {
            $si                     = sale_invoice::orderBy('transaction_date')
                ->whereIn('contact_id', $contact2)
                ->whereBetween('transaction_date', [$start, $end])
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
        $view = view('admin.reports.sales_export.request_ss_surabaya.sales_by_customer_pdf')->with(compact([
            'company',
            'start',
            'end',
            'contact',
            'customers',
            'si',
            'sid',
            'con',
            'today',
        ]));
        $html = $view->render();
        $pdf = PDF::loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->download('sales_by_customer_' . $start . '_' . $end . '.pdf');
    }

    public function customer_balance_sukses_surabaya()
    {
        $this_month                 = new Carbon('first day of this month');
        $get_this_month             = $this_month->toDateString();
        $today                      = Carbon::today()->toDateString();
        $contact                    = contact::get();
        $si                         = sale_invoice::orderBy('transaction_date')
            ->whereBetween('transaction_date', [$get_this_month, $today])
            ->whereIn('status', [1, 4, 5])
            ->get();
        $sid                        = sale_invoice_item::get();
        return view(
            'admin.reports.sales.request_ss_surabaya.customer_balance',
            compact([
                'today', 'contact', 'si', 'sid', 'get_this_month'
            ])
        );
    }

    public function customer_balance_sukses_surabayaInput($start, $end, $con)
    {
        $contact2                   = explode(',', $con);
        if ($con == 'null') {
            $si                         = sale_invoice::orderBy('transaction_date')
                ->whereBetween('transaction_date', [$start, $end])
                ->whereIn('status', [1, 4, 5])
                ->get();
        } else {
            $si                         = sale_invoice::orderBy('transaction_date')
                ->whereBetween('transaction_date', [$start, $end])
                ->whereIn('status', [1, 4, 5])
                ->whereIn('contact_id', $contact2)
                ->get();
        }
        $contact                    = contact::get();
        $sid                        = sale_invoice_item::get();
        return view(
            'admin.reports.sales.request_ss_surabaya.customer_balanceInput',
            compact([
                'start', 'end', 'contact', 'si', 'sid', 'con'
            ])
        );
    }

    public function customer_balance_sukses_surabaya_excel($start, $end, $con)
    {
        return Excel::download(new request_ss_surabaya_customer_balance($start, $end, $con), 'customer_balance_' . $start . '_' . $end . '.xlsx');
    }

    public function customer_balance_sukses_surabaya_csv($start, $end, $con)
    {
        return Excel::download(new request_ss_surabaya_customer_balance($start, $end, $con), 'customer_balance_' . $start . '_' . $end . '.csv');
    }

    public function customer_balance_sukses_surabaya_pdf($start, $end, $con)
    {
        $user                       = User::find(Auth::id());
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $contact2                   = explode(',', $con);
        $today                      = Carbon::now();
        if ($con == 'null') {
            $si                         = sale_invoice::orderBy('transaction_date')
                ->whereBetween('transaction_date', [$start, $end])
                ->get();
        } else {
            $si                         = sale_invoice::orderBy('transaction_date')
                ->whereIn('contact_id', $contact2)
                ->whereBetween('transaction_date', [$start, $end])
                ->get();
        }
        $contact                    = contact::get();
        $sid                        = sale_invoice_item::get();
        $view = view('admin.reports.sales_export.request_ss_surabaya.customer_balance_pdf')->with(compact([
            'company',
            'start',
            'end',
            'contact',
            'si',
            'sid',
            'con',
            'today',
        ]));
        $html = $view->render();
        $pdf = PDF::loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->download('customer_balance_' . $start . '_' . $end . '.pdf');
    }

    public function aged_payable_sukses_surabaya()
    {
        $today                          = Carbon::today()->toDateString();

        $month1                              = purchase_invoice::with('purchase_invoice_item', 'contact')
            ->whereBetween('transaction_date', [$today, $today])
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
            ->whereBetween('transaction_date', [$today, $today])
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
            ->whereBetween('transaction_date', [$today, $today])
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
            ->whereBetween('transaction_date', [$today, $today])
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
            ->whereBetween('transaction_date', [$today, $today])
            ->groupBy('contact_id')
            ->selectRaw('SUM(balance_due) as balance_due, contact_id')
            ->get();

        //dd($pi);
        $contact                    = contact::get();
        //dd($month1, $month2, $month3, $month4);
        return view(
            'admin.reports.purchases.request_ss_surabaya.aged_payable',
            compact([
                'si',
                'today',
                'contact',
                'month1',
                'month2',
                'month3',
                'month4'
            ])
        );
    }

    public function aged_payable_sukses_surabayaInput($start, $end)
    {
        $days                           = Carbon::parse($start);
        $sesi1_start                    = $days->toDateString();
        $sesi1_end                      = $days->addDay(29)->toDateString();
        $sesi2_start                    = $days->addDay(1)->toDateString();
        $sesi2_end                      = $days->addDay(29)->toDateString();
        $sesi3_start                    = $days->addDay(1)->toDateString();
        $sesi3_end                      = $days->addDay(29)->toDateString();
        $sesi4_start                    = $days->addDay(1)->toDateString();
        $sesi4_end                      = $end;

        //dd($sesi1_start, $sesi1_end, $sesi2_start, $sesi2_end, $sesi3_start, $sesi3_end);
        if ($end <= $sesi1_end) {
            $start1 = $sesi1_start;
            $start2 = null;
            $start3 = null;
            $start4 = null;
            $end1 = $end;
            $end2 = null;
            $end3 = null;
            $end4 = null;
        } elseif ($end <= $sesi2_end) {
            $start1 = $sesi1_start;
            $start2 = $sesi2_start;
            $start3 = null;
            $start4 = null;
            $end1 = $sesi1_end;
            $end2 = $end;
            $end3 = null;
            $end4 = null;
        } elseif ($end <= $sesi3_end) {
            $start1 = $sesi1_start;
            $start2 = $sesi2_start;
            $start3 = $sesi3_start;
            $start4 = null;
            $end1 = $sesi1_end;
            $end2 = $sesi2_end;
            $end3 = $end;
            $end4 = null;
        } else {
            $start1 = $sesi1_start;
            $start2 = $sesi2_start;
            $start3 = $sesi3_start;
            $start4 = $sesi4_start;
            $end1 = $sesi1_end;
            $end2 = $sesi2_end;
            $end3 = $sesi3_end;
            $end4 = $end;
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
            ->whereBetween('transaction_date', [$start, $end])
            ->groupBy('contact_id')
            ->selectRaw('SUM(balance_due) as balance_due, contact_id')
            ->get();

        //dd($pi);
        $contact                    = contact::get();
        //dd($group1, $group2, $group3, $group4);
        //dd($start1, $start2, $start3, $start4);
        return view(
            'admin.reports.purchases.request_ss_surabaya.aged_payableInput',
            compact([
                'si',
                'start',
                'end',
                'contact',
                'month1',
                'month2',
                'month3',
                'month4',
                'group1',
                'group2',
                'group3',
                'group4',
            ])
        );
    }

    public function aged_payable_sukses_surabaya_excel($start, $end)
    {
        return Excel::download(new request_ss_surabaya_aged_payable($start, $end), 'aged_payable_' . $start . '_' . $end . '.xlsx');
    }

    public function aged_payable_sukses_surabaya_csv($start, $end)
    {
        return Excel::download(new request_ss_surabaya_aged_payable($start, $end), 'aged_payable_' . $start . '_' . $end . '.csv');
    }

    public function aged_payable_sukses_surabaya_pdf($start, $end)
    {
        $user                       = User::find(Auth::id());
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $today                      = Carbon::now();
        $days                           = Carbon::parse($start);
        $sesi1_start                    = $days->toDateString();
        $sesi1_end                      = $days->addDay(29)->toDateString();
        $sesi2_start                    = $days->addDay(1)->toDateString();
        $sesi2_end                      = $days->addDay(29)->toDateString();
        $sesi3_start                    = $days->addDay(1)->toDateString();
        $sesi3_end                      = $days->addDay(29)->toDateString();
        $sesi4_start                    = $days->addDay(1)->toDateString();
        $sesi4_end                      = $end;

        //dd($sesi1_start, $sesi1_end, $sesi2_start, $sesi2_end, $sesi3_start, $sesi3_end);
        if ($end <= $sesi1_end) {
            $start1 = $sesi1_start;
            $start2 = null;
            $start3 = null;
            $start4 = null;
            $end1 = $end;
            $end2 = null;
            $end3 = null;
            $end4 = null;
        } elseif ($end <= $sesi2_end) {
            $start1 = $sesi1_start;
            $start2 = $sesi2_start;
            $start3 = null;
            $start4 = null;
            $end1 = $sesi1_end;
            $end2 = $end;
            $end3 = null;
            $end4 = null;
        } elseif ($end <= $sesi3_end) {
            $start1 = $sesi1_start;
            $start2 = $sesi2_start;
            $start3 = $sesi3_start;
            $start4 = null;
            $end1 = $sesi1_end;
            $end2 = $sesi2_end;
            $end3 = $end;
            $end4 = null;
        } else {
            $start1 = $sesi1_start;
            $start2 = $sesi2_start;
            $start3 = $sesi3_start;
            $start4 = $sesi4_start;
            $end1 = $sesi1_end;
            $end2 = $sesi2_end;
            $end3 = $sesi3_end;
            $end4 = $end;
        }

        $month1                         = purchase_invoice::with('purchase_invoice_item', 'contact')
            ->whereBetween('transaction_date', [$start1, $end1])
            ->get();

        $group1                         = $month1
            ->groupBy(function ($contact) {
                return $contact->contact->display_name;
            })
            ->map(function ($item) {
                return $item
                    ->map(function ($item) {
                        return $item;
                    });
            });
        $month2                         = purchase_invoice::with('purchase_invoice_item', 'contact')
            ->whereBetween('transaction_date', [$start2, $end2])
            ->get();

        $group2                         = $month2
            ->groupBy(function ($contact) {
                return $contact->contact->display_name;
            })
            ->map(function ($item) {
                return $item
                    ->map(function ($item) {
                        return $item;
                    });
            });
        $month3                         = purchase_invoice::with('purchase_invoice_item', 'contact')
            ->whereBetween('transaction_date', [$start3, $end3])
            ->get();

        $group3                         = $month3
            ->groupBy(function ($contact) {
                return $contact->contact->display_name;
            })
            ->map(function ($item) {
                return $item
                    ->map(function ($item) {
                        return $item;
                    });
            });
        $month4                         = purchase_invoice::with('purchase_invoice_item', 'contact')
            ->whereBetween('transaction_date', [$start4, $end4])
            ->get();

        $group4                         = $month4
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
            ->whereBetween('transaction_date', [$start, $end])
            ->groupBy('contact_id')
            ->selectRaw('SUM(balance_due) as balance_due, contact_id')
            ->get();

        //dd($pi);
        $contact                        = contact::get();
        //dd($group1, $group2, $group3, $group4);
        //dd($start1, $start2, $start3, $start4);
        $view = view('admin.reports.purchases_export.request_ss_surabaya.aged_payable_pdf')->with(compact([
            'company',
            'today',
            'start',
            'end',
            'si',
            'contact',
            'month1',
            'month2',
            'month3',
            'month4',
            'group1',
            'group2',
            'group3',
            'group4',
        ]));
        $html = $view->render();
        $pdf = PDF::loadHTML($html)->setPaper('a4', 'portrait');
        return $pdf->download('aged_payable_' . $start . '_' . $end . '.pdf');
    }

    public function balanceSheet_sukses_surabaya()
    {
        $last_periode                               = new Carbon('first day of last month');
        $start_last_periode                         = $last_periode->toDateString();
        $endmonth_last_periode                      = new Carbon('last day of last month');
        $end_last_periode                           = $endmonth_last_periode->toDateString();
        $current_periode                            = new Carbon('first day of this month');
        //dd($current_periode);
        $today                                      = Carbon::today()->toDateString();
        $today2                                     = $current_periode->toDateString();
        /*
         INI CONTOH UNTUK JOIN COA DETAIL DENGAN COA YANG BENAR
        $view_current_assets4                        = DB::table('coa_details')
                                                        ->join('coas', 'coa_details.id', '=', 'coas.id')
                                                        ->select('coa_details.*', 'coas.coa_category_id')
                                                        ->get();*/
        /*$cek_opening_balance                        = coa_detail::where('type', 'opening balance')->first();
        if ($cek_opening_balance) {
            $coa_detail                             = coa_detail::whereBetween('date', [$cek_opening_balance->date, $today])
                ->orderBy('date', 'ASC')
                ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
                //->selectRaw('debit, credit, SUM(debit - credit) as total1, SUM(credit - debit) as total2, coa_id')
                //->selectRaw('SUM(debit) as debit, SUM(credit) as credit, coa_id')
                ->groupBy('coa_id')
                ->get();
        } else {*/
        $coa_detail                             = coa_detail::whereBetween('date', [$current_periode->toDateString(), $today])
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();
        //}
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
                $total_depreciation                 += $cd->total;
            }
        }
        $total_assets                               = $total_current_assets + $total_fixed_assets - $total_depreciation;
        $total_liability                            = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 8 or $cd->coa->coa_category_id == 10 or $cd->coa->coa_category_id == 17) {
                $total_liability                    += $cd->total2;
            }
        }
        /*$total_equity                               = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 12) {
                $total_equity                       += $cd->total;
            }
        }*/
        // CEK KLO ADA OPENING BALANCE KLO GADA PAKE FIRST COA DETAIL
        // UNTUK LAST PERIODE, KITA PAKE PER BULAN YAITU PAKE BULAN KEMARIN DARI CURRENT
        $last_periode_coa_detail                    = coa_detail::whereBetween('date', [$start_last_periode, $end_last_periode])
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();
        $last_periode_total_current_assets                       = 0;
        foreach ($last_periode_coa_detail as $cd2) {
            if ($cd2->coa->coa_category_id == 1 or $cd2->coa->coa_category_id == 2 or $cd2->coa->coa_category_id == 3 or $cd2->coa->coa_category_id == 4) {
                $last_periode_total_current_assets  += $cd2->total;
            }
        }
        $last_periode_total_fixed_assets                         = 0;
        foreach ($last_periode_coa_detail as $cd2) {
            if ($cd2->coa->coa_category_id == 5 or $cd2->coa->coa_category_id == 6) {
                $last_periode_total_fixed_assets    += $cd2->total;
            }
        }
        $last_periode_total_depreciation                         = 0;
        foreach ($last_periode_coa_detail as $cd2) {
            if ($cd2->coa->coa_category_id == 7) {
                $last_periode_total_depreciation    += $cd2->total;
            }
        }
        $last_periode_total_assets                  = $last_periode_total_current_assets + $last_periode_total_fixed_assets - $last_periode_total_depreciation;
        $last_periode_total_liability               = 0;
        foreach ($last_periode_coa_detail as $cd2) {
            if ($cd2->coa->coa_category_id == 8 or $cd2->coa->coa_category_id == 10 or $cd2->coa->coa_category_id == 17) {
                $last_periode_total_liability       += $cd2->total2;
            }
        }
        $last_periode_earning                       = 0; //$last_periode_total_assets - $last_periode_total_liability;
        //$current_period_earning                     = $total_assets - $total_liability; YANG KATANYA BENER (CUMA SALAH)
        $current_period_earning                     = $total_assets - $total_liability;
        $total_equity2                              = $current_period_earning + $last_periode_earning;
        //$total_lia_eq                               = $total_liability + $total_equity2; YANG KATANYA BENER (CUMA SALAH)
        $total_lia_eq                               = $total_equity2 + $total_liability;
        return view('admin.reports.overview.request_ss_surabaya.balance_sheet', compact([
            'start_last_periode',
            'end_last_periode',
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

    public function balanceSheet_sukses_surabayaInput($start, $end)
    {
        $last_periode                               = new Carbon('first day of last year');
        $startyear_last_periode                     = $last_periode->startOfYear()->toDateString();
        $endyear_last_periode                       = $last_periode->endOfYear()->toDateString();
        //if (Carbon::parse($today)->gt(Carbon::now())) {
        //    $coa_detail                                 = coa_detail::whereBetween('date', [$current_periode->toDateString(), $today])
        //           ->orderBy('coa_id')
        //       ->selectRaw('SUM(debit - credit) as total, coa_id')
        //        ->groupBy('coa_id')
        //        ->get();
        //} else {
        $coa_detail                                 = coa_detail::whereBetween('date', [$start, $end])
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();
        //}
        $total_current_assets                       = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 1 or $cd->coa->coa_category_id == 2 or $cd->coa->coa_category_id == 3 or $cd->coa->coa_category_id == 4) {
                $total_current_assets               += $cd->total;
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
                $total_liability                   += $cd->total2;
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
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
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
                $last_periode_total_liability                    += $cd->total2;
            }
        }
        $last_periode_earning                       = 0; //$last_periode_total_assets - $last_periode_total_liability;
        $current_period_earning                     = $total_assets - $total_liability;
        $total_equity2                              = $current_period_earning + $last_periode_earning;
        $total_lia_eq                               = $total_liability + $total_equity2;

        return view('admin.reports.overview.request_ss_surabaya.balance_sheetInput', compact([
            'startyear_last_periode',
            'endyear_last_periode',
            'start',
            'end',
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

    public function balanceSheet_sukses_surabaya_excel($start, $end, $startyear, $endyear)
    {
        return Excel::download(new request_ss_surabaya_balance_sheet($start, $end, $startyear, $endyear), 'balance_sheet_' . $start . '_' . $end . '.xlsx');
    }

    public function balanceSheet_sukses_surabaya_csv($start, $end, $startyear, $endyear)
    {
        return Excel::download(new request_ss_surabaya_balance_sheet($start, $end, $startyear, $endyear), 'balance_sheet_' . $start . '_' . $end . '.csv');
    }

    public function balanceSheet_sukses_surabaya_pdf($start, $end, $startyear, $endyear)
    {
        $user                                       = User::find(Auth::id());
        $company                                    = company_setting::where('company_id', $user->company_id)->first();
        $today                                      = Carbon::now();
        $coa_detail                                 = coa_detail::whereBetween('date', [$start, $end])
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();
        $last_periode_coa_detail                    = coa_detail::whereBetween('date', [$startyear, $endyear])
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();
        $view = view('admin.reports.overview_export.request_ss_surabaya.balance_sheet_pdf')->with(compact(['coa_detail', 'last_periode_coa_detail', 'company', 'start', 'end', 'today']));
        $html = $view->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('balance_sheet_' . $start . '_' . $end . '.pdf');
    }

    public function profitLoss_sukses_surabaya()
    {
        $today                                      = Carbon::today()->toDateString();
        $coa_detail                                 = coa_detail::whereBetween('date', [$today, $today])
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();

        $total_primary_income               = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 13) {
                $total_primary_income       += $cd->total2;
            }
        }
        $total_cost_of_sales                = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 15) {
                $total_cost_of_sales        += $cd->total;
            }
        }
        $gross_profit                       = $total_primary_income - $total_cost_of_sales;

        $total_operational_expense          = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 16) {
                $total_operational_expense  += $cd->total;
            }
        }
        $net_operating_income               = $gross_profit - $total_operational_expense;

        $total_other_income                 = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 14) {
                $total_other_income         += $cd->total2;
            }
        }

        $total_other_expense                = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 17) {
                $total_other_expense        += $cd->total;
            }
        }
        $net_income                         = $net_operating_income + $total_other_income - $total_other_expense;

        return view('admin.reports.overview.request_ss_surabaya.profit_loss', compact([
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

    public function profitLoss_sukses_surabayaInput($start, $end)
    {
        $coa_detail                                 = coa_detail::whereBetween('date', [$start, $end])
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();

        $total_primary_income               = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 13) {
                $total_primary_income       += $cd->total2;
            }
        }
        $total_cost_of_sales                = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 15) {
                $total_cost_of_sales        += $cd->total;
            }
        }
        $gross_profit                       = $total_primary_income - $total_cost_of_sales;

        $total_operational_expense          = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 16) {
                $total_operational_expense  += $cd->total;
            }
        }
        $net_operating_income               = $gross_profit - $total_operational_expense;

        $total_other_income                 = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 14) {
                $total_other_income         += $cd->total2;
            }
        }

        $total_other_expense                = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 17) {
                $total_other_expense        += $cd->total;
            }
        }
        $net_income                         = $net_operating_income + $total_other_income - $total_other_expense;

        return view('admin.reports.overview.request_ss_surabaya.profit_lossInput', compact([
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

    public function profitLoss_sukses_surabaya_excel($start, $end)
    {
        return Excel::download(new request_ss_surabaya_profit_loss($start, $end), 'profit_loss_' . $start . '_' . $end . '.xlsx');
    }

    public function profitLoss_sukses_surabaya_csv($start, $end)
    {
        return Excel::download(new request_ss_surabaya_profit_loss($start, $end), 'profit_loss_' . $start . '_' . $end . '.csv');
    }

    public function profitLoss_sukses_surabaya_pdf($start, $end)
    {
        $user                               = User::find(Auth::id());
        $today                              = Carbon::now();
        $company                            = company_setting::where('company_id', $user->company_id)->first();
        $coa_detail                         = coa_detail::whereBetween('date', [$start, $end])
            ->orderBy('date', 'ASC')
            ->selectRaw('SUM(debit - credit) as total, SUM(credit - debit) as total2, coa_id')
            ->groupBy('coa_id')
            ->get();

        $total_primary_income               = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 13) {
                $total_primary_income       += $cd->total2;
            }
        }
        $total_cost_of_sales                = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 15) {
                $total_cost_of_sales        += $cd->total;
            }
        }
        $gross_profit                       = $total_primary_income - $total_cost_of_sales;

        $total_operational_expense          = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 16) {
                $total_operational_expense  += $cd->total;
            }
        }
        $net_operating_income               = $gross_profit - $total_operational_expense;

        $total_other_income                 = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 14) {
                $total_other_income         += $cd->total2;
            }
        }

        $total_other_expense                = 0;
        foreach ($coa_detail as $cd) {
            if ($cd->coa->coa_category_id == 17) {
                $total_other_expense        += $cd->total;
            }
        }
        $net_income                 = $net_operating_income + $total_other_income - $total_other_expense;
        $view = view('admin.reports.overview_export.request_ss_surabaya.profit_loss_pdf')->with(compact([
            'company',
            'today',
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
        $html = $view->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('profit_loss_' . $start . '_' . $end . '.pdf');
    }

    //* REQUEST SUKSES SURABAYA
}
