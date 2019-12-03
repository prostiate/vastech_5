<?php

namespace App\Http\Controllers;

use App\sale_invoice;
use App\sale_invoice_item;
use App\sale_delivery;
use App\sale_delivery_item;
use App\contact;
use App\warehouse;
use App\product;
use App\other_term;
use App\other_unit;
use App\other_tax;
use App\company_setting;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\coa_detail;
use App\default_account;
use App\warehouse_detail;
use Validator;
use App\other_transaction;
use App\coa;
use App\product_bundle_cost;
use App\sale_invoice_cost;
use App\sale_payment;
use App\sale_payment_item;
use PDF;
use App\sale_quote;
use App\sale_quote_item;
use App\sale_order;
use App\sale_order_item;
use App\sale_return;
use App\spk;
use App\spk_item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class SaleInvoiceController extends Controller
{
    public function select_product()
    {
        if (request()->ajax()) {
            $page = Input::get('page');
            $resultCount = 10;

            $offset = ($page - 1) * $resultCount;

            $breeds = product::where('name', 'LIKE',  '%' . Input::get("term") . '%')
                ->where('is_sell', 1)
                //->where('is_bundle', 0)
                ->orderBy('name')
                ->skip($offset)
                ->take($resultCount)
                ->get(['id', DB::raw('name as text'), 'other_unit_id', 'desc', 'sell_price', 'sell_tax']);

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

    public function select_contact()
    {
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
                ->get(['id', DB::raw('display_name as text'), 'term_id', 'email']);

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

    public function index()
    {
        $open_po            = sale_invoice::whereIn('status', [1, 4])->count();
        $payment_last       = sale_invoice::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->count();
        $overdue            = sale_invoice::where('status', 5)->count();
        $open_po_total            = sale_invoice::whereIn('status', [1, 4])->sum('grandtotal');
        $payment_last_total       = sale_invoice::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->sum('grandtotal');
        $overdue_total            = sale_invoice::where('status', 5)->sum('grandtotal');
        if (request()->ajax()) {
            //return datatables()->of(Product::all())
            return datatables()->of(sale_invoice::with('sale_invoice_item', 'contact', 'status')->get())
                /*->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                    return $button;
                })
                ->rawColumns(['action'])*/
                ->make(true);
        }

        return view('admin.sales.invoices.index', compact(['open_po', 'payment_last', 'overdue', 'open_po_total', 'payment_last_total', 'overdue_total']));
    }

    public function create()
    {
        $vendors            = contact::where('type_customer', true)->get();
        $warehouses         = warehouse::where('id', '>', 0)->get();
        $terms              = other_term::all();
        $products           = product::where('is_sell', 1)->get();
        $units              = other_unit::all();
        $today              = Carbon::today()->toDateString();
        $todaytambahtiga    = Carbon::today()->addDays(30)->toDateString();
        $taxes              = other_tax::all();
        $number             = sale_invoice::max('number');
        /*if ($number != null) {
            $misahm             = explode("/", $number);
            $misahy             = explode(".", $misahm[1]);
        }
        if (isset($misahy[1]) == 0) {
            $misahy[1]      = 10000;
        }
        $number1                    = $misahy[1] + 1;
        $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;*/
        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;

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
        $vendors            = contact::where('type_customer', true)->get();
        $warehouses         = warehouse::where('id', '>', 0)->get();
        $terms              = other_term::all();
        $products           = product::where('is_sell', 1)->get();
        $units              = other_unit::all();
        $today              = Carbon::today()->toDateString();
        $todaytambahtiga    = Carbon::today()->addDays(30)->toDateString();
        $taxes              = other_tax::all();
        $number             = sale_invoice::max('number');
        /*if ($number != null) {
            $misahm             = explode("/", $number);
            $misahy             = explode(".", $misahm[1]);
        }
        if (isset($misahy[1]) == 0) {
            $misahy[1]      = 10000;
        }
        $number1                    = $misahy[1] + 1;
        $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;*/
        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;

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
        $check              = sale_invoice::where('selected_sd_id', $id)->latest()->first();
        $po                 = sale_delivery::find($id);
        $po_item            = sale_delivery_item::where('sale_delivery_id', $id)->get();
        $today              = Carbon::today()->toDateString();
        $number             = sale_invoice::max('number');
        $terms              = other_term::all();
        /*if ($number != null) {
            $misahm             = explode("/", $number);
            $misahy             = explode(".", $misahm[1]);
        }
        if (isset($misahy[1]) == 0) {
            $misahy[1]      = 10000;
        }
        $number1                    = $misahy[1] + 1;
        $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;*/
        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;

        return view('admin.sales.invoices.createFromDelivery', compact(['today', 'trans_no', 'terms', 'po', 'po_item']));
    }

    public function createFromOrder($id)
    {
        $po                 = sale_order::find($id);
        $po_item            = sale_order_item::where('sale_order_id', $id)->get();
        $today              = Carbon::today()->toDateString();
        $number             = sale_invoice::max('number');
        $terms              = other_term::all();
        $warehouses         = warehouse::all();
        /*if ($number != null) {
            $misahm             = explode("/", $number);
            $misahy             = explode(".", $misahm[1]);
        }
        if (isset($misahy[1]) == 0) {
            $misahy[1]      = 10000;
        }
        $number1                    = $misahy[1] + 1;
        $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;*/
        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;

        return view('admin.sales.invoices.createFromOrder', compact(['today', 'trans_no', 'terms', 'warehouses', 'po', 'po_item']));
    }

    public function createFromQuote($id)
    {
        $po                 = sale_quote::find($id);
        $po_item            = sale_quote_item::where('sale_quote_id', $id)->get();
        $today              = Carbon::today()->toDateString();
        $number             = sale_invoice::max('number');
        $terms              = other_term::all();
        $warehouses         = warehouse::all();
        $products           = product::all();
        $units              = other_unit::all();
        $taxes              = other_tax::all();
        /*if ($number != null) {
            $misahm             = explode("/", $number);
            $misahy             = explode(".", $misahm[1]);
        }
        if (isset($misahy[1]) == 0) {
            $misahy[1]      = 10000;
        }
        $number1                    = $misahy[1] + 1;
        $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;*/
        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;

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
        $po                         = spk::find($id);
        $po_item                    = spk_item::where('spk_id', $id)->get();
        $today                      = Carbon::today()->toDateString();
        $number                     = sale_invoice::max('number');
        $terms                      = other_term::all();
        $warehouses                 = warehouse::all();
        $products                   = product::all();
        $units                      = other_unit::all();
        $taxes                      = other_tax::all();
        $costs                      = coa::whereIn('coa_category_id', [15, 16, 17])->get();
        $cost_from_bundle           = product_bundle_cost::get();
        $check_cost_from_bundle     = product_bundle_cost::first();
        /*if ($number != null) {
            $misahm             = explode("/", $number);
            $misahy             = explode(".", $misahm[1]);
        }
        if (isset($misahy[1]) == 0) {
            $misahy[1]      = 10000;
        }
        $number1                    = $misahy[1] + 1;
        $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;*/
        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;

        return view('admin.request.sukses.sales.invoices.createFromSPK', compact(
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
        ));
    }

    public function createFromOrderRequestSukses($id)
    {
        $po                         = sale_order::find($id);
        $po_item                    = sale_order_item::where('sale_order_id', $id)->get();
        $today                      = Carbon::today()->toDateString();
        $number                     = sale_invoice::max('number');
        $terms                      = other_term::all();
        $warehouses                 = warehouse::all();
        /*if ($number != null) {
            $misahm             = explode("/", $number);
            $misahy             = explode(".", $misahm[1]);
        }
        if (isset($misahy[1]) == 0) {
            $misahy[1]      = 10000;
        }
        $number1                    = $misahy[1] + 1;
        $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;*/
        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;

        return view('admin.request.sukses.sales.invoices.createFromOrder', compact(['today', 'trans_no', 'terms', 'warehouses', 'po', 'po_item']));
    }

    public function store(Request $request)
    {
        $number             = sale_invoice::max('number');
        /*if ($number != null) {
            $misahm             = explode("/", $number);
            $misahy             = explode(".", $misahm[1]);
        }
        if (isset($misahy[1]) == 0) {
            $misahy[1]      = 10000;
        }
        $number1                    = $misahy[1] + 1;
        $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;*/
        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;
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

            coa_detail::create([
                'coa_id'                    => $contact_account->account_receivable_id,
                'date'                      => $request->get('trans_date'),
                'type'                      => 'sales invoice',
                'number'                    => 'Sales Invoice #' . $trans_no,
                'contact_id'                => $request->get('vendor_name'),
                'debit'                     => $request->get('balance'),
                'credit'                    => 0,
            ]);
            $get_current_balance_on_coa     = coa::find($contact_account->account_receivable_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                   => $get_current_balance_on_coa->balance + $request->get('balance'),
            ]);

            $transactions                       = other_transaction::create([
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

            if ($request->taxtotal > 0) {
                $default_tax                = default_account::find(8);
                coa_detail::create([
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'sales invoice',
                    'number'                => 'Sales Invoice #' . $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => 0,
                    'credit'                => $request->get('taxtotal'),
                ]);
                $get_current_balance_on_coa = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'               => $get_current_balance_on_coa->balance + $request->get('taxtotal'),
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
                $total_avg                      = $request->qty[$i] * $avg_price->avg_price;
                $default_product_account        = product::find($request->products[$i]);
                if ($default_product_account->is_track == 1) {
                    // DEFAULT BUY ACCOUNT
                    coa_detail::create([
                        'coa_id'                => $default_product_account->buy_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $total_avg,
                        'credit'                => 0,
                    ]);
                    $get_current_balance_on_coa1 = coa::find($default_product_account->buy_account);
                    coa::find($get_current_balance_on_coa1->id)->update([
                        'balance'               => $get_current_balance_on_coa1->balance + $total_avg,
                    ]);
                    // DEFAULT SELL ACCOUNT
                    coa_detail::create([
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    $get_current_balance_on_coa2 = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa2->id)->update([
                        'balance'               => $get_current_balance_on_coa2->balance + $request->total_price[$i],
                    ]);
                    // DEFAULT INVENTORY ACCOUNT
                    coa_detail::create([
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $total_avg,
                        //'from_product_id'   => 0,
                    ]);
                    $get_current_balance_on_coa3 = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_balance_on_coa3->id)->update([
                        'balance'               => $get_current_balance_on_coa3->balance - $total_avg,
                    ]);
                } else {
                    // DEFAULT SETTING
                    coa_detail::create([
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                        //'from_product_id'   => $request->products[$i],
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $request->total_price[$i],
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

    public function storeRequestSukses(Request $request)
    {
        $number             = sale_invoice::max('number');
        /*if ($number != null) {
            $misahm             = explode("/", $number);
            $misahy             = explode(".", $misahm[1]);
        }
        if (isset($misahy[1]) == 0) {
            $misahy[1]      = 10000;
        }
        $number1                    = $misahy[1] + 1;
        $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;*/
        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;
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

            coa_detail::create([
                'coa_id'                    => $contact_account->account_receivable_id,
                'date'                      => $request->get('trans_date'),
                'type'                      => 'sales invoice',
                'number'                    => 'Sales Invoice #' . $trans_no,
                'contact_id'                => $request->get('vendor_name'),
                'debit'                     => $request->get('balance'),
                'credit'                    => 0,
            ]);
            $get_current_balance_on_coa     = coa::find($contact_account->account_receivable_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                   => $get_current_balance_on_coa->balance + $request->get('balance'),
            ]);

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

            if ($request->taxtotal > 0) {
                $default_tax                = default_account::find(8);
                coa_detail::create([
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'sales invoice',
                    'number'                => 'Sales Invoice #' . $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => 0,
                    'credit'                => $request->get('taxtotal'),
                ]);
                $get_current_balance_on_coa = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'               => $get_current_balance_on_coa->balance + $request->get('taxtotal'),
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
                $total_avg                      = $request->qty[$i] * $avg_price->avg_price;
                $default_product_account        = product::find($request->products[$i]);
                if ($default_product_account->is_track == 1) {
                    // DEFAULT BUY ACCOUNT
                    coa_detail::create([
                        'coa_id'                => $default_product_account->buy_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $total_avg,
                        'credit'                => 0,
                    ]);
                    $get_current_balance_on_coa1 = coa::find($default_product_account->buy_account);
                    coa::find($get_current_balance_on_coa1->id)->update([
                        'balance'               => $get_current_balance_on_coa1->balance + $total_avg,
                    ]);
                    // DEFAULT SELL ACCOUNT
                    coa_detail::create([
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    $get_current_balance_on_coa2 = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa2->id)->update([
                        'balance'               => $get_current_balance_on_coa2->balance + $request->total_price[$i],
                    ]);
                    // DEFAULT INVENTORY ACCOUNT
                    coa_detail::create([
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $total_avg,
                        //'from_product_id'   => 0,
                    ]);
                    $get_current_balance_on_coa3 = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_balance_on_coa3->id)->update([
                        'balance'               => $get_current_balance_on_coa3->balance - $total_avg,
                    ]);
                } else {
                    // DEFAULT SETTING
                    coa_detail::create([
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                        //'from_product_id'   => $request->products[$i],
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $request->total_price[$i],
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
        $number             = sale_invoice::max('number');
        /*if ($number != null) {
            $misahm             = explode("/", $number);
            $misahy             = explode(".", $misahm[1]);
        }
        if (isset($misahy[1]) == 0) {
            $misahy[1]      = 10000;
        }
        $number1                    = $misahy[1] + 1;
        $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;*/
        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;
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
            coa_detail::create([
                'coa_id'                        => $default_unbilled_revenue->account_id,
                'date'                          => $request->get('trans_date'),
                'type'                          => 'sales invoice',
                'number'                        => 'Sales Invoice #' . $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => $request->get('subtotal'),
                'credit'                        => 0,
            ]);
            $get_current_balance_on_coa         = coa::find($default_unbilled_revenue->account_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance - $request->get('subtotal'),
            ]);

            $contact_account                    = contact::find($id_contact);
            if ($contact_account->is_limit == 1) {
                if ($contact_account->current_limit_balance >= $request->balance) {
                    $contact_account->update([
                        'current_limit_balance'         => $contact_account->current_limit_balance - $request->balance,
                    ]);
                }
            }
            coa_detail::create([
                'coa_id'                        => $contact_account->account_receivable_id,
                'date'                          => $request->get('trans_date'),
                'type'                          => 'sales invoice',
                'number'                        => 'Sales Invoice #' . $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => $request->get('balance'),
                'credit'                        => 0,
            ]);
            $get_current_balance_on_coa         = coa::find($contact_account->account_receivable_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance + $request->get('balance'),
            ]);
            // DEFAULT SETTING UNBILLED RECEIVABLE
            $default_unbilled_receivable        = default_account::find(7);
            coa_detail::create([
                'coa_id'                        => $default_unbilled_receivable->account_id,
                'date'                          => $request->get('trans_date'),
                'type'                          => 'sales invoice',
                'number'                        => 'Sales Invoice #' . $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => 0,
                'credit'                        => $request->get('subtotal'),
            ]);
            $get_current_balance_on_coa         = coa::find($default_unbilled_receivable->account_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance - $request->get('subtotal'),
            ]);

            $transactions                       = other_transaction::create([
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

            if ($request->taxtotal > 0) {
                $default_tax                    = default_account::find(8);
                coa_detail::create([
                    'coa_id'                    => $default_tax->account_id,
                    'date'                      => $request->get('trans_date'),
                    'type'                      => 'sales invoice',
                    'number'                    => 'Sales Invoice #' . $trans_no,
                    'contact_id'                => $request->get('vendor_name'),
                    'debit'                     => 0,
                    'credit'                    => $request->get('taxtotal'),
                ]);
                $get_current_balance_on_coa     = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                   => $get_current_balance_on_coa->balance + $request->get('taxtotal'),
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
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $request->total_price[$i],
                    ]);
                    /*coa_detail::create([
                        'coa_id'            => $default_product_account->buy_account,
                        'date'              => $request->get('trans_date'),
                        'type'              => 'sales invoice',
                        'number'            => 'Sales Invoice #' . $trans_no,
                        'contact_id'        => $request->get('vendor_name'),
                        'debit'             => 0,
                        'credit'            => $request->total_price[$i],
                    ]);
                    $get_current_balance_on_coa2 = coa::find($default_product_account->buy_account);
                    coa::find($get_current_balance_on_coa2->id)->update([
                        'balance'       => $get_current_balance_on_coa2->balance + $request->get('balance'),
                    ]);*/
                } else {
                    // YANG GA DI TRACK SELL ACCOUNT
                    coa_detail::create([
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $request->total_price[$i],
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
        $number             = sale_invoice::max('number');
        /*if ($number != null) {
            $misahm             = explode("/", $number);
            $misahy             = explode(".", $misahm[1]);
        }
        if (isset($misahy[1]) == 0) {
            $misahy[1]      = 10000;
        }
        $number1                    = $misahy[1] + 1;
        $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;*/
        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;
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

            coa_detail::create([
                'coa_id'                        => $contact_account->account_receivable_id,
                'date'                          => $request->get('trans_date'),
                'type'                          => 'sales invoice',
                'number'                        => 'Sales Invoice #' . $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => $request->get('balance'),
                'credit'                        => 0,
            ]);
            $get_current_balance_on_coa         = coa::find($contact_account->account_receivable_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance + $request->get('balance'),
            ]);
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

            if ($request->taxtotal > 0) {
                $default_tax                    = default_account::find(8);
                coa_detail::create([
                    'coa_id'                    => $default_tax->account_id,
                    'date'                      => $request->get('trans_date'),
                    'type'                      => 'sales invoice',
                    'number'                    => 'Sales Invoice #' . $trans_no,
                    'contact_id'                => $request->get('vendor_name'),
                    'debit'                     => 0,
                    'credit'                    => $request->get('taxtotal'),
                ]);
                $get_current_balance_on_coa     = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                   => $get_current_balance_on_coa->balance + $request->get('taxtotal'),
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
                $total_avg                      = $request->qty[$i] * $avg_price->avg_price;
                $default_product_account        = product::find($request->products[$i]);
                if ($default_product_account->is_track == 1) {
                    // CREATE COA DETAIL YANG DARI BUY ACCOUNT
                    coa_detail::create([
                        'coa_id'                => $default_product_account->buy_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $total_avg,
                        'credit'                => 0,
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->buy_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $total_avg,
                    ]);
                    // CREATE COA DETAIL YANG DARI SELL ACCOUNT
                    coa_detail::create([
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $request->total_price[$i],
                    ]);
                    // CREATE COA DETAIL YANG DARI INVENTORY ACCOUNT
                    coa_detail::create([
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $total_avg,
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $total_avg,
                    ]);
                } else {
                    coa_detail::create([
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $request->total_price[$i],
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
        $number             = sale_invoice::max('number');
        /*if ($number != null) {
            $misahm             = explode("/", $number);
            $misahy             = explode(".", $misahm[1]);
        }
        if (isset($misahy[1]) == 0) {
            $misahy[1]      = 10000;
        }
        $number1                    = $misahy[1] + 1;
        $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;*/
        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;
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

            coa_detail::create([
                'coa_id'                    => $contact_account->account_receivable_id,
                'date'                      => $request->get('trans_date'),
                'type'                      => 'sales invoice',
                'number'                    => 'Sales Invoice #' . $trans_no,
                'contact_id'                => $request->get('vendor_name'),
                'debit'                     => $request->get('balance'),
                'credit'                    => 0,
            ]);
            $get_current_balance_on_coa     = coa::find($contact_account->account_receivable_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                   => $get_current_balance_on_coa->balance + $request->get('balance'),
            ]);
            // UPDATE STATUS ON SALES QUOTE & OTHER TRANSACTION QUOTE'S
            $updatepdstatus                 = array(
                'status'                    => 2,
            );
            sale_quote::where('number', $id_number)->update($updatepdstatus);
            other_transaction::where('number', $id_number)->where('type', 'sales quote')->update($updatepdstatus);
            // CREATE LIST OTHER TRANSACTION PUNYA INVOICE
            $transactions                   = other_transaction::create([
                'number'                    => $trans_no,
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
                'user_id'                   => Auth::id(),
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

            if ($request->taxtotal > 0) {
                $default_tax                = default_account::find(8);
                coa_detail::create([
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'sales invoice',
                    'number'                => 'Sales Invoice #' . $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => 0,
                    'credit'                => $request->get('taxtotal'),
                ]);
                $get_current_balance_on_coa = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'               => $get_current_balance_on_coa->balance + $request->get('taxtotal'),
                ]);
            }

            // CREATE SALES INVOICE DETAILS
            foreach ($request->products2 as $i => $keys) {
                $pp[$i] = new sale_invoice_item([
                    'product_id'            => $request->products2[$i],
                    'desc'                  => $request->desc[$i],
                    'qty'                   => $request->qty[$i],
                    'unit_id'               => $request->units[$i],
                    'unit_price'            => $request->unit_price[$i],
                    'tax_id'                => $request->tax[$i],
                    'amountsub'             => $request->total_price_sub[$i],
                    'amounttax'             => $request->total_price_tax[$i],
                    'amountgrand'           => $request->total_price_grand[$i],
                    'amount'                => $request->total_price[$i],
                    'qty_remaining'         => $request->r_qty[$i],
                    'qty_remaining_return'  => $request->qty[$i],
                ]);
                $pd->sale_invoice_item()->save($pp[$i]);
                // CREATE COA DETAIL BASED ON PRODUCT SETTING
                $avg_price                  = product::find($request->products2[$i]);
                $total_avg                  = $request->qty[$i] * $avg_price->avg_price;
                $default_product_account    = product::find($request->products2[$i]);
                if ($default_product_account->is_track == 1) {
                    // CREATE COA DETAIL YANG DARI BUY ACCOUNT
                    coa_detail::create([
                        'coa_id'            => $default_product_account->buy_account,
                        'date'              => $request->get('trans_date'),
                        'type'              => 'sales invoice',
                        'number'            => 'Sales Invoice #' . $trans_no,
                        'contact_id'        => $request->get('vendor_name'),
                        'debit'             => $total_avg,
                        'credit'            => 0,
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->buy_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'           => $get_current_balance_on_coa->balance + $total_avg,
                    ]);
                    // CREATE COA DETAIL YANG DARI SELL ACCOUNT
                    coa_detail::create([
                        'coa_id'            => $default_product_account->sell_account,
                        'date'              => $request->get('trans_date'),
                        'type'              => 'sales invoice',
                        'number'            => 'Sales Invoice #' . $trans_no,
                        'contact_id'        => $request->get('vendor_name'),
                        'debit'             => 0,
                        'credit'            => $request->total_price[$i],
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'           => $get_current_balance_on_coa->balance + $request->total_price[$i],
                    ]);
                    // CREATE COA DETAIL YANG DARI INVENTORY ACCOUNT
                    coa_detail::create([
                        'coa_id'            => $default_product_account->default_inventory_account,
                        'date'              => $request->get('trans_date'),
                        'type'              => 'sales invoice',
                        'number'            => 'Sales Invoice #' . $trans_no,
                        'contact_id'        => $request->get('vendor_name'),
                        'debit'             => 0,
                        'credit'            => $total_avg,
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'           => $get_current_balance_on_coa->balance - $total_avg,
                    ]);
                } else {
                    coa_detail::create([
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $request->total_price[$i],
                    ]);
                }

                //menambahkan stok barang ke gudang
                $wh                             = new warehouse_detail();
                $wh->type                       = 'sales invoice';
                $wh->number                     = 'Sales Invoice #' . $trans_no;
                $wh->product_id                 = $request->products2[$i];
                $wh->warehouse_id               = $request->warehouse;
                $wh->date                   = $request->trans_date;
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
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $pd->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function storeFromSPK(Request $request)
    {
        $number             = sale_invoice::max('number');
        /*if ($number != null) {
            $misahm             = explode("/", $number);
            $misahy             = explode(".", $misahm[1]);
        }
        if (isset($misahy[1]) == 0) {
            $misahy[1]      = 10000;
        }
        $number1                    = $misahy[1] + 1;
        $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;*/
        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;
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
                coa_detail::create([
                    'coa_id'                    => $contact_account->account_receivable_id,
                    'date'                      => $request->get('trans_date'),
                    'type'                      => 'sales invoice',
                    'number'                    => 'Sales Invoice #' . $trans_no,
                    'contact_id'                => $request->get('vendor_name'),
                    'debit'                     => $request->get('balance'),
                    'credit'                    => 0,
                ]);
                $get_current_balance_on_coa     = coa::find($contact_account->account_receivable_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                   => $get_current_balance_on_coa->balance + $request->get('balance'),
                ]);
            } else {
                coa_detail::create([
                    'coa_id'                    => $contact_account->account_receivable_id,
                    'date'                      => $request->get('trans_date'),
                    'type'                      => 'sales invoice',
                    'number'                    => 'Sales Invoice #' . $trans_no,
                    'contact_id'                => $request->get('vendor_name'),
                    'debit'                     => $request->get('costtotal'),
                    'credit'                    => 0,
                ]);
                $get_current_balance_on_coa     = coa::find($contact_account->account_receivable_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                   => $get_current_balance_on_coa->balance + $request->get('costtotal'),
                ]);
            }

            if ($jasa_only == 0) {
                $transactions                       = other_transaction::create([
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

            if ($request->taxtotal > 0) {
                $default_tax                = default_account::find(8);
                coa_detail::create([
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'sales invoice',
                    'number'                => 'Sales Invoice #' . $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => 0,
                    'credit'                => $request->get('taxtotal'),
                ]);
                $get_current_balance_on_coa = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'               => $get_current_balance_on_coa->balance + $request->get('taxtotal'),
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
                        $get_current_balance_on_coa = coa::find($request->cost_acc[$i]);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance + $request->cost_amount[$i],
                        ]);
                    }
                }
            }*/
            if ($jasa_only == 0) {
                foreach ($request->products as $i => $product) {
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
                            'coa_id'                => $default_product_account->buy_account,
                            'date'                  => $request->get('trans_date'),
                            'type'                  => 'sales invoice',
                            'number'                => 'Sales Invoice #' . $trans_no,
                            'contact_id'            => $request->get('vendor_name'),
                            'debit'                 => $total_avg,
                            'credit'                => 0,
                        ]);
                        $get_current_balance_on_coa1 = coa::find($default_product_account->buy_account);
                        coa::find($get_current_balance_on_coa1->id)->update([
                            'balance'               => $get_current_balance_on_coa1->balance + $total_avg,
                        ]);
                        // DEFAULT SELL ACCOUNT
                        coa_detail::create([
                            'coa_id'                => $default_product_account->sell_account,
                            'date'                  => $request->get('trans_date'),
                            'type'                  => 'sales invoice',
                            'number'                => 'Sales Invoice #' . $trans_no,
                            'contact_id'            => $request->get('vendor_name'),
                            'debit'                 => 0,
                            'credit'                => $request->total_price[$i],
                        ]);
                        $get_current_balance_on_coa2 = coa::find($default_product_account->sell_account);
                        coa::find($get_current_balance_on_coa2->id)->update([
                            'balance'               => $get_current_balance_on_coa2->balance + $request->total_price[$i],
                        ]);
                        // DEFAULT INVENTORY ACCOUNT
                        coa_detail::create([
                            'coa_id'                => $default_product_account->default_inventory_account,
                            'date'                  => $request->get('trans_date'),
                            'type'                  => 'sales invoice',
                            'number'                => 'Sales Invoice #' . $trans_no,
                            'contact_id'            => $request->get('vendor_name'),
                            'debit'                 => 0,
                            'credit'                => $total_avg,
                            //'from_product_id'   => 0,
                        ]);
                        $get_current_balance_on_coa3 = coa::find($default_product_account->default_inventory_account);
                        coa::find($get_current_balance_on_coa3->id)->update([
                            'balance'               => $get_current_balance_on_coa3->balance - $total_avg,
                        ]);
                        // PUNYA COST
                        coa_detail::create([
                            'coa_id'                => 69,
                            'date'                  => $request->get('trans_date'),
                            'type'                  => 'sales invoice',
                            'number'                => 'Sales Invoice #' . $trans_no,
                            'contact_id'            => $request->get('vendor_name'),
                            'debit'                 => 0,
                            'credit'                => $request->cost_total_price[$i],
                            //'from_product_id'   => $request->products[$i],
                        ]);
                        $get_current_balance_on_coa = coa::find(69);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance + $request->cost_total_price[$i],
                        ]);
                    } else {
                        // DEFAULT SETTING
                        coa_detail::create([
                            'coa_id'                => $default_product_account->sell_account,
                            'date'                  => $request->get('trans_date'),
                            'type'                  => 'sales invoice',
                            'number'                => 'Sales Invoice #' . $trans_no,
                            'contact_id'            => $request->get('vendor_name'),
                            'debit'                 => 0,
                            'credit'                => $request->total_price[$i],
                            //'from_product_id'   => $request->products[$i],
                        ]);
                        $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance + $request->total_price[$i],
                        ]);
                        // PUNYA COST
                        coa_detail::create([
                            'coa_id'                => 69,
                            'date'                  => $request->get('trans_date'),
                            'type'                  => 'sales invoice',
                            'number'                => 'Sales Invoice #' . $trans_no,
                            'contact_id'            => $request->get('vendor_name'),
                            'debit'                 => 0,
                            'credit'                => $request->cost_total_price[$i],
                            //'from_product_id'   => $request->products[$i],
                        ]);
                        $get_current_balance_on_coa = coa::find(69);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance + $request->cost_total_price[$i],
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
                };
            } else {
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
                        /*'amountsub'                 => $request->total_price_sub[$i],
                        'amounttax'                 => $request->total_price_tax[$i],
                        'amountgrand'               => $request->total_price_grand[$i],*/
                        'amount'                    => $request->total_price[$i],
                        // PUNYA COST
                        'cost_unit_price'           => $request->cost_unit_price[$i],
                        'cost_amount'               => $request->cost_total_price[$i],
                    ]);
                    $pi->sale_invoice_item()->save($pp[$i]);

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
        $number             = sale_invoice::max('number');
        /*if ($number != null) {
            $misahm             = explode("/", $number);
            $misahy             = explode(".", $misahm[1]);
        }
        if (isset($misahy[1]) == 0) {
            $misahy[1]      = 10000;
        }
        $number1                    = $misahy[1] + 1;
        $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;*/
        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;
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

            coa_detail::create([
                'coa_id'                        => $contact_account->account_receivable_id,
                'date'                          => $request->get('trans_date'),
                'type'                          => 'sales invoice',
                'number'                        => 'Sales Invoice #' . $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => $request->get('balance'),
                'credit'                        => 0,
            ]);
            $get_current_balance_on_coa         = coa::find($contact_account->account_receivable_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance + $request->get('balance'),
            ]);
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

            if ($request->taxtotal > 0) {
                $default_tax                    = default_account::find(8);
                coa_detail::create([
                    'coa_id'                    => $default_tax->account_id,
                    'date'                      => $request->get('trans_date'),
                    'type'                      => 'sales invoice',
                    'number'                    => 'Sales Invoice #' . $trans_no,
                    'contact_id'                => $request->get('vendor_name'),
                    'debit'                     => 0,
                    'credit'                    => $request->get('taxtotal'),
                ]);
                $get_current_balance_on_coa     = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                   => $get_current_balance_on_coa->balance + $request->get('taxtotal'),
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
                $total_avg                      = $request->qty[$i] * $avg_price->avg_price;
                $default_product_account        = product::find($request->products[$i]);
                if ($default_product_account->is_track == 1) {
                    // CREATE COA DETAIL YANG DARI BUY ACCOUNT
                    coa_detail::create([
                        'coa_id'                => $default_product_account->buy_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $total_avg,
                        'credit'                => 0,
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->buy_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $total_avg,
                    ]);
                    // CREATE COA DETAIL YANG DARI SELL ACCOUNT
                    coa_detail::create([
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $request->total_price[$i],
                    ]);
                    // CREATE COA DETAIL YANG DARI INVENTORY ACCOUNT
                    coa_detail::create([
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $total_avg,
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $total_avg,
                    ]);
                } else {
                    coa_detail::create([
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $request->total_price[$i],
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
                compact(
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

                )
            );
        } else if ($pi->marketting != 0) {
            return view(
                'admin.request.sukses.sales.invoices.showRequestSukses',
                compact(
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
                )
            );
        } else {
            return view(
                'admin.sales.invoices.show',
                compact(
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
                )
            );
        }
    }

    public function edit($id)
    {
        $pi             = sale_invoice::find($id);
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
            if ($contact_id->is_limit == 1) {
                $contact_id->update([
                    'current_limit_balance'         => $contact_id->current_limit_balance + $pi->balance_due,
                ]);
            }
            // DELETE BALANCE DARI YANG PENGEN DI DELETE (CONTACT)
            $get_current_balance_on_coa         = coa::find($contact_id->account_receivable_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance - $pi->grandtotal,
            ]);
            // HAPUS PAJAK
            if ($pi->taxtotal > 0) {
                $get_current_balance_on_coa     = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                   => $get_current_balance_on_coa->balance - $pi->taxtotal,
                ]);
            }
            // HAPUS BALANCE PER ITEM INVOICE
            $pi_details                         = sale_invoice_item::where('sale_invoice_id', $id)->get();
            foreach ($pi_details as $a) {
                $default_product_account        = product::find($a->product_id);
                if ($default_product_account->is_track == 1) {
                    // DEFAULT BUY ACCOUNT
                    $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                        ->where('number', 'Sales Invoice #' . $pi->number)
                        ->where('credit', 0)
                        ->where('coa_id', $default_product_account->buy_account)
                        ->first();
                    $get_current_balance_on_coa = coa::find($default_product_account->buy_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $ambil_avg_price_dari_coadetial->debit,
                    ]);
                    $ambil_avg_price_dari_coadetial->delete();
                    // DEFAULT SELL ACCOUNT
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $a->amount,
                    ]);
                    // DEFAULT INVENTORY ACCOUNT
                    $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                        ->where('number', 'Sales Invoice #' . $pi->number)
                        ->where('debit', 0)
                        ->where('coa_id', $default_product_account->default_inventory_account)
                        ->first();
                    $get_current_balance_on_coa = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $ambil_avg_price_dari_coadetial->credit,
                    ]);
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
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $a->amount,
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

            if ($contact_account->account_receivable_id == null) { } else {
                coa_detail::create([
                    'coa_id'                    => $contact_account->account_receivable_id,
                    'date'                      => $request->get('trans_date'),
                    'type'                      => 'sales invoice',
                    'number'                    => 'Sales Invoice #' . $pi->number,
                    'contact_id'                => $request->get('vendor_name2'),
                    'debit'                     => $request->get('balance'),
                    'credit'                    => 0,
                ]);
                $get_current_balance_on_coa     = coa::find($contact_account->account_receivable_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                   => $get_current_balance_on_coa->balance + $request->get('balance'),
                ]);
            }

            other_transaction::where('type', 'sales invoice')->where('number', $pi->number)->update([
                'memo'                          => $request->get('memo'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'contact'                       => $request->get('vendor_name2'),
                'balance_due'                   => $request->get('balance'),
                'total'                         => $request->get('balance'),
            ]);
            sale_invoice::find($id)->update([
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

            if ($request->taxtotal > 0) {
                $default_tax                    = default_account::find(8);
                coa_detail::create([
                    'coa_id'                    => $default_tax->account_id,
                    'date'                      => $request->get('trans_date'),
                    'type'                      => 'sales invoice',
                    'number'                    => 'Sales Invoice #' . $pi->number,
                    'contact_id'                => $request->get('vendor_name2'),
                    'debit'                     => 0,
                    'credit'                    => $request->get('taxtotal'),
                ]);
                $get_current_balance_on_coa     = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                   => $get_current_balance_on_coa->balance + $request->get('taxtotal'),
                ]);
            }

            foreach ($request->products2 as $i => $product) {
                //menyimpan detail per item dari invoicd
                $pp[$i] = new sale_invoice_item([
                    'product_id'                => $request->products2[$i],
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

                $avg_price                      = product::find($request->products2[$i]);
                $total_avg                      = $request->qty[$i] * $avg_price->avg_price;
                $default_product_account        = product::find($request->products2[$i]);
                if ($default_product_account->is_track == 1) {
                    // DEFAULT BUY ACCOUNT
                    coa_detail::create([
                        'coa_id'                => $default_product_account->buy_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name2'),
                        'debit'                 => $total_avg,
                        'credit'                => 0,
                    ]);
                    $get_current_balance_on_coa1 = coa::find($default_product_account->buy_account);
                    coa::find($get_current_balance_on_coa1->id)->update([
                        'balance'               => $get_current_balance_on_coa1->balance + $total_avg,
                    ]);
                    // DEFAULT SELL ACCOUNT
                    coa_detail::create([
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name2'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    $get_current_balance_on_coa2 = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa2->id)->update([
                        'balance'               => $get_current_balance_on_coa2->balance + $request->total_price[$i],
                    ]);
                    // DEFAULT INVENTORY ACCOUNT
                    coa_detail::create([
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name2'),
                        'debit'                 => 0,
                        'credit'                => $total_avg,
                        //'from_product_id'   => 0,
                    ]);
                    $get_current_balance_on_coa3 = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_balance_on_coa3->id)->update([
                        'balance'               => $get_current_balance_on_coa3->balance - $total_avg,
                    ]);
                } else {
                    // DEFAULT SETTING
                    coa_detail::create([
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name2'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                        //'from_product_id'   => $request->products[$i],
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $request->total_price[$i],
                    ]);
                }
                //menambahkan stok barang ke gudang
                $wh                             = new warehouse_detail();
                $wh->type                       = 'sales invoice';
                $wh->number                     = 'Sales Invoice #' . $pi->number;
                $wh->product_id                 = $request->products2[$i];
                $wh->warehouse_id               = $request->warehouse;
                $wh->date                   = $request->trans_date;
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
            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $pi->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function updateFromDelivery(Request $request)
    {
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
            // DELETE BALANCE DARI YANG PENGEN DI DELETE (CONTACT)
            $get_current_balance_on_coa         = coa::find($contact_id->account_receivable_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance - $pi->grandtotal,
            ]);
            // HAPUS PAJAK
            if ($pi->taxtotal > 0) {
                $get_current_balance_on_coa     = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                   => $get_current_balance_on_coa->balance - $pi->taxtotal,
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
                    $get_current_balance_on_coa = coa::find($default_product_account->buy_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $ambil_avg_price_dari_coadetial->debit,
                    ]);
                    $ambil_avg_price_dari_coadetial->delete();
                    // DEFAULT SELL ACCOUNT
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $a->amount,
                    ]);
                    // DEFAULT INVENTORY ACCOUNT
                    $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                        ->where('number', 'Sales Invoice #' . $pi->number)
                        ->where('debit', 0)
                        ->where('coa_id', $default_product_account->default_inventory_account)
                        ->first();
                    $get_current_balance_on_coa = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $ambil_avg_price_dari_coadetial->credit,
                    ]);
                    $ambil_avg_price_dari_coadetial->delete();
                } else {
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $a->amount,
                    ]);
                }
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
                'coa_id'                        => $contact_account->account_receivable_id,
                'date'                          => $request->get('trans_date'),
                'type'                          => 'sales invoice',
                'number'                        => 'Sales Invoice #' . $pi->number,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => $request->get('balance'),
                'credit'                        => 0,
            ]);
            $get_current_balance_on_coa         = coa::find($contact_account->account_receivable_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance + $request->get('balance'),
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
                    'coa_id'                    => $default_tax->account_id,
                    'date'                      => $request->get('trans_date'),
                    'type'                      => 'sales invoice',
                    'number'                    => 'Sales Invoice #' . $pi->number,
                    'contact_id'                => $request->get('vendor_name'),
                    'debit'                     => 0,
                    'credit'                    => $request->get('taxtotal'),
                ]);
                $get_current_balance_on_coa     = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                   => $get_current_balance_on_coa->balance + $request->get('taxtotal'),
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
                        'coa_id'                => $default_product_account->buy_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $total_avg,
                        'credit'                => 0,
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->buy_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $total_avg,
                    ]);
                    // CREATE COA DETAIL YANG DARI SELL ACCOUNT
                    coa_detail::create([
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $request->total_price[$i],
                    ]);
                    // CREATE COA DETAIL YANG DARI INVENTORY ACCOUNT
                    coa_detail::create([
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $total_avg,
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $total_avg,
                    ]);
                } else {
                    coa_detail::create([
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $request->total_price[$i],
                    ]);
                }

                //menambahkan stok barang ke gudang
                $wh                             = new warehouse_detail();
                $wh->type                       = 'sales invoice';
                $wh->number                     = 'Sales Invoice #' . $pi->number;
                $wh->product_id                 = $request->products[$i];
                $wh->warehouse_id               = $request->warehouse;
                $wh->date                   = $request->trans_date;
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
            return response()->json(['success' => 'Data is successfully updated', 'id' => $pi->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function updateFromQuote(Request $request)
    {
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

            // DELETE BALANCE DARI YANG PENGEN DI DELETE (CONTACT)
            $get_current_balance_on_coa         = coa::find($contact_id->account_receivable_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance - $pi->grandtotal,
            ]);
            // HAPUS BALANCE PER ITEM INVOICE
            $pi_details                         = sale_invoice_item::where('sale_invoice_id', $id)->get();
            foreach ($pi_details as $a) {
                $default_product_account        = product::find($a->product_id);
                if ($default_product_account->is_track == 1) {
                    // DEFAULT BUY ACCOUNT
                    $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                        ->where('number', 'Sales Invoice #' . $pi->number)
                        ->where('credit', 0)
                        ->where('coa_id', $default_product_account->buy_account)
                        ->first();
                    $get_current_balance_on_coa = coa::find($default_product_account->buy_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $ambil_avg_price_dari_coadetial->debit,
                    ]);
                    $ambil_avg_price_dari_coadetial->delete();
                    // DEFAULT SELL ACCOUNT
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $a->amount,
                    ]);
                    // DEFAULT INVENTORY ACCOUNT
                    $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                        ->where('number', 'Sales Invoice #' . $pi->number)
                        ->where('debit', 0)
                        ->where('coa_id', $default_product_account->default_inventory_account)
                        ->first();
                    $get_current_balance_on_coa = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $ambil_avg_price_dari_coadetial->credit,
                    ]);
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
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $a->amount,
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
            }
            coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('credit', 0)->delete();
            sale_invoice_item::where('sale_invoice_id', $id)->delete();
            // BIKIN BARUNYA
            $contact_account                = contact::find($id_contact);
            coa_detail::create([
                'coa_id'                => $contact_account->account_receivable_id,
                'date'                  => $request->get('trans_date'),
                'type'                  => 'sales invoice',
                'number'                => 'Sales Invoice #' . $pi->number,
                'contact_id'            => $request->get('vendor_name'),
                'debit'                 => $request->get('balance'),
                'credit'                => 0,
            ]);
            $get_current_balance_on_coa = coa::find($contact_account->account_receivable_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'               => $get_current_balance_on_coa->balance + $request->get('balance'),
            ]);
            // UPDATE STATUS ON SALES QUOTE & OTHER TRANSACTION QUOTE'S
            $updatepdstatus                 = array(
                'status'                    => 2,
            );
            sale_quote::where('number', $number_sq)->update($updatepdstatus);
            other_transaction::where('number', $number_sq)->where('type', 'sales quote')->update($updatepdstatus);
            // CREATE LIST OTHER TRANSACTION PUNYA INVOICE
            other_transaction::where('type', 'sales invoice')->where('number', $pi->number)->update([
                'memo'                      => $request->get('memo'),
                'transaction_date'          => $request->get('trans_date'),
                'due_date'                  => $request->get('due_date'),
                'contact'                   => $request->get('vendor_name'),
                'balance_due'               => $request->get('balance'),
                'total'                     => $request->get('balance'),
            ]);
            // CREATE SALES INVOICE HEADER
            sale_invoice::find($id)->update([
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
                $pp[$i] = new sale_invoice_item([
                    'product_id'            => $request->products2[$i],
                    'desc'                  => $request->desc[$i],
                    'qty'                   => $request->qty[$i],
                    'qty_remaining_return'                   => $request->qty[$i],
                    'unit_id'               => $request->units[$i],
                    'unit_price'            => $request->unit_price[$i],
                    'tax_id'                => $request->tax[$i],
                    'amountsub'             => $request->total_price_sub[$i],
                    'amounttax'             => $request->total_price_tax[$i],
                    'amountgrand'           => $request->total_price_grand[$i],
                    'amount'                => $request->total_price[$i],
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
                        'coa_id'            => $default_product_account->buy_account,
                        'date'              => $request->get('trans_date'),
                        'type'              => 'sales invoice',
                        'number'            => 'Sales Invoice #' . $pi->number,
                        'contact_id'        => $request->get('vendor_name'),
                        'debit'             => $total_avg,
                        'credit'            => 0,
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->buy_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'           => $get_current_balance_on_coa->balance + $total_avg,
                    ]);
                    // CREATE COA DETAIL YANG DARI SELL ACCOUNT
                    coa_detail::create([
                        'coa_id'            => $default_product_account->sell_account,
                        'date'              => $request->get('trans_date'),
                        'type'              => 'sales invoice',
                        'number'            => 'Sales Invoice #' . $pi->number,
                        'contact_id'        => $request->get('vendor_name'),
                        'debit'             => 0,
                        'credit'            => $request->total_price[$i],
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'           => $get_current_balance_on_coa->balance + $request->total_price[$i],
                    ]);
                    // CREATE COA DETAIL YANG DARI INVENTORY ACCOUNT
                    coa_detail::create([
                        'coa_id'            => $default_product_account->default_inventory_account,
                        'date'              => $request->get('trans_date'),
                        'type'              => 'sales invoice',
                        'number'            => 'Sales Invoice #' . $pi->number,
                        'contact_id'        => $request->get('vendor_name'),
                        'debit'             => 0,
                        'credit'            => $total_avg,
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'           => $get_current_balance_on_coa->balance - $total_avg,
                    ]);
                } else {
                    coa_detail::create([
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $request->total_price[$i],
                    ]);
                }
                //menambahkan stok barang ke gudang
                $wh                             = new warehouse_detail();
                $wh->type                       = 'sales invoice';
                $wh->number                     = 'Sales Invoice #' . $pi->number;
                $wh->product_id                 = $request->products2[$i];
                $wh->warehouse_id               = $request->warehouse;
                $wh->date                   = $request->trans_date;
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
            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $pi->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function updateFromOrderRequestSukses(Request $request)
    {
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
            // DELETE BALANCE DARI YANG PENGEN DI DELETE (CONTACT)
            $get_current_balance_on_coa         = coa::find($contact_id->account_receivable_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance - $pi->grandtotal,
            ]);
            // HAPUS PAJAK
            if ($pi->taxtotal > 0) {
                $get_current_balance_on_coa = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'               => $get_current_balance_on_coa->balance - $pi->taxtotal,
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
                    $get_current_balance_on_coa = coa::find($default_product_account->buy_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $ambil_avg_price_dari_coadetial->debit,
                    ]);
                    $ambil_avg_price_dari_coadetial->delete();
                    // DEFAULT SELL ACCOUNT
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $a->amount,
                    ]);
                    // DEFAULT INVENTORY ACCOUNT
                    $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                        ->where('number', 'Sales Invoice #' . $pi->number)
                        ->where('debit', 0)
                        ->where('coa_id', $default_product_account->default_inventory_account)
                        ->first();
                    $get_current_balance_on_coa = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $ambil_avg_price_dari_coadetial->credit,
                    ]);
                    $ambil_avg_price_dari_coadetial->delete();
                } else {
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $a->amount,
                    ]);
                }
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
                'coa_id'                    => $contact_account->account_receivable_id,
                'date'                      => $request->get('trans_date'),
                'type'                      => 'sales invoice',
                'number'                    => 'Sales Invoice #' . $pi->number,
                'contact_id'                => $request->get('vendor_name'),
                'debit'                     => $request->get('balance'),
                'credit'                    => 0,
            ]);
            $get_current_balance_on_coa = coa::find($contact_account->account_receivable_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                   => $get_current_balance_on_coa->balance + $request->get('balance'),
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
                $default_tax                = default_account::find(8);
                coa_detail::create([
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'sales invoice',
                    'number'                => 'Sales Invoice #' . $pi->number,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => 0,
                    'credit'                => $request->get('taxtotal'),
                ]);
                $get_current_balance_on_coa = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'               => $get_current_balance_on_coa->balance + $request->get('taxtotal'),
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
                        'coa_id'                => $default_product_account->buy_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $total_avg,
                        'credit'                => 0,
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->buy_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $total_avg,
                    ]);
                    // CREATE COA DETAIL YANG DARI SELL ACCOUNT
                    coa_detail::create([
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $request->total_price[$i],
                    ]);
                    // CREATE COA DETAIL YANG DARI INVENTORY ACCOUNT
                    coa_detail::create([
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $total_avg,
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $total_avg,
                    ]);
                } else {
                    coa_detail::create([
                        'coa_id'                => $default_product_account->sell_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'sales invoice',
                        'number'                => 'Sales Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->total_price[$i],
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $request->total_price[$i],
                    ]);
                }

                //menambahkan stok barang ke gudang
                $wh                             = new warehouse_detail();
                $wh->type                       = 'sales invoice';
                $wh->number                     = 'Sales Invoice #' . $pi->number;
                $wh->product_id                 = $request->products[$i];
                $wh->warehouse_id               = $request->warehouse;
                $wh->date                   = $request->trans_date;
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
            return response()->json(['success' => 'Data is successfully updated', 'id' => $pi->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $pi                                     = sale_invoice::find($id);
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

                // DELETE BALANCE DARI YANG PENGEN DI DELETE (CONTACT)
                $get_current_balance_on_coa         = coa::find($contact_id->account_receivable_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance - $pi->grandtotal,
                ]);
                // HAPUS PAJAK
                if ($pi->taxtotal > 0) {
                    $get_current_balance_on_coa = coa::find($default_tax->account_id);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $pi->taxtotal,
                    ]);
                }
                // HAPUS BALANCE PER ITEM INVOICE
                $pi_details                         = sale_invoice_item::where('sale_invoice_id', $id)->get();
                foreach ($pi_details as $a) {
                    $default_product_account        = product::find($a->product_id);
                    if ($default_product_account->is_track == 1) {
                        // DEFAULT BUY ACCOUNT
                        $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('credit', 0)
                            ->where('coa_id', $default_product_account->buy_account)
                            ->first();
                        $get_current_balance_on_coa = coa::find($default_product_account->buy_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance - $ambil_avg_price_dari_coadetial->debit,
                        ]);
                        $ambil_avg_price_dari_coadetial->delete();
                        // DEFAULT SELL ACCOUNT
                        $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance - $a->amount,
                        ]);
                        // DEFAULT INVENTORY ACCOUNT
                        $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('debit', 0)
                            ->where('coa_id', $default_product_account->default_inventory_account)
                            ->first();
                        $get_current_balance_on_coa = coa::find($default_product_account->default_inventory_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance + $ambil_avg_price_dari_coadetial->credit,
                        ]);
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
                        $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance - $a->amount,
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
                // DEFAULT SETTING UNBILLED REVENUE
                $default_unbilled_revenue           = default_account::find(6);
                coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('debit', 0)->delete();
                coa_detail::where('type', 'sales invoice')->where('number', 'Sales Invoice #' . $pi->number)->where('credit', 0)->delete();
                // DELETE BALANCE DARI YANG PENGEN DI DELETE (CONTACT)
                $get_current_balance_on_coa         = coa::find($default_unbilled_revenue->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance + $pi->subtotal,
                ]);
                $get_current_balance_on_coa         = coa::find($contact_id->account_receivable_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance - $pi->grandtotal,
                ]);
                $default_unbilled_receivable        = default_account::find(7);
                $get_current_balance_on_coa         = coa::find($default_unbilled_receivable->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance + $pi->subtotal,
                ]);
                // HAPUS PAJAK
                if ($pi->taxtotal > 0) {
                    $get_current_balance_on_coa = coa::find($default_tax->account_id);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $pi->taxtotal,
                    ]);
                }
                // HAPUS BALANCE PER ITEM INVOICE
                $pi_details                         = sale_invoice_item::where('sale_invoice_id', $id)->get();
                foreach ($pi_details as $a) {
                    $default_product_account        = product::find($a->product_id);
                    if ($default_product_account->is_track == 1) {
                        $get_current_balance_on_coa         = coa::find($default_product_account->sell_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'                       => $get_current_balance_on_coa->balance - $a->amount,
                        ]);
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
                        $get_current_balance_on_coa         = coa::find($default_product_account->sell_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'                       => $get_current_balance_on_coa->balance - $a->amount,
                        ]);
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
                // DELETE BALANCE DARI YANG PENGEN DI DELETE (CONTACT)
                $get_current_balance_on_coa         = coa::find($contact_id->account_receivable_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance - $pi->grandtotal,
                ]);
                // HAPUS PAJAK
                if ($pi->taxtotal > 0) {
                    $get_current_balance_on_coa = coa::find($default_tax->account_id);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $pi->taxtotal,
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
                        $get_current_balance_on_coa = coa::find($default_product_account->buy_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance - $ambil_avg_price_dari_coadetial->debit,
                        ]);
                        $ambil_avg_price_dari_coadetial->delete();
                        // DEFAULT SELL ACCOUNT
                        $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance - $a->amount,
                        ]);
                        // DEFAULT INVENTORY ACCOUNT
                        $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('debit', 0)
                            ->where('coa_id', $default_product_account->default_inventory_account)
                            ->first();
                        $get_current_balance_on_coa = coa::find($default_product_account->default_inventory_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance + $ambil_avg_price_dari_coadetial->credit,
                        ]);
                        $ambil_avg_price_dari_coadetial->delete();
                    } else {
                        $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance - $a->amount,
                        ]);
                    }
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
                    // NGUBAH STATUS SI SPK MENJADI CLOSED
                    /*spk::find($pi->selected_spk_id)->update(['status' => 2]);
                    other_transaction::where('type', 'spk')->where('number', $pi->transaction_no_spk)->update(['status' => 2]);*/
                    // DELETE BALANCE DARI YANG PENGEN DI DELETE (CONTACT)
                    $get_current_balance_on_coa         = coa::find($contact_id->account_receivable_id);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'                       => $get_current_balance_on_coa->balance - $pi->grandtotal,
                    ]);
                    // HAPUS PAJAK
                    if ($pi->taxtotal > 0) {
                        $get_current_balance_on_coa = coa::find($default_tax->account_id);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance - $pi->taxtotal,
                        ]);
                    }
                    $cost_bundle                        = sale_invoice_cost::where('sale_invoice_id', $pi->id)->get();
                    if ($cost_bundle != null) {
                        foreach ($cost_bundle as $i => $p) {
                            if ($cost_bundle[$i] != null) {
                                $get_current_balance_on_coa = coa::find($cost_bundle[$i]->coa_id);
                                coa::find($get_current_balance_on_coa->id)->update([
                                    'balance'               => $get_current_balance_on_coa->balance - $cost_bundle[$i]->amount,
                                ]);
                            }
                        }
                    }
                    // HAPUS BALANCE PER ITEM INVOICE
                    $pi_details                         = sale_invoice_item::where('sale_invoice_id', $id)->get();
                    foreach ($pi_details as $a) {
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
                            $get_current_balance_on_coa = coa::find($default_product_account->buy_account);
                            coa::find($get_current_balance_on_coa->id)->update([
                                'balance'               => $get_current_balance_on_coa->balance - $ambil_avg_price_dari_coadetial->debit,
                            ]);
                            $ambil_avg_price_dari_coadetial->delete();
                            // DEFAULT SELL ACCOUNT
                            $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                            coa::find($get_current_balance_on_coa->id)->update([
                                'balance'               => $get_current_balance_on_coa->balance - $a->amount,
                            ]);
                            // DEFAULT INVENTORY ACCOUNT
                            $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                                ->where('number', 'Sales Invoice #' . $pi->number)
                                ->where('debit', 0)
                                ->where('coa_id', $default_product_account->default_inventory_account)
                                ->first();
                            $get_current_balance_on_coa = coa::find($default_product_account->default_inventory_account);
                            coa::find($get_current_balance_on_coa->id)->update([
                                'balance'               => $get_current_balance_on_coa->balance + $ambil_avg_price_dari_coadetial->credit,
                            ]);
                            $ambil_avg_price_dari_coadetial->delete();
                            // PUNYA COST
                            $get_current_balance_on_coa = coa::find(69);
                            coa::find($get_current_balance_on_coa->id)->update([
                                'balance'               => $get_current_balance_on_coa->balance - $a->cost_amount,
                            ]);
                        } else {
                            $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                            coa::find($get_current_balance_on_coa->id)->update([
                                'balance'               => $get_current_balance_on_coa->balance - $a->amount,
                            ]);
                            // PUNYA COST
                            $get_current_balance_on_coa = coa::find(69);
                            coa::find($get_current_balance_on_coa->id)->update([
                                'balance'               => $get_current_balance_on_coa->balance - $a->cost_amount,
                            ]);
                        }
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
                    // NGUBAH STATUS SI SPK MENJADI CLOSED
                    /*spk::find($pi->selected_spk_id)->update(['status' => 2]);
                    other_transaction::where('type', 'spk')->where('number', $pi->transaction_no_spk)->update(['status' => 2]);*/
                    // DELETE BALANCE DARI YANG PENGEN DI DELETE (CONTACT)
                    $get_current_balance_on_coa         = coa::find($contact_id->account_receivable_id);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'                       => $get_current_balance_on_coa->balance - $pi->grandtotal,
                    ]);
                    $cost_bundle                        = sale_invoice_cost::where('sale_invoice_id', $pi->id)->get();
                    if ($cost_bundle != null) {
                        foreach ($cost_bundle as $i => $p) {
                            if ($cost_bundle[$i] != null) {
                                $get_current_balance_on_coa = coa::find($cost_bundle[$i]->coa_id);
                                coa::find($get_current_balance_on_coa->id)->update([
                                    'balance'               => $get_current_balance_on_coa->balance - $cost_bundle[$i]->amount,
                                ]);
                            }
                        }
                    }
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
                // DELETE BALANCE DARI YANG PENGEN DI DELETE (CONTACT)
                $get_current_balance_on_coa         = coa::find($contact_id->account_receivable_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance - $pi->grandtotal,
                ]);
                // HAPUS PAJAK
                if ($pi->taxtotal > 0) {
                    $get_current_balance_on_coa = coa::find($default_tax->account_id);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $pi->taxtotal,
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
                        $get_current_balance_on_coa = coa::find($default_product_account->buy_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance - $ambil_avg_price_dari_coadetial1->debit,
                        ]);
                        $ambil_avg_price_dari_coadetial1->delete();
                        // DEFAULT SELL ACCOUNT
                        $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance - $a->amount,
                        ]);
                        // DEFAULT INVENTORY ACCOUNT
                        $ambil_avg_price_dari_coadetial2 = coa_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('debit', 0)
                            ->where('coa_id', $default_product_account->default_inventory_account)
                            ->first();
                        $get_current_balance_on_coa = coa::find($default_product_account->default_inventory_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance + $ambil_avg_price_dari_coadetial2->credit,
                        ]);
                        $ambil_avg_price_dari_coadetial2->delete();
                    } else {
                        $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance - $a->amount,
                        ]);
                    }
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
                // DELETE BALANCE DARI YANG PENGEN DI DELETE (CONTACT)
                $get_current_balance_on_coa         = coa::find($contact_id->account_receivable_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                       => $get_current_balance_on_coa->balance - $pi->grandtotal,
                ]);
                // HAPUS PAJAK
                if ($pi->taxtotal > 0) {
                    $get_current_balance_on_coa = coa::find($default_tax->account_id);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $pi->taxtotal,
                    ]);
                }
                // HAPUS BALANCE PER ITEM INVOICE
                $pi_details                         = sale_invoice_item::where('sale_invoice_id', $id)->get();
                foreach ($pi_details as $a) {
                    $default_product_account        = product::find($a->product_id);
                    if ($default_product_account->is_track == 1) {
                        // DEFAULT BUY ACCOUNT
                        $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('credit', 0)
                            ->where('coa_id', $default_product_account->buy_account)
                            ->first();
                        $get_current_balance_on_coa = coa::find($default_product_account->buy_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance - $ambil_avg_price_dari_coadetial->debit,
                        ]);
                        $ambil_avg_price_dari_coadetial->delete();
                        // DEFAULT SELL ACCOUNT
                        $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance - $a->amount,
                        ]);
                        // DEFAULT INVENTORY ACCOUNT
                        $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales invoice')
                            ->where('number', 'Sales Invoice #' . $pi->number)
                            ->where('debit', 0)
                            ->where('coa_id', $default_product_account->default_inventory_account)
                            ->first();
                        $get_current_balance_on_coa = coa::find($default_product_account->default_inventory_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance + $ambil_avg_price_dari_coadetial->credit,
                        ]);
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
                        $get_current_balance_on_coa = coa::find($default_product_account->sell_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'               => $get_current_balance_on_coa->balance - $a->amount,
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
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted']);
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

    public function cetak_pdf2($id)
    {
        $pp                         = sale_invoice::find($id);
        $pp_item                    = sale_invoice_item::where('sale_invoice_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', 1)->first();
        $pdf = PDF::loadview('admin.sales.delivery.PrintPDF', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
