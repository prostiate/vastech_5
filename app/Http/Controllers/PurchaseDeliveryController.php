<?php

namespace App\Http\Controllers;

use App\Model\purchase\purchase_delivery;
use App\Model\purchase\purchase_order;
use App\Model\purchase\purchase_order_item;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Model\purchase\purchase_delivery_item;
use App\Model\coa\default_account;
use App\Model\other\other_transaction;
use App\Model\coa\coa_detail;
use App\Model\product\product;
use App\Model\coa\coa;
use App\Model\purchase\purchase_invoice;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseDeliveryController extends Controller
{
    public function index()
    {
        $user               = User::find(Auth::id());
        $open_po            = purchase_delivery::where('status', 1)->count();
        $payment_last       = purchase_delivery::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->count();
        $overdue            = purchase_delivery::where('status', 5)->count();
        $open_po_total            = purchase_delivery::where('status', 1)->sum('grandtotal');
        $payment_last_total       = purchase_delivery::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->sum('grandtotal');
        $overdue_total            = purchase_delivery::where('status', 5)->sum('grandtotal');

        if (request()->ajax()) {
            return datatables()->of(purchase_delivery::with('contact', 'status')->get())
                ->make(true);
        }

        return view('admin.purchases.delivery.index', compact(['user', 'open_po', 'payment_last', 'overdue', 'open_po_total', 'payment_last_total', 'overdue_total']));
    }

    public function createFromPO($id)
    {
        $check                      = purchase_delivery::where('selected_po_id', $id)->latest()->first();
        if (!$check) {
            $po                     = purchase_order::find($id);
            $po_item                = purchase_order_item::where('purchase_order_id', $id)->get();
            $today                  = Carbon::today()->toDateString();
            $dt                     = Carbon::now();
            $user                   = User::find(Auth::id());
            if ($user->company_id == 5) {
                $number             = purchase_delivery::latest()->first();
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
                        $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PD';
                    } else {
                        $check_number   = purchase_delivery::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                        if ($check_number) {
                            $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PD';
                        } else {
                            $number1    = 10001;
                            $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PD';
                        }
                    }
                } else {
                    $check_number   = purchase_delivery::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PD';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PD';
                    }
                }
            } else {
                $number             = purchase_delivery::max('number');
                if ($number == 0)
                    $number         = 10000;
                $trans_no           = $number + 1;
            }

            return view('admin.purchases.delivery.po.create_baru', compact(['today', 'trans_no', 'po', 'po_item']));
        } else {
            $po                     = purchase_order::find($id);
            $po_item                = purchase_order_item::where('purchase_order_id', $id)->get();
            $today                  = Carbon::today()->toDateString();
            $dt                     = Carbon::now();
            $user                   = User::find(Auth::id());
            if ($user->company_id == 5) {
                $number             = purchase_delivery::latest()->first();
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
                        $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PD';
                    } else {
                        $check_number   = purchase_delivery::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                        if ($check_number) {
                            $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PD';
                        } else {
                            $number1    = 10001;
                            $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PD';
                        }
                    }
                } else {
                    $check_number   = purchase_delivery::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PD';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.PD';
                    }
                }
            } else {
                $number             = purchase_delivery::max('number');
                if ($number == 0)
                    $number         = 10000;
                $trans_no           = $number + 1;
            }

            return view('admin.purchases.delivery.po.create_lama', compact(['today', 'trans_no', 'po', 'po_item']));
        }
    }

    public function storeFromPO(Request $request)
    {
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = purchase_delivery::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                $check_number   = purchase_delivery::whereMonth('transaction_date', Carbon::parse($request->shipping_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->shipping_date)->format('m') . '/' . Carbon::parse($request->shipping_date)->format('y') . '.' . $number2 . '.PD';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->shipping_date)->format('m') . '/' . Carbon::parse($request->shipping_date)->format('y') . '.' . $number1 . '.PD';
                }
            } else {
                $check_number   = purchase_delivery::whereMonth('transaction_date', Carbon::parse($request->shipping_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->shipping_date)->format('m') . '/' . Carbon::parse($request->shipping_date)->format('y') . '.' . $number2 . '.PD';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->shipping_date)->format('m') . '/' . Carbon::parse($request->shipping_date)->format('y') . '.' . $number1 . '.PD';
                }
            }
        } else {
            $number             = purchase_delivery::max('number');
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
                return response()->json(['errors' => 'Quantity cannot be less than 0']);
            } else if ($request->r_qty[$i] < 0) {
                return response()->json(['errors' => 'Quantity cannot be more than stock']);
            } else if ($request->r_qty[$i] == 0) {
                $status_closed = 1;
            } else if ($request->qty[$i] == 0) {
                return response()->json(['errors' => 'Quantity cannot be 0']);
            }
        }
        DB::beginTransaction();
        try {
            $id                                 = $request->hidden_id;
            $id_number                          = $request->hidden_id_number;
            // MENGUBAH STATUS SI PURCHASE ORDER DAN OTHER TRANSACTION DARI OPEN KE CLOSED
            $check_total_po                     = purchase_order::find($id);
            $check_total_po->update([
                'balance_due'                   => $check_total_po->balance_due - $request->balance,
            ]);
            if ($check_total_po->balance_due == 0) {
                $updatepdstatus                 = array(
                    'status'                    => 2,
                );
                purchase_order::where('number', $id_number)->update($updatepdstatus);
                other_transaction::where('number', $id_number)->where('type', 'purchase order')->update($updatepdstatus);
            } else {
                $updatepdstatus                 = array(
                    'status'                    => 4,
                );
                purchase_order::where('number', $id_number)->update($updatepdstatus);
                other_transaction::where('number', $id_number)->where('type', 'purchase order')->update($updatepdstatus);
            }

            $transactions = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'number_complete'               => 'Purchase Delivery #' . $trans_no,
                'type'                          => 'purchase delivery',
                'transaction_date'              => $request->get('shipping_date'),
                'memo'                          => $request->get('memo'),
                'contact'                       => $request->get('vendor_name'),
                'status'                        => 6,
                'balance_due'                   => $request->get('balance'),
                'total'                         => $request->get('balance'),
            ]);

            $pd = new purchase_delivery([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'address'                       => $request->get('address'),
                'email'                         => $request->get('email'),
                'term_id'                       => $request->get('term'),
                'transaction_date'              => $request->get('shipping_date'),
                'transaction_no'                => $request->get('trans_no'),
                'vendor_ref_no'                 => $request->get('vendor_no'),
                'warehouse_id'                  => $request->get('warehouse'),
                'subtotal'                      => $request->get('subtotal'),
                'taxtotal'                      => $request->get('taxtotal'),
                'balance_due'                   => $request->get('balance'),
                'grandtotal'                    => $request->get('balance'),
                'message'                       => $request->get('message'),
                'memo'                          => $request->get('memo'),
                'status'                        => 6,
                'selected_po_id'                => $id,
            ]);
            //$pd->save();
            $transactions->purchase_delivery()->save($pd);
            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $pd->id,
            ]);

            $default_unbilled_account_payable   = default_account::find(13);
            coa_detail::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'ref_id'                        => $pd->id,
                'other_transaction_id'          => $transactions->id,
                'coa_id'                        => $default_unbilled_account_payable->account_id,
                'date'                          => $request->get('shipping_date'),
                'type'                          => 'purchase delivery',
                'number'                        => 'Purchase Delivery #' . $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => 0,
                'credit'                        => $request->get('balance'),
            ]);

            foreach ($request->products as $i => $keys) {
                $pp[$i] = new purchase_delivery_item([
                    'purchase_order_item_id'    => $request->poi_id[$i],
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
                ]);
                $pd->purchase_delivery_item()->save($pp[$i]);

                $updatejugapoinya               = purchase_order_item::find($request->poi_id[$i]);
                $updatejugapoinya->update(['qty_remaining' => $request->r_qty[$i]]);

                $default_product_account        = product::find($request->products[$i]);
                // DEFAULT INVENTORY 17 dan yang di input di debit ini adalah total harga dari per barang
                if ($default_product_account->is_track == 1) {
                    coa_detail::create([
                        'company_id'            => $user->company_id,
                        'user_id'               => Auth::id(),
                        'ref_id'                => $pd->id,
                        'other_transaction_id'  => $transactions->id,
                        'coa_id'                => $default_product_account->default_inventory_account,
                        'date'                  => $request->get('shipping_date'),
                        'type'                  => 'purchase delivery',
                        'number'                => 'Purchase Delivery #' . $trans_no,
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
                        'date'                  => $request->get('shipping_date'),
                        'type'                  => 'purchase delivery',
                        'number'                => 'Purchase Delivery #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $request->total_price[$i],
                        'credit'                => 0,
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
        $pd                         = purchase_delivery::with('status')->find($id);
        $products                   = purchase_delivery_item::where('purchase_delivery_id', $id)->get();
        $checknumberpd              = purchase_delivery::whereId($id)->first();
        $numbercoadetail            = 'Purchase Delivery #' . $checknumberpd->number;
        $numberothertransaction     = $checknumberpd->number;
        $get_all_detail             = coa_detail::where('number', $numbercoadetail)->where('type', 'purchase delivery')->with('coa')->get();
        $total_debit                = $get_all_detail->sum('debit');
        $total_credit               = $get_all_detail->sum('credit');
        $check_invoice              = purchase_invoice::where('selected_pd_id', $id)->first();

        return view('admin.purchases.delivery.show', compact(['pd', 'products', 'get_all_detail', 'total_debit', 'total_credit', 'check_invoice']));
    }

    public function edit($id)
    {
        $pd                 = purchase_delivery::find($id);
        if($pd->status != 6){
            return redirect('/purchases_delivery');
        }
        $products           = purchase_delivery_item::where('purchase_delivery_id', $id)->get();

        return view('admin.purchases.delivery.edit', compact(['pd', 'products']));
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
                return response()->json(['errors' => 'Quantity cannot be less than 0']);
            } else if ($request->r_qty[$i] < 0) {
                return response()->json(['errors' => 'Quantity cannot be more than stock']);
            } else if ($request->r_qty[$i] == 0) {
                $status_closed = 1;
            } else if ($request->qty[$i] == 0) {
                return response()->json(['errors' => 'Quantity cannot be 0']);
            }
        }
        DB::beginTransaction();
        try {
            $id                     = $request->hidden_id;
            $id_number              = $request->hidden_id_number;
            $pp                     = purchase_delivery_item::where('purchase_delivery_id', $id)->get();
            $checknumberpd          = purchase_delivery::find($id);
            // MENGUBAH STATUS SI PURCHASE ORDER DAN OTHER TRANSACTION DARI OPEN KE CLOSED
            if ($status_closed == 1) {
                $updatepdstatus     = array(
                    'status'        => 2,
                );
                purchase_order::where('number', $id_number)->update($updatepdstatus);
                other_transaction::where('number', $id_number)->where('type', 'purchase order')->update($updatepdstatus);
            } else {
                $updatepdstatus = array(
                    'status'        => 4,
                );
                purchase_order::where('number', $id_number)->update($updatepdstatus);
                other_transaction::where('number', $id_number)->where('type', 'purchase order')->update($updatepdstatus);
            }
            other_transaction::where('number', $checknumberpd->number)->where('type', 'purchase delivery')->update([
                'memo'              => $request->get('memo'),
                'transaction_date'  => $request->get('shipping_date'),
                'balance_due'       => $request->get('balance'),
                'total'             => $request->get('balance'),
            ]);
            // DELETE DULU BALANCE YANG SEBELUMNYA
            $default_unbilled_account_payable   = default_account::find(13);
            coa_detail::where('number', 'Purchase Delivery #' . $checknumberpd->number)
                ->where('type', 'purchase delivery')
                ->where('debit', 0)
                ->where('coa_id', $default_unbilled_account_payable->account_id)
                ->update([
                    'date'          => $request->shipping_date,
                    'credit'        => $request->balance,
                ]);
            // UDPATE DELIVERY HEADERNYA
            purchase_delivery::find($id)->update([
                'email'             => $request->get('email'),
                'transaction_date'  => $request->get('shipping_date'),
                'vendor_ref_no'     => $request->get('vendor_no'),
                'message'           => $request->get('message'),
                'memo'              => $request->get('memo'),
                'subtotal'                  => $request->get('subtotal'),
                'taxtotal'                  => $request->get('taxtotal'),
                'balance_due'       => $request->get('balance'),
                'grandtotal'        => $request->get('balance'),
            ]);

            foreach ($request->products as $i => $keys) {
                $default_product_account = product::find($request->products[$i]);
                // DEFAULT INVENTORY 17 dan yang di input di debit ini adalah total harga dari per barang
                if ($default_product_account->is_track == 1) {
                    coa_detail::where('number', 'Purchase Delivery #' . $checknumberpd->number)
                        ->where('type', 'purchase delivery')
                        ->where('credit', 0)
                        ->where('coa_id', $default_product_account->default_inventory_account)
                        ->update([
                            'date'          => $request->shipping_date,
                            'debit'         => $request->total_price[$i],
                        ]);
                } else {
                    coa_detail::where('number', 'Purchase Delivery #' . $checknumberpd->number)
                        ->where('type', 'purchase delivery')
                        ->where('credit', 0)
                        ->where('coa_id', $default_product_account->buy_account)
                        ->update([
                            'date'          => $request->shipping_date,
                            'debit'         => $request->total_price[$i],
                        ]);
                }
                $pp[$i]->update([
                    'product_id'    => $request->products[$i],
                    'desc'          => $request->desc[$i],
                    'qty'           => $request->qty[$i],
                    'unit_id'       => $request->units[$i],
                    'unit_price'    => $request->unit_price[$i],
                    'tax_id'        => $request->tax[$i],
                    'amountsub'             => $request->total_price_sub[$i],
                    'amounttax'             => $request->total_price_tax[$i],
                    'amountgrand'           => $request->total_price_grand[$i],
                    'amount'                => $request->total_price[$i],
                    'qty_remaining' => $request->r_qty[$i],
                ]);
                $updatejugapoinya           = purchase_order_item::find($request->poi_id[$i]);
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
            $pi                                     = purchase_delivery::find($id);
            $idsipo                                 = purchase_order::find($pi->selected_po_id);
            $default_unbilled_account_payable       = default_account::find(13);
            coa_detail::where('type', 'purchase delivery')->where('number', 'Purchase Delivery #' . $pi->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'purchase delivery')->where('number', 'Purchase Delivery #' . $pi->number)->where('credit', 0)->delete();
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
            // HAPUS BALANCE PER ITEM delivery
            $pi_details                             = purchase_delivery_item::where('purchase_delivery_id', $id)->get();
            foreach ($pi_details as $a) {
                /*// KITA AMBIL PO ID
                $ambil_po_id_current_pi             = $pi->selected_po_id; // 7
                $tarik_semua_pi_detail              = purchase_delivery_item::get(); // NGECEK SEMUA PI BUAT AMBIL PARENT
                foreach ($tarik_semua_pi_detail as $tarik) {
                    $ambil_pi_dartarik_semua        = purchase_delivery::where('id', $tarik->purchase_delivery_id)->get();
                    foreach ($ambil_pi_dartarik_semua as $daritarik) {
                        $ambil_po_id_daritarik      = $daritarik->selected_po_id;
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
                $ambil_bapaknya                     = purchase_order::where('id', $pi->selected_po_id)->first();
                //dd($ambil_bapaknya->total_qty);
                if ($ambil_bapaknya->total_qty == $qty_remaining_terbaru) {
                    // UPDATE STATUS PURCHASE ORDER
                    $updatepdstatus                 = array(
                        'status'                    => 1,
                    );
                    purchase_order::where('number', $pi->purchase_order->number)->update($updatepdstatus);
                } else {
                    // UPDATE STATUS PURCHASE ORDER
                    $updatepdstatus                 = array(
                        'status'                    => 4,
                    );
                    purchase_order::where('number', $pi->purchase_order->number)->update($updatepdstatus);
                }*/
                $ambilpoo                       = purchase_order_item::find($a->purchase_order_item_id);
                $ambilpoo->update([
                    'qty_remaining'             => $ambilpoo->qty_remaining + $a->qty,
                ]);
            }
            purchase_delivery_item::where('purchase_delivery_id', $id)->delete();
            // DELETE ROOT OTHER TRANSACTION
            other_transaction::where('type', 'purchase delivery')->where('number', $pi->number)->delete();
            // FINALLY DELETE THE delivery
            $pi->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted', 'id' => $idsipo->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }
}
