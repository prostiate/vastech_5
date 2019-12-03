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
use App\coa;
use App\product;
use PDF;
use App\sale_invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SaleDeliveryController extends Controller
{
    public function index()
    {
        $open_po            = sale_delivery::whereIn('status', [1, 4])->count();
        $payment_last       = sale_delivery::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->count();
        $overdue            = sale_delivery::where('status', 5)->count();
        $open_po_total            = sale_delivery::whereIn('status', [1, 4])->sum('grandtotal');
        $payment_last_total       = sale_delivery::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->sum('grandtotal');
        $overdue_total            = sale_delivery::where('status', 5)->sum('grandtotal');
        if (request()->ajax()) {
            return datatables()->of(sale_delivery::with('contact', 'status')->get())
                ->make(true);
        }

        return view('admin.sales.delivery.index', compact(['open_po', 'payment_last', 'overdue', 'open_po_total', 'payment_last_total', 'overdue_total']));
    }

    public function createFromPO($id)
    {
        $check                  = sale_delivery::where('selected_so_id', $id)->latest()->first();
        if (!$check) {
            $po                 = sale_order::find($id);
            $po_item            = sale_order_item::where('sale_order_id', $id)->get();
            $today              = Carbon::today()->toDateString();
            $number             = sale_delivery::max('number');
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

            return view('admin.sales.delivery.po.create_baru', compact(['today', 'trans_no', 'po', 'po_item']));
        } else {
            $po                 = sale_delivery::where('selected_so_id', $id)->first();
            $po_item            = sale_delivery_item::where('sale_delivery_id', $check->id)->get();
            $today              = Carbon::today()->toDateString();
            $number             = sale_delivery::max('number');
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

            return view('admin.sales.delivery.po.create_lama', compact(['today', 'trans_no', 'po', 'po_item']));
        }
    }

    public function storeFromPO(Request $request)
    {
        $number             = sale_delivery::max('number');
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

            // DEFAULT DARI SETTING
            $default_unbilled_receivable    = default_account::find(7);
            $default_unbilled_revenue       = default_account::find(6);
            // DEFAULT SETTING UNBILLED ACCOUNT RECEIVABLE
            coa_detail::create([
                'coa_id'                    => $default_unbilled_receivable->account_id,
                'date'                      => $request->get('trans_date'),
                'type'                      => 'sales delivery',
                'number'                    => 'Sales Delivery #' . $trans_no,
                'contact_id'                => $request->get('vendor_name'),
                'debit'                     => $request->get('balance'),
                'credit'                    => 0,
            ]);
            $get_current_balance_on_coa = coa::find($default_unbilled_receivable->account_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                   => $get_current_balance_on_coa->balance + $request->get('balance'),
            ]);
            // DEFAULT SETTING UNBILLED REVENUE
            coa_detail::create([
                'coa_id'                    => $default_unbilled_revenue->account_id,
                'date'                      => $request->get('trans_date'),
                'type'                      => 'sales delivery',
                'number'                    => 'Sales Delivery #' . $trans_no,
                'contact_id'                => $request->get('vendor_name'),
                'debit'                     => 0,
                'credit'                    => $request->get('balance'),
            ]);
            $get_current_balance_on_coa     = coa::find($default_unbilled_revenue->account_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                   => $get_current_balance_on_coa->balance + $request->get('balance'),
            ]);

            $transactions = other_transaction::create([
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
                'user_id'                   => Auth::id(),
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
                $pp[$i] = new sale_delivery_item([
                    'sale_order_item_id'    => $request->poi_id[$i],
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
                        'coa_id'            => $default_product_account->buy_account,
                        'date'              => $request->get('trans_date'),
                        'type'              => 'sales delivery',
                        'number'            => 'Sales Delivery #' . $trans_no,
                        'contact_id'        => $request->get('vendor_name'),
                        'debit'             => $total_avg,
                        'credit'            => 0,
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->buy_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'           => $get_current_balance_on_coa->balance + $total_avg,
                    ]);
                    // DEFAULT INVENTORY BARANG
                    coa_detail::create([
                        'coa_id'            => $default_product_account->default_inventory_account,
                        'date'              => $request->get('trans_date'),
                        'type'              => 'sales delivery',
                        'number'            => 'Sales Delivery #' . $trans_no,
                        'contact_id'        => $request->get('vendor_name'),
                        'debit'             => 0,
                        'credit'            => $total_avg,
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'           => $get_current_balance_on_coa->balance - $total_avg,
                    ]);
                }
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
            // DEFAULT SETTING UNBILLED ACCOUNT RECEIVABLE
            $get_current_balance_on_coa     = coa::find($default_unbilled_receivable->account_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                   => $get_current_balance_on_coa->balance - $checknumberpd->grandtotal,
            ]);
            coa_detail::where('type', 'sales delivery')
                ->where('number', 'Sales Delivery #' . $checknumberpd->number)
                ->where('coa_id', $default_unbilled_receivable->account_id)
                ->where('credit', 0)
                ->update([
                    'coa_id'                => $default_unbilled_receivable->account_id,
                    'date'                  => $request->get('trans_date'),
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => $request->get('balance'),
                ]);
            $get_current_balance_on_coa     = coa::find($default_unbilled_receivable->account_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                   => $get_current_balance_on_coa->balance + $request->get('balance'),
            ]);
            // DEFAULT SETTING UNBILLED REVENUE
            $get_current_balance_on_coa     = coa::find($default_unbilled_revenue->account_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                   => $get_current_balance_on_coa->balance - $checknumberpd->grandtotal,
            ]);
            coa_detail::where('type', 'sales delivery')
                ->where('number', 'Sales Delivery #' . $checknumberpd->number)
                ->where('coa_id', $default_unbilled_revenue->account_id)
                ->where('debit', 0)
                ->update([
                    'coa_id'                => $default_unbilled_revenue->account_id,
                    'date'                  => $request->get('trans_date'),
                    'contact_id'            => $request->get('vendor_name'),
                    'credit'                => $request->get('balance'),
                ]);
            $get_current_balance_on_coa     = coa::find($default_unbilled_revenue->account_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                   => $get_current_balance_on_coa->balance + $request->get('balance'),
            ]);

            other_transaction::where('number', $checknumberpd->number)->where('type', 'sales delivery')->update([
                'memo'                      => $request->get('memo'),
                'transaction_date'          => $request->get('shipping_date'),
                'balance_due'               => $request->get('balance'),
                'total'                     => $request->get('balance'),
            ]);

            sale_delivery::find($id)->update([
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
                    $get_current_balance_on_coa = coa::find($default_product_account->buy_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $ambil_avg_price_dari_coadetial->debit,
                    ]);
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
                    $get_current_balance_on_coa = coa::find($default_product_account->buy_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $total_avg,
                    ]);
                    // DEFAULT INVENTORY ACCOUNT
                    $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales delivery')
                        ->where('number', 'Sales Delivery #' . $checknumberpd->number)
                        ->where('debit', 0)
                        ->where('coa_id', $default_product_account->default_inventory_account)
                        ->first();
                    $get_current_balance_on_coa = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $ambil_avg_price_dari_coadetial->credit,
                    ]);
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
                    $get_current_balance_on_coa = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'       => $get_current_balance_on_coa->balance - $total_avg,
                    ]);
                } else { }
                // FINALLY UPDATE THE ITEM
                $pp[$i]->update([
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
                ]);
                $updatejugapoinya           = sale_order_item::find($request->poi_id[$i]);
                $updatejugapoinya->update(['qty_remaining' => $request->r_qty[$i]]);
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
            $pi                                     = sale_delivery::find($id);
            $idsipo                                 = sale_order::find($pi->selected_so_id);
            $default_unbilled_receivable            = default_account::find(7);
            $default_unbilled_revenue               = default_account::find(6);
            // DELETE BALANCE DARI YANG PENGEN DI DELETE (CONTACT)
            $get_current_balance_on_coa             = coa::find($default_unbilled_receivable->account_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                           => $get_current_balance_on_coa->balance - $pi->grandtotal,
            ]);
            $get_current_balance_on_coa             = coa::find($default_unbilled_revenue->account_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                           => $get_current_balance_on_coa->balance - $pi->grandtotal,
            ]);
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
                    $get_current_balance_on_coa     = coa::find($default_product_account->buy_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'                   => $get_current_balance_on_coa->balance - $ambil_avg_price_dari_coadetial->debit,
                    ]);
                    $ambil_avg_price_dari_coadetial->delete();
                    $ambil_avg_price_dari_coadetial = coa_detail::where('type', 'sales delivery')
                        ->where('number', 'Sales Delivery #' . $pi->number)
                        ->where('debit', 0)
                        ->where('coa_id', $default_product_account->default_inventory_account)
                        ->first();
                    $get_current_balance_on_coa     = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'                   => $get_current_balance_on_coa->balance + $ambil_avg_price_dari_coadetial->credit,
                    ]);
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

    public function cetak_pdf($id)
    {
        $pp                         = sale_delivery::find($id);
        $pp_item                    = sale_delivery_item::where('sale_delivery_id', $id)->get();
        $checknumberpd              = sale_delivery::whereId($id)->first();
        $numbercoadetail            = 'Sales Delivery #' . $checknumberpd->number;
        $numberothertransaction     = $checknumberpd->number;
        $today                      = Carbon::today()->format('d F Y');
        $pdf = PDF::loadview('admin.sales.delivery.PrintPDF', compact(['pp', 'pp_item', 'today']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
