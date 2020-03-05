<?php

namespace App\Http\Controllers;

use App\Model\purchase\purchase_invoice;
use App\Model\purchase\purchase_invoice_item;
use App\Model\purchase\purchase_invoice_po;
use App\Model\purchase\purchase_delivery;
use App\Model\purchase\purchase_delivery_item;
use App\Model\purchase\purchase_order;
use App\Model\purchase\purchase_order_item;
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
use PDF;
use App\Model\company\company_logo;
use App\Model\purchase\purchase_quote;
use App\Model\purchase\purchase_quote_item;
use App\Model\purchase\purchase_invoice_po_item;
use App\Model\purchase\purchase_payment_item;
use App\Model\purchase\purchase_return;
use App\Model\sales\sale_invoice_item;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class PurchaseInvoiceController extends Controller
{
    public function benerin_avg_price()
    {
        DB::beginTransaction();
        try {
            $ambil_semua_product            = product::get();
            foreach ($ambil_semua_product as $asp) {
                $ambil_pi_item                  = purchase_invoice_item::where('product_id', $asp->id)->with('purchase_invoice')->get()->sortBy(function ($pi) {
                    return $pi->purchase_invoice->transaction_date;
                });
                $ambil_si_item                  = sale_invoice_item::where('product_id', $asp->id)->with('sale_invoice')->get()->sortBy(function ($si) {
                    return $si->sale_invoice->transaction_date;
                });
                $merged = $ambil_pi_item->merge($ambil_si_item);
                $sorted = $merged->sortBy('transaction_date')->sortBy('created_at');
                //dd($sorted[0]->sale_invoice);
                foreach ($sorted as $disort) {
                    //dd($disort->sale_invoice);
                    if ($disort->sale_invoice) {
                        $asp->update([
                            'qty'                   => $asp->qty - $disort->qty,
                        ]);
                    } else if ($disort->purchase_invoice) {
                        $dibagi                     = $asp->qty + $disort->qty;
                        if ($dibagi < 0) {
                            $avg_price              = $disort->unit_price;
                        } else if ($dibagi > 0) {
                            $avg_price              = (($asp->qty * $asp->avg_price) + ($disort->qty * $disort->unit_price)) / ($dibagi);
                        } else {
                            $avg_price              = ($disort->qty * $disort->unit_price)/* / ($dibagi)*/;
                        }
                        $asp->update([
                            'qty'                   => $asp->qty + $disort->qty,
                            'avg_price'             => abs($avg_price),
                        ]);
                    }
                }
            }
            //dd($sorted);
            DB::commit();
            return response()->json(['errors' => 'berhasil']);
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

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

    public function index()
    {
        $user               = User::find(Auth::id());
        $open_po            = purchase_invoice::whereIn('status', [1, 4])->count();
        $payment_last       = purchase_invoice::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->count();
        $overdue            = purchase_invoice::where('status', 5)->count();
        $open_po_total            = purchase_invoice::whereIn('status', [1, 4])->sum('balance_due');
        $payment_last_total       = purchase_invoice::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->sum('grandtotal');
        $overdue_total            = purchase_invoice::where('status', 5)->sum('grandtotal');
        if (request()->ajax()) {
            //return datatables()->of(Product::all())
            return datatables()->of(purchase_invoice::with('purchase_invoice_item', 'contact', 'status', 'warehouse')->get())
                /*->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                    return $button;
                })
                ->rawColumns(['action'])*/
                ->make(true);
        }

        return view('admin.purchases.invoices.index', compact(['user', 'open_po', 'payment_last', 'overdue', 'open_po_total', 'payment_last_total', 'overdue_total']));
    }

    public function create()
    {
        $vendors                = contact::where('type_vendor', true)->get();
        $warehouses             = warehouse::where('id', '>', 0)->get();
        $terms                  = other_term::all();
        $products               = product::where('is_buy', 1)->get();
        $units                  = other_unit::all();
        $today                  = Carbon::today()->toDateString();
        $todaytambahtiga        = Carbon::today()->addDays(30)->toDateString();
        $taxes                  = other_tax::all();
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = purchase_invoice::latest()->first();
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
                    $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                } else {
                    $check_number   = purchase_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                    }
                }
            } else {
                $check_number   = purchase_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                if ($check_number) {
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                } else {
                    $number1    = 10001;
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                }
            }
        } else {
            $number             = purchase_invoice::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }

        return view('admin.purchases.invoices.create', compact([
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

    public function createRequestSuksesPartOne()
    {
        $warehouses         = warehouse::get();

        return view('admin.request.sukses.purchases.invoices.createRequestSuksesPartOne', compact(['warehouses']));
    }

    public function createRequestSuksesPartTwo($contact, $warehouse)
    {
        $all_po                 = purchase_order::where('contact_id', $contact)->where('warehouse_id', $warehouse)->get();
        $all_po_item            = purchase_order_item::get();
        $vendors                = contact::find($contact);
        $warehouses             = warehouse::find($warehouse);
        $terms                  = other_term::all();
        $today                  = Carbon::today()->toDateString();
        $todaytambahtiga        = Carbon::today()->addDays(30)->toDateString();
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = purchase_invoice::latest()->first();
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
                    $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                } else {
                    $check_number   = purchase_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                    }
                }
            } else {
                $check_number   = purchase_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                if ($check_number) {
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                } else {
                    $number1    = 10001;
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                }
            }
        } else {
            $number             = purchase_invoice::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }

        return view('admin.request.sukses.purchases.invoices.createRequestSuksesPartTwo', compact([
            'all_po',
            'all_po_item',
            'vendors',
            'warehouses',
            'terms',
            'today',
            'todaytambahtiga',
            'trans_no'
        ]));
    }

    public function createFromDelivery($id)
    {
        $po                     = purchase_delivery::find($id);
        $po_item                = purchase_delivery_item::where('purchase_delivery_id', $id)->get();
        $today                  = Carbon::today()->toDateString();
        $terms                  = other_term::all();
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = purchase_invoice::latest()->first();
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
                    $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                } else {
                    $check_number   = purchase_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                    }
                }
            } else {
                $check_number   = purchase_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                if ($check_number) {
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                } else {
                    $number1    = 10001;
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                }
            }
        } else {
            $number             = purchase_invoice::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }

        return view('admin.purchases.invoices.createFromDelivery', compact(['today', 'trans_no', 'terms', 'po', 'po_item']));
    }

    public function createFromOrder($id)
    {
        $po                     = purchase_order::find($id);
        $po_item                = purchase_order_item::where('purchase_order_id', $id)->get();
        $today                  = Carbon::today()->toDateString();
        $terms                  = other_term::all();
        $warehouses             = warehouse::all();
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = purchase_invoice::latest()->first();
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
                    $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                } else {
                    $check_number   = purchase_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                    }
                }
            } else {
                $check_number   = purchase_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                if ($check_number) {
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                } else {
                    $number1    = 10001;
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                }
            }
        } else {
            $number             = purchase_invoice::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }

        return view('admin.purchases.invoices.createFromOrder', compact(['today', 'trans_no', 'terms', 'warehouses', 'po', 'po_item']));
    }

    public function createFromQuote($id)
    {
        $po                     = purchase_quote::find($id);
        $po_item                = purchase_quote_item::where('purchase_quote_id', $id)->get();
        $today                  = Carbon::today()->toDateString();
        $terms                  = other_term::all();
        $warehouses             = warehouse::all();
        $products               = product::all();
        $units                  = other_unit::all();
        $taxes                  = other_tax::all();
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = purchase_invoice::latest()->first();
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
                    $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                } else {
                    $check_number   = purchase_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                    }
                }
            } else {
                $check_number   = purchase_invoice::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                if ($check_number) {
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                } else {
                    $number1    = 10001;
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PI';
                }
            }
        } else {
            $number             = purchase_invoice::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }

        return view('admin.purchases.invoices.createFromQuote', compact([
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

    public function store(Request $request)
    {
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = purchase_invoice::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                $check_number   = purchase_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.PI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.PI';
                }
            } else {
                $check_number   = purchase_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.PI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.PI';
                }
            }
        } else {
            $number             = purchase_invoice::max('number');
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
            $id_contact                     = $request->vendor_name;
            $contact_account                = contact::find($id_contact);

            $transactions                   = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                    => $trans_no,
                'number_complete'           => 'Purchase Invoice #' . $trans_no,
                'type'                      => 'purchase invoice',
                'memo'                      => $request->get('memo'),
                'transaction_date'          => $request->get('trans_date'),
                'due_date'                  => $request->get('due_date'),
                'contact'                   => $request->get('vendor_name'),
                'status'                    => 1,
                'balance_due'               => $request->get('balance'),
                'total'                     => $request->get('balance'),
            ]);

            $pi                             = new purchase_invoice([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
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
            //$pi->save();
            $transactions->purchase_invoice()->save($pi);
            other_transaction::find($transactions->id)->update([
                'ref_id'                    => $pi->id,
            ]);

            coa_detail::create([
                'company_id'                => $user->company_id,
                'user_id'                   => Auth::id(),
                'ref_id'                    => $pi->id,
                'other_transaction_id'      => $transactions->id,
                'coa_id'                    => $contact_account->account_payable_id,
                'date'                      => $request->get('trans_date'),
                'type'                      => 'purchase invoice',
                'number'                    => 'Purchase Invoice #' . $trans_no,
                'contact_id'                => $request->get('vendor_name'),
                'debit'                     => 0,
                'credit'                    => $request->get('balance'),
            ]);

            if ($request->taxtotal > 0) {
                $default_tax                = default_account::find(14);
                coa_detail::create([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'ref_id'                => $pi->id,
                    'other_transaction_id'  => $transactions->id,
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'purchase invoice',
                    'number'                => 'Purchase Invoice #' . $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => $request->get('taxtotal'),
                    'credit'                => 0,
                ]);
            }

            foreach ($request->products as $i => $product) {
                //menyimpan detail per item dari invoicd
                $pp[$i]                     = new purchase_invoice_item([
                    'product_id'            => $request->products[$i],
                    'desc'                  => $request->desc[$i],
                    'qty'                   => $request->qty[$i],
                    'qty_remaining_return'  => $request->qty[$i],
                    'unit_id'               => $request->units[$i],
                    'unit_price'            => $request->unit_price[$i],
                    'tax_id'                => $request->tax[$i],
                    'amountsub'             => $request->total_price_sub[$i],
                    'amounttax'             => $request->total_price_tax[$i],
                    'amountgrand'           => $request->total_price_grand[$i],
                    'amount'                => $request->total_price[$i],
                ]);
                $pi->purchase_invoice_item()->save($pp[$i]);

                $default_product_account = product::find($request->products[$i]);
                // DEFAULT INVENTORY 17 dan yang di input di debit ini adalah total harga dari per barang
                if ($default_product_account->is_track == 1) {
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'purchase invoice',
                        'number'                => 'Purchase Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $request->total_price[$i],
                        'credit'                => 0,
                    ]);
                } else {
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pi->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->buy_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'purchase invoice',
                        'number'                => 'Purchase Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $request->total_price[$i],
                        'credit'                => 0,
                    ]);
                }
                //menambahkan stok barang ke gudang
                warehouse_detail::create([
                    'type'                  => 'purchase invoice',
                    'number'                => 'Purchase Invoice #' . $trans_no,
                    'product_id'            => $request->products[$i],
                    'warehouse_id'          => $request->warehouse,
                    'date'                  => $request->trans_date,
                    'qty_in'                => $request->qty[$i],
                ]);
                /*$wh->type                   = 'purchase invoice';
                $wh->number                 = 'Purchase Invoice #' . $trans_no;
                $wh->product_id             = $request->products[$i];
                $wh->warehouse_id           = $request->warehouse;
                $wh->qty                    = $request->qty[$i];
                $wh->save();*/

                //merubah harga average produk
                $produk                     = product::find($request->products[$i]);
                $qty                        = $request->qty[$i];
                $price                      = $request->unit_price[$i];
                $dibagi                     = $produk->qty + $qty;
                if ($dibagi == 0) {
                    $curr_avg_price             = (($produk->qty * $produk->avg_price) + ($qty * $price));
                } else {
                    $curr_avg_price             = (($produk->qty * $produk->avg_price) + ($qty * $price)) / ($dibagi);
                }
                //dd(abs($curr_avg_price));
                //menyimpan jumlah perubahan pada produk
                product::where('id', $request->products[$i])->update([
                    'qty'                   => $produk->qty + $qty,
                    'avg_price'             => abs($curr_avg_price),
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
        if ($user->company_id == 5) {
            $number             = purchase_invoice::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                $check_number   = purchase_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.PI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.PI';
                }
            } else {
                $check_number   = purchase_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.PI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.PI';
                }
            }
        } else {
            $number             = purchase_invoice::max('number');
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
            $id                 = $request->hidden_id;
            $id_number          = $request->hidden_id_number;
            $id_po              = $request->hidden_id_po;
            $id_no_po           = $request->hidden_id_no_po;
            $id_contact         = $request->vendor_name;

            $transactions = other_transaction::create([
                'company_id'        => $user->company_id,
                'user_id'           => Auth::id(),
                'number'            => $trans_no,
                'number_complete'   => 'Purchase Invoice #' . $trans_no,
                'type'              => 'purchase invoice',
                'memo'              => $request->get('memo'),
                'transaction_date'  => $request->get('trans_date'),
                'due_date'          => $request->get('due_date'),
                'contact'           => $request->get('vendor_name'),
                'status'            => 1,
                'balance_due'       => $request->get('balance'),
                'total'             => $request->get('balance'),
            ]);

            $pd = new purchase_invoice([
                'company_id'        => $user->company_id,
                'user_id'           => Auth::id(),
                'number'            => $trans_no,
                'contact_id'        => $request->get('vendor_name'),
                'email'             => $request->get('email'),
                'address'           => $request->get('vendor_address'),
                'transaction_date'  => $request->get('trans_date'),
                'due_date'          => $request->get('due_date'),
                'term_id'           => $request->get('term'),
                'transaction_no_po' => $id_no_po,
                'transaction_no_pd' => $id_number,
                'vendor_ref_no'     => $request->get('vendor_no'),
                'warehouse_id'      => $request->get('warehouse'),
                'subtotal'          => $request->get('subtotal'),
                'taxtotal'          => $request->get('taxtotal'),
                'balance_due'       => $request->get('balance'),
                'grandtotal'        => $request->get('balance'),
                'message'           => $request->get('message'),
                'memo'              => $request->get('memo'),
                'status'            => 1,
                'selected_pd_id'    => $id,
                'selected_po_id'    => $id_po,
            ]);
            //$pd->save();
            $transactions->purchase_invoice()->save($pd);
            other_transaction::find($transactions->id)->update([
                'ref_id'                => $pd->id,
            ]);

            $default_unbilled_payable   = default_account::find(13);
            // yang di input di debit disini adalah total dari keseluruhan
            coa_detail::create([
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'ref_id'                => $pd->id,
                'other_transaction_id'  => $transactions->id,
                'coa_id'                => $default_unbilled_payable->account_id,
                'date'                  => $request->get('trans_date'),
                'type'                  => 'purchase invoice',
                'number'                => 'Purchase Invoice #' . $trans_no,
                'contact_id'            => $request->get('vendor_name'),
                'debit'                 => $request->get('subtotal'),
                'credit'                => 0,
            ]);

            $contact_account = contact::find($id_contact);
            coa_detail::create([
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'ref_id'                => $pd->id,
                'other_transaction_id'  => $transactions->id,
                'coa_id'                => $contact_account->account_payable_id,
                'date'                  => $request->get('trans_date'),
                'type'                  => 'purchase invoice',
                'number'                => 'Purchase Invoice #' . $trans_no,
                'contact_id'            => $request->get('vendor_name'),
                'debit'                 => 0,
                'credit'                => $request->get('balance'),
            ]);

            if ($request->taxtotal > 0) {
                $default_tax                = default_account::find(14);
                coa_detail::create([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'ref_id'                => $pd->id,
                    'other_transaction_id'  => $transactions->id,
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'purchase invoice',
                    'number'                => 'Purchase Invoice #' . $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => $request->get('taxtotal'),
                    'credit'                => 0,
                ]);
            }

            foreach ($request->products as $i => $keys) {
                $pp[$i] = new purchase_invoice_item([
                    'product_id'            => $request->products[$i],
                    'desc'                  => $request->desc[$i],
                    'qty'                   => $request->qty[$i],
                    'qty_remaining_return'  => $request->qty[$i],
                    'unit_id'               => $request->units[$i],
                    'unit_price'            => $request->unit_price[$i],
                    'tax_id'                => $request->tax[$i],
                    'amountsub'             => $request->total_price_sub[$i],
                    'amounttax'             => $request->total_price_tax[$i],
                    'amountgrand'           => $request->total_price_grand[$i],
                    'amount'                => $request->total_price[$i],
                    //'qty_remaining' => $request->r_qty[$i],
                ]);
                $pd->purchase_invoice_item()->save($pp[$i]);

                //menambahkan stok barang ke gudang
                $wh = new warehouse_detail();
                $wh->type                   = 'purchase invoice';
                $wh->number                 = 'Purchase Invoice #' . $trans_no;
                $wh->product_id             = $request->products[$i];
                $wh->warehouse_id           = $request->warehouse;
                $wh->date                   = $request->trans_date;
                $wh->qty_in                 = $request->qty[$i];
                $wh->save();

                //merubah harga average produk
                $produk                     = product::find($request->products[$i]);
                $qty                        = $request->qty[$i];
                $price                      = $request->unit_price[$i];
                $dibagi                     = $produk->qty + $qty;
                if ($dibagi == 0) {
                    $curr_avg_price             = (($produk->qty * $produk->avg_price) + ($qty * $price));
                } else {
                    $curr_avg_price             = (($produk->qty * $produk->avg_price) + ($qty * $price)) / ($dibagi);
                }
                //dd(abs($curr_avg_price));
                //menyimpan jumlah perubahan pada produk
                product::where('id', $request->products[$i])->update([
                    'qty'                   => $produk->qty + $qty,
                    'avg_price'             => abs($curr_avg_price),
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
        if ($user->company_id == 5) {
            $number             = purchase_invoice::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                $check_number   = purchase_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.PI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.PI';
                }
            } else {
                $check_number   = purchase_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.PI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.PI';
                }
            }
        } else {
            $number             = purchase_invoice::max('number');
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
            $id                 = $request->hidden_id;
            // AMBIL NUMBER DARI IS ORDER PUNYA
            $id_number          = $request->hidden_id_number;
            $id_contact         = $request->vendor_name;
            // BUAT NGECHECK INI QUANTITY YANG DIINPUT LEBIH DARI YANG DI ORDER ATAU TIDAK
            foreach ($request->products as $i => $keys) {
                if ($request->qty[$i] < 0) {
                    DB::rollBack();
                    return response()->json(['errors' => 'Quantity cannot be less than zero']);
                } else if ($request->r_qty[$i] < 0) {
                    DB::rollBack();
                    return response()->json(['errors' => 'Quantity cannot be more than stock']);
                } else if ($request->qty[$i] == 0) {
                    DB::rollBack();
                    return response()->json(['errors' => 'Quantity must be more than zero']);
                }
            }
            // CREATE COA DETAIL BERDASARKAN DARI CONTACT DEFAULT
            $contact_account                = contact::find($id_contact);
            // MENGUBAH STATUS SI PURCHASE ORDER DAN OTHER TRANSACTION DARI OPEN KE CLOSED
            $check_total_po                 = purchase_order::find($id);
            $check_total_po->update([
                'balance_due'               => $check_total_po->balance_due - $request->balance,
            ]);
            if ($check_total_po->balance_due == 0) {
                $updatepdstatus             = array(
                    'status'                => 2,
                );
                purchase_order::where('number', $id_number)->update($updatepdstatus);
                other_transaction::where('number', $id_number)->where('type', 'purchase order')->update($updatepdstatus);
            } else {
                $updatepdstatus             = array(
                    'status'                => 4,
                );
                purchase_order::where('number', $id_number)->update($updatepdstatus);
                other_transaction::where('number', $id_number)->where('type', 'purchase order')->update($updatepdstatus);
            }
            // CREATE OTHER TRANSACTION PUNYA SI INVOICE
            $transactions                   = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                    => $trans_no,
                'number_complete'           => 'Purchase Invoice #' . $trans_no,
                'type'                      => 'purchase invoice',
                'memo'                      => $request->get('memo'),
                'transaction_date'          => $request->get('trans_date'),
                'due_date'                  => $request->get('due_date'),
                'contact'                   => $request->get('vendor_name'),
                'status'                    => 1,
                'balance_due'               => $request->get('balance'),
                'total'                     => $request->get('balance'),
            ]);
            // CREATE HEADERNYA SEKALIAN MASUKKIN OTHER_TRANSACTION_ID DIDALEMNYA
            $pd = new purchase_invoice([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                    => $trans_no,
                'contact_id'                => $request->get('vendor_name'),
                'email'                     => $request->get('email'),
                'address'                   => $request->get('vendor_address'),
                'transaction_date'          => $request->get('trans_date'),
                'due_date'                  => $request->get('due_date'),
                'term_id'                   => $request->get('term'),
                'transaction_no_po'         => $id_number,
                'vendor_ref_no'             => $request->get('vendor_no'),
                'warehouse_id'              => $request->get('warehouse'),
                'subtotal'                  => $request->get('subtotal'),
                'taxtotal'                  => $request->get('taxtotal'),
                'balance_due'               => $request->get('balance'),
                'grandtotal'                => $request->get('balance'),
                'message'                   => $request->get('message'),
                'memo'                      => $request->get('memo'),
                'status'                    => 1,
                'selected_po_id'            => $id,
            ]);
            $transactions->purchase_invoice()->save($pd);
            other_transaction::find($transactions->id)->update([
                'ref_id'                    => $pd->id,
            ]);

            coa_detail::create([
                'company_id'                => $user->company_id,
                'user_id'                   => Auth::id(),
                'ref_id'                    => $pd->id,
                'other_transaction_id'      => $transactions->id,
                'coa_id'                    => $contact_account->account_payable_id,
                'date'                      => $request->get('trans_date'),
                'type'                      => 'purchase invoice',
                'number'                    => 'Purchase Invoice #' . $trans_no,
                'contact_id'                => $request->get('vendor_name'),
                'debit'                     => 0,
                'credit'                    => $request->get('balance'),
            ]);

            if ($request->taxtotal > 0) {
                $default_tax                    = default_account::find(14);
                coa_detail::create([
                    'company_id'                => $user->company_id,
                    'user_id'                   => Auth::id(),
                    'ref_id'                    => $pd->id,
                    'other_transaction_id'      => $transactions->id,
                    'coa_id'                    => $default_tax->account_id,
                    'date'                      => $request->get('trans_date'),
                    'type'                      => 'purchase invoice',
                    'number'                    => 'Purchase Invoice #' . $trans_no,
                    'contact_id'                => $request->get('vendor_name'),
                    'debit'                     => $request->get('taxtotal'),
                    'credit'                    => 0,
                ]);
            }

            foreach ($request->products as $i => $keys) {
                // CREATE DETAILSNYA SEKALIAN MASUKKIN PURCHASE_INVOICE_ID DIDALEMNYA
                $pp[$i] = new purchase_invoice_item([
                    'purchase_order_item_id'    => $request->po_id[$i],
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
                    'qty_remaining_return'      => $request->r_qty[$i],
                ]);
                $pd->purchase_invoice_item()->save($pp[$i]);
                $updatepunyapo                  = purchase_order_item::find($request->po_id[$i]);
                $updatepunyapo->update([
                    'qty_remaining'             => $updatepunyapo->qty_remaining - $request->qty[$i]
                ]);
                // CREATE COA DETAIL BERDASARKAN PRODUCT SETTING
                $default_product_account        = product::find($request->products[$i]);
                if ($default_product_account->is_track == 1) {
                    coa_detail::create([
                        'company_id'                => $user->company_id,
                        'user_id'                   => Auth::id(),
                        'ref_id'                    => $pd->id,
                        'other_transaction_id'      => $transactions->id,
                        'coa_id'                    => $default_product_account->default_inventory_account,
                        'date'                      => $request->get('trans_date'),
                        'type'                      => 'purchase invoice',
                        'number'                    => 'Purchase Invoice #' . $trans_no,
                        'contact_id'                => $request->get('vendor_name'),
                        'debit'                     => $request->total_price[$i],
                        'credit'                    => 0,
                    ]);
                } else {
                    coa_detail::create([
                        'company_id'                => $user->company_id,
                        'user_id'                   => Auth::id(),
                        'ref_id'                    => $pd->id,
                        'other_transaction_id'      => $transactions->id,
                        'coa_id'                    => $default_product_account->buy_account,
                        'date'                      => $request->get('trans_date'),
                        'type'                      => 'purchase invoice',
                        'number'                    => 'Purchase Invoice #' . $trans_no,
                        'contact_id'                => $request->get('vendor_name'),
                        'debit'                     => $request->total_price[$i],
                        'credit'                    => 0,
                    ]);
                }

                //menambahkan stok barang ke gudang
                $wh = new warehouse_detail();
                $wh->type                   = 'purchase invoice';
                $wh->number                 = 'Purchase Invoice #' . $trans_no;
                $wh->product_id             = $request->products[$i];
                $wh->warehouse_id           = $request->warehouse;
                $wh->date                   = $request->trans_date;
                $wh->qty_in                 = $request->qty[$i];
                $wh->save();

                //merubah harga average produk
                $produk                     = product::find($request->products[$i]);
                $qty                        = $request->qty[$i];
                $price                      = $request->unit_price[$i];
                $dibagi                     = $produk->qty + $qty;
                if ($dibagi == 0) {
                    $curr_avg_price             = (($produk->qty * $produk->avg_price) + ($qty * $price));
                } else {
                    $curr_avg_price             = (($produk->qty * $produk->avg_price) + ($qty * $price)) / ($dibagi);
                }
                //dd(abs($curr_avg_price));
                //menyimpan jumlah perubahan pada produk
                product::where('id', $request->products[$i])->update([
                    'qty' => $produk->qty + $qty,
                    'avg_price' => abs($curr_avg_price),
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
        if ($user->company_id == 5) {
            $number             = purchase_invoice::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                $check_number   = purchase_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.PI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.PI';
                }
            } else {
                $check_number   = purchase_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.PI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.PI';
                }
            }
        } else {
            $number             = purchase_invoice::max('number');
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
            // AMBIL ID SI PURCHASE QUOTE
            $id                 = $request->hidden_id;
            // AMBIL NUMBER SI PURCHASE QUOTE
            $id_number          = $request->hidden_id_number;
            $id_contact         = $request->vendor_name;
            // CREATE COA DETAIL BASED ON CONTACT SETTING ACCOUNT
            $contact_account = contact::find($id_contact);
            // UPDATE STATUS ON PURCHASE QUOTE & OTHER TRANSACTION QUOTE'S
            $updatepdstatus = array(
                'status'        => 2,
            );
            purchase_quote::where('number', $id_number)->update($updatepdstatus);
            other_transaction::where('number', $id_number)->where('type', 'purchase quote')->update($updatepdstatus);
            // CREATE LIST OTHER TRANSACTION PUNYA INVOICE
            $transactions = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'transaction_date'          => $request->get('trans_date'),
                'number'                    => $trans_no,
                'number_complete'           => 'Purchase Invoice #' . $trans_no,
                'type'                      => 'purchase invoice',
                'memo'                      => $request->get('memo'),
                'contact'                   => $request->get('vendor_name'),
                'due_date'                  => $request->get('due_date'),
                'status'                    => 1,
                'balance_due'               => $request->get('balance'),
                'total'                     => $request->get('balance'),
            ]);
            // CREATE PURCHASE INVOICE HEADER
            $pd = new purchase_invoice([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                    => $trans_no,
                'contact_id'                => $request->get('vendor_name'),
                'email'                     => $request->get('email'),
                'address'                   => $request->get('vendor_address'),
                'transaction_date'          => $request->get('trans_date'),
                'due_date'                  => $request->get('due_date'),
                'term_id'                   => $request->get('term'),
                'transaction_no_pq'         => $id_number,
                'vendor_ref_no'             => $request->get('vendor_no'),
                'warehouse_id'              => $request->get('warehouse'),
                'subtotal'                  => $request->get('subtotal'),
                'taxtotal'                  => $request->get('taxtotal'),
                'balance_due'               => $request->get('balance'),
                'grandtotal'                => $request->get('balance'),
                'message'                   => $request->get('message'),
                'memo'                      => $request->get('memo'),
                'status'                    => 1,
                'selected_pq_id'            => $id,
            ]);
            $transactions->purchase_invoice()->save($pd);
            other_transaction::find($transactions->id)->update([
                'ref_id'                    => $pd->id,
            ]);

            coa_detail::create([
                'company_id'                => $user->company_id,
                'user_id'                   => Auth::id(),
                'ref_id'                    => $pd->id,
                'other_transaction_id'      => $transactions->id,
                'coa_id'                    => $contact_account->account_payable_id,
                'date'                      => $request->get('trans_date'),
                'type'                      => 'purchase invoice',
                'number'                    => 'Purchase Invoice #' . $trans_no,
                'contact_id'                => $request->get('vendor_name'),
                'debit'                     => 0,
                'credit'                    => $request->get('balance'),
            ]);

            if ($request->taxtotal > 0) {
                $default_tax                = default_account::find(14);
                coa_detail::create([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'ref_id'                => $pd->id,
                    'other_transaction_id'  => $transactions->id,
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'purchase invoice',
                    'number'                => 'Purchase Invoice #' . $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => $request->get('taxtotal'),
                    'credit'                => 0,
                ]);
            }

            // CREATE PURCHASE INVOICE DETAILS
            foreach ($request->products as $i => $keys) {
                $pp[$i] = new purchase_invoice_item([
                    'product_id'            => $request->products[$i],
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
                $pd->purchase_invoice_item()->save($pp[$i]);
                // CREATE COA DETAIL BASED ON PRODUCT SETTING
                $default_product_account = product::find($request->products[$i]);
                if ($default_product_account->is_track == 1) {
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pd->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'purchase invoice',
                        'number'                => 'Purchase Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $request->total_price[$i],
                        'credit'                => 0,
                    ]);
                } else {
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pd->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->buy_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'purchase invoice',
                        'number'                => 'Purchase Invoice #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $request->total_price[$i],
                        'credit'                => 0,
                    ]);
                }
                //menambahkan stok barang ke gudang
                warehouse_detail::create([
                    'type'                  => 'purchase invoice',
                    'number'                => 'Purchase Invoice #' . $trans_no,
                    'product_id'            => $request->products[$i],
                    'warehouse_id'          => $request->warehouse,
                    'date'                  => $request->trans_date,
                    'qty_in'                => $request->qty[$i],
                ]);
                /*$wh->type                   = 'purchase invoice';
                $wh->number                 = 'Purchase Invoice #' . $trans_no;
                $wh->product_id             = $request->products[$i];
                $wh->warehouse_id           = $request->warehouse;
                $wh->qty                    = $request->qty[$i];
                $wh->save();*/
                //merubah harga average produk
                $produk                     = product::find($request->products[$i]);
                $qty                        = $request->qty[$i];
                $price                      = $request->unit_price[$i];
                $dibagi                     = $produk->qty + $qty;
                if ($dibagi == 0) {
                    $curr_avg_price             = (($produk->qty * $produk->avg_price) + ($qty * $price));
                } else {
                    $curr_avg_price             = (($produk->qty * $produk->avg_price) + ($qty * $price)) / ($dibagi);
                }
                //menyimpan jumlah perubahan pada produk
                product::where('id', $request->products[$i])->update([
                    'qty'                   => $produk->qty + $qty,
                    'avg_price'             => abs($curr_avg_price),
                ]);
            };
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $pd->id]);
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
            $number             = purchase_invoice::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                $check_number   = purchase_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.PI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.PI';
                }
            } else {
                $check_number   = purchase_invoice::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.PI';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.PI';
                }
            }
        } else {
            $number             = purchase_invoice::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }
        DB::beginTransaction();
        try {
            $x                      = 0;
            // CREATE OTHER TRANSACTION PUNYA SI INVOICE
            $transactions = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'            => $trans_no,
                'number_complete'   => 'Purchase Invoice #' . $trans_no,
                'type'              => 'purchase invoice',
                'memo'              => $request->get('memo'),
                'transaction_date'  => $request->get('trans_date'),
                'due_date'          => $request->get('due_date'),
                'contact'           => $request->get('vendor_name'),
                'status'            => 1,
                'balance_due'       => $request->get('balance'),
                'total'             => $request->get('balance'),
            ]);
            // CREATE HEADERNYA SEKALIAN MASUKKIN OTHER_TRANSACTION_ID DIDALEMNYA
            $pd = new purchase_invoice([
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
                'subtotal'          => $request->get('balance'),
                //'taxtotal'          => $request->get('balance'),
                'balance_due'       => $request->get('balance'),
                'grandtotal'        => $request->get('balance'),
                'message'           => $request->get('message'),
                'memo'              => $request->get('memo'),
                'status'            => 1,
            ]);
            $transactions->purchase_invoice()->save($pd);
            other_transaction::find($transactions->id)->update([
                'ref_id'                    => $pd->id,
            ]);
            foreach ($request->po_id as $i => $keys) {
                //if ($request->po_id[$i] > 0) {
                //var_dump('po id = ' . $request->po_id[$i]);
                // MENGUBAH STATUS SI PURCHASE ORDER DAN OTHER TRANSACTION DARI OPEN KE CLOSED
                /*$check_total_po                 = purchase_order::find($request->po_id[$i]);
                if ($request->amount[$i] == $check_total_po->grandtotal) {
                    purchase_order::where('number', $request->po_number[$i])->update(['status' => 2, 'balance_due' => 0]);
                    other_transaction::where('number', $request->po_number[$i])->where('type', 'purchase order')->update(['status' => 2]);
                } else if ($request->amount[$i] < $check_total_po->grandtotal && $request->amount[$i] != 0) {
                    $balance                    = $check_total_po->grandtotal - $request->amount[$i];
                    purchase_order::where('number', $request->po_number[$i])->update(['status' => 4, 'balance_due' => $balance]);
                    other_transaction::where('number', $request->po_number[$i])->where('type', 'purchase order')->update(['status' => 2]);
                } else if ($request->amount[$i] > $check_total_po->grandtotal) {
                    DB::rollBack();
                    return response()->json(['errors' => 'Amount cannot be more than balance due!']);
                } else if ($request->amount[$i] == 0) {
                    DB::rollBack();
                    return response()->json(['errors' => 'Amount must be more than zero!']);
                }*/

                $masing_po                      = purchase_order::find($request->po_id[$i]);
                if ($masing_po->jasa_only == 0) {
                    $jasa_doang                     = 0;
                    $get_po_item                    = purchase_order_item::where('purchase_order_id', $request->po_id[$i])->get();
                    foreach ($get_po_item as $j => $gpi) {
                        if ($request->po_qty_dateng[$x]) {
                            if ($gpi->purchase_order_id) {
                                $pipo[$i] = purchase_invoice_po::updateOrCreate([
                                    'purchase_invoice_id'       => $pd->id,
                                    'purchase_order_id'         => $request->po_id[$i],
                                    'amount'                    => $request->amount[$i],
                                ]);
                                //$pipo[$i]->save();
                            }
                            //var_dump($gpi->purchase_order_id);
                            //var_dump('input = ' . $request->po_item_id[$x] . ' freaoch qty');
                            $pipoi[$x] = new purchase_invoice_po_item([
                                'purchase_invoice_id'       => $pd->id,
                                'purchase_order_id'         => $request->po_id[$i],
                                'purchase_order_item_id'    => $request->po_item_id[$x],
                                'product_id'                => $request->po_item_product_id[$x],
                                'unit_price'                => $request->po_unit_price[$x],
                                'amount'                    => $request->po_amount[$x],
                                'qty'                       => $request->po_qty_dateng[$x],
                                'qty_remaining_return'      => $request->po_qty_dateng[$x],
                            ]);
                            $pipoi[$x]->save();
                            $ambil_po_balance               = purchase_order::find($request->po_id[$i]);
                            other_transaction::where('number', $ambil_po_balance->number)->where('type', 'purchase order')->update([
                                'balance_due'                => $ambil_po_balance->balance_due - $request->po_amount[$x]
                            ]);
                            $ambil_po_balance->update([
                                'balance_due'               => $ambil_po_balance->balance_due - $request->po_amount[$x]
                            ]);
                            if ($ambil_po_balance->balance_due == 0) {
                                $ambil_po_balance->update([
                                    'status'                => 2,
                                ]);
                                other_transaction::where('number', $ambil_po_balance->number)->where('type', 'purchase order')->update([
                                    'status'                => 2,
                                ]);
                            } else {
                                $ambil_po_balance->update([
                                    'status'                => 4,
                                ]);
                                other_transaction::where('number', $ambil_po_balance->number)->where('type', 'purchase order')->update([
                                    'status'                => 4,
                                ]);
                            }
                            if ($request->po_qty_dateng[$x] == $request->po_qty_remaining[$x]) {
                                $gpi->update(['qty_remaining' => 0]);
                            } else if ($request->po_qty_dateng[$x] < $request->po_qty_remaining[$x] && $request->po_qty_dateng[$x] != 0) {
                                $gpi->update(['qty_remaining' => $gpi->qty_remaining - $request->po_qty_dateng[$x]]);
                            } else if ($request->po_qty_dateng[$x] > $request->po_qty_remaining[$x]) {
                                DB::rollBack();
                                return response()->json(['errors' => 'Quantity cannot be more than Qty Order = ' . $request->po_qty_remaining[$x]]);
                            } else if ($request->po_qty_dateng[$x] == 0) {
                                DB::rollBack();
                                return response()->json(['errors' => 'Quantity must be more than zero']);
                            }
                            $default_product_account = product::find($gpi->product_id);
                            if ($default_product_account->is_track == 1) {
                                coa_detail::create([
                                    'company_id'            => $user->company_id,
                                    'user_id'               => Auth::id(),
                                    'ref_id'                => $pd->id,
                                    'other_transaction_id'  => $transactions->id,
                                    'coa_id'                => $default_product_account->default_inventory_account,
                                    'date'                  => $request->get('trans_date'),
                                    'type'                  => 'purchase invoice',
                                    'number'                => 'Purchase Invoice #' . $trans_no,
                                    'contact_id'            => $request->get('vendor_name'),
                                    'debit'                 => $request->po_amount[$x],
                                    'credit'                => 0,
                                ]);
                            } else {
                                coa_detail::create([
                                    'company_id'            => $user->company_id,
                                    'user_id'               => Auth::id(),
                                    'ref_id'                => $pd->id,
                                    'other_transaction_id'  => $transactions->id,
                                    'coa_id'                => $default_product_account->buy_account,
                                    'date'                  => $request->get('trans_date'),
                                    'type'                  => 'purchase invoice',
                                    'number'                => 'Purchase Invoice #' . $trans_no,
                                    'contact_id'            => $request->get('vendor_name'),
                                    'debit'                 => $request->po_amount[$x],
                                    'credit'                => 0,
                                ]);
                            }

                            //menambahkan stok barang ke gudang
                            $wh = new warehouse_detail();
                            $wh->type                   = 'purchase invoice';
                            $wh->number                 = 'Purchase Invoice #' . $trans_no;
                            $wh->product_id             = $gpi->product_id;
                            $wh->warehouse_id           = $request->warehouse;
                            $wh->date                   = $request->trans_date;
                            $wh->qty_in                 = $request->po_qty_dateng[$x];
                            $wh->save();

                            //merubah harga average produk
                            $produk                     = product::find($gpi->product_id);
                            $qty                        = $request->po_qty_dateng[$x];
                            $price                      = $request->po_unit_price[$x];
                            $dibagi                     = $produk->qty + $qty;
                            if ($dibagi == 0) {
                                $curr_avg_price             = (($produk->qty * $produk->avg_price) + ($qty * $price));
                            } else {
                                $curr_avg_price             = (($produk->qty * $produk->avg_price) + ($qty * $price)) / ($dibagi);
                            }
                            //dd(abs($curr_avg_price));
                            //menyimpan jumlah perubahan pada produk
                            product::where('id', $gpi->product_id)->update([
                                'qty'                   => $produk->qty + $qty,
                                'avg_price'             => abs($curr_avg_price),
                            ]);
                        }
                        $x++;
                    }
                } else {
                    $jasa_doang                     = 1;
                    $get_po_item                    = purchase_order_item::where('purchase_order_id', $request->po_id[$i])->get();
                    foreach ($get_po_item as $j => $gpi) {
                        if ($request->po_qty_dateng[$x]) {
                            if ($gpi->purchase_order_id) {
                                $pipo[$i] = purchase_invoice_po::updateOrCreate([
                                    'purchase_invoice_id'       => $pd->id,
                                    'purchase_order_id'         => $request->po_id[$i],
                                    'amount'                    => $request->amount[$i],
                                ]);
                                //$pipo[$i]->save();
                            }
                            //var_dump($gpi->purchase_order_id);
                            //var_dump('input = ' . $request->po_item_id[$x] . ' freaoch qty');
                            $pipoi[$x] = new purchase_invoice_po_item([
                                'purchase_invoice_id'       => $pd->id,
                                'purchase_order_id'         => $request->po_id[$i],
                                'purchase_order_item_id'    => $request->po_item_id[$x],
                                'product_id'                => $request->po_item_product_id[$x],
                                'unit_price'                => $request->po_unit_price[$x],
                                'amount'                    => $request->po_amount[$x],
                                'qty'                       => $request->po_qty_dateng[$x],
                                'qty_remaining_return'             => $request->po_qty_dateng[$x],
                            ]);
                            $pipoi[$x]->save();
                            $ambil_po_balance               = purchase_order::find($request->po_id[$i]);
                            $ambil_po_balance->update([
                                'balance_due'               => $ambil_po_balance->balance_due - $request->po_amount[$x]
                            ]);
                            if ($ambil_po_balance->balance_due == 0) {
                                $ambil_po_balance->update([
                                    'status'                => 2,
                                ]);
                                other_transaction::where('number', $ambil_po_balance->number)->where('type', 'purchase order')->update([
                                    'status'                => 2,
                                ]);
                            } else {
                                $ambil_po_balance->update([
                                    'status'                => 4,
                                ]);
                                other_transaction::where('number', $ambil_po_balance->number)->where('type', 'purchase order')->update([
                                    'status'                => 4,
                                ]);
                            }
                            if ($request->po_qty_dateng[$x] == $request->po_qty_remaining[$x]) {
                                $gpi->update(['qty_remaining' => 0]);
                            } else if ($request->po_qty_dateng[$x] < $request->po_qty_remaining[$x] && $request->po_qty_dateng[$x] != 0) {
                                $gpi->update(['qty_remaining' => $gpi->qty_remaining - $request->po_qty_dateng[$x]]);
                            } else if ($request->po_qty_dateng[$x] > $request->po_qty_remaining[$x]) {
                                DB::rollBack();
                                return response()->json(['errors' => 'Quantity cannot be more than Qty Order = ' . $request->po_qty_remaining[$x]]);
                            } else if ($request->po_qty_dateng[$x] == 0) {
                                DB::rollBack();
                                return response()->json(['errors' => 'Quantity must be more than zero']);
                            }

                            //menambahkan stok barang ke gudang
                            $wh = new warehouse_detail();
                            $wh->type                   = 'purchase invoice';
                            $wh->number                 = 'Purchase Invoice #' . $trans_no;
                            $wh->product_id             = $gpi->product_id;
                            $wh->warehouse_id           = $request->warehouse;
                            $wh->date                   = $request->trans_date;
                            $wh->qty_in                 = $request->po_qty_dateng[$x];
                            $wh->save();

                            //merubah harga average produk
                            $produk                     = product::find($gpi->product_id);
                            $qty                        = $request->po_qty_dateng[$x];
                            //dd(abs($curr_avg_price));
                            //menyimpan jumlah perubahan pada produk
                            product::where('id', $gpi->product_id)->update([
                                'qty'                   => $produk->qty + $qty,
                            ]);
                        }
                        $x++;
                    }
                }
            }
            if ($jasa_doang == 0) {
                // CREATE COA DETAIL BERDASARKAN DARI CONTACT DEFAULT
                $contact_account = contact::find($request->vendor_name);
                coa_detail::create([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'ref_id'                => $pd->id,
                    'other_transaction_id'  => $transactions->id,
                    'coa_id'                => $contact_account->account_payable_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'purchase invoice',
                    'number'                => 'Purchase Invoice #' . $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => 0,
                    'credit'                => $request->get('balance'),
                ]);
            }
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $pd->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $pi                         = purchase_invoice::with(['contact', 'term', 'warehouse', 'product'])->find($id);
        $terms                      = other_term::all();
        $products                   = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
        $units                      = other_unit::all();
        $today                      = Carbon::today();
        $pi_history                 = purchase_payment_item::where('purchase_invoice_id', $id)->get();
        $check_pi_history           = purchase_payment_item::where('purchase_invoice_id', $id)->first();
        $pd_history                 = purchase_invoice::where('selected_pd_id', $pi->selected_pd_id)->get();
        $pr_history                 = purchase_return::where('selected_pi_id', $id)->get();
        $check_pr_history           = purchase_return::where('selected_pi_id', $id)->first();
        $checknumberpd              = purchase_invoice::whereId($id)->first();
        $numbercoadetail            = 'Purchase Invoice #' . $checknumberpd->number;
        $numberothertransaction     = $checknumberpd->number;
        $get_all_detail             = coa_detail::where('number', $numbercoadetail)->where('type', 'purchase invoice')->with('coa')->get();
        $total_debit                = $get_all_detail->sum('debit');
        $total_credit               = $get_all_detail->sum('credit');
        //dd($pd_history);
        $check_pipo                 = purchase_invoice_po::where('purchase_invoice_id', $id)->first();
        $pipo                       = purchase_invoice_po::where('purchase_invoice_id', $id)->get();
        $pipoi                      = purchase_invoice_po_item::where('purchase_invoice_id', $id)->get();
        if ($check_pipo == null) {
            return view(
                'admin.purchases.invoices.show',
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
                    'total_credit'
                ])
            );
        } else {
            return view(
                'admin.request.sukses.purchases.invoices.show',
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
                    'pipo',
                    'pipoi'
                ])
            );
        }
    }

    public function edit($id)
    {
        $pi                                     = purchase_invoice::find($id);
        $pi_item                                = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
        $vendors                                = contact::where('type_vendor', true)->get();
        $warehouses                             = warehouse::all();
        $terms                                  = other_term::all();
        $products                               = product::where('is_buy', 1)->get();
        $units                                  = other_unit::all();
        $today                                  = Carbon::today();
        $taxes                                  = other_tax::all();
        $check_bundling_po                      = purchase_invoice_po::where('purchase_invoice_id', $id)->first();
        if ($pi->selected_pq_id) {
            return view('admin.purchases.invoices.editFromQuote', compact([
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
        } else if ($pi->selected_pd_id) {
            return view('admin.purchases.invoices.editFromDelivery', compact([
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
        } else if ($pi->selected_po_id) {
            return view('admin.purchases.invoices.editFromOrder', compact([
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
        } else if ($check_bundling_po) {
            $pipo                               = purchase_invoice_po::where('purchase_invoice_id', $id)->get();
            $pipoi                              = purchase_invoice_po_item::where('purchase_invoice_id', $id)->get();
            return view('admin.request.sukses.purchases.invoices.edit', compact([
                'pi',
                'pi_item',
                'vendors',
                'warehouses',
                'terms',
                'products',
                'units',
                'taxes',
                'today',
                'pipo',
                'pipoi',
            ]));
        } else {
            return view('admin.purchases.invoices.edit', compact([
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
            $pi                                 = purchase_invoice::find($id);
            $pp                                 = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
            $id_contact                         = $request->vendor_name2;
            $contact_account                    = contact::find($id_contact);
            $default_tax                        = default_account::find(14);
            coa_detail::where('type', 'purchase invoice')->where('number', 'Purchase Invoice #' . $pi->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'purchase invoice')->where('number', 'Purchase Invoice #' . $pi->number)->where('credit', 0)->delete();
            // HAPUS BALANCE PER ITEM INVOICE
            $pi_details                         = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
            foreach ($pi_details as $a) {
                // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                warehouse_detail::where('type', 'purchase invoice')
                    ->where('number', 'Purchase Invoice #' . $pi->number)
                    ->where('product_id', $a->product_id)
                    ->where('warehouse_id', $pi->warehouse_id)
                    ->delete();
                // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                $produk                     = product::find($a->product_id);
                $qty                        = $a->qty;
                $price                      = $a->unit_price;
                $dibagi                     = $produk->qty - $qty;
                if ($dibagi == 0) {
                    $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price));
                } else {
                    $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price)) / ($dibagi);
                }
                //menyimpan jumlah perubahan pada produk
                product::where('id', $a->product_id)->update([
                    'qty'                   => $produk->qty - $qty,
                    'avg_price'             => abs($curr_avg_price),
                ]);
            }
            purchase_invoice_item::where('purchase_invoice_id', $id)->delete();
            // BIKIN BARU
            // yang diinput di credit adalah total dari keseluruhan
            $transactions               = other_transaction::where('type', 'purchase invoice')->where('number', $pi->number)->first();
            coa_detail::create([
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'ref_id'                => $id,
                'other_transaction_id'  => $transactions->id,
                'coa_id'                => $contact_account->account_payable_id,
                'date'                  => $request->get('trans_date'),
                'type'                  => 'purchase invoice',
                'number'                => 'Purchase Invoice #' . $pi->number,
                'contact_id'            => $request->get('vendor_name2'),
                'debit'                 => 0,
                'credit'                => $request->balance,
            ]);

            other_transaction::where('type', 'purchase invoice')->where('number', $pi->number)->update([
                'memo'                      => $request->get('memo'),
                'transaction_date'          => $request->get('trans_date'),
                'due_date'                  => $request->get('due_date'),
                'contact'                   => $request->get('vendor_name2'),
                'balance_due'               => $request->balance,
                'total'                     => $request->balance,
            ]);

            purchase_invoice::find($id)->update([
                'contact_id'                => $request->get('vendor_name2'),
                'email'                     => $request->get('email'),
                'address'                   => $request->get('vendor_address'),
                'transaction_date'          => $request->get('trans_date'),
                'due_date'                  => $request->get('due_date'),
                'term_id'                   => $request->get('term'),
                'vendor_ref_no'             => $request->get('vendor_no'),
                'warehouse_id'              => $request->get('warehouse'),
                'subtotal'                  => $request->get('subtotal'),
                'taxtotal'                  => $request->get('taxtotal'),
                'balance_due'               => $request->balance,
                'grandtotal'                => $request->balance,
                'message'                   => $request->get('message'),
                'memo'                      => $request->get('memo'),
            ]);

            if ($request->taxtotal > 0) {
                coa_detail::create([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'ref_id'                => $id,
                    'other_transaction_id'  => $transactions->id,
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'purchase invoice',
                    'number'                => 'Purchase Invoice #' . $pi->number,
                    'contact_id'            => $request->get('vendor_name2'),
                    'debit'                 => $request->get('taxtotal'),
                    'credit'                => 0,
                ]);
            }

            foreach ($request->products2 as $i => $product) {
                //menyimpan detail per item dari invoicd
                $pp[$i]                     = new purchase_invoice_item([
                    'product_id'            => $request->products2[$i],
                    'desc'                  => $request->desc[$i],
                    'qty'                   => $request->qty[$i],
                    'qty_remaining_return'  => $request->qty[$i],
                    'unit_id'               => $request->units[$i],
                    'unit_price'            => $request->unit_price[$i],
                    'tax_id'                => $request->tax[$i],
                    'amountsub'             => $request->total_price_sub[$i],
                    'amounttax'             => $request->total_price_tax[$i],
                    'amountgrand'           => $request->total_price_grand[$i],
                    'amount'                => $request->total_price[$i],
                ]);
                $pi->purchase_invoice_item()->save($pp[$i]);

                $default_product_account = product::find($request->products2[$i]);
                // DEFAULT INVENTORY 17 dan yang di input di debit ini adalah total harga dari per barang
                if ($default_product_account->is_track == 1) {
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'purchase invoice',
                        'number'                => 'Purchase Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name2'),
                        'debit'                 => $request->total_price[$i],
                        'credit'                => 0,
                    ]);
                } else {
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->buy_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'purchase invoice',
                        'number'                => 'Purchase Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name2'),
                        'debit'                 => $request->total_price[$i],
                        'credit'                => 0,
                    ]);
                }
                //menambahkan stok barang ke gudang
                warehouse_detail::create([
                    'type'                  => 'purchase invoice',
                    'number'                => 'Purchase Invoice #' . $pi->number,
                    'product_id'            => $request->products2[$i],
                    'warehouse_id'          => $request->warehouse,
                    'date'                  => $request->trans_date,
                    'qty_in'                => $request->qty[$i],
                ]);

                //merubah harga average produk
                $produk                     = product::find($request->products2[$i]);
                $qty                        = $request->qty[$i];
                $price                      = $request->unit_price[$i];
                $dibagi                     = $produk->qty + $qty;
                if ($dibagi == 0) {
                    $curr_avg_price             = (($produk->qty * $produk->avg_price) + ($qty * $price));
                } else {
                    $curr_avg_price             = (($produk->qty * $produk->avg_price) + ($qty * $price)) / ($dibagi);
                }
                //menyimpan jumlah perubahan pada produk
                product::where('id', $request->products2[$i])->update([
                    'qty'                   => $produk->qty + $qty,
                    'avg_price'             => abs($curr_avg_price),
                ]);
            };
            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
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
            $pi                                 = purchase_invoice::find($id);
            $pp                                 = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
            other_transaction::where('type', 'purchase invoice')->where('number', $pi->number)->update([
                'memo'                      => $request->get('memo'),
                'transaction_date'          => $request->get('trans_date'),
                'due_date'                  => $request->get('due_date'),
            ]);

            purchase_invoice::find($id)->update([
                'email'                     => $request->get('email'),
                'address'                   => $request->get('vendor_address'),
                'transaction_date'          => $request->get('trans_date'),
                'due_date'                  => $request->get('due_date'),
                'term_id'                   => $request->get('term'),
                'vendor_ref_no'             => $request->get('vendor_no'),
                'message'                   => $request->get('message'),
                'memo'                      => $request->get('memo'),
            ]);
            foreach ($request->products as $i => $keys) {
                $pp[$i]->update([
                    'desc'          => $request->desc[$i],
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
            $id_po                              = $request->hidden_id_po;
            $number_po                          = $request->hidden_number_po;
            $pi                                 = purchase_invoice::find($id);
            $pp                                 = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
            $contact_id                         = contact::find($pi->contact_id);
            $id_contact                         = $request->vendor_name;
            $contact_account                    = contact::find($id_contact);
            $default_tax                        = default_account::find(14);
            $transactions                       = other_transaction::where('type', 'purchase invoice')->where('number', $pi->number)->first();
            // BUAT NGECHECK INI QUANTITY YANG DIINPUT LEBIH DARI YANG DI ORDER ATAU TIDAK
            foreach ($request->products as $i => $keys) {
                if ($request->qty[$i] < 0) {
                    DB::rollBack();
                    return response()->json(['errors' => 'Quantity cannot be less than 0']);
                } else if ($request->r_qty[$i] < 0) {
                    DB::rollBack();
                    return response()->json(['errors' => 'Quantity cannot be more than stock']);
                } else if ($request->qty[$i] == 0) {
                    DB::rollBack();
                    return response()->json(['errors' => 'Quantity cannot be 0']);
                }
            }
            // DELETE COA DETAILS
            coa_detail::where('type', 'purchase invoice')->where('number', 'Purchase Invoice #' . $pi->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'purchase invoice')->where('number', 'Purchase Invoice #' . $pi->number)->where('credit', 0)->delete();
            // BALIKIN STATUS ORDER
            $ambilpo                            = purchase_order::find($pi->selected_po_id);
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
            $pi_details                         = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
            foreach ($pi_details as $a) {
                $ambilpoo                       = purchase_order_item::find($a->purchase_order_item_id);
                $ambilpoo->update([
                    'qty_remaining'             => $ambilpoo->qty_remaining + $a->qty,
                ]);
                // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                warehouse_detail::where('type', 'purchase invoice')
                    ->where('number', 'Purchase Invoice #' . $pi->number)
                    ->where('product_id', $a->product_id)
                    ->where('warehouse_id', $pi->warehouse_id)
                    ->delete();
                // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                $produk                     = product::find($a->product_id);
                $qty                        = $a->qty;
                $price                      = $a->unit_price;
                $dibagi                     = $produk->qty - $qty;
                if ($dibagi == 0) {
                    $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price));
                } else {
                    $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price)) / ($dibagi);
                }
                //menyimpan jumlah perubahan pada produk
                product::where('id', $a->product_id)->update([
                    'qty'                   => $produk->qty - $qty,
                    'avg_price'             => abs($curr_avg_price),
                ]);
            }
            purchase_invoice_item::where('purchase_invoice_id', $id)->delete();
            // BIKIN BARU
            // CREATE COA DETAIL BERDASARKAN DARI CONTACT DEFAULT
            $contact_account = contact::find($id_contact);
            coa_detail::create([
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'ref_id'                => $id,
                'other_transaction_id'  => $transactions->id,
                'coa_id'                => $contact_account->account_payable_id,
                'date'                  => $request->get('trans_date'),
                'type'                  => 'purchase invoice',
                'number'                => 'Purchase Invoice #' . $pi->number,
                'contact_id'            => $request->get('vendor_name'),
                'debit'                 => 0,
                'credit'                => $request->get('balance'),
            ]);
            // MENGUBAH STATUS SI PURCHASE ORDER DAN OTHER TRANSACTION DARI OPEN KE CLOSED
            $check_total_po                 = purchase_order::find($id_po);
            $check_total_po->update([
                'balance_due'               => $check_total_po->balance_due - $request->balance,
            ]);
            if ($check_total_po->balance_due == 0) {
                $updatepdstatus             = array(
                    'status'                => 2,
                );
                purchase_order::where('number', $number_po)->update($updatepdstatus);
                other_transaction::where('number', $number_po)->where('type', 'purchase order')->update($updatepdstatus);
            } else {
                $updatepdstatus             = array(
                    'status'                => 4,
                );
                purchase_order::where('number', $number_po)->update($updatepdstatus);
                other_transaction::where('number', $number_po)->where('type', 'purchase order')->update($updatepdstatus);
            }
            // CREATE OTHER TRANSACTION PUNYA SI INVOICE
            other_transaction::where('type', 'purchase invoice')->where('number', $pi->number)->update([
                'memo'              => $request->get('memo'),
                'transaction_date'  => $request->get('trans_date'),
                'due_date'          => $request->get('due_date'),
                'contact'           => $request->get('vendor_name'),
                'balance_due'       => $request->get('balance'),
                'total'             => $request->get('balance'),
            ]);
            // CREATE HEADERNYA SEKALIAN MASUKKIN OTHER_TRANSACTION_ID DIDALEMNYA
            purchase_invoice::find($id)->update([
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
            ]);

            if ($request->taxtotal > 0) {
                $default_tax                = default_account::find(14);
                coa_detail::create([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'ref_id'                => $id,
                    'other_transaction_id'  => $transactions->id,
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'purchase invoice',
                    'number'                => 'Purchase Invoice #' . $pi->number,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => $request->get('taxtotal'),
                    'credit'                => 0,
                ]);
            }

            foreach ($request->products as $i => $keys) {
                // CREATE DETAILSNYA SEKALIAN MASUKKIN PURCHASE_INVOICE_ID DIDALEMNYA
                $pp[$i] = new purchase_invoice_item([
                    'purchase_order_item_id'    => $request->po_id[$i],
                    'product_id'            => $request->products[$i],
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
                $pi->purchase_invoice_item()->save($pp[$i]);
                $updatepunyapo                  = purchase_order_item::find($request->po_id[$i]);
                $updatepunyapo->update([
                    'qty_remaining'             => $updatepunyapo->qty_remaining - $request->qty[$i]
                ]);
                // CREATE COA DETAIL BERDASARKAN PRODUCT SETTING
                $default_product_account = product::find($request->products[$i]);
                if ($default_product_account->is_track == 1) {
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'purchase invoice',
                        'number'                => 'Purchase Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $request->total_price[$i],
                        'credit'                => 0,
                    ]);
                } else {
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->buy_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'purchase invoice',
                        'number'                => 'Purchase Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $request->total_price[$i],
                        'credit'                => 0,
                    ]);
                }

                //menambahkan stok barang ke gudang
                $wh = new warehouse_detail();
                $wh->type                   = 'purchase invoice';
                $wh->number                 = 'Purchase Invoice #' . $pi->number;
                $wh->product_id             = $request->products[$i];
                $wh->warehouse_id           = $request->warehouse;
                $wh->date                   = $request->trans_date;
                $wh->qty_in                 = $request->qty[$i];
                $wh->save();

                //merubah harga average produk
                $produk                     = product::find($request->products[$i]);
                $qty                        = $request->qty[$i];
                $price                      = $request->unit_price[$i];
                $dibagi                     = $produk->qty + $qty;
                if ($dibagi == 0) {
                    $curr_avg_price             = (($produk->qty * $produk->avg_price) + ($qty * $price));
                } else {
                    $curr_avg_price             = (($produk->qty * $produk->avg_price) + ($qty * $price)) / ($dibagi);
                }
                //dd(abs($curr_avg_price));
                //menyimpan jumlah perubahan pada produk
                product::where('id', $request->products[$i])->update([
                    'qty' => $produk->qty + $qty,
                    'avg_price' => abs($curr_avg_price),
                ]);
            };
            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function updateFromQuote(Request $request)
    {
        $user               = User::find(Auth::id());
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
            $id_pq                              = $request->hidden_id_pq;
            $number_pq                          = $request->hidden_number_pq;
            $pi                                 = purchase_invoice::find($id);
            $pp                                 = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
            $contact_id                         = contact::find($pi->contact_id);
            $id_contact                         = $request->vendor_name;
            $contact_account                    = contact::find($id_contact);
            $default_tax                        = default_account::find(14);
            $transactions                       = other_transaction::where('type', 'purchase invoice')->where('number', $pi->number)->first();
            // UPDATE STATUS ON PURCHASE QUOTE & OTHER TRANSACTION QUOTE'S
            $updatepdstatus                     = array(
                'status'                        => 1,
            );
            purchase_quote::where('number', $pi->transaction_no_pq)->update($updatepdstatus);
            other_transaction::where('number', $pi->transaction_no_pq)->where('type', 'purchase quote')->update($updatepdstatus);

            coa_detail::where('type', 'purchase invoice')->where('number', 'Purchase Invoice #' . $pi->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'purchase invoice')->where('number', 'Purchase Invoice #' . $pi->number)->where('credit', 0)->delete();
            // HAPUS BALANCE PER ITEM INVOICE
            $pi_details                         = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
            $default_inventory                  = default_account::find(17);
            foreach ($pi_details as $a) {
                $default_product_account        = product::find($a->product_id);
                if ($default_product_account->is_track == 1) {
                    // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                    warehouse_detail::where('type', 'purchase invoice')
                        ->where('number', 'Purchase Invoice #' . $pi->number)
                        ->where('product_id', $a->product_id)
                        ->where('warehouse_id', $pi->warehouse_id)
                        ->delete();
                    // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                    $produk                     = product::find($a->product_id);
                    $qty                        = $a->qty;
                    $price                      = $a->unit_price;
                    $dibagi                     = $produk->qty - $qty;
                    if ($dibagi == 0) {
                        $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price));
                    } else {
                        $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price)) / ($dibagi);
                    }
                    //menyimpan jumlah perubahan pada produk
                    product::where('id', $a->product_id)->update([
                        'qty'                   => $produk->qty - $qty,
                        'avg_price'             => abs($curr_avg_price),
                    ]);
                } else {
                    // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                    warehouse_detail::where('type', 'purchase invoice')
                        ->where('number', 'Purchase Invoice #' . $pi->number)
                        ->where('product_id', $a->product_id)
                        ->where('warehouse_id', $pi->warehouse_id)
                        ->delete();
                    // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                    $produk                     = product::find($a->product_id);
                    $qty                        = $a->qty;
                    $price                      = $a->unit_price;
                    $dibagi                     = $produk->qty - $qty;
                    if ($dibagi == 0) {
                        $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price));
                    } else {
                        $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price)) / ($dibagi);
                    }
                    //menyimpan jumlah perubahan pada produk
                    product::where('id', $a->product_id)->update([
                        'qty'                   => $produk->qty - $qty,
                        'avg_price'             => abs($curr_avg_price),
                    ]);
                }
            }
            purchase_invoice_item::where('purchase_invoice_id', $id)->delete();
            // BIKIN BARU
            // CREATE COA DETAIL BASED ON CONTACT SETTING ACCOUNT
            $contact_account = contact::find($id_contact);
            coa_detail::create([
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'ref_id'                => $id,
                'other_transaction_id'  => $transactions->id,
                'coa_id'                => $contact_account->account_payable_id,
                'date'                  => $request->get('trans_date'),
                'type'                  => 'purchase invoice',
                'number'                => 'Purchase Invoice #' . $pi->number,
                'contact_id'            => $request->get('vendor_name'),
                'debit'                 => 0,
                'credit'                => $request->get('balance'),
            ]);
            // UPDATE STATUS ON PURCHASE QUOTE & OTHER TRANSACTION QUOTE'S
            $updatepdstatus = array(
                'status'        => 2,
            );
            purchase_quote::where('number', $number_pq)->update($updatepdstatus);
            other_transaction::where('number', $number_pq)->where('type', 'purchase quote')->update($updatepdstatus);
            // CREATE LIST OTHER TRANSACTION PUNYA INVOICE
            other_transaction::where('type', 'purchase invoice')->where('number', $pi->number)->update([
                'transaction_date'          => $request->get('trans_date'),
                'memo'                      => $request->get('memo'),
                'contact'                   => $request->get('vendor_name'),
                'due_date'                  => $request->get('due_date'),
                'balance_due'               => $request->get('balance'),
                'total'                     => $request->get('balance'),
            ]);
            // CREATE PURCHASE INVOICE HEADER
            purchase_invoice::find($id)->update([
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

            if ($request->taxtotal > 0) {
                $default_tax                = default_account::find(14);
                coa_detail::create([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'ref_id'                => $id,
                    'other_transaction_id'  => $transactions->id,
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'purchase invoice',
                    'number'                => 'Purchase Invoice #' . $pi->number,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => $request->get('taxtotal'),
                    'credit'                => 0,
                ]);
            }

            // CREATE PURCHASE INVOICE DETAILS
            foreach ($request->products2 as $i => $keys) {
                $pp[$i] = new purchase_invoice_item([
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
                    'qty_remaining_return'         => $request->qty[$i],
                ]);
                $pi->purchase_invoice_item()->save($pp[$i]);
                // CREATE COA DETAIL BASED ON PRODUCT SETTING
                $default_product_account = product::find($request->products2[$i]);
                if ($default_product_account->is_track == 1) {
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'purchase invoice',
                        'number'                => 'Purchase Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $request->total_price[$i],
                        'credit'                => 0,
                    ]);
                } else {
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->buy_account,
                        'date'                  => $request->get('trans_date'),
                        'type'                  => 'purchase invoice',
                        'number'                => 'Purchase Invoice #' . $pi->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $request->total_price[$i],
                        'credit'                => 0,
                    ]);
                }
                //menambahkan stok barang ke gudang
                warehouse_detail::create([
                    'type'                  => 'purchase invoice',
                    'number'                => 'Purchase Invoice #' . $pi->number,
                    'product_id'            => $request->products2[$i],
                    'warehouse_id'          => $request->warehouse,
                    'date'                  => $request->trans_date,
                    'qty_in'                => $request->qty[$i],
                ]);
                //merubah harga average produk
                $produk                     = product::find($request->products2[$i]);
                $qty                        = $request->qty[$i];
                $price                      = $request->unit_price[$i];
                $dibagi                     = $produk->qty + $qty;
                if ($dibagi == 0) {
                    $curr_avg_price             = (($produk->qty * $produk->avg_price) + ($qty * $price));
                } else {
                    $curr_avg_price             = (($produk->qty * $produk->avg_price) + ($qty * $price)) / ($dibagi);
                }
                //menyimpan jumlah perubahan pada produk
                product::where('id', $request->products2[$i])->update([
                    'qty'                   => $produk->qty + $qty,
                    'avg_price'             => abs($curr_avg_price),
                ]);
            };
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
            $pi                                     = purchase_invoice::find($id);
            $check_bundling_po                      = purchase_invoice_po::where('purchase_invoice_id', $id)->first();
            if ($check_bundling_po) {
                $check_jasa_only                    = coa_detail::where('type', 'purchase invoice')
                    ->where('number', 'Purchase Invoice #' . $pi->number)->where('debit', 0)->first();
                if ($check_jasa_only) {
                    coa_detail::where('type', 'purchase invoice')->where('number', 'Purchase Invoice #' . $pi->number)->where('debit', 0)->delete();
                    coa_detail::where('type', 'purchase invoice')->where('number', 'Purchase Invoice #' . $pi->number)->where('credit', 0)->delete();
                    $ambil_pipo                         = purchase_invoice_po::where('purchase_invoice_id', $id)->get();
                    foreach ($ambil_pipo as $i => $ap) {
                        $ambil_po_item                  = purchase_order_item::where('purchase_order_id', $ap->purchase_order_id)->get();
                        foreach ($ambil_po_item as $j => $apii) {
                            $ambil_pipoi                    = purchase_invoice_po_item::where('purchase_invoice_id', $id)
                                ->where('purchase_order_id', $apii->purchase_order_id)
                                ->where('purchase_order_item_id', $apii->id)
                                ->get();
                            //var_dump('apii ' . $apii->id);
                            foreach ($ambil_pipoi as $k => $api) {
                                if ($api->purchase_order_item_id == $apii->id) {
                                    //var_dump('api ' . $api->id);
                                    $apii->update(['qty_remaining' => $apii->qty_remaining + $api->qty]);
                                    $ambil_po                       = purchase_order::find($apii->purchase_order_id);
                                    other_transaction::where('number', $ambil_po->number)->where('type', 'purchase order')->update([
                                        'balance_due'               => $ambil_po->balance_due + $api->amount,
                                    ]);
                                    $ambil_po->update([
                                        'balance_due'               => $ambil_po->balance_due + $api->amount,
                                    ]);
                                    if ($ambil_po->balance_due == $ambil_po->grandtotal) {
                                        $ambil_po->update([
                                            'status'                => 1,
                                        ]);
                                        other_transaction::where('number', $ambil_po->number)->where('type', 'purchase order')->update([
                                            'status'                => 1,
                                        ]);
                                    } else {
                                        $ambil_po->update([
                                            'status'                => 4,
                                        ]);
                                        other_transaction::where('number', $ambil_po->number)->where('type', 'purchase order')->update([
                                            'status'                => 4,
                                        ]);
                                    }
                                }
                                // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                                warehouse_detail::where('type', 'purchase invoice')
                                    ->where('number', 'Purchase Invoice #' . $pi->number)
                                    ->where('product_id', $api->product_id)
                                    ->where('warehouse_id', $pi->warehouse_id)
                                    ->delete();
                                // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                                $produk                     = product::find($api->product_id);
                                $qty                        = $api->qty;
                                $price                      = $api->unit_price;
                                $dibagi                     = $produk->qty - $qty;
                                if ($dibagi == 0) {
                                    $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price));
                                } else {
                                    $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price)) / ($dibagi);
                                }
                                //menyimpan jumlah perubahan pada produk
                                product::where('id', $api->product_id)->update([
                                    'qty'                   => $produk->qty - $qty,
                                    'avg_price'             => abs($curr_avg_price),
                                ]);
                            }
                        }
                    }
                    purchase_invoice_po_item::where('purchase_invoice_id', $id)->delete();
                    purchase_invoice_po::where('purchase_invoice_id', $id)->delete();
                    // DELETE ROOT OTHER TRANSACTION
                    other_transaction::where('type', 'purchase invoice')->where('number', $pi->number)->delete();
                    // FINALLY DELETE THE INVOICE
                    $pi->delete();
                    //DB::rollBack();
                    //dd($pi);
                } else {
                    $ambil_pipo                         = purchase_invoice_po::where('purchase_invoice_id', $id)->get();
                    foreach ($ambil_pipo as $i => $ap) {
                        $ambil_po_item                  = purchase_order_item::where('purchase_order_id', $ap->purchase_order_id)->get();
                        foreach ($ambil_po_item as $j => $apii) {
                            $ambil_pipoi                    = purchase_invoice_po_item::where('purchase_invoice_id', $id)
                                ->where('purchase_order_id', $apii->purchase_order_id)
                                ->where('purchase_order_item_id', $apii->id)
                                ->get();
                            //var_dump('apii ' . $apii->id);
                            foreach ($ambil_pipoi as $k => $api) {
                                if ($api->purchase_order_item_id == $apii->id) {
                                    //var_dump('api ' . $api->id);
                                    $apii->update(['qty_remaining' => $apii->qty_remaining + $api->qty]);
                                    $ambil_po                       = purchase_order::find($apii->purchase_order_id);
                                    other_transaction::where('number', $ambil_po->number)->where('type', 'purchase order')->update([
                                        'balance_due'               => $ambil_po->balance_due + $api->amount,
                                    ]);
                                    $ambil_po->update([
                                        'balance_due'               => $ambil_po->balance_due + $api->amount,
                                    ]);
                                    if ($ambil_po->balance_due == $ambil_po->grandtotal) {
                                        $ambil_po->update([
                                            'status'                => 1,
                                        ]);
                                        other_transaction::where('number', $ambil_po->number)->where('type', 'purchase order')->update([
                                            'status'                => 1,
                                        ]);
                                    } else {
                                        $ambil_po->update([
                                            'status'                => 4,
                                        ]);
                                        other_transaction::where('number', $ambil_po->number)->where('type', 'purchase order')->update([
                                            'status'                => 4,
                                        ]);
                                    }
                                }
                                // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                                warehouse_detail::where('type', 'purchase invoice')
                                    ->where('number', 'Purchase Invoice #' . $pi->number)
                                    ->where('product_id', $apii->product_id)
                                    ->where('warehouse_id', $pi->warehouse_id)
                                    ->delete();
                                // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                                $produk                     = product::find($apii->product_id);
                                $qty                        = $api->qty;
                                //menyimpan jumlah perubahan pada produk
                                product::where('id', $apii->product_id)->update([
                                    'qty'                   => $produk->qty - $qty,
                                ]);
                            }
                        }
                    }
                    purchase_invoice_po_item::where('purchase_invoice_id', $id)->delete();
                    purchase_invoice_po::where('purchase_invoice_id', $id)->delete();
                    // DELETE ROOT OTHER TRANSACTION
                    other_transaction::where('type', 'purchase invoice')->where('number', $pi->number)->delete();
                    // FINALLY DELETE THE INVOICE
                    $pi->delete();
                    //DB::rollBack();
                    //dd($pi);
                }
            } else {
                if ($pi->selected_pq_id) {
                    // UPDATE STATUS ON PURCHASE QUOTE & OTHER TRANSACTION QUOTE'S
                    $updatepdstatus                     = array(
                        'status'                        => 1,
                    );
                    purchase_quote::where('number', $pi->transaction_no_pq)->update($updatepdstatus);
                    other_transaction::where('number', $pi->transaction_no_pq)->where('type', 'purchase quote')->update($updatepdstatus);

                    coa_detail::where('type', 'purchase invoice')->where('number', 'Purchase Invoice #' . $pi->number)->where('debit', 0)->delete();
                    coa_detail::where('type', 'purchase invoice')->where('number', 'Purchase Invoice #' . $pi->number)->where('credit', 0)->delete();
                    // HAPUS BALANCE PER ITEM INVOICE
                    $pi_details                         = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
                    foreach ($pi_details as $a) {
                        // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                        warehouse_detail::where('type', 'purchase invoice')
                            ->where('number', 'Purchase Invoice #' . $pi->number)
                            ->where('product_id', $a->product_id)
                            ->where('warehouse_id', $pi->warehouse_id)
                            ->delete();
                        // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                        $produk                     = product::find($a->product_id);
                        $qty                        = $a->qty;
                        $price                      = $a->unit_price;
                        $dibagi                     = $produk->qty - $qty;
                        if ($dibagi == 0) {
                            $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price));
                        } else {
                            $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price)) / ($dibagi);
                        }
                        //menyimpan jumlah perubahan pada produk
                        product::where('id', $a->product_id)->update([
                            'qty'                   => $produk->qty - $qty,
                            'avg_price'             => abs($curr_avg_price),
                        ]);
                    }
                    purchase_invoice_item::where('purchase_invoice_id', $id)->delete();
                    // DELETE ROOT OTHER TRANSACTION
                    other_transaction::where('type', 'purchase invoice')->where('number', $pi->number)->delete();
                    // FINALLY DELETE THE INVOICE
                    $pi->delete();
                } else if ($pi->selected_pd_id) {
                    coa_detail::where('type', 'purchase invoice')->where('number', 'Purchase Invoice #' . $pi->number)->where('debit', 0)->delete();
                    coa_detail::where('type', 'purchase invoice')->where('number', 'Purchase Invoice #' . $pi->number)->where('credit', 0)->delete();
                    // HAPUS BALANCE PER ITEM INVOICE
                    $pi_details                         = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
                    foreach ($pi_details as $a) {
                        $default_product_account        = product::find($a->product_id);
                        // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                        warehouse_detail::where('type', 'purchase invoice')
                            ->where('number', 'Purchase Invoice #' . $pi->number)
                            ->where('product_id', $a->product_id)
                            ->where('warehouse_id', $pi->warehouse_id)
                            ->delete();
                        // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                        $produk                     = product::find($a->product_id);
                        $qty                        = $a->qty;
                        $price                      = $a->unit_price;
                        $dibagi                     = $produk->qty - $qty;
                        if ($dibagi == 0) {
                            $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price));
                        } else {
                            $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price)) / ($dibagi);
                        }
                        //menyimpan jumlah perubahan pada produk
                        product::where('id', $a->product_id)->update([
                            'qty'                   => $produk->qty - $qty,
                            'avg_price'             => abs($curr_avg_price),
                        ]);
                    }
                    purchase_invoice_item::where('purchase_invoice_id', $id)->delete();
                    // DELETE ROOT OTHER TRANSACTION
                    other_transaction::where('type', 'purchase invoice')->where('number', $pi->number)->delete();
                    // FINALLY DELETE THE INVOICE
                    $pi->delete();
                } else if ($pi->selected_po_id) {
                    // DELETE COA DETAILS
                    coa_detail::where('type', 'purchase invoice')->where('number', 'Purchase Invoice #' . $pi->number)->where('debit', 0)->delete();
                    coa_detail::where('type', 'purchase invoice')->where('number', 'Purchase Invoice #' . $pi->number)->where('credit', 0)->delete();
                    // BALIKIN STATUS ORDER
                    $ambilpo                            = purchase_order::find($pi->selected_po_id);
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
                    $pi_details                         = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
                    foreach ($pi_details as $a) {
                        /*// KITA AMBIL PO ID
                        $ambil_po_id_current_pi         = $pi->selected_po_id; // 7
                        $tarik_semua_pi_detail          = purchase_invoice_item::get(); // NGECEK SEMUA PI BUAT AMBIL PARENT
                        foreach ($tarik_semua_pi_detail as $tarik) {
                            $ambil_pi_dartarik_semua    = purchase_invoice::where('id', $tarik->purchase_invoice_id)->get();
                            foreach ($ambil_pi_dartarik_semua as $daritarik) {
                                $ambil_po_id_daritarik      = $daritarik->selected_po_id;
                                $simpanb                = 0;
                                $hasil_akhir            = 0;
                                if ($ambil_po_id_daritarik == $ambil_po_id_current_pi) {
                                    $simpana             = $tarik->qty_remaining;
                                    if ($simpanb == 0) {
                                        $simpanb = $simpana;
                                    }
                                    if ($simpana <= $simpanb) {
                                        $hasil_akhir    = $simpana;
                                    }
                                    $simpanb            = $simpana;
                                }
                            }
                        }
                        $qty_remaining_terbaru          = $hasil_akhir + $a->qty; // UDAH DAPET 100 NIH
                        $ambil_bapaknya                 = purchase_order::where('id', $pi->selected_po_id)->first();
                        //dd($ambil_bapaknya->total_qty);
                        if ($ambil_bapaknya->total_qty == $qty_remaining_terbaru) {
                            // UPDATE STATUS PURCHASE ORDER
                            $updatepdstatus                     = array(
                                'status'                        => 1,
                            );
                            purchase_order::where('number', $pi->transaction_no_po)->update($updatepdstatus);
                        } else {
                            // UPDATE STATUS PURCHASE ORDER
                            $updatepdstatus                     = array(
                                'status'                        => 4,
                            );
                            purchase_order::where('number', $pi->transaction_no_po)->update($updatepdstatus);
                        }*/
                        $ambilpoo                       = purchase_order_item::find($a->purchase_order_item_id);
                        $ambilpoo->update([
                            'qty_remaining'             => $ambilpoo->qty_remaining + $a->qty,
                        ]);
                        // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                        warehouse_detail::where('type', 'purchase invoice')
                            ->where('number', 'Purchase Invoice #' . $pi->number)
                            ->where('product_id', $a->product_id)
                            ->where('warehouse_id', $pi->warehouse_id)
                            ->delete();
                        // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                        $produk                     = product::find($a->product_id);
                        $qty                        = $a->qty;
                        $price                      = $a->unit_price;
                        $dibagi                     = $produk->qty - $qty;
                        if ($dibagi == 0) {
                            $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price));
                        } else {
                            $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price)) / ($dibagi);
                        }
                        //menyimpan jumlah perubahan pada produk
                        product::where('id', $a->product_id)->update([
                            'qty'                   => $produk->qty - $qty,
                            'avg_price'             => abs($curr_avg_price),
                        ]);
                    }
                    purchase_invoice_item::where('purchase_invoice_id', $id)->delete();
                    other_transaction::where('number', $pi->number)->where('type', 'purchase invoice')->where('ref_id', $pi->id)->delete();
                    // FINALLY DELETE THE INVOICE
                    $pi->delete();
                } else {
                    coa_detail::where('type', 'purchase invoice')->where('number', 'Purchase Invoice #' . $pi->number)->where('debit', 0)->delete();
                    coa_detail::where('type', 'purchase invoice')->where('number', 'Purchase Invoice #' . $pi->number)->where('credit', 0)->delete();
                    // HAPUS BALANCE PER ITEM INVOICE
                    $pi_details                         = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
                    foreach ($pi_details as $a) {
                        // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                        warehouse_detail::where('type', 'purchase invoice')
                            ->where('number', 'Purchase Invoice #' . $pi->number)
                            ->where('product_id', $a->product_id)
                            ->where('warehouse_id', $pi->warehouse_id)
                            ->delete();
                        // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                        $produk                     = product::find($a->product_id);
                        $qty                        = $a->qty;
                        $price                      = $a->unit_price;
                        $dibagi                     = $produk->qty - $qty;
                        if ($dibagi == 0) {
                            $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price));
                        } else {
                            $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price)) / ($dibagi);
                        }
                        //menyimpan jumlah perubahan pada produk
                        product::find($a->product_id)->update([
                            'qty'                   => $produk->qty - $qty,
                            'avg_price'             => abs($curr_avg_price),
                        ]);
                        //dd(product::find($a->product_id));
                    }
                    purchase_invoice_item::where('purchase_invoice_id', $id)->delete();
                    // DELETE ROOT OTHER TRANSACTION
                    other_transaction::where('type', 'purchase invoice')->where('number', $pi->number)->delete();
                    // FINALLY DELETE THE INVOICE
                    $pi->delete();
                }
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
        $pp                         = purchase_invoice::find($id);
        $pp_item                    = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
        $pp_po                      = purchase_invoice_po_item::where('purchase_invoice_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        if ($pp_po->isNotEmpty()) {
            $pp_po                  = $pp_po;
        } else {
            $pp_po                  = null;
        }
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $logo                       = company_logo::where('company_id', $user->company_id)->latest()->first();
        $pdf = PDF::loadview('admin.purchases.invoices.PrintPDF_1', compact(['pp', 'pp_item', 'pp_po', 'today', 'company', 'logo']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_2($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = purchase_invoice::find($id);
        $pp_item                    = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
        $pp_po                      = purchase_invoice_po_item::where('purchase_invoice_id', $id)->get();
        if ($pp_po->isNotEmpty()) {
            $pp_po                  = $pp_po;
        } else {
            $pp_po                  = null;
        }
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $logo                       = company_logo::where('company_id', $user->company_id)->latest()->first();
        $pdf = PDF::loadview('admin.purchases.invoices.PrintPDF_2', compact(['pp', 'pp_item', 'pp_po', 'today', 'company', 'logo']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_fas($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = purchase_invoice::find($id);
        $pp_item                    = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.purchases.invoices.PrintPDF_FAS', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_gg($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = purchase_invoice::find($id);
        $pp_item                    = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.purchases.invoices.PrintPDF_GG', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = purchase_invoice::find($id);
        $pp_item                    = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.purchases.invoices.PrintPDF_Sukses', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses_surabaya($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = purchase_invoice::find($id);
        $pp_item                    = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.purchases.invoices.PrintPDF_Sukses_Surabaya', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
