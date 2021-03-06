<?php

namespace App\Http\Controllers;

use App\Events\SalesInvoiceStoredEvent;
use App\Model\sales\sale_invoice;
use App\Model\sales\sale_invoice_item;
use App\Model\sales\sale_delivery;
use App\Model\sales\sale_delivery_item;
use App\Model\contact\contact;
use App\Model\warehouse\warehouse;
use App\Model\product\product;
use App\Model\other\other_term;
use App\Model\other\other_unit;
use App\Model\other\other_tax;
use App\Model\company\company_setting;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Model\coa\coa_detail;
use App\Model\coa\default_account;
use App\Model\warehouse\warehouse_detail;
use Validator;
use App\Model\other\other_transaction;
use App\Model\coa\coa;
use App\Model\company\company_logo;
use App\Model\product\product_bundle_cost;
use App\Model\product\product_discount_item;
use App\Model\product\product_fifo_in;
use App\Model\product\product_fifo_out;
use App\Model\sales\sale_invoice_cost;
use App\Model\sales\sale_payment_item;
use PDF;
use App\Model\sales\sale_quote;
use App\Model\sales\sale_quote_item;
use App\Model\sales\sale_order;
use App\Model\sales\sale_order_item;
use App\Model\sales\sale_return;
use App\Model\spk\spk;
use App\Model\spk\spk_item;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class SaleInvoiceController extends Controller
{
    public function select_product()
    {
        $user                       = User::find(Auth::id());
        if ($user->getRoleNames()->first() == 'GT' or $user->getRoleNames()->first() == 'MT' or $user->getRoleNames()->first() == 'WS') {
            if (request()->ajax()) {
                $page               = Input::get('page');
                $resultCount        = 10;

                $offset             = ($page - 1) * $resultCount;

                $breeds             = product::where('name', 'LIKE',  '%' . Input::get("term") . '%')->orWhere('code', 'LIKE',  '%' . Input::get("term") . '%')
                    ->where('is_sell', 1)
                    ->where('sales_type', $user->getRoleNames()->first())
                    //->where('is_bundle', 0)
                    ->orderBy('name')
                    ->skip($offset)
                    ->take($resultCount)
                    ->get(['id', DB::raw('name as text'), 'code', 'other_unit_id', 'desc', 'sell_price', 'sell_tax', 'is_lock_sales', 'qty']);

                $count              = product::where('is_sell', 1)->count();
                $endCount           = $offset + $resultCount;
                $morePages          = $endCount > $count;

                $results = array(
                    "results"       => $breeds,
                    "pagination"    => array(
                        "more"      => $morePages,
                    ),
                    "total_count"   => $count,
                );

                return response()->json($results);
            }
        } else {
            if (request()->ajax()) {
                $page               = Input::get('page');
                $resultCount        = 10;

                $offset             = ($page - 1) * $resultCount;

                $breeds = product::where('name', 'LIKE',  '%' . Input::get("term") . '%')->orWhere('code', 'LIKE',  '%' . Input::get("term") . '%')
                    ->where('is_sell', 1)
                    //->where('is_bundle', 0)
                    ->orderBy('name')
                    ->skip($offset)
                    ->take($resultCount)
                    ->get(['id', DB::raw('name as text'), 'code', 'other_unit_id', 'desc', 'sell_price', 'sell_tax', 'is_lock_sales', 'qty']);

                $count              = product::where('is_sell', 1)->count();
                $endCount           = $offset + $resultCount;
                $morePages          = $endCount > $count;

                $results = array(
                    "results"       => $breeds,
                    "pagination"    => array(
                        "more"      => $morePages,
                    ),
                    "total_count"   => $count,
                );

                return response()->json($results);
            }
        }
    }

    public function select_contact()
    {
        $user               = User::find(Auth::id());
        if ($user->getRoleNames()->first() == 'GT' or $user->getRoleNames()->first() == 'MT' or $user->getRoleNames()->first() == 'WS') {
            if (request()->ajax()) {
                $page = Input::get('page');
                $resultCount = 10;

                $offset = ($page - 1) * $resultCount;

                $breeds = contact::where('display_name', 'LIKE',  '%' . Input::get("term") . '%')
                    ->where('type_customer', 1)
                    ->where('sales_type', $user->getRoleNames()->first())
                    //->where('is_bundle', 0)
                    ->orderBy('display_name')
                    ->skip($offset)
                    ->take($resultCount)
                    ->get(['id', DB::raw('display_name as text'), 'term_id', 'email', 'shipping_address']);

                $count = contact::where('type_customer', 1)->count();
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
        } else {
            if (request()->ajax()) {
                $page = Input::get('page');
                $resultCount = 10;

                $offset = ($page - 1) * $resultCount;

                $breeds = contact::where('display_name', 'LIKE',  '%' . Input::get("term") . '%')
                    ->where('type_customer', 1)
                    //->where('is_bundle', 0)
                    ->orderBy('display_name')
                    ->skip($offset)
                    ->take($resultCount)
                    ->get(['id', DB::raw('display_name as text'), 'term_id', 'email', 'shipping_address']);

                $count = contact::where('type_customer', 1)->count();
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
    }

    public function index()
    {
        $user                       = User::find(Auth::id());
        $open_po                    = sale_invoice::whereIn('status', [1, 4])->count();
        $payment_last               = sale_invoice::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->count();
        $overdue                    = sale_invoice::where('status', 5)->count();
        $open_po_total              = sale_invoice::whereIn('status', [1, 4])->sum('grandtotal');
        $payment_last_total         = sale_invoice::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->sum('grandtotal');
        $overdue_total              = sale_invoice::where('status', 5)->sum('grandtotal');
        if ($user->getRoleNames()->first() == 'GT' or $user->getRoleNames()->first() == 'MT' or $user->getRoleNames()->first() == 'WS') {
            if (request()->ajax()) {
                return datatables()->of(sale_invoice::with('sale_invoice_item', 'contact', 'status')->whereHas('contact', function ($query) use ($user) {
                    $query->where('sales_type', $user->getRoleNames()->first());
                })->get())
                    ->make(true);
            }
        } else {
            if (request()->ajax()) {
                return datatables()->of(sale_invoice::with('sale_invoice_item', 'contact', 'status', 'warehouse')->get())
                    ->make(true);
            }
        }

        return view('admin.sales.invoices.index', compact(['user', 'open_po', 'payment_last', 'overdue', 'open_po_total', 'payment_last_total', 'overdue_total']));
    }

    public function create()
    {
        $vendors                = contact::where('type_customer', true)->get();
        $warehouses             = warehouse::where('id', '>', 0)->get();
        $terms                  = other_term::all();
        $products               = product::where('is_sell', 1)->get();
        $units                  = other_unit::all();
        $today                  = Carbon::today()->toDateString();
        $todaytambahtiga        = Carbon::today()->addDays(30)->toDateString();
        $taxes                  = other_tax::all();
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = sale_invoice::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                if ($dt->isSameMonth($number->transaction_date)) {
                    $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                } else {
                    $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                    }
                }
            } else {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                if ($check_number) {
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                }
            }
        } else {
            $number             = sale_invoice::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }

        return view('admin.sales.invoices.create', compact([
            'vendors',
            'warehouses',
            'terms',
            'products',
            'units',
            'taxes',
            'today',
            'todaytambahtiga',
            'trans_no'
        ]));
    }

    public function createRequestSukses()
    {
        $vendors                = contact::where('type_customer', true)->get();
        $warehouses             = warehouse::where('id', '>', 0)->get();
        $terms                  = other_term::all();
        $products               = product::where('is_sell', 1)->get();
        $units                  = other_unit::all();
        $today                  = Carbon::today()->toDateString();
        $todaytambahtiga        = Carbon::today()->addDays(30)->toDateString();
        $taxes                  = other_tax::all();
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = sale_invoice::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                if ($dt->isSameMonth($number->transaction_date)) {
                    $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                } else {
                    $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                    }
                }
            } else {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                if ($check_number) {
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                }
            }
        } else {
            $number             = sale_invoice::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }

        return view('admin.request.sukses.sales.invoices.create', compact([
            'vendors',
            'warehouses',
            'terms',
            'products',
            'units',
            'taxes',
            'today',
            'todaytambahtiga',
            'trans_no'
        ]));
    }

    public function createFromDelivery($id)
    {
        $check                  = sale_invoice::where('selected_sd_id', $id)->latest()->first();
        $po                     = sale_delivery::find($id);
        $po_item                = sale_delivery_item::where('sale_delivery_id', $id)->get();
        $today                  = Carbon::today()->toDateString();
        $terms                  = other_term::all();
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = sale_invoice::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                if ($dt->isSameMonth($number->transaction_date)) {
                    $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                } else {
                    $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                    }
                }
            } else {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                if ($check_number) {
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                }
            }
        } else {
            $number             = sale_invoice::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }

        return view('admin.sales.invoices.createFromDelivery', compact(['today', 'trans_no', 'terms', 'po', 'po_item']));
    }

    public function createFromOrder($id)
    {
        $po                     = sale_order::find($id);
        $po_item                = sale_order_item::where('sale_order_id', $id)->get();
        $today                  = Carbon::today()->toDateString();
        $terms                  = other_term::all();
        $warehouses             = warehouse::all();
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = sale_invoice::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                if ($dt->isSameMonth($number->transaction_date)) {
                    $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                } else {
                    $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                    }
                }
            } else {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                if ($check_number) {
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                }
            }
        } else {
            $number             = sale_invoice::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }

        return view('admin.sales.invoices.createFromOrder', compact(['today', 'trans_no', 'terms', 'warehouses', 'po', 'po_item']));
    }

    public function createFromQuote($id)
    {
        $po                     = sale_quote::find($id);
        $po_item                = sale_quote_item::where('sale_quote_id', $id)->get();
        $today                  = Carbon::today()->toDateString();
        $terms                  = other_term::all();
        $warehouses             = warehouse::all();
        $products               = product::all();
        $units                  = other_unit::all();
        $taxes                  = other_tax::all();
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = sale_invoice::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                if ($dt->isSameMonth($number->transaction_date)) {
                    $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                } else {
                    $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                    }
                }
            } else {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                if ($check_number) {
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                }
            }
        } else {
            $number             = sale_invoice::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }

        return view('admin.sales.invoices.createFromQuote', compact([
            'today',
            'trans_no',
            'terms',
            'warehouses',
            'po',
            'po_item',
            'products',
            'units',
            'taxes'
        ]));
    }

    public function createFromSPK($id)
    {
        $po                     = spk::find($id);
        $po_item                = spk_item::where('spk_id', $id)->get();
        $today                  = Carbon::today()->toDateString();
        $terms                  = other_term::all();
        $warehouses             = warehouse::all();
        $products               = product::all();
        $units                  = other_unit::all();
        $taxes                  = other_tax::all();
        $costs                  = coa::whereIn('coa_category_id', [15, 16, 17])->get();
        $cost_from_bundle       = product_bundle_cost::get();
        $check_cost_from_bundle = product_bundle_cost::first();
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = sale_invoice::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                if ($dt->isSameMonth($number->transaction_date)) {
                    $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                } else {
                    $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                    }
                }
            } else {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                if ($check_number) {
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                }
            }
        } else {
            $number             = sale_invoice::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }

        return view('admin.request.sukses.sales.invoices.createFromSPK', compact([
            'today',
            'trans_no',
            'terms',
            'warehouses',
            'po',
            'po_item',
            'products',
            'units',
            'taxes',
            'costs',
            'cost_from_bundle',
            'check_cost_from_bundle'
        ]));
    }

    public function createFromOrderRequestSukses($id)
    {
        $po                     = sale_order::find($id);
        $po_item                = sale_order_item::where('sale_order_id', $id)->get();
        $today                  = Carbon::today()->toDateString();
        $terms                  = other_term::all();
        $warehouses             = warehouse::all();
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = sale_invoice::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                if ($dt->isSameMonth($number->transaction_date)) {
                    $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                } else {
                    $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                    }
                }
            } else {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                if ($check_number) {
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SI';
                }
            }
        } else {
            $number             = sale_invoice::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }

        return view('admin.request.sukses.sales.invoices.createFromOrder', compact(['today', 'trans_no', 'terms', 'warehouses', 'po', 'po_item']));
    }

    public function store(Request $request)
    {
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        $cs                     = company_setting::where('company_id', $user->company_id)->first();
        if ($user->company_id == 5) {
            $number             = sale_invoice::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SI';
                }
            } else {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SI';
                }
            }
        } else {
            $number             = sale_invoice::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }
        $rules = array(
            'vendor_name'   => 'required',
            'term'          => 'required',
            'trans_date'    => 'required',
            'due_date'      => 'required',
            'warehouse'     => 'required',
            'products'      => 'required|array|min:1',
            'products.*'    => 'required',
            'qty'           => 'required|array|min:1',
            'qty.*'         => 'required',
            'units'         => 'required|array|min:1',
            'units.*'       => 'required',
            'unit_price'    => 'required|array|min:1',
            'unit_price.*'  => 'required',
            'tax'           => 'required|array|min:1',
            'tax.*'         => 'required',
            'total_price'   => 'required|array|min:1',
            'total_price.*' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $id_contact                         = $request->vendor_name;
            // DEFAULT DARI SETTING
            $contact_account                    = contact::find($id_contact);
            if ($contact_account->is_limit == 1) {
                if ($contact_account->current_limit_balance >= $request->balance) {
                    $contact_account->update([
                        'current_limit_balance'         => $contact_account->current_limit_balance - $request->balance,
                    ]);
                } else {
                    DB::rollBack();
                    return response()->json(['errors' => 'Cannot make a transaction because the balance has exceeded the limit!<br><br>
                    Total Limit Balance = ' . number_format($contact_account->limit_balance, 2, ',', '.') . '<br>
                    Total Current Limit Balance = ' . number_format($contact_account->current_limit_balance, 2, ',', '.')]);
                }
            }
            $subtotal_header_other          = 0;
            $taxtotal_header_other          = 0;
            $grandtotal_header_other        = 0;

            $transactions                       = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'number_complete'               => 'Sales Invoice #' . $trans_no,
                'type'                          => 'sales invoice',
                'memo'                          => $request->get('memo'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'contact'                       => $request->get('vendor_name'),
                'status'                        => 1,
                'balance_due'                   => $request->get('balance'),
                'total'                         => $request->get('balance'),
            ]);
            $pi = new sale_invoice([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'email'                         => $request->get('email'),
                'address'                       => $request->get('vendor_address'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'term_id'                       => $request->get('term'),
                'vendor_ref_no'                 => $request->get('vendor_no'),
                'warehouse_id'                  => $request->get('warehouse'),
                'subtotal'                      => $request->get('subtotal'),
                'taxtotal'                      => $request->get('taxtotal'),
                'balance_due'                   => $request->get('balance'),
                'grandtotal'                    => $request->get('balance'),
                'message'                       => $request->get('message'),
                'memo'                          => $request->get('memo'),
                'status'                        => 1,
            ]);
            //$pi->save();
            $transactions->sale_invoice()->save($pi);
            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $pi->id,
            ]);

            foreach ($request->products as $i => $product) {
                $check_discount     = product::find($request->products[$i]);
                $get_discount_item  = product_discount_item::where('product_id', $request->products[$i])->get();
                if ($check_discount->is_discount == 1) {
                    if ($get_discount_item->count() == 4) {
                        if ($get_discount_item[3]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[3]->price;
                        } else if ($get_discount_item[2]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[2]->price;
                        } else if ($get_discount_item[1]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[1]->price;
                        } else if ($get_discount_item[0]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[0]->price;
                        } else {
                            $unit_price     = $get_discount_item[0]->price;
                        }
                    } else if ($get_discount_item->count() == 3) {
                        if ($get_discount_item[2]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[2]->price;
                        } else if ($get_discount_item[1]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[1]->price;
                        } else if ($get_discount_item[0]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[0]->price;
                        } else {
                            $unit_price     = $get_discount_item[2]->price;
                        }
                    } else if ($get_discount_item->count() == 2) {
                        if ($get_discount_item[1]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[1]->price;
                        } else if ($get_discount_item[0]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[0]->price;
                        } else {
                            $unit_price     = $get_discount_item[0]->price;
                        }
                    } else if ($get_discount_item->count() == 1) {
                        if ($get_discount_item[0]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[0]->price;
                        } else {
                            $unit_price     = $get_discount_item[0]->price;
                        }
                    }
                } else {
                    $unit_price             = $request->unit_price[$i];
                }
                $get_tax                    = other_tax::find($request->tax[$i]);
                $subtotal                   = $request->qty[$i] * $unit_price;
                $taxtotal                   = ($request->qty[$i] * $unit_price * $get_tax->rate) / 100;
                $total                      = $subtotal + $taxtotal;
                $subtotal_header_other      += $subtotal;
                $taxtotal_header_other      += $taxtotal;
                $grandtotal_header_other    += $total;

                //menyimpan detail per item dari invoicd
                $pp[$i] = new sale_invoice_item([
                    'product_id'                => $request->products[$i],
                    'desc'                      => $request->desc[$i],
                    'qty'                       => $request->qty[$i],
                    'qty_remaining_return'      => $request->qty[$i],
                    'unit_id'                   => $request->units[$i],
                    'unit_price'                => $unit_price,
                    'tax_id'                    => $request->tax[$i],
                    'amountsub'                 => $subtotal,
                    'amounttax'                 => $taxtotal,
                    'amountgrand'               => $total,
                    'amount'                    => $subtotal,
                ]);
                $pi->sale_invoice_item()->save($pp[$i]);

                $avg_price                      = product::find($request->products[$i]);
                $total_avg                      = $request->qty[$i] * $avg_price->avg_price;
                /*$total_avg                      = 0;
                if ($cs->is_avg_price == 1) {
                    $total_avg                  = $request->qty[$i] * $avg_price->avg_price;
                } else if ($cs->is_fifo == 1) {
                    $create_product_fifo_out    = new product_fifo_out([
                        'sale_invoice_item_id'  => $pp[$i]->id, // ID SI SALES INVOICE ITEM
                        'type'                  => 'sales invoice',
                        'number'                => $pi->number,
                        'product_id'            => $pp[$i]->product_id,
                        'warehouse_id'          => $pi->warehouse_id,
                        'qty'                   => $pp[$i]->qty,
                        'unit_price'            => $pp[$i]->unit_price,
                        'total_price'           => $pp[$i]->amount,
                        'date'                  => $pi->transaction_date,
                    ]);
                    $create_product_fifo_out->save(); // SAVE FIFO OUT
                    $get_product_fifo_in        = product_fifo_in::where('product_id', $request->products[$i])->where('qty', '>', 0)
                        ->get()->sortBy(function ($item) {
                            return $item->transaction_date;
                        });
                    //dd($get_product_fifo_in);
                    $ambil_qty_fifo_out         = $request->qty[$i];
                    $qty_pool                   = collect([]);
                    foreach ($get_product_fifo_in as $key_gpfi => $gpfi) {
                        $deducted_qty           = $ambil_qty_fifo_out - $gpfi->qty;
                        //dd($deducted_qty);
                        $next                   = isset($get_product_fifo_in[$key_gpfi + 1]);
                        if ($deducted_qty >= 0) {
                            if ($next) {
                                $qty_pool->push([
                                    'qty' => $gpfi->qty,
                                    'unit_price' => $gpfi->unit_price,
                                    'product_id' => $gpfi->product_id,
                                    'gpfi_id' => $gpfi->id
                                ]);
                                $ambil_qty_fifo_out -= $gpfi->qty;
                                $gpfi->update([
                                    'qty' => 0
                                ]);
                            } else {
                                $qty_pool->push([
                                    'qty' => $ambil_qty_fifo_out,
                                    'unit_price' => $gpfi->unit_price,
                                    'product_id' => $gpfi->product_id,
                                    'gpfi_id' => $gpfi->id
                                ]);
                                $gpfi->update([
                                    'qty' => 0
                                ]);
                                break;
                            }
                        } else {
                            $gpfi->update([
                                'qty' => abs($deducted_qty)
                            ]);
                            $qty_pool->push([
                                'qty' => $ambil_qty_fifo_out,
                                'unit_price' => $gpfi->unit_price,
                                'product_id' => $gpfi->product_id,
                                'gpfi_id' => $gpfi->id
                            ]);
                            break;
                        }
                    }
                    $total_sum_qty_pool         = 0;
                    foreach ($qty_pool as $key_qp => $qp) {
                        $total_sum_qty_pool     += $qp['qty'] * $qp['unit_price'];
                    }
                    $total_avg                  = $total_sum_qty_pool;
                }*/
                $default_product_account        = product::find($request->products[$i]);
                if ($default_product_account->is_track == 1) {
                    // DEFAULT BUY ACCOUNT
                    coa_detail::create([
                        'company_id'                => $user->company_id,
                        'user_id'                   => Auth::id(),
                        'ref_id'                    => $pi->id,
                        'other_transaction_id'      => $transactions->id,
                        'coa_id'                    => $default_product_account->buy_account,
                        'date'                      => $request->get('trans_date'),
                        'type'                      => 'sales invoice',
                        'number'                    => 'Sales Invoice #' . $trans_no,
                        'contact_id'                => $request->get('vendor_name'),
                        'debit'                     => $total_avg,
                        'credit'                    => 0,
                    ]);
                    // DEFAULT SELL ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $subtotal,
                    ]);
                    // DEFAULT INVENTORY ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $total_avg,
                        //'from_product_id'   => 0,
                    ]);
                } else {
                    // DEFAULT SETTING
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $subtotal,
                        //'from_product_id'   => $request->products[$i],
                    ]);
                }
                //menambahkan stok barang ke gudang
                $wh                             = new warehouse_detail();
                $wh->type                       = 'sales invoice';
                $wh->number                     = 'Sales Invoice #' . $trans_no;
                $wh->product_id                 = $request->products[$i];
                $wh->warehouse_id               = $request->warehouse;
                $wh->date                       = $request->trans_date;
                $wh->qty_out                    = $request->qty[$i];
                $wh->save();

                //merubah harga average produk
                $produk                         = product::find($request->products[$i]);
                $qty                            = $request->qty[$i];
                //$price = $request->unit_price[$i];
                //$curr_avg_price = (($produk->qty * $produk->avg_price) + ($qty * $price)) / ($produk->qty + $qty);
                //dd(abs($curr_avg_price));
                //menyimpan jumlah perubahan pada produk
                product::where('id', $request->products[$i])->update([
                    'qty'                       => $produk->qty - $qty,
                    //'avg_price' => abs($curr_avg_price),
                ]);
            };

            coa_detail::create([
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'ref_id'                => $pi->id,
                'other_transaction_id'  => $transactions->id,
                'coa_id'                => $contact_account->account_receivable_id,
                'date'                  => $request->get('trans_date'),
                'type'                  => 'sales invoice',
                'number'                => 'Sales Invoice #' . $trans_no,
                'contact_id'            => $request->get('vendor_name'),
                'debit'                 => $grandtotal_header_other,
                'credit'                => 0,
            ]);

            other_transaction::find($transactions->id)->update([
                'balance_due'       => $grandtotal_header_other,
                'total'             => $grandtotal_header_other,
            ]);

            sale_invoice::find($pi->id)->update([
                'subtotal'          => $subtotal_header_other,
                'taxtotal'          => $taxtotal_header_other,
                'balance_due'       => $grandtotal_header_other,
                'grandtotal'        => $grandtotal_header_other,
            ]);

            $get_sale_invoice       = sale_invoice::find($pi->id);
            if ($get_sale_invoice->taxtotal > 0) {
                $default_tax                = default_account::find(8);
                coa_detail::create([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'ref_id'                => $pi->id,
                    'other_transaction_id'  => $transactions->id,
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'sales invoice',
                    'number'                => 'Sales Invoice #' . $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => 0,
                    'credit'                => $taxtotal_header_other,
                ]);
            }
            event(new SalesInvoiceStoredEvent());

            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $pi->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function storeRequestSukses(Request $request)
    {
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        $cs                     = company_setting::where('company_id', $user->company_id)->first();
        if ($user->company_id == 5) {
            $number             = sale_invoice::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SI';
                }
            } else {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SI';
                }
            }
        } else {
            $number             = sale_invoice::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }
        $rules = array(
            'vendor_name'   => 'required',
            'term'          => 'required',
            'trans_date'    => 'required',
            'due_date'      => 'required',
            'warehouse'     => 'required',
            'products'      => 'required|array|min:1',
            'products.*'    => 'required',
            'qty'           => 'required|array|min:1',
            'qty.*'         => 'required',
            'units'         => 'required|array|min:1',
            'units.*'       => 'required',
            'unit_price'    => 'required|array|min:1',
            'unit_price.*'  => 'required',
            'tax'           => 'required|array|min:1',
            'tax.*'         => 'required',
            'total_price'   => 'required|array|min:1',
            'total_price.*' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $id_contact                         = $request->vendor_name;
            // DEFAULT DARI SETTING
            $contact_account                    = contact::find($id_contact);
            if ($contact_account->is_limit == 1) {
                if ($contact_account->current_limit_balance >= $request->balance) {
                    $contact_account->update([
                        'current_limit_balance'         => $contact_account->current_limit_balance - $request->balance,
                    ]);
                } else {
                    DB::rollBack();
                    return response()->json(['errors' => 'Cannot make a transaction because the balance has exceeded the limit!<br><br>
                    Total Limit Balance = ' . number_format($contact_account->limit_balance, 2, ',', '.') . '<br>
                    Total Current Limit Balance = ' . number_format($contact_account->current_limit_balance, 2, ',', '.')]);
                }
            }

            if ($request->warehouse == null) {
                $is_warehouse                   = 1;
            } else {
                $is_warehouse                   = $request->warehouse;
            }
            if ($request->marketting == null) {
                $marketting                     = null;
                $is_marketting                  = 0;
            } else {
                $is_marketting                  = 1;
                $marketting                     = $request->marketting;
            }

            $transactions                       = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'number_complete'               => 'Sales Invoice #' . $trans_no,
                'type'                          => 'sales invoice',
                'memo'                          => $request->get('memo'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'contact'                       => $request->get('vendor_name'),
                'status'                        => 1,
                'balance_due'                   => $request->get('balance'),
                'total'                         => $request->get('balance'),
            ]);
            $pi = new sale_invoice([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'email'                         => $request->get('email'),
                'address'                       => $request->get('vendor_address'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'term_id'                       => $request->get('term'),
                'vendor_ref_no'                 => $request->get('vendor_no'),
                'warehouse_id'                  => $request->get('warehouse'),
                'is_marketting'                 => $is_marketting,
                'marketting'                    => $marketting,
                'subtotal'                      => $request->get('subtotal'),
                'taxtotal'                      => $request->get('taxtotal'),
                'balance_due'                   => $request->get('balance'),
                'grandtotal'                    => $request->get('balance'),
                'message'                       => $request->get('message'),
                'memo'                          => $request->get('memo'),
                'status'                        => 1,
            ]);
            //$pi->save();
            $transactions->sale_invoice()->save($pi);
            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $pi->id,
            ]);

            coa_detail::create([
                'company_id'                => $user->company_id,
                'user_id'                   => Auth::id(),
                'ref_id'                    => $pi->id,
                'other_transaction_id'      => $transactions->id,
                'coa_id'                    => $contact_account->account_receivable_id,
                'date'                      => $request->get('trans_date'),
                'type'                      => 'sales invoice',
                'number'                    => 'Sales Invoice #' . $trans_no,
                'contact_id'                => $request->get('vendor_name'),
                'debit'                     => $request->get('balance'),
                'credit'                    => 0,
            ]);

            if ($request->taxtotal > 0) {
                $default_tax                = default_account::find(8);
                coa_detail::create([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'ref_id'                => $pi->id,
                    'other_transaction_id'  => $transactions->id,
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'sales invoice',
                    'number'                => 'Sales Invoice #' . $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => 0,
                    'credit'                => $request->get('taxtotal'),
                ]);
            }

            foreach ($request->products as $i => $product) {
                //menyimpan detail per item dari invoicd
                $pp[$i] = new sale_invoice_item([
                    'product_id'                => $request->products[$i],
                    'desc'                      => $request->desc[$i],
                    'qty'                       => $request->qty[$i],
                    'qty_remaining_return'      => $request->qty[$i],
                    'unit_id'                   => $request->units[$i],
                    'unit_price'                => $request->unit_price[$i],
                    'tax_id'                    => $request->tax[$i],
                    'amountsub'                 => $request->total_price_sub[$i],
                    'amounttax'                 => $request->total_price_tax[$i],
                    'amountgrand'               => $request->total_price_grand[$i],
                    'amount'                    => $request->total_price[$i],
                ]);
                $pi->sale_invoice_item()->save($pp[$i]);

                $avg_price                      = product::find($request->products[$i]);
                $total_avg                      = 0;
                if ($cs->is_avg_price == 1) {
                    $total_avg                  = $request->qty[$i] * $avg_price->avg_price;
                } else if ($cs->is_fifo == 1) {
                    $create_product_fifo_out    = new product_fifo_out([
                        'sale_invoice_item_id'  => $pp[$i]->id, // ID SI SALES INVOICE ITEM
                        'type'                  => 'sales invoice',
                        'number'                => $pi->number,
                        'product_id'            => $pp[$i]->product_id,
                        'warehouse_id'          => $pi->warehouse_id,
                        'qty'                   => $pp[$i]->qty,
                        'unit_price'            => $pp[$i]->unit_price,
                        'total_price'           => $pp[$i]->amount,
                        'date'                  => $pi->transaction_date,
                    ]);
                    $create_product_fifo_out->save(); // SAVE FIFO OUT
                    $get_product_fifo_in        = product_fifo_in::where('product_id', $request->products[$i])->where('qty', '>', 0)
                        ->get()->sortBy(function ($item) {
                            return $item->transaction_date;
                        });
                    //dd($get_product_fifo_in);
                    $ambil_qty_fifo_out         = $request->qty[$i];
                    $qty_pool                   = collect([]);
                    foreach ($get_product_fifo_in as $key_gpfi => $gpfi) {
                        $deducted_qty           = $ambil_qty_fifo_out - $gpfi->qty;
                        //dd($deducted_qty);
                        $next                   = isset($get_product_fifo_in[$key_gpfi + 1]);
                        if ($deducted_qty >= 0) {
                            if ($next) {
                                $qty_pool->push([
                                    'qty' => $gpfi->qty,
                                    'unit_price' => $gpfi->unit_price,
                                    'product_id' => $gpfi->product_id,
                                    'gpfi_id' => $gpfi->id
                                ]);
                                $ambil_qty_fifo_out -= $gpfi->qty;
                                $gpfi->update([
                                    'qty' => 0
                                ]);
                            } else {
                                $qty_pool->push([
                                    'qty' => $ambil_qty_fifo_out,
                                    'unit_price' => $gpfi->unit_price,
                                    'product_id' => $gpfi->product_id,
                                    'gpfi_id' => $gpfi->id
                                ]);
                                $gpfi->update([
                                    'qty' => 0
                                ]);
                                break;
                            }
                        } else {
                            $gpfi->update([
                                'qty' => abs($deducted_qty)
                            ]);
                            $qty_pool->push([
                                'qty' => $ambil_qty_fifo_out,
                                'unit_price' => $gpfi->unit_price,
                                'product_id' => $gpfi->product_id,
                                'gpfi_id' => $gpfi->id
                            ]);
                            break;
                        }
                    }
                    $total_sum_qty_pool         = 0;
                    foreach ($qty_pool as $key_qp => $qp) {
                        $total_sum_qty_pool     += $qp['qty'] * $qp['unit_price'];
                    }
                    $total_avg                  = $total_sum_qty_pool;
                }
                $default_product_account        = product::find($request->products[$i]);
                if ($default_product_account->is_track == 1) {
                    // DEFAULT BUY ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->buy_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $total_avg,
                        'credit'                => 0,
                    ]);
                    // DEFAULT SELL ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    // DEFAULT INVENTORY ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $total_avg,
                        //'from_product_id'   => 0,
                    ]);
                } else {
                    // DEFAULT SETTING
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                        //'from_product_id'   => $request->products[$i],
                    ]);
                }
                //menambahkan stok barang ke gudang
                $wh                             = new warehouse_detail();
                $wh->type                       = 'sales invoice';
                $wh->number                     = 'Sales Invoice #' . $trans_no;
                $wh->product_id                 = $request->products[$i];
                $wh->warehouse_id               = $request->warehouse;
                $wh->date                       = $request->trans_date;
                $wh->qty_out                    = $request->qty[$i];
                $wh->save();

                //merubah harga average produk
                $produk                         = product::find($request->products[$i]);
                $qty                            = $request->qty[$i];
                //$price = $request->unit_price[$i];
                //$curr_avg_price = (($produk->qty * $produk->avg_price) + ($qty * $price)) / ($produk->qty + $qty);
                //dd(abs($curr_avg_price));
                //menyimpan jumlah perubahan pada produk
                product::where('id', $request->products[$i])->update([
                    'qty'                       => $produk->qty - $qty,
                    //'avg_price' => abs($curr_avg_price),
                ]);
            };
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $pi->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function storeFromDelivery(Request $request)
    {
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        $cs                     = company_setting::where('company_id', $user->company_id)->first();
        if ($user->company_id == 5) {
            $number             = sale_invoice::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SI';
                }
            } else {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SI';
                }
            }
        } else {
            $number             = sale_invoice::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }
        $rules = array(
            'vendor_name'   => 'required',
            'trans_date'    => 'required',
            'due_date'      => 'required',
            'term'          => 'required',
            'warehouse'     => 'required',
            'products'      => 'required|array|min:1',
            'products.*'    => 'required',
            'qty'           => 'required|array|min:1',
            'qty.*'         => 'required',
            'units'         => 'required|array|min:1',
            'units.*'       => 'required',
            'unit_price'    => 'required|array|min:1',
            'unit_price.*'  => 'required',
            'tax'           => 'required|array|min:1',
            'tax.*'         => 'required',
            'total_price'   => 'required|array|min:1',
            'total_price.*' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $id                                 = $request->hidden_id;
            $id_number                          = $request->hidden_id_number;
            $id_po                              = $request->hidden_id_po;
            $id_no_po                           = $request->hidden_id_no_po;
            $id_contact                         = $request->vendor_name;
            //DEFAULT ACCOUNT BUAT DELIVERY ONLY NOT INCLUDED TAX
            // DEFAULT SETTING UNBILLED REVENUE
            $default_unbilled_revenue           = default_account::find(6);

            $contact_account                    = contact::find($id_contact);
            if ($contact_account->is_limit == 1) {
                if ($contact_account->current_limit_balance >= $request->balance) {
                    $contact_account->update([
                        'current_limit_balance'         => $contact_account->current_limit_balance - $request->balance,
                    ]);
                }
            }
            // DEFAULT SETTING UNBILLED RECEIVABLE
            $default_unbilled_receivable        = default_account::find(7);

            $transactions                       = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'number_complete'               => 'Sales Invoice #' . $trans_no,
                'type'                          => 'sales invoice',
                'memo'                          => $request->get('memo'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'contact'                       => $request->get('vendor_name'),
                'status'                        => 1,
                'balance_due'                   => $request->get('balance'),
                'total'                         => $request->get('balance'),
            ]);

            $pd = new sale_invoice([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'email'                         => $request->get('email'),
                'address'                       => $request->get('vendor_address'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'term_id'                       => $request->get('term'),
                'transaction_no_so'             => $id_no_po,
                'transaction_no_sd'             => $id_number,
                'vendor_ref_no'                 => $request->get('vendor_no'),
                'warehouse_id'                  => $request->get('warehouse'),
                'subtotal'                      => $request->get('subtotal'),
                'taxtotal'                      => $request->get('taxtotal'),
                'balance_due'                   => $request->get('balance'),
                'grandtotal'                    => $request->get('balance'),
                'message'                       => $request->get('message'),
                'memo'                          => $request->get('memo'),
                'status'                        => 1,
                'selected_so_id'                => $id_po,
                'selected_sd_id'                => $id,
            ]);
            $transactions->sale_invoice()->save($pd);
            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $pd->id,
            ]);

            coa_detail::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'ref_id'                        => $pd->id,
                'other_transaction_id'          => $transactions->id,
                'coa_id'                        => $default_unbilled_revenue->account_id,
                'date'                          => $request->get('trans_date'),
                'type'                          => 'sales invoice',
                'number'                        => 'Sales Invoice #' . $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => $request->get('subtotal'),
                'credit'                        => 0,
            ]);

            coa_detail::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'ref_id'                        => $pd->id,
                'other_transaction_id'          => $transactions->id,
                'coa_id'                        => $contact_account->account_receivable_id,
                'date'                          => $request->get('trans_date'),
                'type'                          => 'sales invoice',
                'number'                        => 'Sales Invoice #' . $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => $request->get('balance'),
                'credit'                        => 0,
            ]);

            coa_detail::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'ref_id'                        => $pd->id,
                'other_transaction_id'          => $transactions->id,
                'coa_id'                        => $default_unbilled_receivable->account_id,
                'date'                          => $request->get('trans_date'),
                'type'                          => 'sales invoice',
                'number'                        => 'Sales Invoice #' . $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => 0,
                'credit'                        => $request->get('subtotal'),
            ]);

            if ($request->taxtotal > 0) {
                $default_tax                    = default_account::find(8);
                coa_detail::create([
                    'company_id'                => $user->company_id,
                    'user_id'                   => Auth::id(),
                    'ref_id'                    => $pd->id,
                    'other_transaction_id'      => $transactions->id,
                    'coa_id'                    => $default_tax->account_id,
                    'date'                      => $request->get('trans_date'),
                    'type'                      => 'sales invoice',
                    'number'                    => 'Sales Invoice #' . $trans_no,
                    'contact_id'                => $request->get('vendor_name'),
                    'debit'                     => 0,
                    'credit'                    => $request->get('taxtotal'),
                ]);
            }

            foreach ($request->products as $i => $keys) {
                $pp[$i] = new sale_invoice_item([
                    'product_id'                => $request->products[$i],
                    'desc'                      => $request->desc[$i],
                    'qty'                       => $request->qty[$i],
                    'qty_remaining_return'      => $request->qty[$i],
                    'unit_id'                   => $request->units[$i],
                    'unit_price'                => $request->unit_price[$i],
                    'tax_id'                    => $request->tax[$i],
                    'amountsub'                 => $request->total_price_sub[$i],
                    'amounttax'                 => $request->total_price_tax[$i],
                    'amountgrand'               => $request->total_price_grand[$i],
                    'amount'                    => $request->total_price[$i],
                    //'qty_remaining' => $request->r_qty[$i],
                ]);
                $pd->sale_invoice_item()->save($pp[$i]);

                $avg_price                      = product::find($request->products[$i]);
                $total_avg                      = $request->qty[$i] * $avg_price->avg_price;
                $default_product_account        = product::find($request->products[$i]);
                if ($default_product_account->is_track == 1) {
                    // YANG DI TRACK SELL ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pd->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    /*coa_detail::create([
                        'coa_id'            => $default_product_account->buy_account,
                        'date'              => $request->get('trans_date'),
                        'type'              => 'sales invoice',
                        'number'            => 'Sales Invoice #' . $trans_no,
                        'contact_id'        => $request->get('vendor_name'),
                        'debit'             => 0,
                        'credit'            => $request->total_price[$i],
                    ]);*/
                } else {
                    // YANG GA DI TRACK SELL ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pd->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                }

                //menambahkan stok barang ke gudang
                $wh                             = new warehouse_detail();
                $wh->type                       = 'sales invoice';
                $wh->number                     = 'Sales Invoice #' . $trans_no;
                $wh->product_id                 = $request->products[$i];
                $wh->warehouse_id               = $request->warehouse;
                $wh->date                       = $request->trans_date;
                $wh->qty_out                    = $request->qty[$i];
                $wh->save();

                //merubah harga average produk
                $produk                         = product::find($request->products[$i]);
                $qty                            = $request->qty[$i];
                //menyimpan jumlah perubahan pada produk
                product::where('id', $request->products[$i])->update([
                    'qty'                       => $produk->qty - $qty,
                ]);
            };
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $pd->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function storeFromOrder(Request $request)
    {
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        $cs                     = company_setting::where('company_id', $user->company_id)->first();
        if ($user->company_id == 5) {
            $number             = sale_invoice::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SI';
                }
            } else {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SI';
                }
            }
        } else {
            $number             = sale_invoice::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }
        $rules = array(
            'vendor_name'   => 'required',
            'trans_date'    => 'required',
            'due_date'      => 'required',
            'term'          => 'required',
            'warehouse'     => 'required',
            'products'      => 'required|array|min:1',
            'products.*'    => 'required',
            'qty'           => 'required|array|min:1',
            'qty.*'         => 'required',
            'units'         => 'required|array|min:1',
            'units.*'       => 'required',
            'unit_price'    => 'required|array|min:1',
            'unit_price.*'  => 'required',
            'tax'           => 'required|array|min:1',
            'tax.*'         => 'required',
            'total_price'   => 'required|array|min:1',
            'total_price.*' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            // AMBIL ID DARI SI ORDER PUNYA
            $id                                 = $request->hidden_id;
            // AMBIL NUMBER DARI IS ORDER PUNYA
            $id_number                          = $request->hidden_id_number;
            $id_contact                         = $request->vendor_name;
            // BUAT NGECHECK INI QUANTITY YANG DIINPUT LEBIH DARI YANG DI ORDER ATAU TIDAK
            foreach ($request->products as $i => $keys) {
                if ($request->qty[$i] < 0) {
                    return response()->json(['errors' => 'Quantity cannot be less than 0']);
                } else if ($request->r_qty[$i] < 0) {
                    return response()->json(['errors' => 'Quantity cannot be more than stock']);
                } else if ($request->qty[$i] == 0) {
                    return response()->json(['errors' => 'Quantity cannot be 0']);
                }
            }
            // CREATE COA DETAIL BERDASARKAN DARI CONTACT DEFAULT
            $contact_account                    = contact::find($id_contact);
            if ($contact_account->is_limit == 1) {
                if ($contact_account->current_limit_balance >= $request->balance) {
                    $contact_account->update([
                        'current_limit_balance'         => $contact_account->current_limit_balance - $request->balance,
                    ]);
                } else {
                    DB::rollBack();
                    return response()->json(['errors' => 'Cannot make a transaction because the balance has exceeded the limit!<br><br>
                    Total Limit Balance = ' . number_format($contact_account->limit_balance, 2, ',', '.') . '<br>
                    Total Current Limit Balance = ' . number_format($contact_account->current_limit_balance, 2, ',', '.')]);
                }
            }
            // MENGUBAH STATUS SI SALES ORDER DAN OTHER TRANSACTION DARI OPEN KE CLOSED
            $check_total_po                     = sale_order::find($id);
            $check_total_po->update([
                'balance_due'                   => $check_total_po->balance_due - $request->balance,
            ]);
            if ($check_total_po->balance_due == 0) {
                $updatepdstatus                 = array(
                    'status'                    => 2,
                );
                sale_order::where('number', $id_number)->update($updatepdstatus);
                other_transaction::where('number', $id_number)->where('type', 'sales order')->update($updatepdstatus);
            } else {
                $updatepdstatus                 = array(
                    'status'                    => 4,
                );
                sale_order::where('number', $id_number)->update($updatepdstatus);
                other_transaction::where('number', $id_number)->where('type', 'sales order')->update($updatepdstatus);
            }
            // CREATE OTHER TRANSACTION PUNYA SI INVOICE
            $transactions                       = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'number_complete'               => 'Sales Invoice #' . $trans_no,
                'type'                          => 'sales invoice',
                'memo'                          => $request->get('memo'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'contact'                       => $request->get('vendor_name'),
                'status'                        => 1,
                'balance_due'                   => $request->get('balance'),
                'total'                         => $request->get('balance'),
            ]);
            // CREATE HEADERNYA SEKALIAN MASUKKIN OTHER_TRANSACTION_ID DIDALEMNYA
            $pd = new sale_invoice([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'email'                         => $request->get('email'),
                'address'                       => $request->get('vendor_address'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'term_id'                       => $request->get('term'),
                'transaction_no_so'             => $id_number,
                'vendor_ref_no'                 => $request->get('vendor_no'),
                'warehouse_id'                  => $request->get('warehouse'),
                'subtotal'                      => $request->get('subtotal'),
                'taxtotal'                      => $request->get('taxtotal'),
                'balance_due'                   => $request->get('balance'),
                'grandtotal'                    => $request->get('balance'),
                'message'                       => $request->get('message'),
                'memo'                          => $request->get('memo'),
                'status'                        => 1,
                'selected_so_id'                => $id,
            ]);
            $transactions->sale_invoice()->save($pd);
            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $pd->id,
            ]);

            coa_detail::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'ref_id'                        => $pd->id,
                'other_transaction_id'          => $transactions->id,
                'coa_id'                        => $contact_account->account_receivable_id,
                'date'                          => $request->get('trans_date'),
                'type'                          => 'sales invoice',
                'number'                        => 'Sales Invoice #' . $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => $request->get('balance'),
                'credit'                        => 0,
            ]);

            if ($request->taxtotal > 0) {
                $default_tax                    = default_account::find(8);
                coa_detail::create([
                    'company_id'                => $user->company_id,
                    'user_id'                   => Auth::id(),
                    'ref_id'                    => $pd->id,
                    'other_transaction_id'      => $transactions->id,
                    'coa_id'                    => $default_tax->account_id,
                    'date'                      => $request->get('trans_date'),
                    'type'                      => 'sales invoice',
                    'number'                    => 'Sales Invoice #' . $trans_no,
                    'contact_id'                => $request->get('vendor_name'),
                    'debit'                     => 0,
                    'credit'                    => $request->get('taxtotal'),
                ]);
            }

            foreach ($request->products as $i => $keys) {
                // CREATE DETAILSNYA SEKALIAN MASUKKIN sale_invoice_ID DIDALEMNYA
                $pp[$i]                         = new sale_invoice_item([
                    'sale_order_item_id'        => $request->so_id[$i],
                    'product_id'                => $request->products[$i],
                    'desc'                      => $request->desc[$i],
                    'qty'                       => $request->qty[$i],
                    'unit_id'                   => $request->units[$i],
                    'unit_price'                => $request->unit_price[$i],
                    'tax_id'                    => $request->tax[$i],
                    'amountsub'                 => $request->total_price_sub[$i],
                    'amounttax'                 => $request->total_price_tax[$i],
                    'amountgrand'               => $request->total_price_grand[$i],
                    'amount'                    => $request->total_price[$i],
                    'qty_remaining'             => $request->r_qty[$i],
                    'qty_remaining_return'      => $request->qty[$i],
                ]);
                $pd->sale_invoice_item()->save($pp[$i]);
                $updatepunyapo                  = sale_order_item::find($request->so_id[$i]);
                $updatepunyapo->update([
                    'qty_remaining'             => $updatepunyapo->qty_remaining - $request->qty[$i]
                ]);
                // CREATE COA DETAIL BERDASARKAN PRODUCT SETTING
                $avg_price                      = product::find($request->products[$i]);
                $total_avg                      = 0;
                if ($cs->is_avg_price == 1) {
                    $total_avg                  = $request->qty[$i] * $avg_price->avg_price;
                } else if ($cs->is_fifo == 1) {
                    $create_product_fifo_out    = new product_fifo_out([
                        'sale_invoice_item_id'  => $pp[$i]->id, // ID SI SALES INVOICE ITEM
                        'type'                  => 'sales invoice',
                        'number'                => $pd->number,
                        'product_id'            => $pp[$i]->product_id,
                        'warehouse_id'          => $pd->warehouse_id,
                        'qty'                   => $pp[$i]->qty,
                        'unit_price'            => $pp[$i]->unit_price,
                        'total_price'           => $pp[$i]->amount,
                        'date'                  => $pd->transaction_date,
                    ]);
                    $create_product_fifo_out->save(); // SAVE FIFO OUT
                    $get_product_fifo_in        = product_fifo_in::where('product_id', $request->products[$i])->where('qty', '>', 0)
                        ->get()->sortBy(function ($item) {
                            return $item->transaction_date;
                        });
                    //dd($get_product_fifo_in);
                    $ambil_qty_fifo_out         = $request->qty[$i];
                    $qty_pool                   = collect([]);
                    foreach ($get_product_fifo_in as $key_gpfi => $gpfi) {
                        $deducted_qty           = $ambil_qty_fifo_out - $gpfi->qty;
                        //dd($deducted_qty);
                        $next                   = isset($get_product_fifo_in[$key_gpfi + 1]);
                        if ($deducted_qty >= 0) {
                            if ($next) {
                                $qty_pool->push([
                                    'qty' => $gpfi->qty,
                                    'unit_price' => $gpfi->unit_price,
                                    'product_id' => $gpfi->product_id,
                                    'gpfi_id' => $gpfi->id
                                ]);
                                $ambil_qty_fifo_out -= $gpfi->qty;
                                $gpfi->update([
                                    'qty' => 0
                                ]);
                            } else {
                                $qty_pool->push([
                                    'qty' => $ambil_qty_fifo_out,
                                    'unit_price' => $gpfi->unit_price,
                                    'product_id' => $gpfi->product_id,
                                    'gpfi_id' => $gpfi->id
                                ]);
                                $gpfi->update([
                                    'qty' => 0
                                ]);
                                break;
                            }
                        } else {
                            $gpfi->update([
                                'qty' => abs($deducted_qty)
                            ]);
                            $qty_pool->push([
                                'qty' => $ambil_qty_fifo_out,
                                'unit_price' => $gpfi->unit_price,
                                'product_id' => $gpfi->product_id,
                                'gpfi_id' => $gpfi->id
                            ]);
                            break;
                        }
                    }
                    $total_sum_qty_pool         = 0;
                    foreach ($qty_pool as $key_qp => $qp) {
                        $total_sum_qty_pool     += $qp['qty'] * $qp['unit_price'];
                    }
                    $total_avg                  = $total_sum_qty_pool;
                }
                $default_product_account        = product::find($request->products[$i]);
                if ($default_product_account->is_track == 1) {
                    // CREATE COA DETAIL YANG DARI BUY ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pd->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->buy_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $total_avg,
                        'credit'                => 0,
                    ]);
                    // CREATE COA DETAIL YANG DARI SELL ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pd->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    // CREATE COA DETAIL YANG DARI INVENTORY ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pd->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $total_avg,
                    ]);
                } else {
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pd->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                }

                //menambahkan stok barang ke gudang
                $wh                             = new warehouse_detail();
                $wh->type                       = 'sales invoice';
                $wh->number                     = 'Sales Invoice #' . $trans_no;
                $wh->product_id                 = $request->products[$i];
                $wh->warehouse_id               = $request->warehouse;
                $wh->date                   = $request->trans_date;
                $wh->qty_out                        = $request->qty[$i];
                $wh->save();

                //merubah harga average produk
                $produk                         = product::find($request->products[$i]);
                $qty                            = $request->qty[$i];
                //$price = $request->unit_price[$i];
                //$curr_avg_price = (($produk->qty * $produk->avg_price) + ($qty * $price)) / ($produk->qty + $qty);
                //dd(abs($curr_avg_price));
                //menyimpan jumlah perubahan pada produk
                product::where('id', $request->products[$i])->update([
                    'qty'                       => $produk->qty - $qty,
                    //'avg_price' => abs($curr_avg_price),
                ]);
            };
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $pd->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function storeFromQuote(Request $request)
    {
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        $cs                     = company_setting::where('company_id', $user->company_id)->first();
        if ($user->company_id == 5) {
            $number             = sale_invoice::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SI';
                }
            } else {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SI';
                }
            }
        } else {
            $number             = sale_invoice::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }
        $rules = array(
            'vendor_name'   => 'required',
            'trans_date'    => 'required',
            'due_date'      => 'required',
            'term'          => 'required',
            'warehouse'     => 'required',
            'products'      => 'required|array|min:1',
            'products.*'    => 'required',
            'qty'           => 'required|array|min:1',
            'qty.*'         => 'required',
            'units'         => 'required|array|min:1',
            'units.*'       => 'required',
            'unit_price'    => 'required|array|min:1',
            'unit_price.*'  => 'required',
            'tax'           => 'required|array|min:1',
            'tax.*'         => 'required',
            'total_price'   => 'required|array|min:1',
            'total_price.*' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            // AMBIL ID SI SALES QUOTE
            $id                             = $request->hidden_id;
            // AMBIL NUMBER SI SALES QUOTE
            $id_number                      = $request->hidden_id_number;
            $id_contact                     = $request->vendor_name;
            // CREATE COA DETAIL BASED ON CONTACT SETTING ACCOUNT
            $contact_account                = contact::find($id_contact);
            if ($contact_account->is_limit == 1) {
                if ($contact_account->current_limit_balance >= $request->balance) {
                    $contact_account->update([
                        'current_limit_balance'         => $contact_account->current_limit_balance - $request->balance,
                    ]);
                } else {
                    DB::rollBack();
                    return response()->json(['errors' => 'Cannot make a transaction because the balance has exceeded the limit!<br><br>
                    Total Limit Balance = ' . number_format($contact_account->limit_balance, 2, ',', '.') . '<br>
                    Total Current Limit Balance = ' . number_format($contact_account->current_limit_balance, 2, ',', '.')]);
                }
            }
            $subtotal_header_other          = 0;
            $taxtotal_header_other          = 0;
            $grandtotal_header_other        = 0;

            // UPDATE STATUS ON SALES QUOTE & OTHER TRANSACTION QUOTE'S
            $updatepdstatus                 = array(
                'status'                    => 2,
            );
            sale_quote::where('number', $id_number)->update($updatepdstatus);
            other_transaction::where('number', $id_number)->where('type', 'sales quote')->update($updatepdstatus);
            // CREATE LIST OTHER TRANSACTION PUNYA INVOICE
            $transactions                   = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                    => $trans_no,
                'number_complete'           => 'Sales Invoice #' . $trans_no,
                'type'                      => 'sales invoice',
                'memo'                      => $request->get('memo'),
                'transaction_date'          => $request->get('trans_date'),
                'due_date'                  => $request->get('due_date'),
                'contact'                   => $request->get('vendor_name'),
                'status'                    => 1,
                'balance_due'               => $request->get('balance'),
                'total'                     => $request->get('balance'),
            ]);
            //$transactions->save();
            // CREATE SALES INVOICE HEADER
            $pd                             = new sale_invoice([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                    => $trans_no,
                'contact_id'                => $request->get('vendor_name'),
                'email'                     => $request->get('email'),
                'address'                   => $request->get('vendor_address'),
                'transaction_date'          => $request->get('trans_date'),
                'due_date'                  => $request->get('due_date'),
                'term_id'                   => $request->get('term'),
                'transaction_no_sq'         => $id_number,
                'vendor_ref_no'             => $request->get('vendor_no'),
                'warehouse_id'              => $request->get('warehouse'),
                'subtotal'                  => $request->get('subtotal'),
                'taxtotal'                  => $request->get('taxtotal'),
                'balance_due'               => $request->get('balance'),
                'grandtotal'                => $request->get('balance'),
                'message'                   => $request->get('message'),
                'memo'                      => $request->get('memo'),
                'status'                    => 1,
                'selected_sq_id'            => $id,
            ]);
            $transactions->sale_invoice()->save($pd);
            other_transaction::find($transactions->id)->update([
                'ref_id'                    => $pd->id,
            ]);

            // CREATE SALES INVOICE DETAILS
            foreach ($request->products2 as $i => $keys) {
                $check_discount     = product::find($request->products2[$i]);
                $get_discount_item  = product_discount_item::where('product_id', $request->products2[$i])->get();
                if ($check_discount->is_discount == 1) {
                    if ($get_discount_item->count() == 4) {
                        if ($get_discount_item[3]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[3]->price;
                        } else if ($get_discount_item[2]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[2]->price;
                        } else if ($get_discount_item[1]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[1]->price;
                        } else if ($get_discount_item[0]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[0]->price;
                        } else {
                            $unit_price     = $get_discount_item[0]->price;
                        }
                    } else if ($get_discount_item->count() == 3) {
                        if ($get_discount_item[2]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[2]->price;
                        } else if ($get_discount_item[1]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[1]->price;
                        } else if ($get_discount_item[0]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[0]->price;
                        } else {
                            $unit_price     = $get_discount_item[2]->price;
                        }
                    } else if ($get_discount_item->count() == 2) {
                        if ($get_discount_item[1]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[1]->price;
                        } else if ($get_discount_item[0]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[0]->price;
                        } else {
                            $unit_price     = $get_discount_item[0]->price;
                        }
                    } else if ($get_discount_item->count() == 1) {
                        if ($get_discount_item[0]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[0]->price;
                        } else {
                            $unit_price     = $get_discount_item[0]->price;
                        }
                    }
                } else {
                    $unit_price             = $request->unit_price[$i];
                }
                $get_tax                    = other_tax::find($request->tax[$i]);
                $subtotal                   = $request->qty[$i] * $unit_price;
                $taxtotal                   = ($request->qty[$i] * $unit_price * $get_tax->rate) / 100;
                $total                      = $subtotal + $taxtotal;
                $subtotal_header_other      += $subtotal;
                $taxtotal_header_other      += $taxtotal;
                $grandtotal_header_other    += $total;

                $pp[$i] = new sale_invoice_item([
                    'product_id'            => $request->products2[$i],
                    'desc'                  => $request->desc[$i],
                    'qty'                   => $request->qty[$i],
                    'unit_id'               => $request->units[$i],
                    'unit_price'            => $unit_price,
                    'tax_id'                => $request->tax[$i],
                    'amountsub'             => $subtotal,
                    'amounttax'             => $taxtotal,
                    'amountgrand'           => $total,
                    'amount'                => $subtotal,
                    'qty_remaining'         => $request->r_qty[$i],
                    'qty_remaining_return'  => $request->qty[$i],
                ]);
                $pd->sale_invoice_item()->save($pp[$i]);
                // CREATE COA DETAIL BASED ON PRODUCT SETTING
                $avg_price                      = product::find($request->products2[$i]);
                $total_avg                      = 0;
                if ($cs->is_avg_price == 1) {
                    $total_avg                  = $request->qty[$i] * $avg_price->avg_price;
                } else if ($cs->is_fifo == 1) {
                    $create_product_fifo_out    = new product_fifo_out([
                        'sale_invoice_item_id'  => $pp[$i]->id, // ID SI SALES INVOICE ITEM
                        'type'                  => 'sales invoice',
                        'number'                => $pd->number,
                        'product_id'            => $pp[$i]->product_id,
                        'warehouse_id'          => $pd->warehouse_id,
                        'qty'                   => $pp[$i]->qty,
                        'unit_price'            => $pp[$i]->unit_price,
                        'total_price'           => $pp[$i]->amount,
                        'date'                  => $pd->transaction_date,
                    ]);
                    $create_product_fifo_out->save(); // SAVE FIFO OUT
                    $get_product_fifo_in        = product_fifo_in::where('product_id', $request->products[$i])->where('qty', '>', 0)
                        ->get()->sortBy(function ($item) {
                            return $item->transaction_date;
                        });
                    //dd($get_product_fifo_in);
                    $ambil_qty_fifo_out         = $request->qty[$i];
                    $qty_pool                   = collect([]);
                    foreach ($get_product_fifo_in as $key_gpfi => $gpfi) {
                        $deducted_qty           = $ambil_qty_fifo_out - $gpfi->qty;
                        //dd($deducted_qty);
                        $next                   = isset($get_product_fifo_in[$key_gpfi + 1]);
                        if ($deducted_qty >= 0) {
                            if ($next) {
                                $qty_pool->push([
                                    'qty' => $gpfi->qty,
                                    'unit_price' => $gpfi->unit_price,
                                    'product_id' => $gpfi->product_id,
                                    'gpfi_id' => $gpfi->id
                                ]);
                                $ambil_qty_fifo_out -= $gpfi->qty;
                                $gpfi->update([
                                    'qty' => 0
                                ]);
                            } else {
                                $qty_pool->push([
                                    'qty' => $ambil_qty_fifo_out,
                                    'unit_price' => $gpfi->unit_price,
                                    'product_id' => $gpfi->product_id,
                                    'gpfi_id' => $gpfi->id
                                ]);
                                $gpfi->update([
                                    'qty' => 0
                                ]);
                                break;
                            }
                        } else {
                            $gpfi->update([
                                'qty' => abs($deducted_qty)
                            ]);
                            $qty_pool->push([
                                'qty' => $ambil_qty_fifo_out,
                                'unit_price' => $gpfi->unit_price,
                                'product_id' => $gpfi->product_id,
                                'gpfi_id' => $gpfi->id
                            ]);
                            break;
                        }
                    }
                    $total_sum_qty_pool         = 0;
                    foreach ($qty_pool as $key_qp => $qp) {
                        $total_sum_qty_pool     += $qp['qty'] * $qp['unit_price'];
                    }
                    $total_avg                  = $total_sum_qty_pool;
                }
                $default_product_account    = product::find($request->products2[$i]);
                if ($default_product_account->is_track == 1) {
                    // CREATE COA DETAIL YANG DARI BUY ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pd->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->buy_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $total_avg,
                        'credit'                => 0,
                    ]);
                    // CREATE COA DETAIL YANG DARI SELL ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pd->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $subtotal,
                    ]);
                    // CREATE COA DETAIL YANG DARI INVENTORY ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pd->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $total_avg,
                    ]);
                } else {
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pd->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $subtotal,
                    ]);
                }

                //menambahkan stok barang ke gudang
                $wh                             = new warehouse_detail();
                $wh->type                       = 'sales invoice';
                $wh->number                     = 'Sales Invoice #' . $trans_no;
                $wh->product_id                 = $request->products2[$i];
                $wh->warehouse_id               = $request->warehouse;
                $wh->date                       = $request->trans_date;
                $wh->qty_out                    = $request->qty[$i];
                $wh->save();

                //merubah harga average produk
                $produk                         = product::find($request->products2[$i]);
                $qty                            = $request->qty[$i];
                //$price = $request->unit_price[$i];
                //$curr_avg_price = (($produk->qty * $produk->avg_price) + ($qty * $price)) / ($produk->qty + $qty);
                //dd(abs($curr_avg_price));
                //menyimpan jumlah perubahan pada produk
                product::where('id', $request->products2[$i])->update([
                    'qty'                       => $produk->qty - $qty,
                    //'avg_price' => abs($curr_avg_price),
                ]);
            };

            coa_detail::create([
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'ref_id'                => $pd->id,
                'other_transaction_id'  => $transactions->id,
                'coa_id'                => $contact_account->account_receivable_id,
                'date'                  => $request->get('trans_date'),
                'type'                  => 'sales invoice',
                'number'                => 'Sales Invoice #' . $trans_no,
                'contact_id'            => $request->get('vendor_name'),
                'debit'                 => $grandtotal_header_other,
                'credit'                => 0,
            ]);

            other_transaction::find($transactions->id)->update([
                'balance_due'       => $grandtotal_header_other,
                'total'             => $grandtotal_header_other,
            ]);

            sale_invoice::find($pd->id)->update([
                'subtotal'          => $subtotal_header_other,
                'taxtotal'          => $taxtotal_header_other,
                'balance_due'       => $grandtotal_header_other,
                'grandtotal'        => $grandtotal_header_other,
            ]);

            $get_sale_invoice       = sale_invoice::find($pd->id);
            if ($get_sale_invoice->taxtotal > 0) {
                $default_tax                = default_account::find(8);
                coa_detail::create([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'ref_id'                => $pd->id,
                    'other_transaction_id'  => $transactions->id,
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'sales invoice',
                    'number'                => 'Sales Invoice #' . $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => 0,
                    'credit'                => $taxtotal_header_other,
                ]);
            }

            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $pd->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function storeFromSPK(Request $request) // GAPAKE FIFO KARENA PUNYA FAS
    {
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        $cs                     = company_setting::where('company_id', $user->company_id)->first();
        if ($user->company_id == 5) {
            $number             = sale_invoice::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SI';
                }
            } else {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SI';
                }
            }
        } else {
            $number             = sale_invoice::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }
        DB::beginTransaction();
        try {
            $id_contact                         = $request->vendor_name;
            $spk_id                             = $request->spk_id;
            $spk_number                         = $request->spk_number;
            if ($request->has('jasa_only')) {
                $jasa_only = 1;
            } else {
                $jasa_only = 0;
            };

            $contact_account                    = contact::find($id_contact);
            if ($contact_account->is_limit == 1) {
                if ($contact_account->current_limit_balance >= $request->balance) {
                    $contact_account->update([
                        'current_limit_balance'         => $contact_account->current_limit_balance - $request->balance,
                    ]);
                } else {
                    DB::rollBack();
                    return response()->json(['errors' => 'Cannot make a transaction because the balance has exceeded the limit!<br><br>
                    Total Limit Balance = ' . number_format($contact_account->limit_balance, 2, ',', '.') . '<br>
                    Total Current Limit Balance = ' . number_format($contact_account->current_limit_balance, 2, ',', '.')]);
                }
            }

            if ($jasa_only == 0) {
                $transactions                       = other_transaction::create([
                    'company_id'                    => $user->company_id,
                    'user_id'                       => Auth::id(),
                    'number'                        => $trans_no,
                    'number_complete'               => 'Sales Invoice #' . $trans_no,
                    'type'                          => 'sales invoice',
                    'memo'                          => $request->get('memo'),
                    'transaction_date'              => $request->get('trans_date'),
                    'due_date'                      => $request->get('due_date'),
                    'contact'                       => $request->get('vendor_name'),
                    'status'                        => 1,
                    'balance_due'                   => $request->get('balance'),
                    'total'                         => $request->get('balance'),
                ]);

                $pi = new sale_invoice([
                    'company_id'                    => $user->company_id,
                    'user_id'                       => Auth::id(),
                    'number'                        => $trans_no,
                    'contact_id'                    => $request->get('vendor_name'),
                    'email'                         => $request->get('email'),
                    'address'                       => $request->get('vendor_address'),
                    'transaction_date'              => $request->get('trans_date'),
                    'due_date'                      => $request->get('due_date'),
                    'term_id'                       => $request->get('term'),
                    'transaction_no_spk'            => $spk_number,
                    'vendor_ref_no'                 => $request->get('vendor_no'),
                    'warehouse_id'                  => $request->get('warehouse'),
                    'jasa_only'                     => 0,
                    'costtotal'                     => $request->get('costtotal'),
                    'subtotal'                      => $request->get('subtotal'),
                    'taxtotal'                      => $request->get('taxtotal'),
                    'balance_due'                   => $request->get('balance'),
                    'grandtotal'                    => $request->get('balance'),
                    'message'                       => $request->get('message'),
                    'memo'                          => $request->get('memo'),
                    'status'                        => 1,
                    'selected_spk_id'               => $spk_id,
                ]);
            } else {
                $transactions                       = other_transaction::create([
                    'company_id'                    => $user->company_id,
                    'user_id'                       => Auth::id(),
                    'number'                        => $trans_no,
                    'number_complete'               => 'Sales Invoice #' . $trans_no,
                    'type'                          => 'sales invoice',
                    'memo'                          => $request->get('memo'),
                    'transaction_date'              => $request->get('trans_date'),
                    'due_date'                      => $request->get('due_date'),
                    'contact'                       => $request->get('vendor_name'),
                    'status'                        => 1,
                    'balance_due'                   => $request->get('costtotal'),
                    'total'                         => $request->get('costtotal'),
                ]);

                $pi = new sale_invoice([
                    'company_id'                    => $user->company_id,
                    'user_id'                       => Auth::id(),
                    'number'                        => $trans_no,
                    'contact_id'                    => $request->get('vendor_name'),
                    'email'                         => $request->get('email'),
                    'address'                       => $request->get('vendor_address'),
                    'transaction_date'              => $request->get('trans_date'),
                    'due_date'                      => $request->get('due_date'),
                    'term_id'                       => $request->get('term'),
                    'transaction_no_spk'            => $spk_number,
                    'vendor_ref_no'                 => $request->get('vendor_no'),
                    'warehouse_id'                  => $request->get('warehouse'),
                    'jasa_only'                     => 1,
                    'costtotal'                     => $request->get('costtotal'),
                    'subtotal'                      => $request->get('subtotal'),
                    'taxtotal'                      => $request->get('taxtotal'),
                    'balance_due'                   => $request->get('costtotal'),
                    'grandtotal'                    => $request->get('costtotal'),
                    'message'                       => $request->get('message'),
                    'memo'                          => $request->get('memo'),
                    'status'                        => 1,
                    'selected_spk_id'               => $spk_id,
                ]);
            }
            //$pi->save();
            $transactions->sale_invoice()->save($pi);
            other_transaction::find($transactions->id)->update([
                'ref_id'                            => $pi->id,
            ]);

            if ($jasa_only == 0) {
                coa_detail::create([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'ref_id'                => $pi->id,
                    'other_transaction_id'  => $transactions->id,
                    'coa_id'                => $contact_account->account_receivable_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'sales invoice',
                    'number'                => 'Sales Invoice #' . $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => $request->get('balance'),
                    'credit'                => 0,
                ]);
            } else {
                coa_detail::create([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'ref_id'                => $pi->id,
                    'other_transaction_id'  => $transactions->id,
                    'coa_id'                => $contact_account->account_receivable_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'sales invoice',
                    'number'                => 'Sales Invoice #' . $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => $request->get('costtotal'),
                    'credit'                => 0,
                ]);
                // REVENUE BUAT TEMENNYA AR SI JASA ONLY
                coa_detail::create([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'ref_id'                => $pi->id,
                    'other_transaction_id'  => $transactions->id,
                    'coa_id'                => 65,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'sales invoice',
                    'number'                => 'Sales Invoice #' . $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => 0,
                    'credit'                => $request->get('costtotal'),
                ]);
            }

            if ($request->taxtotal > 0) {
                $default_tax                = default_account::find(8);
                coa_detail::create([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'ref_id'                => $pi->id,
                    'other_transaction_id'  => $transactions->id,
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'sales invoice',
                    'number'                => 'Sales Invoice #' . $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => 0,
                    'credit'                => $request->get('taxtotal'),
                ]);
            }

            /*if ($cost_bundle != null) {
                foreach ($cost_bundle as $i => $p) {
                    if ($cost_bundle[$i] != null) {
                        $item_cost[$i]              = new sale_invoice_cost([
                            'sale_invoice_id'       => $pi->id,
                            'coa_id'                => $request->cost_acc[$i],
                            'amount'                => $request->cost_amount[$i],
                        ]);
                        $item_cost[$i]->save();
                        coa_detail::create([
                            'coa_id'                => $request->cost_acc[$i],
                            'date'                  => $request->get('trans_date'),
                            'type'                  => 'sales invoice',
                            'number'                => 'Sales Invoice #' . $trans_no,
                            'contact_id'            => $request->get('vendor_name'),
                            'debit'                 => 0,
                            'credit'                => $request->cost_amount[$i],
                        ]);
                    }
                }
            }*/
            if ($jasa_only == 0) {
                foreach ($request->products as $i => $product) {
                    if ($request->qty[$i] != null) {
                        //menyimpan detail per item dari invoicd
                        $kurangin                       = $request->qty_remaining[$i] - $request->qty[$i];
                        $pp[$i] = new sale_invoice_item([
                            'product_id'                => $request->products[$i],
                            'desc'                      => $request->desc[$i],
                            'qty'                       => $request->qty[$i],
                            'unit_id'                   => $request->units[$i],
                            'unit_price'                => $request->unit_price[$i],
                            'tax_id'                    => $request->tax[$i],
                            /*'amountsub'                 => $request->total_price_sub[$i],
                        'amounttax'                 => $request->total_price_tax[$i],
                        'amountgrand'               => $request->total_price_grand[$i],*/
                            'amount'                    => $request->total_price[$i],
                            'qty_remaining'             => $kurangin,
                            'qty_remaining_return'      => $request->qty[$i],
                            // PUNYA COST
                            'cost_unit_price'           => $request->cost_unit_price[$i],
                            'cost_amount'               => $request->cost_total_price[$i],
                        ]);
                        $pi->sale_invoice_item()->save($pp[$i]);
                        if ($request->qty[$i] == $request->qty_remaining[$i]) {
                            spk_item::where('product_id', $request->products[$i])
                                ->update([
                                    'qty_remaining_sent' => $request->qty_remaining[$i] - $request->qty[$i]
                                ]);
                        } else if ($request->qty[$i] < $request->qty_remaining[$i] && $request->qty[$i] != 0) {
                            spk_item::where('product_id', $request->products[$i])
                                ->update([
                                    'qty_remaining_sent' => $request->qty_remaining[$i] - $request->qty[$i]
                                ]);
                        } else if ($request->qty[$i] > $request->qty_remaining[$i]) {
                            DB::rollback();
                            return response()->json(['errors' => 'Quantity cannot be more than requirement!']);
                        } else if ($request->qty[$i] == 0) {
                            DB::rollback();
                            return response()->json(['errors' => 'Quantity must be more than zero!']);
                        }
                        $avg_price                      = product::find($request->products[$i]);
                        $total_avg                      = $request->qty[$i] * $avg_price->avg_price;
                        $default_product_account        = product::find($request->products[$i]);
                        if ($default_product_account->is_track == 1) {
                            // DEFAULT BUY ACCOUNT
                            coa_detail::create([
                                'company_id'            => $user->company_id,
                                'user_id'               => Auth::id(),
                                'ref_id'                => $pi->id,
                                'other_transaction_id'  => $transactions->id,
                                'coa_id'                => $default_product_account->buy_account,
                                'date'                  => $request->get('trans_date'),
                                'type'                  => 'sales invoice',
                                'number'                => 'Sales Invoice #' . $trans_no,
                                'contact_id'            => $request->get('vendor_name'),
                                'debit'                 => $total_avg,
                                'credit'                => 0,
                            ]);
                            // DEFAULT SELL ACCOUNT
                            coa_detail::create([
                                'company_id'            => $user->company_id,
                                'user_id'               => Auth::id(),
                                'ref_id'                => $pi->id,
                                'other_transaction_id'  => $transactions->id,
                                'coa_id'                => $default_product_account->sell_account,
                                'date'                  => $request->get('trans_date'),
                                'type'                  => 'sales invoice',
                                'number'                => 'Sales Invoice #' . $trans_no,
                                'contact_id'            => $request->get('vendor_name'),
                                'debit'                 => 0,
                                'credit'                => $request->total_price[$i],
                            ]);
                            // DEFAULT INVENTORY ACCOUNT
                            coa_detail::create([
                                'company_id'            => $user->company_id,
                                'user_id'               => Auth::id(),
                                'ref_id'                => $pi->id,
                                'other_transaction_id'  => $transactions->id,
                                'coa_id'                => $default_product_account->default_inventory_account,
                                'date'                  => $request->get('trans_date'),
                                'type'                  => 'sales invoice',
                                'number'                => 'Sales Invoice #' . $trans_no,
                                'contact_id'            => $request->get('vendor_name'),
                                'debit'                 => 0,
                                'credit'                => $total_avg,
                                //'from_product_id'   => 0,
                            ]);
                            // PUNYA COST
                            coa_detail::create([
                                'company_id'            => $user->company_id,
                                'user_id'               => Auth::id(),
                                'ref_id'                => $pi->id,
                                'other_transaction_id'  => $transactions->id,
                                'coa_id'                => 69,
                                'date'                  => $request->get('trans_date'),
                                'type'                  => 'sales invoice',
                                'number'                => 'Sales Invoice #' . $trans_no,
                                'contact_id'            => $request->get('vendor_name'),
                                'debit'                 => 0,
                                'credit'                => $request->cost_total_price[$i],
                                //'from_product_id'   => $request->products[$i],
                            ]);
                        } else {
                            // DEFAULT SETTING
                            coa_detail::create([
                                'company_id'            => $user->company_id,
                                'user_id'               => Auth::id(),
                                'ref_id'                => $pi->id,
                                'other_transaction_id'  => $transactions->id,
                                'coa_id'                => $default_product_account->sell_account,
                                'date'                  => $request->get('trans_date'),
                                'type'                  => 'sales invoice',
                                'number'                => 'Sales Invoice #' . $trans_no,
                                'contact_id'            => $request->get('vendor_name'),
                                'debit'                 => 0,
                                'credit'                => $request->total_price[$i],
                                //'from_product_id'   => $request->products[$i],
                            ]);
                            // PUNYA COST
                            coa_detail::create([
                                'company_id'            => $user->company_id,
                                'user_id'               => Auth::id(),
                                'ref_id'                => $pi->id,
                                'other_transaction_id'  => $transactions->id,
                                'coa_id'                => 69,
                                'date'                  => $request->get('trans_date'),
                                'type'                  => 'sales invoice',
                                'number'                => 'Sales Invoice #' . $trans_no,
                                'contact_id'            => $request->get('vendor_name'),
                                'debit'                 => 0,
                                'credit'                => $request->cost_total_price[$i],
                                //'from_product_id'   => $request->products[$i],
                            ]);
                        }
                        //menambahkan stok barang ke gudang
                        $wh                             = new warehouse_detail();
                        $wh->type                       = 'sales invoice';
                        $wh->number                     = 'Sales Invoice #' . $trans_no;
                        $wh->product_id                 = $request->products[$i];
                        $wh->warehouse_id               = $request->warehouse;
                        $wh->date                   = $request->trans_date;
                        $wh->qty_out                    = $request->qty[$i];
                        $wh->save();

                        //merubah harga average produk
                        $produk                         = product::find($request->products[$i]);
                        $qty                            = $request->qty[$i];
                        //$price = $request->unit_price[$i];
                        //$curr_avg_price = (($produk->qty * $produk->avg_price) + ($qty * $price)) / ($produk->qty + $qty);
                        //dd(abs($curr_avg_price));
                        //menyimpan jumlah perubahan pada produk
                        product::where('id', $request->products[$i])->update([
                            'qty'                       => $produk->qty - $qty,
                            //'avg_price' => abs($curr_avg_price),
                        ]);
                    }
                };
            } else {
                foreach ($request->products as $i => $product) {
                    if ($request->qty[$i] != null) {
                        //menyimpan detail per item dari invoicd
                        $kurangin                       = $request->qty_remaining[$i] - $request->qty[$i];
                        $pp[$i] = new sale_invoice_item([
                            'product_id'                => $request->products[$i],
                            'desc'                      => $request->desc[$i],
                            'qty'                       => $request->qty[$i],
                            'unit_id'                   => $request->units[$i],
                            'unit_price'                => $request->unit_price[$i],
                            'tax_id'                    => $request->tax[$i],
                            /*'amountsub'                 => $request->total_price_sub[$i],
                        'amounttax'                 => $request->total_price_tax[$i],
                        'amountgrand'               => $request->total_price_grand[$i],*/
                            'amount'                    => $request->total_price[$i],
                            'qty_remaining'             => $kurangin,
                            'qty_remaining_return'      => $request->qty[$i],
                            // PUNYA COST
                            'cost_unit_price'           => $request->cost_unit_price[$i],
                            'cost_amount'               => $request->cost_total_price[$i],
                        ]);
                        $pi->sale_invoice_item()->save($pp[$i]);
                        if ($request->qty[$i] == $request->qty_remaining[$i]) {
                            spk_item::where('product_id', $request->products[$i])
                                ->update([
                                    'qty_remaining_sent' => $request->qty_remaining[$i] - $request->qty[$i]
                                ]);
                        } else if ($request->qty[$i] < $request->qty_remaining[$i] && $request->qty[$i] != 0) {
                            spk_item::where('product_id', $request->products[$i])
                                ->update([
                                    'qty_remaining_sent' => $request->qty_remaining[$i] - $request->qty[$i]
                                ]);
                        } else if ($request->qty[$i] > $request->qty_remaining[$i]) {
                            DB::rollback();
                            return response()->json(['errors' => 'Quantity cannot be more than requirement!']);
                        } else if ($request->qty[$i] == 0) {
                            DB::rollback();
                            return response()->json(['errors' => 'Quantity must be more than zero!']);
                        }

                        //menambahkan stok barang ke gudang
                        $wh                             = new warehouse_detail();
                        $wh->type                       = 'sales invoice';
                        $wh->number                     = 'Sales Invoice #' . $trans_no;
                        $wh->product_id                 = $request->products[$i];
                        $wh->warehouse_id               = $request->warehouse;
                        $wh->date                   = $request->trans_date;
                        $wh->qty_out                    = $request->qty[$i];
                        $wh->save();

                        //merubah harga average produk
                        $produk                         = product::find($request->products[$i]);
                        $qty                            = $request->qty[$i];
                        //$price = $request->unit_price[$i];
                        //$curr_avg_price = (($produk->qty * $produk->avg_price) + ($qty * $price)) / ($produk->qty + $qty);
                        //dd(abs($curr_avg_price));
                        //menyimpan jumlah perubahan pada produk
                        product::where('id', $request->products[$i])->update([
                            'qty'                       => $produk->qty - $qty,
                            //'avg_price' => abs($curr_avg_price),
                        ]);
                    }
                };
            }
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $pi->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function storeFromOrderRequestSukses(Request $request)
    {
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        $cs                     = company_setting::where('company_id', $user->company_id)->first();
        if ($user->company_id == 5) {
            $number             = sale_invoice::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SI';
                }
            } else {
                $check_number   = sale_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SI';
                }
            }
        } else {
            $number             = sale_invoice::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }
        DB::beginTransaction();
        try {
            // AMBIL ID DARI SI ORDER PUNYA
            $id                                 = $request->hidden_id;
            // AMBIL NUMBER DARI IS ORDER PUNYA
            $id_number                          = $request->hidden_id_number;
            $id_contact                         = $request->vendor_name;
            // BUAT NGECHECK INI QUANTITY YANG DIINPUT LEBIH DARI YANG DI ORDER ATAU TIDAK
            foreach ($request->products as $i => $keys) {
                if ($request->qty[$i] < 0) {
                    return response()->json(['errors' => 'Quantity cannot be less than zero']);
                } else if ($request->r_qty[$i] < 0) {
                    return response()->json(['errors' => 'Quantity cannot be more than stock']);
                } else if ($request->qty[$i] == 0) {
                    return response()->json(['errors' => 'Quantity must be more than zero']);
                }
            }
            // CREATE COA DETAIL BERDASARKAN DARI CONTACT DEFAULT
            $contact_account                    = contact::find($id_contact);
            if ($contact_account->is_limit == 1) {
                if ($contact_account->current_limit_balance >= $request->balance) {
                    $contact_account->update([
                        'current_limit_balance'         => $contact_account->current_limit_balance - $request->balance,
                    ]);
                } else {
                    DB::rollBack();
                    return response()->json(['errors' => 'Cannot make a transaction because the balance has exceeded the limit!<br><br>
                    Total Limit Balance = ' . number_format($contact_account->limit_balance, 2, ',', '.') . '<br>
                    Total Current Limit Balance = ' . number_format($contact_account->current_limit_balance, 2, ',', '.')]);
                }
            }
            // MENGUBAH STATUS SI SALES ORDER DAN OTHER TRANSACTION DARI OPEN KE CLOSED
            $check_total_po                     = sale_order::find($id);
            $check_total_po->update([
                'balance_due'                   => $check_total_po->balance_due - $request->balance,
            ]);
            if ($check_total_po->balance_due == 0) {
                $updatepdstatus                 = array(
                    'status'                    => 2,
                );
                sale_order::where('number', $id_number)->update($updatepdstatus);
                other_transaction::where('number', $id_number)->where('type', 'sales order')->update($updatepdstatus);
            } else {
                $updatepdstatus                 = array(
                    'status'                    => 4,
                );
                sale_order::where('number', $id_number)->update($updatepdstatus);
                other_transaction::where('number', $id_number)->where('type', 'sales order')->update($updatepdstatus);
            }
            // CREATE OTHER TRANSACTION PUNYA SI INVOICE
            $transactions                       = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'number_complete'               => 'Sales Invoice #' . $trans_no,
                'type'                          => 'sales invoice',
                'memo'                          => $request->get('memo'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'contact'                       => $request->get('vendor_name'),
                'status'                        => 1,
                'balance_due'                   => $request->get('balance'),
                'total'                         => $request->get('balance'),
            ]);

            if ($request->warehouse == null) {
                $is_warehouse                   = 1;
            } else {
                $is_warehouse                   = $request->warehouse;
            }
            if ($request->hidden_marketting == null) {
                $marketting                     = null;
                $is_marketting                  = 0;
            } else {
                $is_marketting                  = 1;
                $marketting                     = $request->hidden_marketting;
            }

            // CREATE HEADERNYA SEKALIAN MASUKKIN OTHER_TRANSACTION_ID DIDALEMNYA
            $pd = new sale_invoice([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'email'                         => $request->get('email'),
                'address'                       => $request->get('vendor_address'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'term_id'                       => $request->get('term'),
                'transaction_no_so'             => $id_number,
                'vendor_ref_no'                 => $request->get('vendor_no'),
                'warehouse_id'                  => $is_warehouse,
                'is_marketting'                 => $is_marketting,
                'marketting'                    => $marketting,
                'subtotal'                      => $request->get('subtotal'),
                'taxtotal'                      => $request->get('taxtotal'),
                'balance_due'                   => $request->get('balance'),
                'grandtotal'                    => $request->get('balance'),
                'message'                       => $request->get('message'),
                'memo'                          => $request->get('memo'),
                'status'                        => 1,
                'selected_so_id'                => $id,
            ]);
            $transactions->sale_invoice()->save($pd);
            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $pd->id,
            ]);

            coa_detail::create([
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'ref_id'                => $pd->id,
                'other_transaction_id'  => $transactions->id,
                'coa_id'                => $contact_account->account_receivable_id,
                'date'                  => $request->get('trans_date'),
                'type'                  => 'sales invoice',
                'number'                => 'Sales Invoice #' . $trans_no,
                'contact_id'            => $request->get('vendor_name'),
                'debit'                 => $request->get('balance'),
                'credit'                => 0,
            ]);

            if ($request->taxtotal > 0) {
                $default_tax                    = default_account::find(8);
                coa_detail::create([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'ref_id'                => $pd->id,
                    'other_transaction_id'  => $transactions->id,
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'sales invoice',
                    'number'                => 'Sales Invoice #' . $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => 0,
                    'credit'                => $request->get('taxtotal'),
                ]);
            }

            foreach ($request->products as $i => $keys) {
                // CREATE DETAILSNYA SEKALIAN MASUKKIN sale_invoice_ID DIDALEMNYA
                $pp[$i]                         = new sale_invoice_item([
                    'sale_order_item_id'        => $request->so_id[$i],
                    'product_id'                => $request->products[$i],
                    'desc'                      => $request->desc[$i],
                    'qty'                       => $request->qty[$i],
                    'unit_id'                   => $request->units[$i],
                    'unit_price'                => $request->unit_price[$i],
                    'tax_id'                    => $request->tax[$i],
                    'amountsub'                 => $request->total_price_sub[$i],
                    'amounttax'                 => $request->total_price_tax[$i],
                    'amountgrand'               => $request->total_price_grand[$i],
                    'amount'                    => $request->total_price[$i],
                    'qty_remaining'             => $request->r_qty[$i],
                    'qty_remaining_return'      => $request->qty[$i],
                ]);
                $pd->sale_invoice_item()->save($pp[$i]);
                $updatepunyapo                  = sale_order_item::find($request->so_id[$i]);
                $updatepunyapo->update([
                    'qty_remaining'             => $updatepunyapo->qty_remaining - $request->qty[$i]
                ]);
                // CREATE COA DETAIL BERDASARKAN PRODUCT SETTING
                $avg_price                      = product::find($request->products[$i]);
                $total_avg                      = 0;
                if ($cs->is_avg_price == 1) {
                    $total_avg                  = $request->qty[$i] * $avg_price->avg_price;
                } else if ($cs->is_fifo == 1) {
                    $create_product_fifo_out    = new product_fifo_out([
                        'sale_invoice_item_id'  => $pp[$i]->id, // ID SI SALES INVOICE ITEM
                        'type'                  => 'sales invoice',
                        'number'                => $pd->number,
                        'product_id'            => $pp[$i]->product_id,
                        'warehouse_id'          => $pd->warehouse_id,
                        'qty'                   => $pp[$i]->qty,
                        'unit_price'            => $pp[$i]->unit_price,
                        'total_price'           => $pp[$i]->amount,
                        'date'                  => $pd->transaction_date,
                    ]);
                    $create_product_fifo_out->save(); // SAVE FIFO OUT
                    $get_product_fifo_in        = product_fifo_in::where('product_id', $request->products[$i])->where('qty', '>', 0)
                        ->get()->sortBy(function ($item) {
                            return $item->transaction_date;
                        });
                    //dd($get_product_fifo_in);
                    $ambil_qty_fifo_out         = $request->qty[$i];
                    $qty_pool                   = collect([]);
                    foreach ($get_product_fifo_in as $key_gpfi => $gpfi) {
                        $deducted_qty           = $ambil_qty_fifo_out - $gpfi->qty;
                        //dd($deducted_qty);
                        $next                   = isset($get_product_fifo_in[$key_gpfi + 1]);
                        if ($deducted_qty >= 0) {
                            if ($next) {
                                $qty_pool->push([
                                    'qty' => $gpfi->qty,
                                    'unit_price' => $gpfi->unit_price,
                                    'product_id' => $gpfi->product_id,
                                    'gpfi_id' => $gpfi->id
                                ]);
                                $ambil_qty_fifo_out -= $gpfi->qty;
                                $gpfi->update([
                                    'qty' => 0
                                ]);
                            } else {
                                $qty_pool->push([
                                    'qty' => $ambil_qty_fifo_out,
                                    'unit_price' => $gpfi->unit_price,
                                    'product_id' => $gpfi->product_id,
                                    'gpfi_id' => $gpfi->id
                                ]);
                                $gpfi->update([
                                    'qty' => 0
                                ]);
                                break;
                            }
                        } else {
                            $gpfi->update([
                                'qty' => abs($deducted_qty)
                            ]);
                            $qty_pool->push([
                                'qty' => $ambil_qty_fifo_out,
                                'unit_price' => $gpfi->unit_price,
                                'product_id' => $gpfi->product_id,
                                'gpfi_id' => $gpfi->id
                            ]);
                            break;
                        }
                    }
                    $total_sum_qty_pool         = 0;
                    foreach ($qty_pool as $key_qp => $qp) {
                        $total_sum_qty_pool     += $qp['qty'] * $qp['unit_price'];
                    }
                    $total_avg                  = $total_sum_qty_pool;
                }
                $default_product_account        = product::find($request->products[$i]);
                if ($default_product_account->is_track == 1) {
                    // CREATE COA DETAIL YANG DARI BUY ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pd->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->buy_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $total_avg,
                        'credit'                => 0,
                    ]);
                    // CREATE COA DETAIL YANG DARI SELL ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pd->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    // CREATE COA DETAIL YANG DARI INVENTORY ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pd->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $total_avg,
                    ]);
                } else {
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pd->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                }

                //menambahkan stok barang ke gudang
                $wh                             = new warehouse_detail();
                $wh->type                       = 'sales invoice';
                $wh->number                     = 'Sales Invoice #' . $trans_no;
                $wh->product_id                 = $request->products[$i];
                $wh->warehouse_id               = $request->warehouse;
                $wh->date                       = $request->trans_date;
                $wh->qty_out                    = $request->qty[$i];
                $wh->save();

                //merubah harga average produk
                $produk                         = product::find($request->products[$i]);
                $qty                            = $request->qty[$i];
                product::where('id', $request->products[$i])->update([
                    'qty'                       => $produk->qty - $qty,
                ]);
            };
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $pd->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $pi                         = sale_invoice::with(['contact', 'term', 'warehouse', 'product'])->find($id);
        $terms                      = other_term::all();
        $products                   = sale_invoice_item::where('sale_invoice_id', $id)->get();
        $bundle_cost                = sale_invoice_cost::where('sale_invoice_id', $id)->get();
        $units                      = other_unit::all();
        $today                      = Carbon::today();
        $pi_history                 = sale_payment_item::where('sale_invoice_id', $id)->get();
        $check_pi_history           = sale_payment_item::where('sale_invoice_id', $id)->first();
        $pd_history                 = sale_invoice::where('selected_sd_id', $pi->selected_sd_id)->get();
        $pr_history                 = sale_return::where('selected_si_id', $id)->get();
        $check_pr_history           = sale_return::where('selected_si_id', $id)->first();
        $checknumberpd              = sale_invoice::whereId($id)->first();
        $numbercoadetail            = 'Sales Invoice #' . $checknumberpd->number;
        $numberothertransaction     = $checknumberpd->number;
        $get_all_detail             = coa_detail::where('number', $numbercoadetail)->where('type', 'sales invoice')->with('coa')->get();
        $total_debit                = $get_all_detail->sum('debit');
        $total_credit               = $get_all_detail->sum('credit');
        if ($pi->selected_spk_id != 0) {
            return view(
                'admin.request.sukses.sales.invoices.show',
                compact([
                    'pi',
                    'terms',
                    'products',
                    'units',
                    'today',
                    'pi_history',
                    'check_pi_history',
                    'pd_history',
                    'pr_history',
                    'check_pr_history',
                    'get_all_detail',
                    'total_debit',
                    'total_credit',
                    'bundle_cost'

                ])
            );
        } else if ($pi->marketting != 0) {
            return view(
                'admin.request.sukses.sales.invoices.showRequestSukses',
                compact([
                    'pi',
                    'terms',
                    'products',
                    'units',
                    'today',
                    'pi_history',
                    'check_pi_history',
                    'pd_history',
                    'pr_history',
                    'check_pr_history',
                    'get_all_detail',
                    'total_debit',
                    'total_credit',
                    'bundle_cost'
                ])
            );
        } else {
            return view(
                'admin.sales.invoices.show',
                compact([
                    'pi',
                    'terms',
                    'products',
                    'units',
                    'today',
                    'pi_history',
                    'check_pi_history',
                    'pd_history',
                    'pr_history',
                    'check_pr_history',
                    'get_all_detail',
                    'total_debit',
                    'total_credit',
                    'bundle_cost'
                ])
            );
        }
    }

    public function edit($id)
    {
        $pi             = sale_invoice::find($id);
        if ($pi->status != 1) {
            return redirect('/sales_invoice');
        }
        $pi_item        = sale_invoice_item::where('sale_invoice_id', $id)->get();
        $vendors        = contact::where('type_customer', true)->get();
        $warehouses     = warehouse::all();
        $terms          = other_term::all();
        $products       = product::all();
        $units          = other_unit::all();
        $today          = Carbon::today();
        $taxes          = other_tax::all();

        if ($pi->selected_sq_id) {
            return view('admin.sales.invoices.editFromQuote', compact([
                'pi',
                'pi_item',
                'vendors',
                'warehouses',
                'terms',
                'products',
                'units',
                'taxes',
                'today',
            ]));
        } else if ($pi->selected_sd_id) {
            return view('admin.sales.invoices.editFromDelivery', compact([
                'pi',
                'pi_item',
                'vendors',
                'warehouses',
                'terms',
                'products',
                'units',
                'taxes',
                'today',
            ]));
        } else if ($pi->selected_so_id && $pi->is_marketting == 0) {
            return view('admin.sales.invoices.editFromOrder', compact([
                'pi',
                'pi_item',
                'vendors',
                'warehouses',
                'terms',
                'products',
                'units',
                'taxes',
                'today',
            ]));
        } else if ($pi->selected_so_id && $pi->is_marketting == 1) {
            return view('admin.request.sukses.sales.invoices.editFromOrder', compact([
                'pi',
                'pi_item',
                'vendors',
                'warehouses',
                'terms',
                'products',
                'units',
                'taxes',
                'today',
            ]));
        } else {
            return view('admin.sales.invoices.edit', compact([
                'pi',
                'pi_item',
                'vendors',
                'warehouses',
                'terms',
                'products',
                'units',
                'taxes',
                'today',
            ]));
        }
    }

    public function update(Request $request)
    {
        $user               = User::find(Auth::id());
        $cs                 = company_setting::where('company_id', $user->company_id)->first();
        $rules = array(
            'vendor_name'   => 'required',
            'term'          => 'required',
            'trans_date'    => 'required',
            'due_date'      => 'required',
            'warehouse'     => 'required',
            'products'      => 'required|array|min:1',
            'products.*'    => 'required',
            'qty'           => 'required|array|min:1',
            'qty.*'         => 'required',
            'units'         => 'required|array|min:1',
            'units.*'       => 'required',
            'unit_price'    => 'required|array|min:1',
            'unit_price.*'  => 'required',
            'tax'           => 'required|array|min:1',
            'tax.*'         => 'required',
            'total_price'   => 'required|array|min:1',
            'total_price.*' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $id                                 = $request->hidden_id;
            $pi                                 = sale_invoice::find($id);
            $pp                                 = sale_invoice_item::where('sale_invoice_id', $id)->get();
            $contact_id                         = contact::find($pi->contact_id);
            $id_contact                         = $request->vendor_name2;
            $contact_account                    = contact::find($id_contact);
            $default_tax                        = default_account::find(8);
            $get_ot                             = other_transaction::where('type', 'sales invoice')->where('number', $pi->number)->first();
            $subtotal_header_other              = 0;
            $taxtotal_header_other              = 0;
            $grandtotal_header_other            = 0;
            if ($contact_id->is_limit == 1) {
                $contact_id->update([
                    'current_limit_balance'         => $contact_id->current_limit_balance + $pi->balance_due,
                ]);
            }
            // HAPUS BALANCE PER ITEM INVOICE
            $pi_details                         = sale_invoice_item::where('sale_invoice_id', $id)->get();
            foreach ($pi_details as $a) {
                if ($cs->is_fifo == 1) {
                    product_fifo_out::where('sale_invoice_item_id', $a->id)->delete();
                }
                $default_product_account        = product::find($a->product_id);
                if ($default_product_account->is_track == 1) {
                    // DEFAULT BUY ACCOUNT
                    $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                        ->where('number', 'Sales Invoice #' . $pi->number)
                        ->where('credit', 0)
                        ->where('coa_id', $default_product_account->buy_account)
                        ->first();
                    $ambil_avg_price_dari_coadetial->delete();
                    // DEFAULT INVENTORY ACCOUNT
                    $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                        ->where('number', 'Sales Invoice #' . $pi->number)
                        ->where('debit', 0)
                        ->where('coa_id', $default_product_account->default_inventory_account)
                        ->first();
                    $ambil_avg_price_dari_coadetial->delete();
                    // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                    warehouse_detail::where('type', 'sales invoice')
                        ->where('number', 'Sales Invoice #' . $pi->number)
                        ->where('product_id', $a->product_id)
                        ->where('warehouse_id', $pi->warehouse_id)
                        ->delete();
                    // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                    $produk                     = product::find($a->product_id);
                    $qty                        = $a->qty;
                    //menyimpan jumlah perubahan pada produk
                    product::where('id', $a->product_id)->update([
                        'qty'                   => $produk->qty + $qty,
                    ]);
                } else {
                    // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                    warehouse_detail::where('type', 'sales invoice')
                        ->where('number', 'Sales Invoice #' . $pi->number)
                        ->where('product_id', $a->product_id)
                        ->where('warehouse_id', $pi->warehouse_id)
                        ->delete();
                    // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                    $produk                     = product::find($a->product_id);
                    $qty                        = $a->qty;
                    //menyimpan jumlah perubahan pada produk
                    product::where('id', $a->product_id)->update([
                        'qty'                   => $produk->qty + $qty,
                    ]);
                }
            }

            // FINALLY DELETE THE COA DETAIL WITH DEBIT = 0
            coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('credit', 0)->delete();
            sale_invoice_item::where('sale_invoice_id', $id)->delete();
            // BARU BIKIN BARU
            $contact_account                    = contact::find($id_contact);
            if ($contact_account->is_limit == 1) {
                if ($contact_account->current_limit_balance >= $request->balance) {
                    $contact_account->update([
                        'current_limit_balance'         => $contact_account->current_limit_balance - $request->balance,
                    ]);
                } else {
                    DB::rollBack();
                    return response()->json(['errors' => 'Cannot make a transaction because the balance has exceeded the limit!<br><br>
                    Total Limit Balance = ' . number_format($contact_account->limit_balance, 2, ',', '.') . '<br>
                    Total Current Limit Balance = ' . number_format($contact_account->current_limit_balance, 2, ',', '.')]);
                }
            }

            $get_ot->update([
                'memo'                          => $request->get('memo'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'contact'                       => $request->get('vendor_name2'),
                'balance_due'                   => $request->get('balance'),
                'total'                         => $request->get('balance'),
            ]);

            $pi->update([
                'contact_id'                    => $request->get('vendor_name2'),
                'email'                         => $request->get('email'),
                'address'                       => $request->get('vendor_address'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'term_id'                       => $request->get('term'),
                'vendor_ref_no'                 => $request->get('vendor_no'),
                'warehouse_id'                  => $request->get('warehouse'),
                'subtotal'                      => $request->get('subtotal'),
                'taxtotal'                      => $request->get('taxtotal'),
                'balance_due'                   => $request->get('balance'),
                'grandtotal'                    => $request->get('balance'),
                'message'                       => $request->get('message'),
                'memo'                          => $request->get('memo'),
            ]);

            foreach ($request->products2 as $i => $product) {
                $check_discount     = product::find($request->products2[$i]);
                $get_discount_item  = product_discount_item::where('product_id', $request->products2[$i])->get();
                if ($check_discount->is_discount == 1) {
                    if ($get_discount_item->count() == 4) {
                        if ($get_discount_item[3]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[3]->price;
                        } else if ($get_discount_item[2]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[2]->price;
                        } else if ($get_discount_item[1]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[1]->price;
                        } else if ($get_discount_item[0]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[0]->price;
                        } else {
                            $unit_price     = $get_discount_item[0]->price;
                        }
                    } else if ($get_discount_item->count() == 3) {
                        if ($get_discount_item[2]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[2]->price;
                        } else if ($get_discount_item[1]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[1]->price;
                        } else if ($get_discount_item[0]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[0]->price;
                        } else {
                            $unit_price     = $get_discount_item[2]->price;
                        }
                    } else if ($get_discount_item->count() == 2) {
                        if ($get_discount_item[1]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[1]->price;
                        } else if ($get_discount_item[0]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[0]->price;
                        } else {
                            $unit_price     = $get_discount_item[0]->price;
                        }
                    } else if ($get_discount_item->count() == 1) {
                        if ($get_discount_item[0]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[0]->price;
                        } else {
                            $unit_price     = $get_discount_item[0]->price;
                        }
                    }
                } else {
                    $unit_price             = $request->unit_price[$i];
                }
                $get_tax                    = other_tax::find($request->tax[$i]);
                $subtotal                   = $request->qty[$i] * $unit_price;
                $taxtotal                   = ($request->qty[$i] * $unit_price * $get_tax->rate) / 100;
                $total                      = $subtotal + $taxtotal;
                $subtotal_header_other      += $subtotal;
                $taxtotal_header_other      += $taxtotal;
                $grandtotal_header_other    += $total;

                //menyimpan detail per item dari invoicd
                $pp[$i] = new sale_invoice_item([
                    'product_id'                => $request->products2[$i],
                    'desc'                      => $request->desc[$i],
                    'qty'                       => $request->qty[$i],
                    'qty_remaining_return'      => $request->qty[$i],
                    'unit_id'                   => $request->units[$i],
                    'unit_price'                => $unit_price,
                    'tax_id'                    => $request->tax[$i],
                    'amountsub'                 => $subtotal,
                    'amounttax'                 => $taxtotal,
                    'amountgrand'               => $total,
                    'amount'                    => $subtotal,
                ]);
                $pi->sale_invoice_item()->save($pp[$i]);

                $avg_price                      = product::find($request->products2[$i]);
                $total_avg                      = $request->qty[$i] * $avg_price->avg_price;
                $default_product_account        = product::find($request->products2[$i]);
                if ($default_product_account->is_track == 1) {
                    // DEFAULT BUY ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $get_ot->id,
                        'coa_id'                => $default_product_account->buy_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name2'),
                        'debit'                 => $total_avg,
                        'credit'                => 0,
                    ]);
                    // DEFAULT SELL ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $get_ot->id,
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name2'),
                        'debit'                 => 0,
                        'credit'                => $subtotal,
                    ]);
                    // DEFAULT INVENTORY ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $get_ot->id,
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name2'),
                        'debit'                 => 0,
                        'credit'                => $total_avg,
                        //'from_product_id'   => 0,
                    ]);
                } else {
                    // DEFAULT SETTING
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $get_ot->id,
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name2'),
                        'debit'                 => 0,
                        'credit'                => $subtotal,
                        //'from_product_id'   => $request->products[$i],
                    ]);
                }
                //menambahkan stok barang ke gudang
                $wh                             = new warehouse_detail();
                $wh->type                       = 'sales invoice';
                $wh->number                     = 'Sales Invoice #' . $pi->number;
                $wh->product_id                 = $request->products2[$i];
                $wh->warehouse_id               = $request->warehouse;
                $wh->date                       = $request->trans_date;
                $wh->qty_out                    = $request->qty[$i];
                $wh->save();

                //merubah harga average produk
                $produk                         = product::find($request->products2[$i]);
                $qty                            = $request->qty[$i];
                //menyimpan jumlah perubahan pada produk
                product::where('id', $request->products2[$i])->update([
                    'qty'                       => $produk->qty - $qty,
                ]);
            };

            coa_detail::create([
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'ref_id'                => $pi->id,
                'other_transaction_id'  => $get_ot->id,
                'coa_id'                => $contact_account->account_receivable_id,
                'date'                  => $request->get('trans_date'),
                'type'                  => 'sales invoice',
                'number'                => 'Sales Invoice #' . $pi->number,
                'contact_id'            => $request->get('vendor_name2'),
                'debit'                 => $grandtotal_header_other,
                'credit'                => 0,
            ]);

            $get_ot->update([
                'balance_due'       => $grandtotal_header_other,
                'total'             => $grandtotal_header_other,
            ]);

            $pi->update([
                'subtotal'          => $subtotal_header_other,
                'taxtotal'          => $taxtotal_header_other,
                'balance_due'       => $grandtotal_header_other,
                'grandtotal'        => $grandtotal_header_other,
            ]);

            if ($pi->taxtotal > 0) {
                $default_tax                    = default_account::find(8);
                coa_detail::create([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'ref_id'                => $pi->id,
                    'other_transaction_id'  => $get_ot->id,
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'sales invoice',
                    'number'                => 'Sales Invoice #' . $pi->number,
                    'contact_id'            => $request->get('vendor_name2'),
                    'debit'                 => 0,
                    'credit'                => $taxtotal_header_other,
                ]);
            }
            if ($cs->is_fifo == 1) {
                app(\App\Http\Controllers\PurchaseInvoiceController::class)->fifoAll();
                $a = response()->json(['fifo_success' => 'fifo_berhasil']);
                if ($a->getData()->fifo_success) {
                    //dd('of');
                    DB::commit();
                    return response()->json(['success' => 'Data is successfully updated', 'id' => $pi->id]);
                } else {
                    //dd('else');
                    DB::rollBack();
                    return response()->json(['errors' => 'Check log!']);
                }
            }
            //$a->getData()->fifo_success;
            //dd($a);

            //DB::commit();
            //return response()->json(['success' => 'Data is successfully updated', 'id' => $pi->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function updateFromDelivery(Request $request)
    {
        $user               = User::find(Auth::id());
        $cs                 = company_setting::where('company_id', $user->company_id)->first();
        DB::beginTransaction();
        try {
            $id                                 = $request->hidden_id;
            $pi                                 = sale_invoice::find($id);
            $pp                                 = sale_invoice_item::where('sale_invoice_id', $id)->get();
            other_transaction::where('type', 'purchase invoice')->where('number', $pi->number)->update([
                'memo'                          => $request->get('memo'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
            ]);

            sale_invoice::find($id)->update([
                'email'                         => $request->get('email'),
                'address'                       => $request->get('vendor_address'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'term_id'                       => $request->get('term'),
                'vendor_ref_no'                 => $request->get('vendor_no'),
                'message'                       => $request->get('message'),
                'memo'                          => $request->get('memo'),
            ]);
            foreach ($request->products as $i => $keys) {
                $pp[$i]->update([
                    'desc'                      => $request->desc[$i],
                ]);
            }
            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function updateFromOrder(Request $request)
    {
        $user               = User::find(Auth::id());
        $cs                 = company_setting::where('company_id', $user->company_id)->first();
        $rules = array(
            'vendor_name'   => 'required',
            'term'          => 'required',
            'trans_date'    => 'required',
            'due_date'      => 'required',
            'warehouse'     => 'required',
            'products'      => 'required|array|min:1',
            'products.*'    => 'required',
            'qty'           => 'required|array|min:1',
            'qty.*'         => 'required',
            'units'         => 'required|array|min:1',
            'units.*'       => 'required',
            'unit_price'    => 'required|array|min:1',
            'unit_price.*'  => 'required',
            'tax'           => 'required|array|min:1',
            'tax.*'         => 'required',
            'total_price'   => 'required|array|min:1',
            'total_price.*' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $id                                 = $request->hidden_id;
            $id_so                              = $request->hidden_id_so;
            $number_so                          = $request->hidden_number_so;
            $pi                                 = sale_invoice::find($id);
            $pp                                 = sale_invoice_item::where('sale_invoice_id', $id)->get();
            $contact_id                         = contact::find($pi->contact_id);
            $id_contact                         = $request->vendor_name;
            $contact_account                    = contact::find($id_contact);
            $default_tax                        = default_account::find(8);
            $transactions                       = other_transaction::where('type', 'sales invoice')->where('number', $pi->number)->first();
            if ($contact_id->is_limit == 1) {
                $contact_id->update([
                    'current_limit_balance'         => $contact_id->current_limit_balance + $pi->balance_due,
                ]);
            }
            // BUAT NGECHECK INI QUANTITY YANG DIINPUT LEBIH DARI YANG DI ORDER ATAU TIDAK
            foreach ($request->products as $i => $keys) {
                if ($request->qty[$i] < 0) {
                    return response()->json(['errors' => 'Quantity cannot be less than zero']);
                } else if ($request->r_qty[$i] < 0) {
                    return response()->json(['errors' => 'Quantity cannot be more than stock']);
                } else if ($request->qty[$i] == 0) {
                    return response()->json(['errors' => 'Quantity must be more than zero']);
                }
            }
            // BALIKIN STATUS ORDER
            $ambilpo                            = sale_order::find($pi->selected_so_id);
            $ambilpo->update([
                'balance_due'                   => $pi->grandtotal + $ambilpo->balance_due,
            ]);
            if ($ambilpo->balance_due == $ambilpo->grandtotal) {
                $ambilpo->update([
                    'status'                    => 1,
                ]);
            } else {
                $ambilpo->update([
                    'status'                    => 4,
                ]);
            }
            // HAPUS BALANCE PER ITEM INVOICE
            $pi_details                         = sale_invoice_item::where('sale_invoice_id', $id)->get();
            foreach ($pi_details as $a) {
                if ($cs->is_fifo == 1) {
                    product_fifo_out::where('sale_invoice_item_id', $a->id)->delete();
                }
                $ambilpoo                       = sale_order_item::find($a->sale_order_item_id);
                $ambilpoo->update([
                    'qty_remaining'             => $ambilpoo->qty_remaining + $a->qty,
                ]);
                $default_product_account        = product::find($a->product_id);
                if ($default_product_account->is_track == 1) {
                    // DEFAULT BUY ACCOUNT
                    $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                        ->where('number', 'Sales Invoice #' . $pi->number)
                        ->where('credit', 0)
                        ->where('coa_id', $default_product_account->buy_account)
                        ->first();
                    $ambil_avg_price_dari_coadetial->delete();
                    // DEFAULT INVENTORY ACCOUNT
                    $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                        ->where('number', 'Sales Invoice #' . $pi->number)
                        ->where('debit', 0)
                        ->where('coa_id', $default_product_account->default_inventory_account)
                        ->first();
                    $ambil_avg_price_dari_coadetial->delete();
                } else { }
                // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                warehouse_detail::where('type', 'sales invoice')
                    ->where('number', 'Sales Invoice #' . $pi->number)
                    ->where('product_id', $a->product_id)
                    ->where('warehouse_id', $pi->warehouse_id)
                    ->delete();
                // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                $produk                         = product::find($a->product_id);
                $qty                            = $a->qty;
                //menyimpan jumlah perubahan pada produk
                product::where('id', $a->product_id)->update([
                    'qty'                       => $produk->qty + $qty,
                ]);
            }
            coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('credit', 0)->delete();
            sale_invoice_item::where('sale_invoice_id', $id)->delete();
            // BARU BIKIN BARU
            // CREATE COA DETAIL BERDASARKAN DARI CONTACT DEFAULT
            $contact_account                    = contact::find($id_contact);
            coa_detail::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'ref_id'                        => $pi->id,
                'other_transaction_id'          => $transactions->id,
                'coa_id'                        => $contact_account->account_receivable_id,
                'date'                          => $request->get('trans_date'),
                'type'                          => 'sales invoice',
                'number'                        => 'Sales Invoice #' . $pi->number,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => $request->get('balance'),
                'credit'                        => 0,
            ]);
            // MENGUBAH STATUS SI PURCHASE ORDER DAN OTHER TRANSACTION DARI OPEN KE CLOSED
            $check_total_po                     = sale_order::find($id_so);
            $check_total_po->update([
                'balance_due'                   => $check_total_po->balance_due - $request->balance,
            ]);
            if ($check_total_po->balance_due == 0) {
                $updatepdstatus                 = array(
                    'status'                    => 2,
                );
                sale_order::where('number', $number_so)->update($updatepdstatus);
                other_transaction::where('number', $number_so)->where('type', 'sales order')->update($updatepdstatus);
            } else {
                $updatepdstatus                 = array(
                    'status'                    => 4,
                );
                sale_order::where('number', $number_so)->update($updatepdstatus);
                other_transaction::where('number', $number_so)->where('type', 'sales order')->update($updatepdstatus);
            }
            // CREATE OTHER TRANSACTION PUNYA SI INVOICE
            other_transaction::where('type', 'sales invoice')->where('number', $pi->number)->update([
                'memo'                          => $request->get('memo'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'contact'                       => $request->get('vendor_name'),
                'balance_due'                   => $request->get('balance'),
                'total'                         => $request->get('balance'),
            ]);
            // CREATE HEADERNYA SEKALIAN MASUKKIN OTHER_TRANSACTION_ID DIDALEMNYA
            sale_invoice::find($id)->update([
                'contact_id'                    => $request->get('vendor_name'),
                'email'                         => $request->get('email'),
                'address'                       => $request->get('vendor_address'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'term_id'                       => $request->get('term'),
                'vendor_ref_no'                 => $request->get('vendor_no'),
                'warehouse_id'                  => $request->get('warehouse'),
                'subtotal'                      => $request->get('subtotal'),
                'taxtotal'                      => $request->get('taxtotal'),
                'balance_due'                   => $request->get('balance'),
                'grandtotal'                    => $request->get('balance'),
                'message'                       => $request->get('message'),
                'memo'                          => $request->get('memo'),
            ]);

            if ($request->taxtotal > 0) {
                $default_tax                    = default_account::find(8);
                coa_detail::create([
                    'company_id'                => $user->company_id,
                    'user_id'                   => Auth::id(),
                    'ref_id'                    => $pi->id,
                    'other_transaction_id'      => $transactions->id,
                    'coa_id'                    => $default_tax->account_id,
                    'date'                      => $request->get('trans_date'),
                    'type'                      => 'sales invoice',
                    'number'                    => 'Sales Invoice #' . $pi->number,
                    'contact_id'                => $request->get('vendor_name'),
                    'debit'                     => 0,
                    'credit'                    => $request->get('taxtotal'),
                ]);
            }

            foreach ($request->products as $i => $keys) {
                // CREATE DETAILSNYA SEKALIAN MASUKKIN sale_invoice_ID DIDALEMNYA
                $pp[$i]                         = new sale_invoice_item([
                    'sale_order_item_id'        => $request->so_id[$i],
                    'product_id'                => $request->products[$i],
                    'desc'                      => $request->desc[$i],
                    'qty'                       => $request->qty[$i],
                    'qty_remaining_return'      => $request->qty[$i],
                    'unit_id'                   => $request->units[$i],
                    'unit_price'                => $request->unit_price[$i],
                    'tax_id'                    => $request->tax[$i],
                    'amountsub'                 => $request->total_price_sub[$i],
                    'amounttax'                 => $request->total_price_tax[$i],
                    'amountgrand'               => $request->total_price_grand[$i],
                    'amount'                    => $request->total_price[$i],
                    'qty_remaining'             => $request->r_qty[$i],
                ]);
                $pi->sale_invoice_item()->save($pp[$i]);
                $updatepunyapo                  = sale_order_item::find($request->so_id[$i]);
                $updatepunyapo->update([
                    'qty_remaining'             => $updatepunyapo->qty_remaining - $request->qty[$i]
                ]);
                // CREATE COA DETAIL BERDASARKAN PRODUCT SETTING
                $avg_price                      = product::find($request->products[$i]);
                $total_avg                      = $request->qty[$i] * $avg_price->avg_price;
                $default_product_account        = product::find($request->products[$i]);
                if ($default_product_account->is_track == 1) {
                    // CREATE COA DETAIL YANG DARI BUY ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->buy_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $total_avg,
                        'credit'                => 0,
                    ]);
                    // CREATE COA DETAIL YANG DARI SELL ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    // CREATE COA DETAIL YANG DARI INVENTORY ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $total_avg,
                    ]);
                } else {
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                }

                //menambahkan stok barang ke gudang
                $wh                             = new warehouse_detail();
                $wh->type                       = 'sales invoice';
                $wh->number                     = 'Sales Invoice #' . $pi->number;
                $wh->product_id                 = $request->products[$i];
                $wh->warehouse_id               = $request->warehouse;
                $wh->date                       = $request->trans_date;
                $wh->qty_out                    = $request->qty[$i];
                $wh->save();

                //merubah harga average produk
                $produk                         = product::find($request->products[$i]);
                $qty                            = $request->qty[$i];
                //menyimpan jumlah perubahan pada produk
                product::where('id', $request->products[$i])->update([
                    'qty'                       => $produk->qty - $qty,
                ]);
            };
            if ($cs->is_fifo == 1) {
                app(\App\Http\Controllers\PurchaseInvoiceController::class)->fifoAll();
                $a = response()->json(['fifo_success' => 'fifo_berhasil']);
                if ($a->getData()->fifo_success) {
                    //dd('of');
                    DB::commit();
                    return response()->json(['success' => 'Data is successfully updated', 'id' => $pi->id]);
                } else {
                    //dd('else');
                    DB::rollBack();
                    return response()->json(['errors' => 'Check log!']);
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function updateFromQuote(Request $request)
    {
        $user               = User::find(Auth::id());
        $cs                 = company_setting::where('company_id', $user->company_id)->first();
        $rules = array(
            'vendor_name'   => 'required',
            'term'          => 'required',
            'trans_date'    => 'required',
            'due_date'      => 'required',
            'warehouse'     => 'required',
            'products'      => 'required|array|min:1',
            'products.*'    => 'required',
            'qty'           => 'required|array|min:1',
            'qty.*'         => 'required',
            'units'         => 'required|array|min:1',
            'units.*'       => 'required',
            'unit_price'    => 'required|array|min:1',
            'unit_price.*'  => 'required',
            'tax'           => 'required|array|min:1',
            'tax.*'         => 'required',
            'total_price'   => 'required|array|min:1',
            'total_price.*' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $id                                 = $request->hidden_id;
            $id_sq                              = $request->hidden_id_sq;
            $number_sq                          = $request->hidden_number_sq;
            $pi                                 = sale_invoice::find($id);
            $pp                                 = sale_invoice_item::where('sale_invoice_id', $id)->get();
            $contact_id                         = contact::find($pi->contact_id);
            $id_contact                         = $request->vendor_name;
            $contact_account                    = contact::find($id_contact);
            $subtotal_header_other              = 0;
            $taxtotal_header_other              = 0;
            $grandtotal_header_other            = 0;
            $get_ot                             = other_transaction::where('type', 'sales invoice')->where('number', $pi->number)->first();
            if ($contact_id->is_limit == 1) {
                $contact_id->update([
                    'current_limit_balance'         => $contact_id->current_limit_balance + $pi->balance_due,
                ]);
            }
            // UPDATE STATUS ON SALES QUOTE & OTHER TRANSACTION QUOTE'S
            $updatepdstatus                     = array(
                'status'                        => 1,
            );
            sale_quote::where('number', $pi->transaction_no_sq)->update($updatepdstatus);
            other_transaction::where('number', $pi->transaction_no_sq)->where('type', 'sales quote')->update($updatepdstatus);
            // HAPUS BALANCE PER ITEM INVOICE
            $pi_details                         = sale_invoice_item::where('sale_invoice_id', $id)->get();
            foreach ($pi_details as $a) {
                if ($cs->is_fifo == 1) {
                    product_fifo_out::where('sale_invoice_item_id', $a->id)->delete();
                }
                $default_product_account        = product::find($a->product_id);
                if ($default_product_account->is_track == 1) {
                    // DEFAULT BUY ACCOUNT
                    $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                        ->where('number', 'Sales Invoice #' . $pi->number)
                        ->where('credit', 0)
                        ->where('coa_id', $default_product_account->buy_account)
                        ->first();
                    $ambil_avg_price_dari_coadetial->delete();
                    // DEFAULT INVENTORY ACCOUNT
                    $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                        ->where('number', 'Sales Invoice #' . $pi->number)
                        ->where('debit', 0)
                        ->where('coa_id', $default_product_account->default_inventory_account)
                        ->first();
                    $ambil_avg_price_dari_coadetial->delete();
                    // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                    warehouse_detail::where('type', 'sales invoice')
                        ->where('number', 'Sales Invoice #' . $pi->number)
                        ->where('product_id', $a->product_id)
                        ->where('warehouse_id', $pi->warehouse_id)
                        ->delete();
                    // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                    $produk                     = product::find($a->product_id);
                    $qty                        = $a->qty;
                    //menyimpan jumlah perubahan pada produk
                    product::where('id', $a->product_id)->update([
                        'qty'                   => $produk->qty + $qty,
                    ]);
                } else {
                    // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                    warehouse_detail::where('type', 'sales invoice')
                        ->where('number', 'Sales Invoice #' . $pi->number)
                        ->where('product_id', $a->product_id)
                        ->where('warehouse_id', $pi->warehouse_id)
                        ->delete();
                    // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                    $produk                     = product::find($a->product_id);
                    $qty                        = $a->qty;
                    //menyimpan jumlah perubahan pada produk
                    product::where('id', $a->product_id)->update([
                        'qty'                   => $produk->qty + $qty,
                    ]);
                }
            }
            coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('credit', 0)->delete();
            sale_invoice_item::where('sale_invoice_id', $id)->delete();

            // UPDATE STATUS ON SALES QUOTE & OTHER TRANSACTION QUOTE'S
            $updatepdstatus                 = array(
                'status'                    => 2,
            );
            sale_quote::where('number', $number_sq)->update($updatepdstatus);
            other_transaction::where('number', $number_sq)->where('type', 'sales quote')->update($updatepdstatus);
            // CREATE LIST OTHER TRANSACTION PUNYA INVOICE
            $get_ot->update([
                'memo'                      => $request->get('memo'),
                'transaction_date'          => $request->get('trans_date'),
                'due_date'                  => $request->get('due_date'),
                'contact'                   => $request->get('vendor_name'),
                'balance_due'               => $request->get('balance'),
                'total'                     => $request->get('balance'),
            ]);
            // CREATE SALES INVOICE HEADER
            $pi->update([
                'contact_id'                => $request->get('vendor_name'),
                'email'                     => $request->get('email'),
                'address'                   => $request->get('vendor_address'),
                'transaction_date'          => $request->get('trans_date'),
                'due_date'                  => $request->get('due_date'),
                'term_id'                   => $request->get('term'),
                'vendor_ref_no'             => $request->get('vendor_no'),
                'warehouse_id'              => $request->get('warehouse'),
                'subtotal'                  => $request->get('subtotal'),
                'taxtotal'                  => $request->get('taxtotal'),
                'balance_due'               => $request->get('balance'),
                'grandtotal'                => $request->get('balance'),
                'message'                   => $request->get('message'),
                'memo'                      => $request->get('memo'),
            ]);
            // CREATE SALES INVOICE DETAILS
            foreach ($request->products2 as $i => $keys) {
                $check_discount     = product::find($request->products2[$i]);
                $get_discount_item  = product_discount_item::where('product_id', $request->products2[$i])->get();
                if ($check_discount->is_discount == 1) {
                    if ($get_discount_item->count() == 4) {
                        if ($get_discount_item[3]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[3]->price;
                        } else if ($get_discount_item[2]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[2]->price;
                        } else if ($get_discount_item[1]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[1]->price;
                        } else if ($get_discount_item[0]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[0]->price;
                        } else {
                            $unit_price     = $get_discount_item[0]->price;
                        }
                    } else if ($get_discount_item->count() == 3) {
                        if ($get_discount_item[2]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[2]->price;
                        } else if ($get_discount_item[1]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[1]->price;
                        } else if ($get_discount_item[0]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[0]->price;
                        } else {
                            $unit_price     = $get_discount_item[2]->price;
                        }
                    } else if ($get_discount_item->count() == 2) {
                        if ($get_discount_item[1]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[1]->price;
                        } else if ($get_discount_item[0]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[0]->price;
                        } else {
                            $unit_price     = $get_discount_item[0]->price;
                        }
                    } else if ($get_discount_item->count() == 1) {
                        if ($get_discount_item[0]->qty < $request->qty[$i]) {
                            $unit_price     = $get_discount_item[0]->price;
                        } else {
                            $unit_price     = $get_discount_item[0]->price;
                        }
                    }
                } else {
                    $unit_price             = $request->unit_price[$i];
                }
                $get_tax                    = other_tax::find($request->tax[$i]);
                $subtotal                   = $request->qty[$i] * $unit_price;
                $taxtotal                   = ($request->qty[$i] * $unit_price * $get_tax->rate) / 100;
                $total                      = $subtotal + $taxtotal;
                $subtotal_header_other      += $subtotal;
                $taxtotal_header_other      += $taxtotal;
                $grandtotal_header_other    += $total;

                $pp[$i] = new sale_invoice_item([
                    'product_id'            => $request->products2[$i],
                    'desc'                  => $request->desc[$i],
                    'qty'                   => $request->qty[$i],
                    'qty_remaining_return'  => $request->qty[$i],
                    'unit_id'               => $request->units[$i],
                    'unit_price'            => $unit_price,
                    'tax_id'                => $request->tax[$i],
                    'amountsub'             => $subtotal,
                    'amounttax'             => $taxtotal,
                    'amountgrand'           => $total,
                    'amount'                => $subtotal,
                    'qty_remaining'         => $request->r_qty[$i],
                ]);
                $pi->sale_invoice_item()->save($pp[$i]);
                // CREATE COA DETAIL BASED ON PRODUCT SETTING
                $avg_price                      = product::find($request->products2[$i]);
                $total_avg                      = $request->qty[$i] * $avg_price->avg_price;
                $default_product_account    = product::find($request->products2[$i]);
                if ($default_product_account->is_track == 1) {
                    // CREATE COA DETAIL YANG DARI BUY ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $get_ot->id,
                        'coa_id'                => $default_product_account->buy_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $total_avg,
                        'credit'                => 0,
                    ]);
                    // CREATE COA DETAIL YANG DARI SELL ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $get_ot->id,
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $subtotal,
                    ]);
                    // CREATE COA DETAIL YANG DARI INVENTORY ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $get_ot->id,
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $total_avg,
                    ]);
                } else {
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $get_ot->id,
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $subtotal,
                    ]);
                }
                //menambahkan stok barang ke gudang
                $wh                             = new warehouse_detail();
                $wh->type                       = 'sales invoice';
                $wh->number                     = 'Sales Invoice #' . $pi->number;
                $wh->product_id                 = $request->products2[$i];
                $wh->warehouse_id               = $request->warehouse;
                $wh->date                       = $request->trans_date;
                $wh->qty_out                    = $request->qty[$i];
                $wh->save();
                //merubah harga average produk
                $produk                         = product::find($request->products2[$i]);
                $qty                            = $request->qty[$i];
                //menyimpan jumlah perubahan pada produk
                product::where('id', $request->products2[$i])->update([
                    'qty'                       => $produk->qty - $qty,
                    //'avg_price' => abs($curr_avg_price),
                ]);
            };
            // BIKIN BARUNYA
            $contact_account                = contact::find($id_contact);
            coa_detail::create([
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'ref_id'                => $pi->id,
                'other_transaction_id'  => $get_ot->id,
                'coa_id'                => $contact_account->account_receivable_id,
                'date'                  => $request->get('trans_date'),
                'type'                  => 'sales invoice',
                'number'                => 'Sales Invoice #' . $pi->number,
                'contact_id'            => $request->get('vendor_name'),
                'debit'                 => $grandtotal_header_other,
                'credit'                => 0,
            ]);

            $get_ot->update([
                'balance_due'       => $grandtotal_header_other,
                'total'             => $grandtotal_header_other,
            ]);

            $pi->update([
                'subtotal'          => $subtotal_header_other,
                'taxtotal'          => $taxtotal_header_other,
                'balance_due'       => $grandtotal_header_other,
                'grandtotal'        => $grandtotal_header_other,
            ]);

            if ($pi->taxtotal > 0) {
                $default_tax                = default_account::find(8);
                coa_detail::create([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'ref_id'                => $pi->id,
                    'other_transaction_id'  => $get_ot->id,
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'sales invoice',
                    'number'                => 'Sales Invoice #' . $pi->number,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => 0,
                    'credit'                => $taxtotal_header_other,
                ]);
            }
            if ($cs->is_fifo == 1) {
                app(\App\Http\Controllers\PurchaseInvoiceController::class)->fifoAll();
                $a = response()->json(['fifo_success' => 'fifo_berhasil']);
                if ($a->getData()->fifo_success) {
                    //dd('of');
                    DB::commit();
                    return response()->json(['success' => 'Data is successfully updated', 'id' => $pi->id]);
                } else {
                    //dd('else');
                    DB::rollBack();
                    return response()->json(['errors' => 'Check log!']);
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function updateFromOrderRequestSukses(Request $request)
    {
        $user               = User::find(Auth::id());
        $cs                 = company_setting::where('company_id', $user->company_id)->first();
        DB::beginTransaction();
        try {
            $id                                 = $request->hidden_id;
            $id_so                              = $request->hidden_id_so;
            $number_so                          = $request->hidden_number_so;
            $pi                                 = sale_invoice::find($id);
            $pp                                 = sale_invoice_item::where('sale_invoice_id', $id)->get();
            $contact_id                         = contact::find($pi->contact_id);
            $id_contact                         = $request->vendor_name;
            $contact_account                    = contact::find($id_contact);
            $default_tax                        = default_account::find(8);
            $get_ot                             = other_transaction::where('type', 'sales invoice')->where('number', $pi->number)->first();
            if ($contact_id->is_limit == 1) {
                $contact_id->update([
                    'current_limit_balance'         => $contact_id->current_limit_balance + $pi->balance_due,
                ]);
            }
            // BUAT NGECHECK INI QUANTITY YANG DIINPUT LEBIH DARI YANG DI ORDER ATAU TIDAK
            foreach ($request->products as $i => $keys) {
                if ($request->qty[$i] < 0) {
                    return response()->json(['errors' => 'Quantity cannot be less than zero']);
                } else if ($request->r_qty[$i] < 0) {
                    return response()->json(['errors' => 'Quantity cannot be more than stock']);
                } else if ($request->qty[$i] == 0) {
                    return response()->json(['errors' => 'Quantity must be more than zero']);
                }
            }
            // BALIKIN STATUS ORDER
            $ambilpo                            = sale_order::find($pi->selected_so_id);
            $ambilpo->update([
                'balance_due'                   => $pi->grandtotal + $ambilpo->balance_due,
            ]);
            if ($ambilpo->balance_due == $ambilpo->grandtotal) {
                $ambilpo->update([
                    'status'                    => 1,
                ]);
            } else {
                $ambilpo->update([
                    'status'                    => 4,
                ]);
            }
            // HAPUS BALANCE PER ITEM INVOICE
            $pi_details                         = sale_invoice_item::where('sale_invoice_id', $id)->get();
            foreach ($pi_details as $a) {
                if ($cs->is_fifo == 1) {
                    product_fifo_out::where('sale_invoice_item_id', $a->id)->delete();
                }
                $ambilpoo                       = sale_order_item::find($a->sale_order_item_id);
                $ambilpoo->update([
                    'qty_remaining'             => $ambilpoo->qty_remaining + $a->qty,
                ]);
                $default_product_account        = product::find($a->product_id);
                if ($default_product_account->is_track == 1) {
                    // DEFAULT BUY ACCOUNT
                    $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                        ->where('number', 'Sales Invoice #' . $pi->number)
                        ->where('credit', 0)
                        ->where('coa_id', $default_product_account->buy_account)
                        ->first();
                    $ambil_avg_price_dari_coadetial->delete();
                    // DEFAULT INVENTORY ACCOUNT
                    $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                        ->where('number', 'Sales Invoice #' . $pi->number)
                        ->where('debit', 0)
                        ->where('coa_id', $default_product_account->default_inventory_account)
                        ->first();
                    $ambil_avg_price_dari_coadetial->delete();
                } else { }
                // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                warehouse_detail::where('type', 'sales invoice')
                    ->where('number', 'Sales Invoice #' . $pi->number)
                    ->where('product_id', $a->product_id)
                    ->where('warehouse_id', $pi->warehouse_id)
                    ->delete();
                // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                $produk                     = product::find($a->product_id);
                $qty                        = $a->qty;
                //menyimpan jumlah perubahan pada produk
                product::where('id', $a->product_id)->update([
                    'qty'                   => $produk->qty + $qty,
                ]);
            }
            coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('credit', 0)->delete();
            sale_invoice_item::where('sale_invoice_id', $id)->delete();
            // BARU BIKIN BARU
            // CREATE COA DETAIL BERDASARKAN DARI CONTACT DEFAULT
            $contact_account                    = contact::find($id_contact);
            if ($contact_account->is_limit == 1) {
                if ($contact_account->current_limit_balance >= $request->balance) {
                    $contact_account->update([
                        'current_limit_balance'         => $contact_account->current_limit_balance - $request->balance,
                    ]);
                } else {
                    DB::rollBack();
                    return response()->json(['errors' => 'Cannot make a transaction because the balance has exceeded the limit!<br><br>
                    Total Limit Balance = ' . number_format($contact_account->limit_balance, 2, ',', '.') . '<br>
                    Total Current Limit Balance = ' . number_format($contact_account->current_limit_balance, 2, ',', '.')]);
                }
            }

            coa_detail::create([
                'company_id'                => $user->company_id,
                'user_id'                   => Auth::id(),
                'ref_id'                    => $pi->id,
                'other_transaction_id'      => $get_ot->id,
                'coa_id'                    => $contact_account->account_receivable_id,
                'date'                      => $request->get('trans_date'),
                'type'                      => 'sales invoice',
                'number'                    => 'Sales Invoice #' . $pi->number,
                'contact_id'                => $request->get('vendor_name'),
                'debit'                     => $request->get('balance'),
                'credit'                    => 0,
            ]);
            // MENGUBAH STATUS SI PURCHASE ORDER DAN OTHER TRANSACTION DARI OPEN KE CLOSED
            $check_total_po                 = sale_order::find($id_so);
            $check_total_po->update([
                'balance_due'               => $check_total_po->balance_due - $request->balance,
            ]);
            if ($check_total_po->balance_due == 0) {
                $updatepdstatus             = array(
                    'status'                => 2,
                );
                sale_order::where('number', $number_so)->update($updatepdstatus);
                other_transaction::where('number', $number_so)->where('type', 'sales order')->update($updatepdstatus);
            } else {
                $updatepdstatus             = array(
                    'status'                => 4,
                );
                sale_order::where('number', $number_so)->update($updatepdstatus);
                other_transaction::where('number', $number_so)->where('type', 'sales order')->update($updatepdstatus);
            }
            // CREATE OTHER TRANSACTION PUNYA SI INVOICE
            other_transaction::where('type', 'sales invoice')->where('number', $pi->number)->update([
                'memo'                          => $request->get('memo'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'contact'                       => $request->get('vendor_name'),
                'balance_due'                   => $request->get('balance'),
                'total'                         => $request->get('balance'),
            ]);
            // CREATE HEADERNYA SEKALIAN MASUKKIN OTHER_TRANSACTION_ID DIDALEMNYA
            sale_invoice::find($id)->update([
                'contact_id'                    => $request->get('vendor_name'),
                'email'                         => $request->get('email'),
                'address'                       => $request->get('vendor_address'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'term_id'                       => $request->get('term'),
                'vendor_ref_no'                 => $request->get('vendor_no'),
                'warehouse_id'                  => $request->get('warehouse'),
                'subtotal'                      => $request->get('subtotal'),
                'taxtotal'                      => $request->get('taxtotal'),
                'balance_due'                   => $request->get('balance'),
                'grandtotal'                    => $request->get('balance'),
                'message'                       => $request->get('message'),
                'memo'                          => $request->get('memo'),
            ]);

            if ($request->taxtotal > 0) {
                $default_tax                    = default_account::find(8);
                coa_detail::create([
                    'company_id'                => $user->company_id,
                    'user_id'                   => Auth::id(),
                    'ref_id'                    => $pi->id,
                    'other_transaction_id'      => $get_ot->id,
                    'coa_id'                    => $default_tax->account_id,
                    'date'                      => $request->get('trans_date'),
                    'type'                      => 'sales invoice',
                    'number'                    => 'Sales Invoice #' . $pi->number,
                    'contact_id'                => $request->get('vendor_name'),
                    'debit'                     => 0,
                    'credit'                    => $request->get('taxtotal'),
                ]);
            }

            foreach ($request->products as $i => $keys) {
                // CREATE DETAILSNYA SEKALIAN MASUKKIN sale_invoice_ID DIDALEMNYA
                $pp[$i]                         = new sale_invoice_item([
                    'sale_order_item_id'        => $request->so_id[$i],
                    'product_id'                => $request->products[$i],
                    'desc'                      => $request->desc[$i],
                    'qty'                       => $request->qty[$i],
                    'qty_remaining_return'      => $request->qty[$i],
                    'unit_id'                   => $request->units[$i],
                    'unit_price'                => $request->unit_price[$i],
                    'tax_id'                    => $request->tax[$i],
                    'amountsub'                 => $request->total_price_sub[$i],
                    'amounttax'                 => $request->total_price_tax[$i],
                    'amountgrand'               => $request->total_price_grand[$i],
                    'amount'                    => $request->total_price[$i],
                    'qty_remaining'             => $request->r_qty[$i],
                ]);
                $pi->sale_invoice_item()->save($pp[$i]);
                $updatepunyapo                  = sale_order_item::find($request->so_id[$i]);
                $updatepunyapo->update([
                    'qty_remaining'             => $updatepunyapo->qty_remaining - $request->qty[$i]
                ]);
                // CREATE COA DETAIL BERDASARKAN PRODUCT SETTING
                $avg_price                      = product::find($request->products[$i]);
                $total_avg                      = $request->qty[$i] * $avg_price->avg_price;
                $default_product_account        = product::find($request->products[$i]);
                if ($default_product_account->is_track == 1) {
                    // CREATE COA DETAIL YANG DARI BUY ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $get_ot->id,
                        'coa_id'                => $default_product_account->buy_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $total_avg,
                        'credit'                => 0,
                    ]);
                    // CREATE COA DETAIL YANG DARI SELL ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $get_ot->id,
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    // CREATE COA DETAIL YANG DARI INVENTORY ACCOUNT
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $get_ot->id,
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $total_avg,
                    ]);
                } else {
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $get_ot->id,
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                }

                //menambahkan stok barang ke gudang
                $wh                             = new warehouse_detail();
                $wh->type                       = 'sales invoice';
                $wh->number                     = 'Sales Invoice #' . $pi->number;
                $wh->product_id                 = $request->products[$i];
                $wh->warehouse_id               = $request->warehouse;
                $wh->date                       = $request->trans_date;
                $wh->qty_out                    = $request->qty[$i];
                $wh->save();

                //merubah harga average produk
                $produk                         = product::find($request->products[$i]);
                $qty                            = $request->qty[$i];
                //menyimpan jumlah perubahan pada produk
                product::where('id', $request->products[$i])->update([
                    'qty'                       => $produk->qty - $qty,
                ]);
            };
            if ($cs->is_fifo == 1) {
                app(\App\Http\Controllers\PurchaseInvoiceController::class)->fifoAll();
                $a = response()->json(['fifo_success' => 'fifo_berhasil']);
                if ($a->getData()->fifo_success) {
                    //dd('of');
                    DB::commit();
                    return response()->json(['success' => 'Data is successfully updated', 'id' => $pi->id]);
                } else {
                    //dd('else');
                    DB::rollBack();
                    return response()->json(['errors' => 'Check log!']);
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $user       = User::find(Auth::id());
        $cs         = company_setting::where('company_id', $user->company_id)->first();
        if ($cs->company_id == 5) {
            if(Auth::id() != 999999){
                return redirect('/dashboard');
            }
        }
        DB::beginTransaction();
        try {
            $pi                                     = sale_invoice::find($id);
            if($cs->company_id == 5){
                if ($pi->status < 10) {
                    return redirect('/sales_invoice');
                }
            }
            $contact_id                             = contact::find($pi->contact_id);
            $default_revenue                        = default_account::find(1);
            $default_tax                            = default_account::find(8);
            if ($pi->selected_sq_id) {
                if ($contact_id->is_limit == 1) {
                    $contact_id->update([
                        'current_limit_balance'         => $contact_id->current_limit_balance + $pi->balance_due,
                    ]);
                }
                // UPDATE STATUS ON SALES QUOTE & OTHER TRANSACTION QUOTE'S
                $updatepdstatus                     = array(
                    'status'                        => 1,
                );
                sale_quote::where('number', $pi->transaction_no_sq)->update($updatepdstatus);
                other_transaction::where('number', $pi->transaction_no_sq)->where('type', 'sales quote')->update($updatepdstatus);
                // HAPUS BALANCE PER ITEM INVOICE
                $pi_details                         = sale_invoice_item::where('sale_invoice_id', $id)->get();
                foreach ($pi_details as $a) {
                    if ($cs->is_fifo == 1) {
                        product_fifo_out::where('sale_invoice_item_id', $a->id)->delete();
                    }
                    $default_product_account        = product::find($a->product_id);
                    if ($default_product_account->is_track == 1) {
                        // DEFAULT BUY ACCOUNT
                        $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('credit', 0)
                            ->where('coa_id', $default_product_account->buy_account)
                            ->first();
                        $ambil_avg_price_dari_coadetial->delete();
                        // DEFAULT INVENTORY ACCOUNT
                        $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('debit', 0)
                            ->where('coa_id', $default_product_account->default_inventory_account)
                            ->first();
                        $ambil_avg_price_dari_coadetial->delete();
                        // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                        warehouse_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('product_id', $a->product_id)
                            ->where('warehouse_id', $pi->warehouse_id)
                            ->delete();
                        // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                        $produk                     = product::find($a->product_id);
                        $qty                        = $a->qty;
                        //menyimpan jumlah perubahan pada produk
                        product::where('id', $a->product_id)->update([
                            'qty'                   => $produk->qty + $qty,
                        ]);
                    } else {
                        // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                        warehouse_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('product_id', $a->product_id)
                            ->where('warehouse_id', $pi->warehouse_id)
                            ->delete();
                        // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                        $produk                     = product::find($a->product_id);
                        $qty                        = $a->qty;
                        //menyimpan jumlah perubahan pada produk
                        product::where('id', $a->product_id)->update([
                            'qty'                   => $produk->qty + $qty,
                        ]);
                    }
                }
                coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('debit', 0)->delete();
                coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('credit', 0)->delete();
                sale_invoice_item::where('sale_invoice_id', $id)->delete();
                // DELETE ROOT OTHER TRANSACTION
                other_transaction::where('type', 'sales invoice')->where('number', $pi->number)->delete();
                // FINALLY DELETE THE INVOICE
                $pi->delete();
            } else if ($pi->selected_sd_id) {
                if ($contact_id->is_limit == 1) {
                    $contact_id->update([
                        'current_limit_balance'         => $contact_id->current_limit_balance + $pi->balance_due,
                    ]);
                }
                coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('debit', 0)->delete();
                coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('credit', 0)->delete();
                // HAPUS BALANCE PER ITEM INVOICE
                $pi_details                         = sale_invoice_item::where('sale_invoice_id', $id)->get();
                foreach ($pi_details as $a) {
                    if ($cs->is_fifo == 1) {
                        product_fifo_out::where('sale_invoice_item_id', $a->id)->delete();
                    }
                    $default_product_account        = product::find($a->product_id);
                    if ($default_product_account->is_track == 1) {
                        // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                        warehouse_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('product_id', $a->product_id)
                            ->where('warehouse_id', $pi->warehouse_id)
                            ->delete();
                        // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                        $produk                             = product::find($a->product_id);
                        $qty                                = $a->qty;
                        //menyimpan jumlah perubahan pada produk
                        product::where('id', $a->product_id)->update([
                            'qty'                           => $produk->qty + $qty,
                        ]);
                    } else {
                        // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                        warehouse_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('product_id', $a->product_id)
                            ->where('warehouse_id', $pi->warehouse_id)
                            ->delete();
                        // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                        $produk                             = product::find($a->product_id);
                        $qty                                = $a->qty;
                        //menyimpan jumlah perubahan pada produk
                        product::where('id', $a->product_id)->update([
                            'qty'                           => $produk->qty + $qty,
                        ]);
                    }
                }
                sale_invoice_item::where('sale_invoice_id', $id)->delete();
                // DELETE ROOT OTHER TRANSACTION
                other_transaction::where('type', 'sales invoice')->where('number', $pi->number)->delete();
                // FINALLY DELETE THE INVOICE
                $pi->delete();
            } else if ($pi->selected_so_id && $pi->is_marketting == 0) {
                if ($contact_id->is_limit == 1) {
                    $contact_id->update([
                        'current_limit_balance'         => $contact_id->current_limit_balance + $pi->balance_due,
                    ]);
                }
                // BALIKIN STATUS ORDER
                $ambilpo                            = sale_order::find($pi->selected_so_id);
                $ambilpo->update([
                    'balance_due'                   => $pi->grandtotal + $ambilpo->balance_due,
                ]);
                if ($ambilpo->balance_due == $ambilpo->grandtotal) {
                    $ambilpo->update([
                        'status'                    => 1,
                    ]);
                } else {
                    $ambilpo->update([
                        'status'                    => 4,
                    ]);
                }
                // HAPUS BALANCE PER ITEM INVOICE
                $pi_details                         = sale_invoice_item::where('sale_invoice_id', $id)->get();
                foreach ($pi_details as $a) {
                    if ($cs->is_fifo == 1) {
                        product_fifo_out::where('sale_invoice_item_id', $a->id)->delete();
                    }
                    $ambilpoo                       = sale_order_item::find($a->sale_order_item_id);
                    $ambilpoo->update([
                        'qty_remaining'             => $ambilpoo->qty_remaining + $a->qty,
                    ]);
                    $default_product_account        = product::find($a->product_id);
                    if ($default_product_account->is_track == 1) {
                        // DEFAULT BUY ACCOUNT
                        $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('credit', 0)
                            ->where('coa_id', $default_product_account->buy_account)
                            ->first();
                        $ambil_avg_price_dari_coadetial->delete();
                        // DEFAULT INVENTORY ACCOUNT
                        $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('debit', 0)
                            ->where('coa_id', $default_product_account->default_inventory_account)
                            ->first();
                        $ambil_avg_price_dari_coadetial->delete();
                    } else { }
                    // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                    warehouse_detail::where('type', 'sales invoice')
                        ->where('number', 'Sales Invoice #' . $pi->number)
                        ->where('product_id', $a->product_id)
                        ->where('warehouse_id', $pi->warehouse_id)
                        ->delete();
                    // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                    $produk                     = product::find($a->product_id);
                    $qty                        = $a->qty;
                    //menyimpan jumlah perubahan pada produk
                    product::where('id', $a->product_id)->update([
                        'qty'                   => $produk->qty + $qty,
                    ]);
                }
                coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('debit', 0)->delete();
                coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('credit', 0)->delete();
                sale_invoice_item::where('sale_invoice_id', $id)->delete();
                // DELETE ROOT OTHER TRANSACTION
                other_transaction::where('type', 'sales invoice')->where('number', $pi->number)->delete();
                // FINALLY DELETE THE INVOICE
                $pi->delete();
            } else if ($pi->selected_spk_id) {
                if ($contact_id->is_limit == 1) {
                    $contact_id->update([
                        'current_limit_balance'         => $contact_id->current_limit_balance + $pi->balance_due,
                    ]);
                }
                if ($pi->jasa_only == 0) {
                    // HAPUS BALANCE PER ITEM INVOICE
                    $pi_details                         = sale_invoice_item::where('sale_invoice_id', $id)->get();
                    foreach ($pi_details as $a) {
                        if ($cs->is_fifo == 1) {
                            product_fifo_out::where('sale_invoice_item_id', $a->id)->delete();
                        }
                        $ambilspkitem                   = spk_item::where('product_id', $a->product_id)->first();
                        $ambilspkitem->update([
                            'qty_remaining_sent' => $ambilspkitem->qty_remaining_sent + $a->qty
                        ]);

                        $default_product_account        = product::find($a->product_id);
                        if ($default_product_account->is_track == 1) {
                            // DEFAULT BUY ACCOUNT
                            $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                                ->where('number', 'Sales Invoice #' . $pi->number)
                                ->where('credit', 0)
                                ->where('coa_id', $default_product_account->buy_account)
                                ->first();
                            $ambil_avg_price_dari_coadetial->delete();
                            // DEFAULT INVENTORY ACCOUNT
                            $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                                ->where('number', 'Sales Invoice #' . $pi->number)
                                ->where('debit', 0)
                                ->where('coa_id', $default_product_account->default_inventory_account)
                                ->first();
                            $ambil_avg_price_dari_coadetial->delete();
                        } else { }
                        // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                        warehouse_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('product_id', $a->product_id)
                            ->where('warehouse_id', $pi->warehouse_id)
                            ->delete();
                        // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                        $produk                     = product::find($a->product_id);
                        $qty                        = $a->qty;
                        //menyimpan jumlah perubahan pada produk
                        product::where('id', $a->product_id)->update([
                            'qty'                   => $produk->qty + $qty,
                        ]);
                    }
                    // FINALLY DELETE THE COA DETAIL WITH DEBIT = 0
                    coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('debit', 0)->delete();
                    coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('credit', 0)->delete();
                    sale_invoice_item::where('sale_invoice_id', $id)->delete();
                    sale_invoice_cost::where('sale_invoice_id', $id)->delete();
                    // DELETE ROOT OTHER TRANSACTION
                    other_transaction::where('type', 'sales invoice')->where('number', $pi->number)->delete();
                    // FINALLY DELETE THE INVOICE
                    $pi->delete();
                } else {
                    // HAPUS BALANCE PER ITEM INVOICE
                    $pi_details                         = sale_invoice_item::where('sale_invoice_id', $id)->get();
                    foreach ($pi_details as $a) {
                        $ambilspkitem                   = spk_item::where('product_id', $a->product_id)->first();
                        $ambilspkitem->update([
                            'qty_remaining_sent' => $ambilspkitem->qty_remaining_sent + $a->qty
                        ]);

                        // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                        warehouse_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('product_id', $a->product_id)
                            ->where('warehouse_id', $pi->warehouse_id)
                            ->delete();
                        // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                        $produk                     = product::find($a->product_id);
                        $qty                        = $a->qty;
                        //menyimpan jumlah perubahan pada produk
                        product::where('id', $a->product_id)->update([
                            'qty'                   => $produk->qty + $qty,
                        ]);
                    }
                    // FINALLY DELETE THE COA DETAIL WITH DEBIT = 0
                    coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('debit', 0)->delete();
                    coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('credit', 0)->delete();
                    sale_invoice_item::where('sale_invoice_id', $id)->delete();
                    sale_invoice_cost::where('sale_invoice_id', $id)->delete();
                    // DELETE ROOT OTHER TRANSACTION
                    other_transaction::where('type', 'sales invoice')->where('number', $pi->number)->delete();
                    // FINALLY DELETE THE INVOICE
                    $pi->delete();
                }
            } else if ($pi->selected_so_id && $pi->is_marketting == 1) {
                if ($contact_id->is_limit == 1) {
                    $contact_id->update([
                        'current_limit_balance'         => $contact_id->current_limit_balance + $pi->balance_due,
                    ]);
                }
                // BALIKIN STATUS ORDER
                $ambilpo                            = sale_order::find($pi->selected_so_id);
                $ambilpo->update([
                    'balance_due'                   => $pi->grandtotal + $ambilpo->balance_due,
                ]);
                if ($ambilpo->balance_due == $ambilpo->grandtotal) {
                    $ambilpo->update([
                        'status'                    => 1,
                    ]);
                } else {
                    $ambilpo->update([
                        'status'                    => 4,
                    ]);
                }
                // HAPUS BALANCE PER ITEM INVOICE
                $pi_details                         = sale_invoice_item::where('sale_invoice_id', $id)->get();
                foreach ($pi_details as $a) {
                    if ($cs->is_fifo == 1) {
                        product_fifo_out::where('sale_invoice_item_id', $a->id)->delete();
                    }
                    $ambilpoo                       = sale_order_item::find($a->sale_order_item_id);
                    $ambilpoo->update([
                        'qty_remaining'             => $ambilpoo->qty_remaining + $a->qty,
                    ]);
                    $default_product_account        = product::find($a->product_id);
                    if ($default_product_account->is_track == 1) {
                        // DEFAULT BUY ACCOUNT
                        $ambil_avg_price_dari_coadetial1 = coa_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('credit', 0)
                            ->where('coa_id', $default_product_account->buy_account)
                            ->first();
                        $ambil_avg_price_dari_coadetial1->delete();
                        // DEFAULT INVENTORY ACCOUNT
                        $ambil_avg_price_dari_coadetial2 = coa_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('debit', 0)
                            ->where('coa_id', $default_product_account->default_inventory_account)
                            ->first();
                        $ambil_avg_price_dari_coadetial2->delete();
                    } else { }
                    // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                    warehouse_detail::where('type', 'sales invoice')
                        ->where('number', 'Sales Invoice #' . $pi->number)
                        ->where('product_id', $a->product_id)
                        ->where('warehouse_id', $pi->warehouse_id)
                        ->delete();
                    // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                    $produk                     = product::find($a->product_id);
                    $qty                        = $a->qty;
                    //menyimpan jumlah perubahan pada produk
                    product::where('id', $a->product_id)->update([
                        'qty'                   => $produk->qty + $qty,
                    ]);
                }
                coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('debit', 0)->delete();
                coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('credit', 0)->delete();
                sale_invoice_item::where('sale_invoice_id', $id)->delete();
                // DELETE ROOT OTHER TRANSACTION
                other_transaction::where('type', 'sales invoice')->where('number', $pi->number)->delete();
                // FINALLY DELETE THE INVOICE
                $pi->delete();
            } else {
                if ($contact_id->is_limit == 1) {
                    $contact_id->update([
                        'current_limit_balance'         => $contact_id->current_limit_balance + $pi->balance_due,
                    ]);
                }
                // HAPUS BALANCE PER ITEM INVOICE
                $pi_details                         = sale_invoice_item::where('sale_invoice_id', $id)->get();
                foreach ($pi_details as $a) {
                    if ($cs->is_fifo == 1) {
                        product_fifo_out::where('sale_invoice_item_id', $a->id)->delete();
                    }
                    $default_product_account        = product::find($a->product_id);
                    if ($default_product_account->is_track == 1) {
                        // DEFAULT BUY ACCOUNT
                        $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('credit', 0)
                            ->where('coa_id', $default_product_account->buy_account)
                            ->first();
                        $ambil_avg_price_dari_coadetial->delete();
                        // DEFAULT INVENTORY ACCOUNT
                        $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('debit', 0)
                            ->where('coa_id', $default_product_account->default_inventory_account)
                            ->first();
                        $ambil_avg_price_dari_coadetial->delete();
                        // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                        warehouse_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('product_id', $a->product_id)
                            ->where('warehouse_id', $pi->warehouse_id)
                            ->delete();
                        // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                        $produk                     = product::find($a->product_id);
                        $qty                        = $a->qty;
                        //menyimpan jumlah perubahan pada produk
                        product::where('id', $a->product_id)->update([
                            'qty'                   => $produk->qty + $qty,
                        ]);
                    } else {
                        // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                        warehouse_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('product_id', $a->product_id)
                            ->where('warehouse_id', $pi->warehouse_id)
                            ->delete();
                        // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                        $produk                     = product::find($a->product_id);
                        $qty                        = $a->qty;
                        //menyimpan jumlah perubahan pada produk
                        product::where('id', $a->product_id)->update([
                            'qty'                   => $produk->qty + $qty,
                        ]);
                    }
                }
                // FINALLY DELETE THE COA DETAIL WITH DEBIT = 0
                coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('debit', 0)->delete();
                coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('credit', 0)->delete();
                sale_invoice_item::where('sale_invoice_id', $id)->delete();
                // DELETE ROOT OTHER TRANSACTION
                other_transaction::where('type', 'sales invoice')->where('number', $pi->number)->delete();
                // FINALLY DELETE THE INVOICE
                $pi->delete();
            }
            if ($cs->is_fifo == 1) {
                app(\App\Http\Controllers\PurchaseInvoiceController::class)->fifoAll();
                $a = response()->json(['fifo_success' => 'fifo_berhasil']);
                if ($a->getData()->fifo_success) {
                    //dd('of');
                    DB::commit();
                    return response()->json(['success' => 'Data is successfully deleted']);
                } else {
                    //dd('else');
                    DB::rollBack();
                    return response()->json(['errors' => 'Check log!']);
                }
            } else {
                DB::commit();
                return response()->json(['success' => 'Data is successfully deleted']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function cetak_pdf($id)
    {
        $pp                         = sale_invoice::find($id);
        $pp_item                    = sale_invoice_item::where('sale_invoice_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', 1)->first();
        $pdf = PDF::loadview('admin.sales.invoices.PrintPDF', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses_surabaya_sj($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_invoice::find($id);
        $pp_item                    = sale_invoice_item::where('sale_invoice_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.delivery.PrintPDF', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_1($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_invoice::find($id);
        $pp_item                    = sale_invoice_item::where('sale_invoice_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $logo                       = company_logo::where('company_id', $user->company_id)->latest()->first();
        $pdf = PDF::loadview('admin.sales.invoices.PrintPDF_1', compact(['pp', 'pp_item', 'today', 'company', 'logo']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_1_sj($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_invoice::find($id);
        $pp_item                    = sale_invoice_item::where('sale_invoice_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $logo                       = company_logo::where('company_id', $user->company_id)->latest()->first();
        $pdf = PDF::loadview('admin.sales.delivery.PrintPDF_1', compact(['pp', 'pp_item', 'today', 'company', 'logo']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_2($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_invoice::find($id);
        $pp_item                    = sale_invoice_item::where('sale_invoice_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $logo                       = company_logo::where('company_id', $user->company_id)->latest()->first();
        $pdf = PDF::loadview('admin.sales.invoices.PrintPDF_2', compact(['pp', 'pp_item', 'today', 'company', 'logo']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_2_sj($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_invoice::find($id);
        $pp_item                    = sale_invoice_item::where('sale_invoice_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $logo                       = company_logo::where('company_id', $user->company_id)->latest()->first();
        $pdf = PDF::loadview('admin.sales.delivery.PrintPDF_2', compact(['pp', 'pp_item', 'today', 'company', 'logo']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_fas($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_invoice::find($id);
        $pp_item                    = sale_invoice_item::where('sale_invoice_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.invoices.PrintPDF_FAS', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_fas_sj($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_invoice::find($id);
        $pp_item                    = sale_invoice_item::where('sale_invoice_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.delivery.PrintPDF_FAS', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_gg($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_invoice::find($id);
        $pp_item                    = sale_invoice_item::where('sale_invoice_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.invoices.PrintPDF_GG', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_gg_sj($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_invoice::find($id);
        $pp_item                    = sale_invoice_item::where('sale_invoice_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.delivery.PrintPDF_GG', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_invoice::find($id);
        $pp_item                    = sale_invoice_item::where('sale_invoice_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.invoices.PrintPDF_Sukses', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses_sj($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_invoice::find($id);
        $pp_item                    = sale_invoice_item::where('sale_invoice_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.delivery.PrintPDF_Sukses', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses_surabaya($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_invoice::find($id);
        $pp_item                    = sale_invoice_item::where('sale_invoice_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.invoices.PrintPDF_Sukses_Surabaya', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
