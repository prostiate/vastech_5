<?php

namespace App\Http\Controllers;

use App\sale_delivery;
use App\sale_order;
use App\sale_order_item;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\sale_delivery_item;
use App\default_account;
use App\other_transaction;
use App\coa_detail;
use App\company_logo;
use App\company_setting;
use App\other_tax;
use App\product;
use App\product_discount_item;
use PDF;
use App\sale_invoice;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SaleDeliveryController extends Controller
{
    public function index()
    {
        $user                       = User::find(Auth::id());
        $open_po                    = sale_delivery::whereIn('status', [1, 4])->count();
        $payment_last               = sale_delivery::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->count();
        $overdue                    = sale_delivery::where('status', 5)->count();
        $open_po_total              = sale_delivery::whereIn('status', [1, 4])->sum('grandtotal');
        $payment_last_total         = sale_delivery::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->sum('grandtotal');
        $overdue_total              = sale_delivery::where('status', 5)->sum('grandtotal');
        if ($user->getRoleNames()->first() == 'GT' or $user->getRoleNames()->first() == 'MT' or $user->getRoleNames()->first() == 'WS') {
            if (request()->ajax()) {
                return datatables()->of(sale_delivery::with('contact', 'status')->whereHas('contact', function ($query) use ($user) {
                    $query->where('sales_type', $user->getRoleNames()->first());
                })->get())
                    ->make(true);
            }
        } else {
            if (request()->ajax()) {
                return datatables()->of(sale_delivery::with('contact', 'status')->get())
                    ->make(true);
            }
        }

        return view('admin.sales.delivery.index', compact(['user', 'open_po', 'payment_last', 'overdue', 'open_po_total', 'payment_last_total', 'overdue_total']));
    }

    public function createFromPO($id)
    {
        $check                      = sale_delivery::where('selected_so_id', $id)->latest()->first();
        if (!$check) {
            $po                     = sale_order::find($id);
            $po_item                = sale_order_item::where('sale_order_id', $id)->get();
            $today                  = Carbon::today()->toDateString();
            $dt                     = Carbon::now();
            $user                   = User::find(Auth::id());
            if ($user->company_id == 5) {
                $number             = sale_delivery::latest()->first();
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
                        $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SD';
                    } else {
                        $check_number   = sale_delivery::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                        if ($check_number) {
                            $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SD';
                        } else {
                            $number1    = 10001;
                            $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SD';
                        }
                    }
                } else {
                    $check_number   = sale_delivery::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SD';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SD';
                    }
                }
            } else {
                $number             = sale_delivery::max('number');
                if ($number == 0)
                    $number         = 10000;
                $trans_no           = $number + 1;
            }
            return view('admin.sales.delivery.po.create_baru', compact(['today', 'trans_no', 'po', 'po_item']));
        } else {
            $po                     = sale_delivery::where('selected_so_id', $id)->first();
            $po_item                = sale_delivery_item::where('sale_delivery_id', $check->id)->get();
            $today                  = Carbon::today()->toDateString();
            $dt                     = Carbon::now();
            $user                   = User::find(Auth::id());
            if ($user->company_id == 5) {
                $number             = sale_delivery::latest()->first();
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
                        $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SD';
                    } else {
                        $check_number   = sale_delivery::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                        if ($check_number) {
                            $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SD';
                        } else {
                            $number1    = 10001;
                            $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SD';
                        }
                    }
                } else {
                    $check_number   = sale_delivery::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SD';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SD';
                    }
                }
            } else {
                $number             = sale_delivery::max('number');
                if ($number == 0)
                    $number         = 10000;
                $trans_no           = $number + 1;
            }
            return view('admin.sales.delivery.po.create_lama', compact(['today', 'trans_no', 'po', 'po_item']));
        }
    }

    public function storeFromPO(Request $request)
    {
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = sale_delivery::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                    $check_number   = sale_delivery::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                    if ($check_number) {
                        if ($check_number != null) {
                            $misahm = explode("/", $check_number->number);
                            $misahy = explode(".", $misahm[1]);
                        }
                        if (isset($misahy[1]) == 0) {
                            $misahy[1]      = 10000;
                        }
                        $number2    = $misahy[1] + 1;
                        $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SD';
                    } else {
                        $number1    = 10001;
                        $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SD';
                    }
            } else {
                $check_number   = sale_delivery::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SD';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SD';
                }
            }
        } else {
            $number             = sale_delivery::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }
        $rules = array(
            'vendor_name'   => 'required',
            'shipping_date' => 'required',
            'warehouse'     => 'required',
            'products'      => 'required|array|min:1',
            'products.*'    => 'required',
            'qty'           => 'required|array|min:1',
            'qty.*'         => 'required',
            'units'         => 'required|array|min:1',
            'units.*'       => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        //dd($request->qty, $request->r_qty);
        $status_closed = 0;
        foreach ($request->products as $i => $keys) {
            if ($request->qty[$i] < 0) {
                return response()->json(['errors' => 'Quantity cannot be less than zero']);
            } else if ($request->r_qty[$i] < 0) {
                return response()->json(['errors' => 'Quantity cannot be more than stock']);
            } else if ($request->r_qty[$i] == 0) {
                $status_closed = 1;
            } else if ($request->qty[$i] == 0) {
                return response()->json(['errors' => 'Quantity must be more than zero']);
            }
        }
        DB::beginTransaction();
        try {
            $id                             = $request->hidden_id;
            $id_number                      = $request->hidden_id_number;
            $subtotal_header_other          = 0;
            $taxtotal_header_other          = 0;
            $grandtotal_header_other        = 0;
            // MENGUBAH STATUS SI SALES ORDER DAN OTHER TRANSACTION DARI OPEN KE CLOSED
            $check_total_po                 = sale_order::find($id);
            $check_total_po->update([
                'balance_due'               => $check_total_po->balance_due - $request->balance,
            ]);
            if ($check_total_po->balance_due == 0) {
                $updatepdstatus             = array(
                    'status'                => 2,
                );
                sale_order::where('number', $id_number)->update($updatepdstatus);
                other_transaction::where('number', $id_number)->where('type', 'sales order')->update($updatepdstatus);
            } else {
                $updatepdstatus             = array(
                    'status'                => 4,
                );
                sale_order::where('number', $id_number)->update($updatepdstatus);
                other_transaction::where('number', $id_number)->where('type', 'sales order')->update($updatepdstatus);
            }

            $transactions = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                    => $trans_no,
                'number_complete'           => 'Sales Delivery #' . $trans_no,
                'type'                      => 'sales delivery',
                'transaction_date'          => $request->get('shipping_date'),
                'memo'                      => $request->get('memo'),
                'contact'                   => $request->get('vendor_name'),
                'status'                    => 6,
                'balance_due'               => $request->get('balance'),
                'total'                     => $request->get('balance'),
            ]);
            //$transactions->save();

            $pd = new sale_delivery([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                    => $trans_no,
                'contact_id'                => $request->get('vendor_name'),
                'email'                     => $request->get('email'),
                'transaction_date'          => $request->get('shipping_date'),
                'transaction_no'            => $request->get('trans_no'),
                'vendor_ref_no'             => $request->get('vendor_no'),
                'warehouse_id'              => $request->get('warehouse'),
                'subtotal'                  => $request->get('subtotal'),
                'taxtotal'                  => $request->get('taxtotal'),
                'balance_due'               => $request->get('balance'),
                'grandtotal'                => $request->get('balance'),
                'message'                   => $request->get('message'),
                'memo'                      => $request->get('memo'),
                'status'                    => 6,
                'selected_so_id'            => $id,
            ]);
            //$pd->save();
            $transactions->sale_order()->save($pd);
            other_transaction::find($transactions->id)->update([
                'ref_id'                    => $pd->id,
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

                $pp[$i] = new sale_delivery_item([
                    'sale_order_item_id'    => $request->poi_id[$i],
                    'product_id'            => $request->products[$i],
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
                ]);
                $pd->sale_delivery_item()->save($pp[$i]);

                $updatejugapoinya           = sale_order_item::find($request->poi_id[$i]);
                $updatejugapoinya->update(['qty_remaining' => $request->r_qty[$i]]);

                $avg_price                  = product::find($request->products[$i]);
                $total_avg                  = $request->qty[$i] * $avg_price->avg_price;
                $default_product_account    = product::find($request->products[$i]);
                if ($default_product_account->is_track == 1) {
                    // BUY ACCOUNT BARANG
                    coa_detail::create([
                        'company_id'                => $user->company_id,
                        'user_id'                   => Auth::id(),
                        'ref_id'                    => $pd->id,
                        'other_transaction_id'      => $transactions->id,
                        'coa_id'                    => $default_product_account->buy_account,
                        'date'                      => $request->get('trans_date'),
                        'type'                      => 'sales delivery',
                        'number'                    => 'Sales Delivery #' . $trans_no,
                        'contact_id'                => $request->get('vendor_name'),
                        'debit'                     => $total_avg,
                        'credit'                    => 0,
                    ]);
                    // DEFAULT INVENTORY BARANG
                    coa_detail::create([
                        'company_id'                => $user->company_id,
                        'user_id'                   => Auth::id(),
                        'ref_id'                    => $pd->id,
                        'other_transaction_id'      => $transactions->id,
                        'coa_id'                    => $default_product_account->default_inventory_account,
                        'date'                      => $request->get('trans_date'),
                        'type'                      => 'sales delivery',
                        'number'                    => 'Sales Delivery #' . $trans_no,
                        'contact_id'                => $request->get('vendor_name'),
                        'debit'                     => 0,
                        'credit'                    => $total_avg,
                    ]);
                }
            };

            other_transaction::find($transactions->id)->update([
                'balance_due'       => $grandtotal_header_other,
                'total'             => $grandtotal_header_other,
            ]);

            sale_delivery::find($pd->id)->update([
                'subtotal'          => $subtotal_header_other,
                'taxtotal'          => $taxtotal_header_other,
                'balance_due'       => $grandtotal_header_other,
                'grandtotal'        => $grandtotal_header_other,
            ]);

            // DEFAULT DARI SETTING
            $default_unbilled_receivable    = default_account::find(7);
            $default_unbilled_revenue       = default_account::find(6);
            // DEFAULT SETTING UNBILLED ACCOUNT RECEIVABLE
            coa_detail::create([
                'company_id'                => $user->company_id,
                'user_id'                   => Auth::id(),
                'ref_id'                    => $pd->id,
                'other_transaction_id'      => $transactions->id,
                'coa_id'                    => $default_unbilled_receivable->account_id,
                'date'                      => $request->get('trans_date'),
                'type'                      => 'sales delivery',
                'number'                    => 'Sales Delivery #' . $trans_no,
                'contact_id'                => $request->get('vendor_name'),
                'debit'                     => $grandtotal_header_other,
                'credit'                    => 0,
            ]);
            // DEFAULT SETTING UNBILLED REVENUE
            coa_detail::create([
                'company_id'                => $user->company_id,
                'user_id'                   => Auth::id(),
                'ref_id'                    => $pd->id,
                'other_transaction_id'      => $transactions->id,
                'coa_id'                    => $default_unbilled_revenue->account_id,
                'date'                      => $request->get('trans_date'),
                'type'                      => 'sales delivery',
                'number'                    => 'Sales Delivery #' . $trans_no,
                'contact_id'                => $request->get('vendor_name'),
                'debit'                     => 0,
                'credit'                    => $grandtotal_header_other,
            ]);

            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $pd->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $pd                 = sale_delivery::find($id);
        $products           = sale_delivery_item::where('sale_delivery_id', $id)->get();
        $checknumberpd              = sale_delivery::whereId($id)->first();
        $numbercoadetail            = 'Sales Delivery #' . $checknumberpd->number;
        $numberothertransaction     = $checknumberpd->number;
        $get_all_detail             = coa_detail::where('number', $numbercoadetail)->where('type', 'sales delivery')->with('coa')->get();
        $total_debit                = $get_all_detail->sum('debit');
        $total_credit               = $get_all_detail->sum('credit');
        $check_invoice              = sale_invoice::where('selected_sd_id', $id)->first();

        return view('admin.sales.delivery.show', compact(['pd', 'products', 'get_all_detail', 'total_debit', 'total_credit', 'check_invoice']));
    }

    public function edit($id)
    {
        $pd                 = sale_delivery::find($id);
        $products           = sale_delivery_item::where('sale_delivery_id', $id)->get();

        return view('admin.sales.delivery.edit', compact(['pd', 'products']));
    }

    public function updateFromPO(Request $request)
    {
        $rules = array(
            'vendor_name'   => 'required',
            'shipping_date' => 'required',
            'warehouse'     => 'required',
            'products'      => 'required|array|min:1',
            'products.*'    => 'required',
            'qty'           => 'required|array|min:1',
            'qty.*'         => 'required',
            'units'         => 'required|array|min:1',
            'units.*'       => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        //dd($request->qty, $request->r_qty);
        $status_closed = 0;
        foreach ($request->products as $i => $keys) {
            if ($request->qty[$i] < 0) {
                return response()->json(['errors' => 'Quantity cannot be less than zero']);
            } else if ($request->r_qty[$i] < 0) {
                return response()->json(['errors' => 'Quantity cannot be more than stock']);
            } else if ($request->r_qty[$i] == 0) {
                $status_closed = 1;
            } else if ($request->qty[$i] == 0) {
                return response()->json(['errors' => 'Quantity must be more than zero']);
            }
        }
        DB::beginTransaction();
        try {
            $id                             = $request->hidden_id;
            $id_number                      = $request->hidden_id_number;
            $pp                             = sale_delivery_item::where('sale_delivery_id', $id)->get();
            $checknumberpd                  = sale_delivery::find($id);
            $get_ot                         = other_transaction::where('number', $checknumberpd->number)->where('type', 'sales delivery')->first();
            $subtotal_header_other          = 0;
            $taxtotal_header_other          = 0;
            $grandtotal_header_other        = 0;
            // MENGUBAH STATUS SI SALES ORDER DAN OTHER TRANSACTION DARI OPEN KE CLOSED
            if ($status_closed == 1) {
                $updatepdstatus = array(
                    'status'                => 2,
                );
                sale_order::where('number', $id_number)->update($updatepdstatus);
                other_transaction::where('number', $id_number)->where('type', 'sales order')->update($updatepdstatus);
            } else {
                $updatepdstatus = array(
                    'status'                => 4,
                );
                sale_order::where('number', $id_number)->update($updatepdstatus);
                other_transaction::where('number', $id_number)->where('type', 'sales order')->update($updatepdstatus);
            }
            // DEFAULT DARI SETTING
            $default_unbilled_receivable    = default_account::find(7);
            $default_unbilled_revenue       = default_account::find(6);

            $get_ot->update([
                'memo'                      => $request->get('memo'),
                'transaction_date'          => $request->get('shipping_date'),
                'balance_due'               => $request->get('balance'),
                'total'                     => $request->get('balance'),
            ]);

            $checknumberpd->update([
                'email'                     => $request->get('email'),
                'transaction_date'          => $request->get('shipping_date'),
                'vendor_ref_no'             => $request->get('vendor_no'),
                'message'                   => $request->get('message'),
                'memo'                      => $request->get('memo'),
                'subtotal'                  => $request->get('subtotal'),
                'taxtotal'                  => $request->get('taxtotal'),
                'balance_due'               => $request->get('balance'),
                'grandtotal'                => $request->get('balance'),
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

                $avg_price                      = product::find($request->products[$i]);
                $total_avg                      = $request->qty[$i] * $avg_price->avg_price;
                $default_product_account        = product::find($request->products[$i]);
                if ($default_product_account->is_track == 1) {
                    // DEFAULT BUY ACCOUNT
                    $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales delivery')
                        ->where('number', 'Sales Delivery #' . $checknumberpd->number)
                        ->where('credit', 0)
                        ->where('coa_id', $default_product_account->buy_account)
                        ->first();
                    $ambil_avg_price_dari_coadetial->delete();
                    coa_detail::where('type', 'sales delivery')
                        ->where('number', 'Sales Delivery #' . $checknumberpd->number)
                        ->where('credit', 0)
                        ->where('coa_id', $default_product_account->buy_account)
                        ->update([
                            'coa_id'            => $default_product_account->buy_account,
                            'date'              => $request->get('trans_date'),
                            'contact_id'        => $request->get('vendor_name'),
                            'debit'             => $total_avg,
                        ]);
                    // DEFAULT INVENTORY ACCOUNT
                    $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales delivery')
                        ->where('number', 'Sales Delivery #' . $checknumberpd->number)
                        ->where('debit', 0)
                        ->where('coa_id', $default_product_account->default_inventory_account)
                        ->first();
                    $ambil_avg_price_dari_coadetial->delete();
                    coa_detail::where('type', 'sales delivery')
                        ->where('number', 'Sales Delivery #' . $checknumberpd->number)
                        ->where('debit', 0)
                        ->where('coa_id', $default_product_account->default_inventory_account)
                        ->update([
                            'coa_id'            => $default_product_account->default_inventory_account,
                            'date'              => $request->get('trans_date'),
                            'contact_id'        => $request->get('vendor_name'),
                            'credit'            => $total_avg,
                        ]);
                }
                // FINALLY UPDATE THE ITEM
                $pp[$i]->update([
                    'product_id'            => $request->products[$i],
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
                ]);
                $updatejugapoinya           = sale_order_item::find($request->poi_id[$i]);
                $updatejugapoinya->update(['qty_remaining' => $request->r_qty[$i]]);
            };

            $get_ot->update([
                'balance_due'       => $grandtotal_header_other,
                'total'             => $grandtotal_header_other,
            ]);

            $checknumberpd->update([
                'subtotal'          => $subtotal_header_other,
                'taxtotal'          => $taxtotal_header_other,
                'balance_due'       => $grandtotal_header_other,
                'grandtotal'        => $grandtotal_header_other,
            ]);

            // UPDATE PAKE YANG BARU
            coa_detail::where('type', 'sales delivery')
                ->where('number', 'Sales Delivery #' . $checknumberpd->number)
                ->where('coa_id', $default_unbilled_receivable->account_id)
                ->where('credit', 0)
                ->update([
                    'coa_id'                => $default_unbilled_receivable->account_id,
                    'date'                  => $request->get('trans_date'),
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => $grandtotal_header_other,
                ]);

            coa_detail::where('type', 'sales delivery')
                ->where('number', 'Sales Delivery #' . $checknumberpd->number)
                ->where('coa_id', $default_unbilled_revenue->account_id)
                ->where('debit', 0)
                ->update([
                    'coa_id'                => $default_unbilled_revenue->account_id,
                    'date'                  => $request->get('trans_date'),
                    'contact_id'            => $request->get('vendor_name'),
                    'credit'                => $grandtotal_header_other,
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
            $pi                                     = sale_delivery::find($id);
            $idsipo                                 = sale_order::find($pi->selected_so_id);
            // BALIKIN STATUS ORDER
            $ambilpo                            = sale_order::find($pi->selected_so_id);
            $ambilpo->update([
                'balance_due'                   => $ambilpo->balance_due + $pi->subtotal,
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
            // HAPUS BALANCE PER ITEM delivery
            $pi_details                             = sale_delivery_item::where('sale_delivery_id', $id)->get();
            foreach ($pi_details as $a) {
                /*// KITA AMBIL PO ID
                $ambil_po_id_current_pi             = $pi->selected_so_id; // 7
                $tarik_semua_pi_detail              = sale_delivery_item::get(); // NGECEK SEMUA PI BUAT AMBIL PARENT
                foreach ($tarik_semua_pi_detail as $tarik) {
                    $ambil_pi_dartarik_semua        = sale_delivery::where('id', $tarik->sale_delivery_id)->get();
                    foreach ($ambil_pi_dartarik_semua as $daritarik) {
                        $ambil_po_id_daritarik      = $daritarik->selected_so_id;
                        $simpanb                    = 0;
                        $hasil_akhir                = 0;
                        if ($ambil_po_id_daritarik == $ambil_po_id_current_pi) {
                            $simpana                = $tarik->qty_remaining;
                            if ($simpanb == 0) {
                                $simpanb            = $simpana;
                            }
                            if ($simpana <= $simpanb) {
                                $hasil_akhir        = $simpana;
                            }
                            $simpanb                = $simpana;
                        }
                    }
                }
                $qty_remaining_terbaru              = $hasil_akhir + $a->qty; // UDAH DAPET 100 NIH
                $ambil_bapaknya                     = sale_order::where('id', $pi->selected_so_id)->first();
                //dd($ambil_bapaknya->total_qty);
                if ($ambil_bapaknya->total_qty == $qty_remaining_terbaru) {
                    // UPDATE STATUS sales ORDER
                    $updatepdstatus                 = array(
                        'status'                    => 1,
                    );
                    sale_order::where('number', $pi->sale_order->number)->update($updatepdstatus);
                } else {
                    // UPDATE STATUS sales ORDER
                    $updatepdstatus                 = array(
                        'status'                    => 4,
                    );
                    sale_order::where('number', $pi->sale_order->number)->update($updatepdstatus);
                }*/
                $ambilpoo                       = sale_order_item::find($a->sale_order_item_id);
                $ambilpoo->update([
                    'qty_remaining'             => $ambilpoo->qty_remaining + $a->qty,
                ]);
                $default_product_account            = product::find($a->product_id);
                if ($default_product_account->is_track == 1) {
                    $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales delivery')
                        ->where('number', 'Sales Delivery #' . $pi->number)
                        ->where('credit', 0)
                        ->where('coa_id', $default_product_account->buy_account)
                        ->first();
                    $ambil_avg_price_dari_coadetial->delete();
                    $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales delivery')
                        ->where('number', 'Sales Delivery #' . $pi->number)
                        ->where('debit', 0)
                        ->where('coa_id', $default_product_account->default_inventory_account)
                        ->first();
                    $ambil_avg_price_dari_coadetial->delete();
                }
            }
            coa_detail::where('type', 'sales delivery')->where('number', 'Sales Delivery #' . $pi->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'sales delivery')->where('number', 'Sales Delivery #' . $pi->number)->where('credit', 0)->delete();
            sale_delivery_item::where('sale_delivery_id', $id)->delete();
            // DELETE ROOT OTHER TRANSACTION
            other_transaction::where('type', 'sales delivery')->where('number', $pi->number)->delete();
            // FINALLY DELETE THE delivery
            $pi->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted', 'id' => $idsipo->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function cetak_pdf_1($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_delivery::find($id);
        $pp_item                    = sale_delivery_item::where('sale_delivery_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $logo                       = company_logo::where('company_id', $user->company_id)->latest()->first();
        $pdf = PDF::loadview('admin.sales.delivery.PrintPDF_1', compact(['pp', 'pp_item', 'today', 'company', 'logo']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_2($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_delivery::find($id);
        $pp_item                    = sale_delivery_item::where('sale_delivery_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $logo                       = company_logo::where('company_id', $user->company_id)->latest()->first();
        $pdf = PDF::loadview('admin.sales.delivery.PrintPDF_2', compact(['pp', 'pp_item', 'today', 'company', 'logo']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_fas($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_delivery::find($id);
        $pp_item                    = sale_delivery_item::where('sale_delivery_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.delivery.PrintPDF_FAS', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_gg($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_delivery::find($id);
        $pp_item                    = sale_delivery_item::where('sale_delivery_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.delivery.PrintPDF_GG', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_delivery::find($id);
        $pp_item                    = sale_delivery_item::where('sale_delivery_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.delivery.PrintPDF_Sukses', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses_surabaya($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_delivery::find($id);
        $pp_item                    = sale_delivery_item::where('sale_delivery_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.delivery.PrintPDF_Sukses_Surabaya', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
