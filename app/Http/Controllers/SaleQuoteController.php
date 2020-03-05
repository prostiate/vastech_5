<?php

namespace App\Http\Controllers;

use App\Model\company\company_logo;
use App\Model\sales\sale_quote;
use App\Model\contact\contact;
use App\Model\company\company_setting;
use App\Model\product\product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Model\warehouse\warehouse;
use Validator;
use App\Model\other\other_term;
use App\Model\other\other_unit;
use App\Model\other\other_tax;
use App\Model\other\other_transaction;
use App\Model\product\product_discount_item;
use App\Model\sales\sale_quote_item;
use App\Model\sales\sale_order;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use PDF;

class SaleQuoteController extends Controller
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

    public function index()
    {
        $user                       = User::find(Auth::id());
        $open_po                    = sale_quote::whereIn('status', [1, 4])->count();
        $payment_last               = sale_quote::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->count();
        $overdue                    = sale_quote::where('status', 5)->count();
        $open_po_total              = sale_quote::whereIn('status', [1, 4])->sum('grandtotal');
        $payment_last_total         = sale_quote::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->sum('grandtotal');
        $overdue_total              = sale_quote::where('status', 5)->sum('grandtotal');
        if ($user->getRoleNames()->first() == 'GT' or $user->getRoleNames()->first() == 'MT' or $user->getRoleNames()->first() == 'WS') {
            if (request()->ajax()) {
                return datatables()
                    ->of(sale_quote::with('sale_quote_item', 'contact', 'status')->whereHas('contact', function ($query) use ($user) {
                        $query->where('sales_type', $user->getRoleNames()->first());
                    })->get())
                    ->make(true);
            }
        } else {
            if (request()->ajax()) {
                return datatables()
                    ->of(sale_quote::with('sale_quote_item', 'contact', 'status')->get())
                    ->make(true);
            }
        }

        return view('admin.sales.quote.index', compact(['user', 'open_po', 'payment_last', 'overdue', 'open_po_total', 'payment_last_total', 'overdue_total']));
    }

    public function create()
    {
        $vendors                = contact::where('type_vendor', true)->get();
        $warehouses             = warehouse::where('id', '>', 0)->get();
        $terms                  = other_term::all();
        $products               = product::all();
        $units                  = other_unit::all();
        $today                  = Carbon::today()->toDateString();
        $todaytambahtiga        = Carbon::today()->addDays(30)->toDateString();
        $taxes                  = other_tax::all();
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = sale_quote::latest()->first();
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
                    $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SQ';
                } else {
                    $check_number   = sale_quote::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SQ';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SQ';
                    }
                }
            } else {
                $check_number   = sale_quote::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                if ($check_number) {
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SQ';
                } else {
                    $number1    = 10001;
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SQ';
                }
            }
        } else {
            $number             = sale_quote::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }

        return view('admin.sales.quote.create', compact([
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
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            if (isset($number)) {
                $check_number   = sale_quote::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SQ';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SQ';
                }
            } else {
                $check_number   = sale_quote::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SQ';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SQ';
                }
            }
        } else {
            $number             = sale_quote::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }
        $rules = array(
            'vendor_name'   => 'required',
            'trans_date'    => 'required',
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
            $subtotal_header_other      = 0;
            $taxtotal_header_other      = 0;
            $grandtotal_header_other    = 0;

            $transactions = other_transaction::create([
                'company_id'        => $user->company_id,
                'user_id'           => Auth::id(),
                'transaction_date'  => $request->get('trans_date'),
                'number'            => $trans_no,
                'number_complete'   => 'Sales Quote #' . $trans_no,
                'type'              => 'sales quote',
                'memo'              => $request->get('memo'),
                'contact'           => $request->get('vendor_name'),
                'due_date'          => $request->get('due_date'),
                'status'            => 1,
                'balance_due'       => $request->get('balance'),
                'total'             => $request->get('balance'),
            ]);

            $po = new sale_quote([
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
                'subtotal'          => $request->get('subtotal'),
                'taxtotal'          => $request->get('taxtotal'),
                'balance_due'       => $request->get('balance'),
                'grandtotal'        => $request->get('balance'),
                'message'           => $request->get('message'),
                'memo'              => $request->get('memo'),
                'status'            => 1,
            ]);

            $transactions->sale_quote()->save($po);
            other_transaction::find($transactions->id)->update([
                'ref_id'            => $po->id,
            ]);

            foreach ($request->products as $i => $keys) {
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

                $pp[$i]             = new sale_quote_item([
                    'product_id'    => $request->products[$i],
                    'desc'          => $request->desc[$i],
                    'qty'           => $request->qty[$i],
                    'unit_id'       => $request->units[$i],
                    /*'unit_price'    => $request->unit_price[$i],*/
                    'unit_price'    => $unit_price,
                    'tax_id'        => $request->tax[$i],
                    'amountsub'     => $subtotal,
                    'amounttax'     => $taxtotal,
                    'amountgrand'   => $total,
                    'amount'        => $subtotal,
                ]);

                $po->sale_quote_item()->save($pp[$i]);
            };

            other_transaction::find($transactions->id)->update([
                'balance_due'       => $grandtotal_header_other,
                'total'             => $grandtotal_header_other,
            ]);

            sale_quote::find($po->id)->update([
                'subtotal'          => $subtotal_header_other,
                'taxtotal'          => $taxtotal_header_other,
                'balance_due'       => $grandtotal_header_other,
                'grandtotal'        => $grandtotal_header_other,
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
        $pi             = sale_quote::with(['contact', 'term', 'warehouse', 'product'])->find($id);
        $terms          = other_term::all();
        $products       = sale_quote_item::where('sale_quote_id', $id)->get();
        $units          = other_unit::all();
        $today          = Carbon::today();
        $pi_history     = sale_order::where('selected_sq_id', $id)->get();
        //$pd_history     = sale_delivery::where('selected_po_id', $id)->with('status')->get();

        return view(
            'admin.sales.quote.show',
            compact([
                'pi', 'terms', 'products', 'units', 'today', 'pi_history'

            ])
        );
    }

    public function edit(sale_quote $sale_quote, $id)
    {
        $sq             = sale_quote::find($id);
        $sq_item        = sale_quote_item::where('sale_quote_id', $id)->get();
        $vendors        = contact::where('type_customer', true)->get();
        $terms          = other_term::all();
        $products       = product::all();
        $units          = other_unit::all();
        $today          = Carbon::today();
        $taxes          = other_tax::all();

        return view('admin.sales.quote.edit', compact(['vendors', 'terms', 'products', 'units', 'taxes', 'today', 'sq', 'sq_item']));
    }

    public function update(Request $request)
    {
        $rules = array(
            'vendor_name'   => 'required',
            'term'          => 'required',
            'trans_date'    => 'required',
            'due_date'      => 'required',
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
            $idd                                = sale_quote::find($id);
            $get_ot                             = other_transaction::where('type', 'sales quote')->where('number', $idd->number)->first();
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

            $idd->update([
                'contact_id'                    => $request->get('vendor_name2'),
                'email'                         => $request->get('email'),
                'address'                       => $request->get('vendor_address'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'term_id'                       => $request->get('term'),
                'vendor_ref_no'                 => $request->get('vendor_no'),
                'message'                       => $request->get('message'),
                'memo'                          => $request->get('memo'),
                'subtotal'                      => $request->get('subtotal'),
                'taxtotal'                      => $request->get('taxtotal'),
                'balance_due'                   => $request->get('balance'),
                'grandtotal'                    => $request->get('balance'),
            ]);

            sale_quote_item::where('sale_quote_id', $id)->delete();

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

                $pp[$i] = new sale_quote_item([
                    'sale_quote_id'             => $id,
                    'product_id'                => $request->products2[$i],
                    'desc'                      => $request->desc[$i],
                    'qty'                       => $request->qty[$i],
                    'unit_id'                   => $request->units[$i],
                    'unit_price'                => $request->unit_price[$i],
                    'tax_id'                    => $request->tax[$i],
                    'amountsub'                 => $request->total_price_sub[$i],
                    'amounttax'                 => $request->total_price_tax[$i],
                    'amountgrand'               => $request->total_price_grand[$i],
                    'amount'                    => $request->total_price[$i],
                ]);
                $pp[$i]->save();
            };

            $get_ot->update([
                'balance_due'       => $grandtotal_header_other,
                'total'             => $grandtotal_header_other,
            ]);

            $idd->update([
                'subtotal'          => $subtotal_header_other,
                'taxtotal'          => $taxtotal_header_other,
                'balance_due'       => $grandtotal_header_other,
                'grandtotal'        => $grandtotal_header_other,
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
        DB::beginTransaction();
        try {
            $pq = sale_quote::find($id);
            other_transaction::where('type', 'sales quote')->where('number', $pq->number)->delete();
            sale_quote_item::where('sale_quote_id', $id)->delete();
            $pq->delete();
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
        $pp                         = sale_quote::find($id);
        $pp_item                    = sale_quote_item::where('sale_quote_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $logo                       = company_logo::where('company_id', $user->company_id)->latest()->first();
        $pdf = PDF::loadview('admin.sales.quote.PrintPDF_1', compact(['pp', 'pp_item', 'today', 'company', 'logo']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_2($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_quote::find($id);
        $pp_item                    = sale_quote_item::where('sale_quote_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $logo                       = company_logo::where('company_id', $user->company_id)->latest()->first();
        $pdf = PDF::loadview('admin.sales.quote.PrintPDF_2', compact(['pp', 'pp_item', 'today', 'company', 'logo']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_fas($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_quote::find($id);
        $pp_item                    = sale_quote_item::where('sale_quote_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.quote.PrintPDF_FAS', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_gg($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_quote::find($id);
        $pp_item                    = sale_quote_item::where('sale_quote_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.quote.PrintPDF_GG', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_quote::find($id);
        $pp_item                    = sale_quote_item::where('sale_quote_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.quote.PrintPDF_Sukses', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses_surabaya($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_quote::find($id);
        $pp_item                    = sale_quote_item::where('sale_quote_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.quote.PrintPDF_Sukses_Surabaya', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
