<?php

namespace App\Http\Controllers;

use App\company_logo;
use App\company_setting;
use App\purchase_order;
use App\purchase_order_item;
use App\contact;
use App\other_term;
use App\product;
use App\other_unit;
use App\other_tax;
use App\other_transaction;
use App\purchase_delivery;
use App\purchase_invoice;
use App\warehouse;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use PDF;
use App\purchase_quote;
use App\purchase_quote_item;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderController extends Controller
{
    public function select_product()
    {
        if (request()->ajax()) {
            $page = Input::get('page');
            $resultCount = 10;

            $offset = ($page - 1) * $resultCount;

            $breeds = product::where('name', 'LIKE',  '%' . Input::get("term") . '%')->orWhere('code', 'LIKE',  '%' . Input::get("term") . '%')
                ->where('is_buy', 1)
                //->where('is_bundle', 0)
                ->orderBy('name')
                ->skip($offset)
                ->take($resultCount)
                ->get(['id', DB::raw('name as text'), 'code', 'other_unit_id', 'desc', 'buy_price', 'buy_tax', 'is_lock_purchase']);

            $count = product::where('is_buy', 1)->count();
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
                ->where('type_vendor', 1)
                //->where('is_bundle', 0)
                ->orderBy('display_name')
                ->skip($offset)
                ->take($resultCount)
                ->get(['id', DB::raw('display_name as text'), 'term_id', 'email', 'billing_address']);

            $count = contact::where('type_vendor', 1)->count();
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

    public function closeOrder($id)
    {
        DB::beginTransaction();
        try {
            $ambilheader            = purchase_order::find($id);
            other_transaction::where('type', 'purchase order')->where('number', $ambilheader->number)->update([
                'status'  => 2,
            ]);

            purchase_order::find($id)->update([
                'status'  => 2,
            ]);
            DB::commit();
            return response()->json(['success' => 'Data is successfully closed', 'id' => $id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function index()
    {
        $user               = User::find(Auth::id());
        $open_po            = purchase_order::whereIn('status', [1, 4])->count();
        //$payment_last       = purchase_order::where('status', 3)->whereMonth('transaction_date', '<', '30')->count();
        $payment_last       = purchase_order::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->count();
        $overdue            = purchase_order::where('status', 5)->count();
        $open_po_total            = purchase_order::whereIn('status', [1, 4])->sum('grandtotal');
        //$payment_last_total       = purchase_order::where('status', 3)->whereDate('transaction_date', '<', '9')->sum('grandtotal');
        $payment_last_total       = purchase_order::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->sum('grandtotal');
        $overdue_total            = purchase_order::where('status', 5)->sum('grandtotal');
        if (request()->ajax()) {
            //return datatables()->of(Product::all())
            return datatables()->of(purchase_order::with('purchase_order_item', 'contact', 'status')->get())
                /*->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                    return $button;
                })
                ->rawColumns(['action'])*/
                ->make(true);
        }

        return view('admin.purchases.order.index', compact(['user', 'open_po', 'payment_last', 'overdue', 'open_po_total', 'payment_last_total', 'overdue_total']));
    }

    public function create()
    {
        $vendors            = contact::where('type_vendor', true)->get();
        $warehouses         = warehouse::where('id', '>', 0)->get();
        $terms              = other_term::all();
        $products           = product::all();
        $units              = other_unit::all();
        $today              = Carbon::today()->toDateString();
        $todaytambahtiga    = Carbon::today()->addDays(30)->toDateString();
        $taxes              = other_tax::all();
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = purchase_order::latest()->first();
            if ($number != null) {
                $misahm             = explode("/", $number->number);
                $misahy             = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1                    = $misahy[1] + 1;
            $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;
        } else {
            $number             = purchase_order::max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }

        return view('admin.purchases.order.create', compact([
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
        $po                 = purchase_quote::find($id);
        $po_item            = purchase_quote_item::where('purchase_quote_id', $id)->get();
        $today              = Carbon::today()->toDateString();
        $terms              = other_term::all();
        $warehouses         = warehouse::all();
        $products           = product::all();
        $units              = other_unit::all();
        $taxes              = other_tax::all();
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = purchase_order::latest()->first();
            if ($number != null) {
                $misahm             = explode("/", $number->number);
                $misahy             = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1                    = $misahy[1] + 1;
            $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;
        } else {
            $number             = purchase_order::max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }

        return view('admin.purchases.order.createFromQuote', compact([
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
        $vendors            = contact::where('type_vendor', true)->get();
        $warehouses         = warehouse::where('id', '>', 0)->get();
        $terms              = other_term::all();
        $products           = product::all();
        $units              = other_unit::all();
        $today              = Carbon::today()->toDateString();
        $todaytambahtiga    = Carbon::today()->addDays(30)->toDateString();
        $taxes              = other_tax::all();
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = purchase_order::latest()->first();
            if ($number != null) {
                $misahm             = explode("/", $number->number);
                $misahy             = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1                    = $misahy[1] + 1;
            $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;
        } else {
            $number             = purchase_order::max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }

        return view('admin.request.sukses.purchases.order.create', compact(
            'vendors',
            'warehouses',
            'terms',
            'products',
            'units',
            'taxes',
            'today',
            'todaytambahtiga',
            'trans_no'
        ));
    }

    public function store(Request $request)
    {
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = purchase_order::latest()->first();
            if ($number != null) {
                $misahm             = explode("/", $number->number);
                $misahy             = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1                    = $misahy[1] + 1;
            $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;
        } else {
            $number             = purchase_order::max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
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
            $transactions = other_transaction::create([
                'company_id'        => $user->company_id,
                'user_id'           => Auth::id(),
                'transaction_date'  => $request->get('trans_date'),
                'number'            => $trans_no,
                'number_complete'   => 'Purchase Order #' . $trans_no,
                'type'              => 'purchase order',
                'memo'              => $request->get('memo'),
                'contact'           => $request->get('vendor_name'),
                'due_date'          => $request->get('due_date'),
                'status'            => 1,
                'balance_due'       => $request->get('balance'),
                'total'             => $request->get('balance'),
            ]);

            $po = new purchase_order([
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
            ]);

            $transactions->purchase_order()->save($po);
            other_transaction::find($transactions->id)->update([
                'ref_id'            => $po->id,
            ]);
            $total_qty = 0;
            foreach ($request->products as $i => $keys) {
                $pp[$i] = new purchase_order_item([
                    'product_id'                => $request->products[$i],
                    'desc'                      => $request->desc[$i],
                    'qty'                       => $request->qty[$i],
                    'qty_remaining'             => $request->qty[$i],
                    'unit_id'                   => $request->units[$i],
                    'unit_price'                => $request->unit_price[$i],
                    'tax_id'                    => $request->tax[$i],
                    'amountsub'                 => $request->total_price_sub[$i],
                    'amounttax'                 => $request->total_price_tax[$i],
                    'amountgrand'               => $request->total_price_grand[$i],
                    'amount'                    => $request->total_price[$i],
                ]);
                $total_qty      = $total_qty + $request->qty[$i];

                $po->purchase_order_item()->save($pp[$i]);
            };

            purchase_order::find($po->id)->update([
                'total_qty'         => $total_qty,
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
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = purchase_order::latest()->first();
            if ($number != null) {
                $misahm             = explode("/", $number->number);
                $misahy             = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1                    = $misahy[1] + 1;
            $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;
        } else {
            $number             = purchase_order::max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
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
            //$u_id = Carbon::now()->format('dsiH');
            // AMBIL ID SI PURCHASE QUOTE
            $id                     = $request->hidden_id;
            // AMBIL NUMBER SI PURCHASE QUOTE
            $id_number              = $request->hidden_id_number;
            // UPDATE STATUS ON PURCHASE QUOTE & OTHER TRANSACTION QUOTE'S
            $updatepdstatus = array(
                'status'            => 2,
            );
            purchase_quote::where('number', $id_number)->update($updatepdstatus);
            other_transaction::where('number', $id_number)->where('type', 'purchase order')->update($updatepdstatus);
            // CREATE OTHER TRANSACTION ORDER
            $transactions = other_transaction::create([
                'company_id'        => $user->company_id,
                'user_id'           => Auth::id(),
                'transaction_date'  => $request->get('trans_date'),
                'number'            => $trans_no,
                'number_complete'   => 'Purchase Order #' . $trans_no,
                'type'              => 'purchase order',
                'memo'              => $request->get('memo'),
                'contact'           => $request->get('vendor_name'),
                'due_date'          => $request->get('due_date'),
                'status'            => 1,
                'balance_due'       => $request->get('balance'),
                'total'             => $request->get('balance'),
            ]);
            // CREATE PURCHASE ORDER HEADER
            $po = new purchase_order([
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
                'selected_pq_id'    => $id,
                'transaction_no_pq' => $id_number,
            ]);
            $transactions->purchase_order()->save($po);
            other_transaction::find($transactions->id)->update([
                'ref_id'            => $po->id,
            ]);
            $total_qty = 0;
            // CREATE PURCHASE ORDER DETAIL
            foreach ($request->products2 as $i => $keys) {
                $pp[$i] = new purchase_order_item([
                    'product_id'                => $request->products2[$i],
                    'desc'                      => $request->desc[$i],
                    'qty'                       => $request->qty[$i],
                    'qty_remaining'             => $request->qty[$i],
                    'unit_id'                   => $request->units[$i],
                    'unit_price'                => $request->unit_price[$i],
                    'tax_id'                    => $request->tax[$i],
                    'amountsub'                 => $request->total_price_sub[$i],
                    'amounttax'                 => $request->total_price_tax[$i],
                    'amountgrand'               => $request->total_price_grand[$i],
                    'amount'                    => $request->total_price[$i],
                ]);
                $total_qty      = $total_qty + $request->qty[$i];

                $po->purchase_order_item()->save($pp[$i]);
            };

            purchase_order::find($po->id)->update([
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
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = purchase_order::latest()->first();
            if ($number != null) {
                $misahm             = explode("/", $number->number);
                $misahy             = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1                    = $misahy[1] + 1;
            $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;
        } else {
            $number             = purchase_order::max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
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
            if ($request->has('jasa_only')) {
                $jasa_only = 1;
            } else {
                $jasa_only = 0;
            };

            $transactions = other_transaction::create([
                'company_id'        => $user->company_id,
                'user_id'           => Auth::id(),
                'transaction_date'  => $request->get('trans_date'),
                'number'            => $trans_no,
                'number_complete'   => 'Purchase Order #' . $trans_no,
                'type'              => 'purchase order',
                'memo'              => $request->get('memo'),
                'contact'           => $request->get('vendor_name'),
                'due_date'          => $request->get('due_date'),
                'status'            => 1,
                'balance_due'       => $request->get('balance'),
                'total'             => $request->get('balance'),
            ]);
            if ($jasa_only == 0) {
                $po = new purchase_order([
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
                    'jasa_only'         => 0,
                    'subtotal'          => $request->get('subtotal'),
                    'taxtotal'          => $request->get('taxtotal'),
                    'balance_due'       => $request->get('balance'),
                    'grandtotal'        => $request->get('balance'),
                    'message'           => $request->get('message'),
                    'memo'              => $request->get('memo'),
                    'status'            => 1,
                ]);
            } else {
                $po = new purchase_order([
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
                    'jasa_only'         => 1,
                    'subtotal'          => $request->get('subtotal'),
                    'taxtotal'          => $request->get('taxtotal'),
                    'balance_due'       => $request->get('balance'),
                    'grandtotal'        => $request->get('balance'),
                    'message'           => $request->get('message'),
                    'memo'              => $request->get('memo'),
                    'status'            => 1,
                ]);
            }
            $transactions->purchase_order()->save($po);
            other_transaction::find($transactions->id)->update([
                'ref_id'            => $po->id,
            ]);
            $total_qty = 0;
            foreach ($request->products as $i => $keys) {
                $pp[$i] = new purchase_order_item([
                    'product_id'                => $request->products[$i],
                    'desc'                      => $request->desc[$i],
                    'qty'                       => $request->qty[$i],
                    'qty_remaining'             => $request->qty[$i],
                    'unit_id'                   => $request->units[$i],
                    'unit_price'                => $request->unit_price[$i],
                    'tax_id'                    => $request->tax[$i],
                    'amountsub'                 => $request->total_price_sub[$i],
                    'amounttax'                 => $request->total_price_tax[$i],
                    'amountgrand'               => $request->total_price_grand[$i],
                    'amount'                    => $request->total_price[$i],
                ]);
                $total_qty      = $total_qty + $request->qty[$i];

                $po->purchase_order_item()->save($pp[$i]);
            };

            purchase_order::find($po->id)->update([
                'total_qty'         => $total_qty,
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
        $pi             = purchase_order::with(['contact', 'term', 'warehouse', 'product'])->find($id);
        $terms          = other_term::all();
        $products       = purchase_order_item::where('purchase_order_id', $id)->get();
        $units          = other_unit::all();
        $today          = Carbon::today();
        $pi_history     = purchase_invoice::where('selected_po_id', $id)->get();
        $check_pi_history     = purchase_invoice::where('selected_po_id', $id)->first();
        $pd_history     = purchase_delivery::where('selected_po_id', $id)->get();
        $check_pd_history     = purchase_delivery::where('selected_po_id', $id)->first();

        return view(
            'admin.purchases.order.show',
            compact([
                'pi', 'terms', 'products', 'units', 'today', 'pi_history', 'pd_history', 'check_pi_history', 'check_pd_history'

            ])
        );
    }

    public function edit($id)
    {
        $po             = purchase_order::find($id);
        $po_item        = purchase_order_item::where('purchase_order_id', $id)->get();
        $vendors        = contact::where('type_vendor', true)->get();
        $warehouses     = warehouse::all();
        $terms          = other_term::all();
        $products       = product::all();
        $units          = other_unit::all();
        $today          = Carbon::today();
        $taxes          = other_tax::all();
        if ($po->jasa_only == 0) {
            return view('admin.purchases.order.edit', compact(
                'vendors',
                'warehouses',
                'terms',
                'products',
                'units',
                'taxes',
                'today',
                'po',
                'po_item'
            ));
        } else {
            return view('admin.request.sukses.purchases.order.edit', compact(
                'vendors',
                'warehouses',
                'terms',
                'products',
                'units',
                'taxes',
                'today',
                'po',
                'po_item'
            ));
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
            $id = $request->hidden_id;
            $ambilheader = purchase_order::find($id);
            $pp = purchase_order_item::where('purchase_order_id', $id)->get();
            $rp = $request->products;

            other_transaction::where('type', 'purchase order')->where('number', $ambilheader->number)->update([
                'transaction_date'  => $request->get('trans_date'),
                'contact'           => $request->get('vendor_name2'),
                'due_date'          => $request->get('due_date'),
                'balance_due'       => $request->get('balance'),
                'total'             => $request->get('balance'),
            ]);

            purchase_order::find($id)->update([
                'contact_id'        => $request->get('vendor_name2'),
                'email'             => $request->get('email'),
                'address'           => $request->get('vendor_address'),
                'transaction_date'  => $request->get('trans_date'),
                'due_date'          => $request->get('due_date'),
                'term_id'           => $request->get('term_date'),
                'vendor_ref_no'     => $request->get('vendor_no'),
                'warehouse_id'      => $request->get('warehouse'),
                'subtotal'          => $request->get('subtotal'),
                'taxtotal'          => $request->get('taxtotal'),
                'balance_due'       => $request->get('balance'),
                'grandtotal'        => $request->get('balance'),
                'message'           => $request->get('message'),
                'memo'              => $request->get('memo'),
            ]);
            $total_qty = 0;

            //UNTUK UPDATE DATA JIKA BANYAKNYA TETAP
            if (count($rp) == count($pp)) {
                foreach ($request->products2 as $i => $keys) {
                    $pp[$i]->update([
                        'product_id'                => $request->products2[$i],
                        'desc'                      => $request->desc[$i],
                        'qty'                       => $request->qty[$i],
                        'qty_remaining'             => $request->qty[$i],
                        'unit_id'                   => $request->units[$i],
                        'unit_price'                => $request->unit_price[$i],
                        'tax_id'                    => $request->tax[$i],
                        'amountsub'                 => $request->total_price_sub[$i],
                        'amounttax'                 => $request->total_price_tax[$i],
                        'amountgrand'               => $request->total_price_grand[$i],
                        'amount'                    => $request->total_price[$i],
                    ]);
                    $total_qty      = $total_qty + $request->qty[$i];
                }
            }
            //UNTUK UPDATE DATA JIKA BERTAMBAH
            else if (count($rp) >= count($pp)) {
                //UPDATE DATA SEBANYAK INDEX AWAL
                for ($i = 0; $i < count($pp); $i++) {
                    $pp[$i]->update([
                        'product_id'                => $request->products2[$i],
                        'desc'                      => $request->desc[$i],
                        'qty'                       => $request->qty[$i],
                        'qty_remaining'             => $request->qty[$i],
                        'unit_id'                   => $request->units[$i],
                        'unit_price'                => $request->unit_price[$i],
                        'tax_id'                    => $request->tax[$i],
                        'amountsub'                 => $request->total_price_sub[$i],
                        'amounttax'                 => $request->total_price_tax[$i],
                        'amountgrand'               => $request->total_price_grand[$i],
                        'amount'                    => $request->total_price[$i],
                    ]);
                    $total_qty      = $total_qty + $request->qty[$i];
                }
                //KEMUDIAN MEMBUAT DATA SEBANYAK INDEX BARU
                for ($i = count($pp); $i < count($rp); $i++) {
                    $ppo[$i] = purchase_order_item::create([
                        'purchase_order_id'         => $id,
                        'product_id'                => $request->products2[$i],
                        'desc'                      => $request->desc[$i],
                        'qty'                       => $request->qty[$i],
                        'qty_remaining'             => $request->qty[$i],
                        'unit_id'                   => $request->units[$i],
                        'unit_price'                => $request->unit_price[$i],
                        'tax_id'                    => $request->tax[$i],
                        'amountsub'                 => $request->total_price_sub[$i],
                        'amounttax'                 => $request->total_price_tax[$i],
                        'amountgrand'               => $request->total_price_grand[$i],
                        'amount'                    => $request->total_price[$i],
                    ]);
                    $total_qty      = $total_qty + $request->qty[$i];
                };
            }
            //UNTUK UPDATA DATA JIKA BERKURANG
            else {
                //MENGUPDATE DATA BERDASAR BANYAKNYA INDEX
                foreach ($request->products2 as $i => $keys) {
                    $pp[$i]->update([
                        'product_id'                => $request->products2[$i],
                        'desc'                      => $request->desc[$i],
                        'qty'                       => $request->qty[$i],
                        'qty_remaining'             => $request->qty[$i],
                        'unit_id'                   => $request->units[$i],
                        'unit_price'                => $request->unit_price[$i],
                        'tax_id'                    => $request->tax[$i],
                        'amountsub'                 => $request->total_price_sub[$i],
                        'amounttax'                 => $request->total_price_tax[$i],
                        'amountgrand'               => $request->total_price_grand[$i],
                        'amount'                    => $request->total_price[$i],
                    ]);
                    $total_qty      = $total_qty + $request->qty[$i];
                }

                //KEMUDIAN MENGHAPUS DATA KARENA INDEX LEBIH BESAR 
                for ($i = count($rp); $i < count($pp); $i++) {
                    $pp[$i]->delete();
                };
            }

            purchase_order::find($id)->update([
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
            $id = $request->hidden_id;
            $ambilheader = purchase_order::find($id);
            $pp = purchase_order_item::where('purchase_order_id', $id)->get();
            $rp = $request->products;

            other_transaction::where('type', 'purchase order')->where('number', $ambilheader->number)->update([
                'transaction_date'  => $request->get('trans_date'),
                'contact'           => $request->get('vendor_name2'),
                'due_date'          => $request->get('due_date'),
                'balance_due'       => $request->get('balance'),
                'total'             => $request->get('balance'),
            ]);

            if ($request->has('jasa_only')) {
                $jasa_only = 1;
            } else {
                $jasa_only = 0;
            };

            if ($jasa_only == 0) {
                purchase_order::find($id)->update([
                    'contact_id'        => $request->get('vendor_name2'),
                    'email'             => $request->get('email'),
                    'address'           => $request->get('vendor_address'),
                    'transaction_date'  => $request->get('trans_date'),
                    'due_date'          => $request->get('due_date'),
                    'term_id'           => $request->get('term_date'),
                    'vendor_ref_no'     => $request->get('vendor_no'),
                    'warehouse_id'      => $request->get('warehouse'),
                    'jasa_only'         => 0,
                    'subtotal'          => $request->get('subtotal'),
                    'taxtotal'          => $request->get('taxtotal'),
                    'balance_due'       => $request->get('balance'),
                    'grandtotal'        => $request->get('balance'),
                    'message'           => $request->get('message'),
                    'memo'              => $request->get('memo'),
                ]);
            } else {
                purchase_order::find($id)->update([
                    'contact_id'        => $request->get('vendor_name2'),
                    'email'             => $request->get('email'),
                    'address'           => $request->get('vendor_address'),
                    'transaction_date'  => $request->get('trans_date'),
                    'due_date'          => $request->get('due_date'),
                    'term_id'           => $request->get('term_date'),
                    'vendor_ref_no'     => $request->get('vendor_no'),
                    'jasa_only'         => 1,
                    'warehouse_id'      => $request->get('warehouse'),
                    'subtotal'          => $request->get('subtotal'),
                    'taxtotal'          => $request->get('taxtotal'),
                    'balance_due'       => $request->get('balance'),
                    'grandtotal'        => $request->get('balance'),
                    'message'           => $request->get('message'),
                    'memo'              => $request->get('memo'),
                ]);
            }
            $total_qty = 0;

            //UNTUK UPDATE DATA JIKA BANYAKNYA TETAP
            if (count($rp) == count($pp)) {
                foreach ($request->products2 as $i => $keys) {
                    $pp[$i]->update([
                        'product_id'                => $request->products2[$i],
                        'desc'                      => $request->desc[$i],
                        'qty'                       => $request->qty[$i],
                        'qty_remaining'             => $request->qty[$i],
                        'unit_id'                   => $request->units[$i],
                        'unit_price'                => $request->unit_price[$i],
                        'tax_id'                    => $request->tax[$i],
                        'amountsub'                 => $request->total_price_sub[$i],
                        'amounttax'                 => $request->total_price_tax[$i],
                        'amountgrand'               => $request->total_price_grand[$i],
                        'amount'                    => $request->total_price[$i],
                    ]);
                    $total_qty      = $total_qty + $request->qty[$i];
                }
            }
            //UNTUK UPDATE DATA JIKA BERTAMBAH
            else if (count($rp) >= count($pp)) {
                //UPDATE DATA SEBANYAK INDEX AWAL
                for ($i = 0; $i < count($pp); $i++) {
                    $pp[$i]->update([
                        'product_id'                => $request->products2[$i],
                        'desc'                      => $request->desc[$i],
                        'qty'                       => $request->qty[$i],
                        'qty_remaining'             => $request->qty[$i],
                        'unit_id'                   => $request->units[$i],
                        'unit_price'                => $request->unit_price[$i],
                        'tax_id'                    => $request->tax[$i],
                        'amountsub'                 => $request->total_price_sub[$i],
                        'amounttax'                 => $request->total_price_tax[$i],
                        'amountgrand'               => $request->total_price_grand[$i],
                        'amount'                    => $request->total_price[$i],
                    ]);
                    $total_qty      = $total_qty + $request->qty[$i];
                }
                //KEMUDIAN MEMBUAT DATA SEBANYAK INDEX BARU
                for ($i = count($pp); $i < count($rp); $i++) {
                    $ppo[$i] = purchase_order_item::create([
                        'purchase_order_id'         => $id,
                        'product_id'                => $request->products2[$i],
                        'desc'                      => $request->desc[$i],
                        'qty'                       => $request->qty[$i],
                        'qty_remaining'             => $request->qty[$i],
                        'unit_id'                   => $request->units[$i],
                        'unit_price'                => $request->unit_price[$i],
                        'tax_id'                    => $request->tax[$i],
                        'amountsub'                 => $request->total_price_sub[$i],
                        'amounttax'                 => $request->total_price_tax[$i],
                        'amountgrand'               => $request->total_price_grand[$i],
                        'amount'                    => $request->total_price[$i],
                    ]);
                    $total_qty      = $total_qty + $request->qty[$i];
                };
            }
            //UNTUK UPDATA DATA JIKA BERKURANG
            else {
                //MENGUPDATE DATA BERDASAR BANYAKNYA INDEX
                foreach ($request->products2 as $i => $keys) {
                    $pp[$i]->update([
                        'product_id'                => $request->products2[$i],
                        'desc'                      => $request->desc[$i],
                        'qty'                       => $request->qty[$i],
                        'qty_remaining'             => $request->qty[$i],
                        'unit_id'                   => $request->units[$i],
                        'unit_price'                => $request->unit_price[$i],
                        'tax_id'                    => $request->tax[$i],
                        'amountsub'                 => $request->total_price_sub[$i],
                        'amounttax'                 => $request->total_price_tax[$i],
                        'amountgrand'               => $request->total_price_grand[$i],
                        'amount'                    => $request->total_price[$i],
                    ]);
                    $total_qty      = $total_qty + $request->qty[$i];
                }

                //KEMUDIAN MENGHAPUS DATA KARENA INDEX LEBIH BESAR 
                for ($i = count($rp); $i < count($pp); $i++) {
                    $pp[$i]->delete();
                };
            }

            purchase_order::find($id)->update([
                'total_qty'         => $total_qty,
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
            $po                         = purchase_order::find($id);
            if ($po->selected_pq_id) {
                // DELETE STATUS ON SALES QUOTE & OTHER TRANSACTION QUOTE'S
                $updatepdstatus         = array(
                    'status'            => 1,
                );
                purchase_quote::where('number', $po->purchase_quote->number)->update($updatepdstatus);
                other_transaction::where('number', $po->purchase_quote->number)->where('type', 'purchase order')->update($updatepdstatus);
                // DELETE PUNYA SI SLAES ORDER
                other_transaction::where('type', 'purchase order')->where('number', $po->number)->delete();
                purchase_order_item::where('purchase_order_id', $id)->delete();
                $po->delete();
            } else {
                other_transaction::where('type', 'purchase order')->where('number', $po->number)->delete();
                purchase_order_item::where('purchase_order_id', $id)->delete();
                $po->delete();
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
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pp                         = purchase_order::find($id);
        $pp_item                    = purchase_order_item::where('purchase_order_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $logo                       = company_logo::where('company_id', $user->company_id)->latest()->first();
        $pdf = PDF::loadview('admin.purchases.order.PrintPDF_1', compact(['pp', 'pp_item', 'today', 'company', 'logo']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_2($id)
    {
        $user                       = User::find(Auth::id());
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pp                         = purchase_order::find($id);
        $pp_item                    = purchase_order_item::where('purchase_order_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $logo                       = company_logo::where('company_id', $user->company_id)->latest()->first();
        $pdf = PDF::loadview('admin.purchases.order.PrintPDF_2', compact(['pp', 'pp_item', 'today', 'company', 'logo']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_fas($id)
    {
        $user                       = User::find(Auth::id());
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pp                         = purchase_order::find($id);
        $pp_item                    = purchase_order_item::where('purchase_order_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $pdf = PDF::loadview('admin.purchases.order.PrintPDF_FAS', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_gg($id)
    {
        $user                       = User::find(Auth::id());
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pp                         = purchase_order::find($id);
        $pp_item                    = purchase_order_item::where('purchase_order_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $pdf = PDF::loadview('admin.purchases.order.PrintPDF_GG', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = purchase_order::find($id);
        $pp_item                    = purchase_order_item::where('purchase_order_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.purchases.order.PrintPDF_Sukses', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses_surabaya($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = purchase_order::find($id);
        $pp_item                    = purchase_order_item::where('purchase_order_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.purchases.order.PrintPDF_Sukses_Surabaya', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
