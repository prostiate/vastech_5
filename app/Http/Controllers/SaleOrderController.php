<?php

namespace App\Http\Controllers;

use App\Model\closing_book\closing_book;
use App\Model\company\company_logo;
use App\Model\sales\sale_order;
use App\Model\sales\sale_order_item;
use App\Model\contact\contact;
use App\Model\other\other_term;
use App\Model\product\product;
use App\Model\other\other_unit;
use App\Model\other\other_tax;
use App\Model\other\other_transaction;
use App\Model\warehouse\warehouse;
use App\Model\company\company_setting;
use App\Model\product\product_discount_item;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Model\sales\sale_invoice;
use App\Model\sales\sale_delivery;
use PDF;
use App\Model\sales\sale_quote;
use App\Model\sales\sale_quote_item;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class SaleOrderController extends Controller
{
    public function select_product()
    {
        $user               = User::find(Auth::id());
        if ($user->getRoleNames()->first() == 'GT' or $user->getRoleNames()->first() == 'MT' or $user->getRoleNames()->first() == 'WS') {
            if (request()->ajax()) {
                $page = Input::get('page');
                $resultCount = 10;

                $offset = ($page - 1) * $resultCount;

                $breeds = product::where('name', 'LIKE',  '%' . Input::get("term") . '%')->orWhere('code', 'LIKE',  '%' . Input::get("term") . '%')
                    ->where('is_sell', 1)
                    ->where('sales_type', $user->getRoleNames()->first())
                    //->where('is_bundle', 0)
                    ->orderBy('name')
                    ->skip($offset)
                    ->take($resultCount)
                    ->get(['id', DB::raw('name as text'), 'code', 'other_unit_id', 'desc', 'sell_price', 'sell_tax', 'is_lock_sales', 'qty']);

                $count = product::where('is_sell', 1)->count();
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

                $breeds = product::where('name', 'LIKE',  '%' . Input::get("term") . '%')->orWhere('code', 'LIKE',  '%' . Input::get("term") . '%')
                    ->where('is_sell', 1)
                    //->where('is_bundle', 0)
                    ->orderBy('name')
                    ->skip($offset)
                    ->take($resultCount)
                    ->get(['id', DB::raw('name as text'), 'code', 'other_unit_id', 'desc', 'sell_price', 'sell_tax', 'is_lock_sales', 'qty']);

                $count = product::where('is_sell', 1)->count();
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

    public function closeOrder($id)
    {
        DB::beginTransaction();
        try {
            $ambilheader            = sale_order::find($id);
            other_transaction::where('type', 'sales order')->where('number', $ambilheader->number)->update([
                'status'  => 2,
            ]);

            sale_order::find($id)->update([
                'status'  => 2,
            ]);
            DB::commit();
            return response()->json(['success' => 'Data is successfully closed', 'id' => $id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function select_contact_employee()
    {
        if (request()->ajax()) {
            $page = Input::get('page');
            $resultCount = 10;

            $offset = ($page - 1) * $resultCount;

            $breeds = contact::where('display_name', 'LIKE',  '%' . Input::get("term") . '%')
                ->where('type_employee', 1)
                //->where('is_bundle', 0)
                ->orderBy('display_name')
                ->skip($offset)
                ->take($resultCount)
                ->get(['id', DB::raw('display_name as text'), 'term_id', 'email']);

            $count = contact::where('type_employee', 1)->count();
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

    public function index()
    {
        $user                       = User::find(Auth::id());
        $open_po                    = sale_order::whereIn('status', [1, 4])->count();
        $payment_last               = sale_order::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->count();
        $overdue                    = sale_order::where('status', 5)->count();
        $open_po_total              = sale_order::whereIn('status', [1, 4])->sum('grandtotal');
        $payment_last_total         = sale_order::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->sum('grandtotal');
        $overdue_total              = sale_order::where('status', 5)->sum('grandtotal');
        if ($user->getRoleNames()->first() == 'GT' or $user->getRoleNames()->first() == 'MT' or $user->getRoleNames()->first() == 'WS') {
            if (request()->ajax()) {
                return datatables()->of(sale_order::with('sale_order_item', 'contact', 'status')->whereHas('contact', function ($query) use ($user) {
                    $query->where('sales_type', $user->getRoleNames()->first());
                })->get())
                    ->make(true);
            }
        } else {
            if (request()->ajax()) {
                return datatables()->of(sale_order::with('sale_order_item', 'contact', 'status')->get())
                    ->make(true);
            }
        }

        return view('admin.sales.order.index', compact(['user', 'open_po', 'payment_last', 'overdue', 'open_po_total', 'payment_last_total', 'overdue_total']));
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
            $number             = sale_order::latest()->first();
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
                    $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SO';
                } else {
                    $check_number   = sale_order::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SO';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SO';
                    }
                }
            } else {
                $check_number   = sale_order::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                if ($check_number) {
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SO';
                } else {
                    $number1    = 10001;
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SO';
                }
            }
        } else {
            $number             = sale_order::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }

        return view('admin.sales.order.create', compact([
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
            $number             = sale_order::latest()->first();
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
                    $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SO';
                } else {
                    $check_number   = sale_order::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SO';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SO';
                    }
                }
            } else {
                $check_number   = sale_order::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                if ($check_number) {
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SO';
                } else {
                    $number1    = 10001;
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SO';
                }
            }
        } else {
            $number             = sale_order::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }

        return view('admin.sales.order.createFromQuote', compact([
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

    public function createRequestSukses()
    {
        $vendors                = contact::where('type_customer', true)->get();
        $warehouses             = warehouse::where('id', '>', 1)->get();
        $terms                  = other_term::all();
        $products               = product::where('is_sell', 1)->get();
        $units                  = other_unit::all();
        $today                  = Carbon::today()->toDateString();
        $todaytambahtiga        = Carbon::today()->addDays(30)->toDateString();
        $taxes                  = other_tax::all();
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = sale_order::latest()->first();
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
                    $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SO';
                } else {
                    $check_number   = sale_order::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SO';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SO';
                    }
                }
            } else {
                $check_number   = sale_order::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                if ($check_number) {
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SO';
                } else {
                    $number1    = 10001;
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SO';
                }
            }
        } else {
            $number             = sale_order::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }

        return view('admin.request.sukses.sales.order.create', compact([
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

    public function store(Request $request)
    {
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = sale_order::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                $check_number   = sale_order::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SO';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SO';
                }
            } else {
                $check_number   = sale_order::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SO';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SO';
                }
            }
        } else {
            $number             = sale_order::max('number');
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
            $check_closing_book             = closing_book::latest()->first();
            if ($check_closing_book) {
                $get_closing_book_date          = $check_closing_book->date;
                $get_request_date               = $request->trans_date;
                if ($get_request_date->greaterThanOrEqualTo($get_closing_book_date)) {
                    DB::rollBack();
                    return response()->json(['errors' => 'Transaction date cannot be less than closing book!']); // BENERIN LAGI INI KALIMATNYA
                }
            }
            $check_limit_balance            = contact::find($request->vendor_name);
            if ($check_limit_balance->is_limit == 1) {
                if ($check_limit_balance->current_limit_balance < $request->balance) {
                    DB::rollBack();
                    return response()->json(['errors' => 'Cannot make a transaction because the balance has exceeded the limit!<br><br>
                    Total Limit Balance = ' . number_format($check_limit_balance->limit_balance, 2, ',', '.') . '<br>
                    Total Current Limit Balance = ' . number_format($check_limit_balance->current_limit_balance, 2, ',', '.')]);
                }
            }
            $subtotal_header_other          = 0;
            $taxtotal_header_other          = 0;
            $grandtotal_header_other        = 0;

            $transactions = other_transaction::create([
                'company_id'                => $user->company_id,
                'user_id'                   => Auth::id(),
                'transaction_date'          => $request->get('trans_date'),
                'number'                    => $trans_no,
                'number_complete'           => 'Sales Order #' . $trans_no,
                'type'                      => 'sales order',
                'memo'                      => $request->get('memo'),
                'contact'                   => $request->get('vendor_name'),
                'due_date'                  => $request->get('due_date'),
                'status'                    => 1,
                'balance_due'               => $request->get('balance'),
                'total'                     => $request->get('balance'),
            ]);

            $po = new sale_order([
                'company_id'                => $user->company_id,
                'user_id'                   => Auth::id(),
                'number'                    => $trans_no,
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
                'status'                    => 1,
            ]);

            $transactions->sale_order()->save($po);
            other_transaction::find($transactions->id)->update([
                'ref_id'                    => $po->id,
            ]);
            $total_qty                      = 0;
            foreach ($request->products as $i => $keys) {
                $check_discount             = product::find($request->products[$i]);
                $get_discount_item          = product_discount_item::where('product_id', $request->products[$i])->get();
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

                $pp[$i]                     = new sale_order_item([
                    'product_id'            => $request->products[$i],
                    'desc'                  => $request->desc[$i],
                    'qty'                   => $request->qty[$i],
                    'qty_remaining'         => $request->qty[$i],
                    'unit_id'               => $request->units[$i],
                    'unit_price'            => $unit_price,
                    'tax_id'                => $request->tax[$i],
                    'amountsub'             => $subtotal,
                    'amounttax'             => $taxtotal,
                    'amountgrand'           => $total,
                    'amount'                => $subtotal,
                ]);
                $total_qty                  = $total_qty + $request->qty[$i];

                $po->sale_order_item()->save($pp[$i]);
            };

            other_transaction::find($transactions->id)->update([
                'balance_due'               => $grandtotal_header_other,
                'total'                     => $grandtotal_header_other,
            ]);

            sale_order::find($po->id)->update([
                'subtotal'                  => $subtotal_header_other,
                'taxtotal'                  => $taxtotal_header_other,
                'balance_due'               => $grandtotal_header_other,
                'grandtotal'                => $grandtotal_header_other,
                'total_qty'                 => $total_qty,
            ]);
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $po->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function storeFromQuote(Request $request)
    {
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = sale_order::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                $check_number   = sale_order::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SO';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SO';
                }
            } else {
                $check_number   = sale_order::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SO';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SO';
                }
            }
        } else {
            $number             = sale_order::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }
        $rules = array(
            'vendor_name'           => 'required',
            'term'                  => 'required',
            'trans_date'            => 'required',
            'due_date'              => 'required',
            'warehouse'             => 'required',
            'products'              => 'required|array|min:1',
            'products.*'            => 'required',
            'qty'                   => 'required|array|min:1',
            'qty.*'                 => 'required',
            'units'                 => 'required|array|min:1',
            'units.*'               => 'required',
            'unit_price'            => 'required|array|min:1',
            'unit_price.*'          => 'required',
            'tax'                   => 'required|array|min:1',
            'tax.*'                 => 'required',
            'total_price'           => 'required|array|min:1',
            'total_price.*'         => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $check_limit_balance    = contact::find($request->vendor_name);
            if ($check_limit_balance->is_limit == 1) {
                if ($check_limit_balance->current_limit_balance < $request->balance) {
                    DB::rollBack();
                    return response()->json(['errors' => 'Cannot make a transaction because the balance has exceeded the limit!<br><br>
                    Total Limit Balance = ' . number_format($check_limit_balance->limit_balance, 2, ',', '.') . '<br>
                    Total Current Limit Balance = ' . number_format($check_limit_balance->current_limit_balance, 2, ',', '.')]);
                }
            }

            $subtotal_header_other      = 0;
            $taxtotal_header_other      = 0;
            $grandtotal_header_other    = 0;
            // AMBIL ID SI SALES QUOTE
            $id                     = $request->hidden_id;
            // AMBIL NUMBER SI SALES QUOTE
            $id_number              = $request->hidden_id_number;
            // UPDATE STATUS ON SALES QUOTE & OTHER TRANSACTION QUOTE'S
            $updatepdstatus         = array(
                'status'            => 2,
            );
            sale_quote::where('number', $id_number)->update($updatepdstatus);
            other_transaction::where('number', $id_number)->where('type', 'sales quote')->update($updatepdstatus);
            // CREATE OTHER TRANSACTION ORDER
            $transactions           = other_transaction::create([
                'company_id'        => $user->company_id,
                'user_id'           => Auth::id(),
                'transaction_date'  => $request->get('trans_date'),
                'number'            => $trans_no,
                'number_complete'   => 'Sales Order #' . $trans_no,
                'type'              => 'sales order',
                'memo'              => $request->get('memo'),
                'contact'           => $request->get('vendor_name'),
                'due_date'          => $request->get('due_date'),
                'status'            => 1,
                'balance_due'       => $request->get('balance'),
                'total'             => $request->get('balance'),
            ]);
            // CREATE SALES ORDER HEADER
            $po                     = new sale_order([
                'company_id'        => $user->company_id,
                'user_id'           => Auth::id(),
                'number'            => $trans_no,
                'contact_id'        => $request->get('vendor_name'),
                'email'             => $request->get('email'),
                'address'           => $request->get('vendor_address'),
                'transaction_date'  => $request->get('trans_date'),
                'due_date'          => $request->get('due_date'),
                'term_id'           => $request->get('term'),
                'vendor_ref_no'     => $request->get('vendor_no'),
                'warehouse_id'      => $request->get('warehouse'),
                'subtotal'          => $request->get('subtotal'),
                'taxtotal'          => $request->get('taxtotal'),
                'balance_due'       => $request->get('balance'),
                'grandtotal'        => $request->get('balance'),
                'message'           => $request->get('message'),
                'memo'              => $request->get('memo'),
                'status'            => 1,
                'selected_sq_id'    => $id,
                'transaction_no_sq' => $id_number,
            ]);
            $transactions->sale_order()->save($po);
            other_transaction::find($transactions->id)->update([
                'ref_id'            => $po->id,
            ]);
            $total_qty = 0;
            // CREATE SALES ORDER DETAIL
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

                $pp[$i] = new sale_order_item([
                    'product_id'    => $request->products2[$i],
                    'desc'          => $request->desc[$i],
                    'qty'           => $request->qty[$i],
                    'qty_remaining' => $request->qty[$i],
                    'unit_id'       => $request->units[$i],
                    'unit_price'    => $unit_price,
                    'tax_id'        => $request->tax[$i],
                    'amountsub'     => $subtotal,
                    'amounttax'     => $taxtotal,
                    'amountgrand'   => $total,
                    'amount'        => $subtotal,
                ]);
                $total_qty          = $total_qty + $request->qty[$i];

                $po->sale_order_item()->save($pp[$i]);
            };

            other_transaction::find($transactions->id)->update([
                'balance_due'       => $grandtotal_header_other,
                'total'             => $grandtotal_header_other,
            ]);

            sale_order::find($po->id)->update([
                'subtotal'          => $subtotal_header_other,
                'taxtotal'          => $taxtotal_header_other,
                'balance_due'       => $grandtotal_header_other,
                'grandtotal'        => $grandtotal_header_other,
                'total_qty'         => $total_qty,
            ]);

            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $po->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function storeRequestSukses(Request $request)
    {
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = sale_order::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                $check_number   = sale_order::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SO';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SO';
                }
            } else {
                $check_number   = sale_order::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SO';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SO';
                }
            }
        } else {
            $number             = sale_order::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }
        $rules = array(
            'vendor_name'   => 'required',
            'term'          => 'required',
            'trans_date'    => 'required',
            'due_date'      => 'required',
            'marketting'    => 'required',
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
            $check_limit_balance    = contact::find($request->vendor_name);
            if ($check_limit_balance->is_limit == 1) {
                if ($check_limit_balance->current_limit_balance < $request->balance) {
                    DB::rollBack();
                    return response()->json(['errors' => 'Cannot make a transaction because the balance has exceeded the limit!<br><br>
                    Total Limit Balance = ' . number_format($check_limit_balance->limit_balance, 2, ',', '.') . '<br>
                    Total Current Limit Balance = ' . number_format($check_limit_balance->current_limit_balance, 2, ',', '.')]);
                }
            }

            $transactions = other_transaction::create([
                'company_id'        => $user->company_id,
                'user_id'           => Auth::id(),
                'transaction_date'          => $request->get('trans_date'),
                'number'                    => $trans_no,
                'number_complete'           => 'Sales Order #' . $trans_no,
                'type'                      => 'sales order',
                'memo'                      => $request->get('memo'),
                'contact'                   => $request->get('vendor_name'),
                'due_date'                  => $request->get('due_date'),
                'status'                    => 1,
                'balance_due'               => $request->get('balance'),
                'total'                     => $request->get('balance'),
            ]);

            if ($request->warehouse == null) {
                $is_warehouse               = 1;
            } else {
                $is_warehouse               = $request->warehouse;
            }
            if ($request->marketting == null) {
                $is_marketting              = 0;
                $marketting                 = null;
            } else {
                $is_marketting              = 1;
                $marketting                 = $request->marketting;
            }

            $po = new sale_order([
                'company_id'        => $user->company_id,
                'user_id'           => Auth::id(),
                'number'                    => $trans_no,
                'contact_id'                => $request->get('vendor_name'),
                'email'                     => $request->get('email'),
                'address'                   => $request->get('vendor_address'),
                'transaction_date'          => $request->get('trans_date'),
                'due_date'                  => $request->get('due_date'),
                'term_id'                   => $request->get('term'),
                'vendor_ref_no'             => $request->get('vendor_no'),
                'warehouse_id'              => $is_warehouse,
                'is_marketting'             => $is_marketting,
                'marketting'                => $marketting,
                'subtotal'                  => $request->get('subtotal'),
                'taxtotal'                  => $request->get('taxtotal'),
                'balance_due'               => $request->get('balance'),
                'grandtotal'                => $request->get('balance'),
                'message'                   => $request->get('message'),
                'memo'                      => $request->get('memo'),
                'status'                    => 1,
            ]);

            $transactions->sale_order()->save($po);
            other_transaction::find($transactions->id)->update([
                'ref_id'                    => $po->id,
            ]);
            $total_qty = 0;
            foreach ($request->products as $i => $keys) {
                $pp[$i]                     = new sale_order_item([
                    'product_id'            => $request->products[$i],
                    'desc'                  => $request->desc[$i],
                    'qty'                   => $request->qty[$i],
                    'qty_remaining'         => $request->qty[$i],
                    'unit_id'               => $request->units[$i],
                    'harga_nota'            => $request->harga_nota[$i],
                    'unit_price'            => $request->unit_price[$i],
                    'tax_id'                => $request->tax[$i],
                    'amountsub'             => $request->total_price_sub[$i],
                    'amounttax'             => $request->total_price_tax[$i],
                    'amountgrand'           => $request->total_price_grand[$i],
                    'amount'                => $request->total_price[$i],
                ]);
                $total_qty                  = $total_qty + $request->qty[$i];

                $po->sale_order_item()->save($pp[$i]);
            };

            sale_order::find($po->id)->update([
                'total_qty'                 => $total_qty,
            ]);
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $po->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $pi                     = sale_order::with(['contact', 'term', 'warehouse', 'product'])->find($id);
        $terms                  = other_term::all();
        $products               = sale_order_item::where('sale_order_id', $id)->with('product')->get();
        $units                  = other_unit::all();
        $today                  = Carbon::today();
        $allproducts            = product::all();
        $pi_history             = sale_invoice::where('selected_so_id', $id)->get();
        $check_pi_history       = sale_invoice::where('selected_so_id', $id)->first();
        $pd_history             = sale_delivery::where('selected_so_id', $id)->with('status')->get();
        $check_pd_history       = sale_delivery::where('selected_so_id', $id)->first();
        if ($pi->is_marketting == 0) {
            return view(
                'admin.sales.order.show',
                compact([
                    'pi', 'terms', 'products', 'units', 'today', 'allproducts', 'pi_history', 'pd_history', 'check_pi_history', 'check_pd_history'

                ])
            );
        } else {
            return view(
                'admin.request.sukses.sales.order.show',
                compact([
                    'pi', 'terms', 'products', 'units', 'today', 'allproducts', 'pi_history', 'pd_history', 'check_pi_history', 'check_pd_history'

                ])
            );
        }
    }

    public function edit($id)
    {
        $po                     = sale_order::find($id);
        if($po->status != 1){
            return redirect('/sales_order');
        }
        $po_item                = sale_order_item::where('sale_order_id', $id)->get();
        $vendors                = contact::where('type_customer', true)->get();
        $warehouses             = warehouse::all();
        $terms                  = other_term::all();
        $products               = product::all();
        $units                  = other_unit::all();
        $today                  = Carbon::today();
        $taxes                  = other_tax::all();
        if ($po->is_marketting == 0) {
            return view('admin.sales.order.edit', compact([
                'vendors',
                'warehouses',
                'terms',
                'products',
                'units',
                'taxes',
                'today',
                'po',
                'po_item'
            ]));
        } else {
            return view('admin.request.sukses.sales.order.edit', compact([
                'vendors',
                'warehouses',
                'terms',
                'products',
                'units',
                'taxes',
                'today',
                'po',
                'po_item'
            ]));
        }
    }

    public function update(Request $request)
    {
        $rules = array(
            'vendor_name'   => 'required',
            'term_date'     => 'required',
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
            $check_limit_balance    = contact::find($request->vendor_name2);
            if ($check_limit_balance->is_limit == 1) {
                if ($check_limit_balance->current_limit_balance < $request->balance) {
                    DB::rollBack();
                    return response()->json(['errors' => 'Cannot make a transaction because the balance has exceeded the limit!<br><br>
                    Total Limit Balance = ' . number_format($check_limit_balance->limit_balance, 2, ',', '.') . '<br>
                    Total Current Limit Balance = ' . number_format($check_limit_balance->current_limit_balance, 2, ',', '.')]);
                }
            }

            $id                                 = $request->hidden_id;
            $ambilheader                        = sale_order::find($id);
            $pp                                 = sale_order_item::where('sale_order_id', $id)->get();
            $get_ot                             = other_transaction::where('type', 'sales order')->where('number', $ambilheader->number)->first();
            $rp                                 = $request->products2;
            $subtotal_header_other              = 0;
            $taxtotal_header_other              = 0;
            $grandtotal_header_other            = 0;

            $get_ot->update([
                'transaction_date'              => $request->get('trans_date'),
                'contact'                       => $request->get('vendor_name2'),
                'memo'                          => $request->get('memo'),
                'due_date'                      => $request->get('due_date'),
                'balance_due'                   => $request->get('balance'),
                'total'                         => $request->get('balance'),
            ]);

            $ambilheader->update([
                'contact_id'                    => $request->get('vendor_name2'),
                'email'                         => $request->get('email'),
                'address'                       => $request->get('vendor_address'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'term_id'                       => $request->get('term_date'),
                'vendor_ref_no'                 => $request->get('vendor_no'),
                'warehouse_id'                  => $request->get('warehouse'),
                'message'                       => $request->get('message'),
                'memo'                          => $request->get('memo'),
                'subtotal'                      => $request->get('subtotal'),
                'taxtotal'                      => $request->get('taxtotal'),
                'balance_due'                   => $request->get('balance'),
                'grandtotal'                    => $request->get('balance'),
            ]);
            $total_qty = 0;
            sale_order_item::where('sale_order_id', $id)->delete();

            // CREATE SALES ORDER DETAIL
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

                $pp[$i]             = new sale_order_item([
                    'sale_order_id' => $id,
                    'product_id'    => $request->products2[$i],
                    'desc'          => $request->desc[$i],
                    'qty'           => $request->qty[$i],
                    'qty_remaining' => $request->qty[$i],
                    'unit_id'       => $request->units[$i],
                    'unit_price'    => $unit_price,
                    'tax_id'        => $request->tax[$i],
                    'amountsub'     => $subtotal,
                    'amounttax'     => $taxtotal,
                    'amountgrand'   => $total,
                    'amount'        => $subtotal,
                ]);
                $pp[$i]->save();
                $total_qty          = $total_qty + $request->qty[$i];
            };

            $get_ot->update([
                'balance_due'       => $grandtotal_header_other,
                'total'             => $grandtotal_header_other,
            ]);

            $ambilheader->update([
                'subtotal'          => $subtotal_header_other,
                'taxtotal'          => $taxtotal_header_other,
                'balance_due'       => $grandtotal_header_other,
                'grandtotal'        => $grandtotal_header_other,
                'total_qty'         => $total_qty,
            ]);

            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function updateRequestSukses(Request $request)
    {
        $rules = array(
            'vendor_name'   => 'required',
            'term_date'     => 'required',
            'trans_date'    => 'required',
            'due_date'      => 'required',
            'marketting2'   => 'required',
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
            $check_limit_balance    = contact::find($request->vendor_name2);
            if ($check_limit_balance->is_limit == 1) {
                if ($check_limit_balance->current_limit_balance < $request->balance) {
                    DB::rollBack();
                    return response()->json(['errors' => 'Cannot make a transaction because the balance has exceeded the limit!<br><br>
                    Total Limit Balance = ' . number_format($check_limit_balance->limit_balance, 2, ',', '.') . '<br>
                    Total Current Limit Balance = ' . number_format($check_limit_balance->current_limit_balance, 2, ',', '.')]);
                }
            }

            $id                                 = $request->hidden_id;
            $ambilheader    = sale_order::find($id);
            $pp                                 = sale_order_item::where('sale_order_id', $id)->get();
            $rp                                 = $request->products2;

            other_transaction::where('type', 'sales order')->where('number', $ambilheader->number)->update([
                'transaction_date'              => $request->get('trans_date'),
                'contact'                       => $request->get('vendor_name2'),
                'memo'                          => $request->get('memo'),
                'due_date'                      => $request->get('due_date'),
                'balance_due'                   => $request->get('balance'),
                'total'                         => $request->get('balance'),
            ]);

            if ($request->warehouse == null) {
                $is_warehouse               = 1;
            } else {
                $is_warehouse               = $request->warehouse;
            }
            if ($request->marketting2 == null) {
                $is_marketting              = 0;
                $marketting                 = null;
            } else {
                $is_marketting              = 1;
                $marketting                 = $request->marketting2;
            }

            sale_order::find($id)->update([
                'contact_id'                    => $request->get('vendor_name2'),
                'email'                         => $request->get('email'),
                'address'                       => $request->get('vendor_address'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'term_id'                       => $request->get('term_date'),
                'vendor_ref_no'                 => $request->get('vendor_no'),
                'warehouse_id'                  => $is_warehouse,
                'is_marketting'                 => $is_marketting,
                'marketting'                    => $marketting,
                'message'                       => $request->get('message'),
                'memo'                          => $request->get('memo'),
                'subtotal'                      => $request->get('subtotal'),
                'taxtotal'                      => $request->get('taxtotal'),
                'balance_due'                   => $request->get('balance'),
                'grandtotal'                    => $request->get('balance'),
            ]);
            $total_qty = 0;

            //UNTUK UPDATE DATA JIKA BANYAKNYA TETAP
            if (count($rp) == count($pp)) {
                foreach ($request->products2 as $i => $keys) {
                    $pp[$i]->update([
                        'product_id'            => $request->products2[$i],
                        'desc'                  => $request->desc[$i],
                        'qty'                   => $request->qty[$i],
                        'qty_remaining'         => $request->qty[$i],
                        'unit_id'               => $request->units[$i],
                        'harga_nota'            => $request->harga_nota[$i],
                        'unit_price'            => $request->unit_price[$i],
                        'tax_id'                => $request->tax[$i],
                        'amountsub'             => $request->total_price_sub[$i],
                        'amounttax'             => $request->total_price_tax[$i],
                        'amountgrand'           => $request->total_price_grand[$i],
                        'amount'                => $request->total_price[$i],
                    ]);
                    $total_qty                  = $total_qty + $request->qty[$i];
                }
            }
            //UNTUK UPDATE DATA JIKA BERTAMBAH
            else if (count($rp) >= count($pp)) {
                //UPDATE DATA SEBANYAK INDEX AWAL
                for ($i = 0; $i < count($pp); $i++) {
                    $pp[$i]->update([
                        'product_id'            => $request->products2[$i],
                        'desc'                  => $request->desc[$i],
                        'qty'                   => $request->qty[$i],
                        'qty_remaining'         => $request->qty[$i],
                        'unit_id'               => $request->units[$i],
                        'harga_nota'            => $request->harga_nota[$i],
                        'unit_price'            => $request->unit_price[$i],
                        'tax_id'                => $request->tax[$i],
                        'amountsub'             => $request->total_price_sub[$i],
                        'amounttax'             => $request->total_price_tax[$i],
                        'amountgrand'           => $request->total_price_grand[$i],
                        'amount'                => $request->total_price[$i],
                    ]);
                    $total_qty                  = $total_qty + $request->qty[$i];
                }
                //KEMUDIAN MEMBUAT DATA SEBANYAK INDEX BARU
                for ($i = count($pp); $i < count($rp); $i++) {
                    $ppo[$i] = sale_order_item::create([
                        'sale_order_id' => $id,
                        'product_id'            => $request->products2[$i],
                        'desc'                  => $request->desc[$i],
                        'qty'                   => $request->qty[$i],
                        'qty_remaining'         => $request->qty[$i],
                        'unit_id'               => $request->units[$i],
                        'harga_nota'            => $request->harga_nota[$i],
                        'unit_price'            => $request->unit_price[$i],
                        'tax_id'                => $request->tax[$i],
                        'amountsub'             => $request->total_price_sub[$i],
                        'amounttax'             => $request->total_price_tax[$i],
                        'amountgrand'           => $request->total_price_grand[$i],
                        'amount'                => $request->total_price[$i],
                    ]);
                    $total_qty                  = $total_qty + $request->qty[$i];
                };
            }
            //UNTUK UPDATA DATA JIKA BERKURANG
            else {
                //MENGUPDATE DATA BERDASAR BANYAKNYA INDEX
                foreach ($request->products2 as $i => $keys) {
                    $pp[$i]->update([
                        'product_id'            => $request->products2[$i],
                        'desc'                  => $request->desc[$i],
                        'qty'                   => $request->qty[$i],
                        'qty_remaining'         => $request->qty[$i],
                        'unit_id'               => $request->units[$i],
                        'harga_nota'            => $request->harga_nota[$i],
                        'unit_price'            => $request->unit_price[$i],
                        'tax_id'                => $request->tax[$i],
                        'amountsub'             => $request->total_price_sub[$i],
                        'amounttax'             => $request->total_price_tax[$i],
                        'amountgrand'           => $request->total_price_grand[$i],
                        'amount'                => $request->total_price[$i],
                    ]);
                    $total_qty                  = $total_qty + $request->qty[$i];
                }

                //KEMUDIAN MENGHAPUS DATA KARENA INDEX LEBIH BESAR 
                for ($i = count($rp); $i < count($pp); $i++) {
                    $pp[$i]->delete();
                };
            }

            sale_order::find($id)->update([
                'total_qty'                     => $total_qty,
            ]);
            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
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
            $so                         = sale_order::find($id);
            if ($so->selected_sq_id) {
                // DELETE STATUS ON SALES QUOTE & OTHER TRANSACTION QUOTE'S
                $updatepdstatus         = array(
                    'status'            => 1,
                );
                sale_quote::where('number', $so->sale_quote->number)->update($updatepdstatus);
                other_transaction::where('number', $so->sale_quote->number)->where('type', 'sales quote')->update($updatepdstatus);
                // DELETE PUNYA SI SLAES ORDER
                other_transaction::where('type', 'sales order')->where('number', $so->number)->delete();
                sale_order_item::where('sale_order_id', $id)->delete();
                $so->delete();
            } else {
                other_transaction::where('type', 'sales order')->where('number', $so->number)->delete();
                sale_order_item::where('sale_order_id', $id)->delete();
                $so->delete();
            }
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function cetak_pdf_1($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_order::find($id);
        $pp_item                    = sale_order_item::where('sale_order_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $logo                       = company_logo::where('company_id', $user->company_id)->latest()->first();
        $pdf = PDF::loadview('admin.sales.order.PrintPDF_1', compact(['pp', 'pp_item', 'today', 'company', 'logo']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_2($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_order::find($id);
        $pp_item                    = sale_order_item::where('sale_order_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $logo                       = company_logo::where('company_id', $user->company_id)->latest()->first();
        $pdf = PDF::loadview('admin.sales.order.PrintPDF_2', compact(['pp', 'pp_item', 'today', 'company', 'logo']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_fas($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_order::find($id);
        $pp_item                    = sale_order_item::where('sale_order_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.order.PrintPDF_FAS', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_gg($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_order::find($id);
        $pp_item                    = sale_order_item::where('sale_order_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.order.PrintPDF_GG', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_order::find($id);
        $pp_item                    = sale_order_item::where('sale_order_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.order.PrintPDF_Sukses', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses_surabaya($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_order::find($id);
        $pp_item                    = sale_order_item::where('sale_order_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.order.PrintPDF_Sukses_Surabaya', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
