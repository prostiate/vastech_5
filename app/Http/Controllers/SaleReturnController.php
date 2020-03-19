<?php

namespace App\Http\Controllers;

use App\Model\sales\sale_invoice;
use App\Model\sales\sale_invoice_item;
use App\Model\contact\contact;
use App\Model\warehouse\warehouse;
use App\Model\product\product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Model\coa\coa_detail;
use App\Model\coa\default_account;
use App\Model\warehouse\warehouse_detail;
use App\Model\other\other_transaction;
use PDF;
use App\Model\coa\coa;
use App\Model\company\company_logo;
use App\Model\company\company_setting;
use App\Model\sales\sale_return;
use App\Model\sales\sale_return_item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class SaleReturnController extends Controller
{
    public function index()
    {
        $user               = User::find(Auth::id());
        if (request()->ajax()) {
            return datatables()->of(sale_return::with('sale_invoice')->get())
                ->make(true);
        }

        return view('admin.sales.return.index', compact(['user']));
    }

    public function create($id)
    {
        $po                     = sale_invoice::find($id);
        $po_item                = sale_invoice_item::where('sale_invoice_id', $id)->get();
        $today                  = Carbon::today()->toDateString();
        $warehouses             = warehouse::all();
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = sale_return::latest()->first();
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
                    $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SR';
                } else {
                    $check_number   = sale_return::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SR';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SR';
                    }
                }
            } else {
                $check_number   = sale_return::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                if ($check_number) {
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SR';
                } else {
                    $number1    = 10001;
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.SR';
                }
            }
        } else {
            $number             = sale_return::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }

        return view('admin.sales.return.create', compact(['today', 'trans_no', 'warehouses', 'po', 'po_item']));
    }

    public function store(Request $request)
    {
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = sale_return::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                    $check_number   = sale_return::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                    if ($check_number) {
                        if ($check_number != null) {
                            $misahm = explode("/", $check_number->number);
                            $misahy = explode(".", $misahm[1]);
                        }
                        if (isset($misahy[1]) == 0) {
                            $misahy[1]      = 10000;
                        }
                        $number2    = $misahy[1] + 1;
                        $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SR';
                    } else {
                        $number1    = 10001;
                        $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SR';
                    }
            } else {
                $check_number   = sale_return::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.SR';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.SR';
                }
            }
        } else {
            $number             = sale_return::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }
        DB::beginTransaction();
        try {
            // AMBIL ID DAN NUMBER SI PURCHASE INVOICE
            $id_pi                          = $request->hidden_id;
            $number_pi                      = $request->hidden_id_number;
            // CREATE COA DETAIL BASED ON CONTACT SETTING ACCOUNT
            $contact_account                = contact::find($request->vendor_name);
            // CREATE OTHER TRANSACTION PUNYA RETURN
            $transactions = other_transaction::create([
                'company_id'                => $user->company_id,
                'user_id'                   => Auth::id(),
                'transaction_date'          => $request->get('return_date'),
                'number'                    => $trans_no,
                'number_complete'           => 'Sales Return #' . $trans_no,
                'type'                      => 'sales return',
                'memo'                      => $request->get('memo'),
                'contact'                   => $request->get('vendor_name'),
                'due_date'                  => $request->get('due_date'),
                'status'                    => 2,
                'balance_due'               => 0,
                'total'                     => 0,
            ]);
            // CREATE PURCHASE RETURN HEADER
            $pd = new sale_return([
                'company_id'                => $user->company_id,
                'user_id'                   => Auth::id(),
                'number'                    => $trans_no,
                'contact_id'                => $request->get('vendor_name'),
                'email'                     => $request->get('email'),
                'address'                   => $request->get('vendor_address'),
                'transaction_date'          => $request->get('trans_date'),
                'due_date'                  => $request->get('due_date'),
                'return_date'               => $request->get('return_date'),
                'transaction_no_si'         => $number_pi,
                'warehouse_id'              => $request->get('warehouse'),
                'message'                   => $request->get('message'),
                'memo'                      => $request->get('memo'),
                'subtotal'                  => $request->get('subtotal'),
                'taxtotal'                  => $request->get('taxtotal'),
                'grandtotal'                => $request->get('balance'),
                'status'                    => 2,
                'selected_si_id'            => $id_pi,
            ]);
            $transactions->sale_return()->save($pd);
            other_transaction::find($transactions->id)->update([
                'ref_id'                    => $pd->id,
            ]);
            coa_detail::create([
                'company_id'                => $user->company_id,
                'user_id'                   => Auth::id(),
                'ref_id'                    => $pd->id,
                'other_transaction_id'      => $transactions->id,
                'coa_id'                    => $contact_account->account_receivable_id,
                'date'                      => $request->get('return_date'),
                'type'                      => 'sales return',
                'number'                    => 'Sales Return #' . $trans_no,
                'contact_id'                => $request->get('vendor_name'),
                'debit'                     => 0,
                'credit'                    => $request->get('balance'),
            ]);
            // UPDATE STATUS ON PURCHASE INVOICE & OTHER TRANSACTION INVOICE'S
            $ambilpi                        = sale_invoice::find($id_pi);
            $ambilpi->update([
                'total_return'              => $ambilpi->total_return + $request->balance,
                'balance_due'               => $ambilpi->balance_due - $request->balance
            ]);
            if ($ambilpi->balance_due <= 0) {
                $ambilpi->update([
                    'credit_memo'           => $ambilpi->credit_memo + abs($ambilpi->balance_due),
                ]);
                $ambilpi->update([
                    'balance_due'           => 0,
                ]);
            }
            $ambilot                        = other_transaction::where('number', $number_pi)->where('type', 'sales invoice')->first();
            $ambilot->update([
                'balance_due'               => $ambilpi->balance_due,
            ]);
            if ($ambilpi->balance_due == 0) {
                $updatestatus               = array(
                    'status'                => 3,
                );
            } else if ($request->balance == 0) {
                DB::rollBack();
                return response()->json(['errors' => 'Quantity at least must be more than zero']);
            } else {
                $updatestatus               = array(
                    'status'                => 4,
                );
            }
            $ambilpi->update($updatestatus);
            $ambilot->update($updatestatus);

            if ($request->taxtotal > 0) {
                $default_tax                = default_account::find(8);
                coa_detail::create([
                    'company_id'            => $user->company_id,
                    'user_id'               => Auth::id(),
                    'ref_id'                => $pd->id,
                    'other_transaction_id'  => $transactions->id,
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('return_date'),
                    'type'                  => 'sales return',
                    'number'                => 'Sales Return #' . $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => $request->get('taxtotal'),
                    'credit'                => 0,
                ]);
            }

            // CREATE PURCHASE RETURN DETAILS
            foreach ($request->products as $i => $keys) {
                if ($request->qty[$i] > 0) {
                    $pp[$i]                     = new sale_return_item([
                        'sale_invoice_item_id'  => $request->invoice_item[$i],
                        'product_id'            => $request->products[$i],
                        'qty_invoice'           => $request->qty_invoice[$i],
                        'qty_remaining_invoice' => $request->qty_remaining_return[$i],
                        'qty'                   => $request->qty[$i],
                        'unit_id'               => $request->units[$i],
                        'unit_price'            => $request->unit_price[$i],
                        'tax_id'                => $request->tax[$i],
                        'amountsub'             => $request->total_price_sub[$i],
                        'amounttax'             => $request->total_price_tax[$i],
                        'amountgrand'           => $request->total_price_grand[$i],
                        'amount'                => $request->total_price[$i],
                    ]);
                    $pd->sale_return_item()->save($pp[$i]);
                    // UPDATE ITEM INVOICE
                    if ($request->qty[$i] > $request->qty_remaining_return[$i]) {
                        DB::rollBack();
                        return response()->json(['errors' => 'Quantity cannot be more than order']);
                    } else {
                        $ambil_pii              = sale_invoice_item::find($request->invoice_item[$i]);
                        $ambil_pii->update([
                            'qty_remaining_return' => $ambil_pii->qty_remaining_return - $request->qty[$i]
                        ]);
                    }
                    // CREATE COA DETAIL BASED ON PRODUCT SETTING
                    $avg_price                      = product::find($request->products[$i]);
                    $total_avg                      = $request->qty[$i] * $avg_price->avg_price;
                    $default_product_account        = product::find($request->products[$i]);
                    $default_sales_return           = default_account::find(3);
                    if ($default_product_account->is_track == 1) {
                        // DEFAULT BUY ACCOUNT
                        coa_detail::create([
                            'company_id'            => $user->company_id,
                            'user_id'               => Auth::id(),
                            'ref_id'                => $pd->id,
                            'other_transaction_id'  => $transactions->id,
                            'coa_id'                => $default_product_account->buy_account,
                            'date'                  => $request->get('return_date'),
                            'type'                  => 'sales return',
                            'number'                => 'Sales Return #' . $trans_no,
                            'contact_id'            => $request->get('vendor_name'),
                            'debit'                 => 0,
                            'credit'                => $total_avg,
                        ]);
                        // DEFAULT SELL ACCOUNT (KARENA RETURN, DIA JADINYA MASUK KE SALES RETURN)
                        coa_detail::create([
                            'company_id'            => $user->company_id,
                            'user_id'               => Auth::id(),
                            'ref_id'                => $pd->id,
                            'other_transaction_id'  => $transactions->id,
                            'coa_id'                => $default_sales_return->account_id,
                            'date'                  => $request->get('return_date'),
                            'type'                  => 'sales return',
                            'number'                => 'Sales Return #' . $trans_no,
                            'contact_id'            => $request->get('vendor_name'),
                            'debit'                 => $request->total_price[$i],
                            'credit'                => 0,
                        ]);
                        // DEFAULT INVENTORY ACCOUNT
                        coa_detail::create([
                            'company_id'            => $user->company_id,
                            'user_id'               => Auth::id(),
                            'ref_id'                => $pd->id,
                            'other_transaction_id'  => $transactions->id,
                            'coa_id'                => $default_product_account->default_inventory_account,
                            'date'                  => $request->get('return_date'),
                            'type'                  => 'sales return',
                            'number'                => 'Sales Return #' . $trans_no,
                            'contact_id'            => $request->get('vendor_name'),
                            'debit'                 => $total_avg,
                            'credit'                => 0,
                            //'from_product_id'   => 0,
                        ]);
                    } else {
                        // DEFAULT SETTING
                        coa_detail::create([
                            'company_id'            => $user->company_id,
                            'user_id'               => Auth::id(),
                            'ref_id'                => $pd->id,
                            'other_transaction_id'  => $transactions->id,
                            'coa_id'                => $default_product_account->sell_account,
                            'date'                  => $request->get('return_date'),
                            'type'                  => 'sales return',
                            'number'                => 'Sales Return #' . $trans_no,
                            'contact_id'            => $request->get('vendor_name'),
                            'debit'                 => $request->total_price[$i],
                            'credit'                => 0,
                            //'from_product_id'   => $request->products[$i],
                        ]);
                    }
                    //menambahkan stok barang ke gudang
                    warehouse_detail::create([
                        'type'                  => 'sales return',
                        'number'                => 'Sales Return #' . $trans_no,
                        'product_id'            => $request->products[$i],
                        'warehouse_id'          => $request->warehouse,
                        'qty_in'                => $request->qty[$i],
                    ]);
                    //merubah harga average produk
                    $produk                     = product::find($request->products[$i]);
                    $qty                        = $request->qty[$i];
                    //menyimpan jumlah perubahan pada produk
                    product::where('id', $request->products[$i])->update([
                        'qty'                   => $qty + $produk->qty,
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
        $pi                         = sale_return::find($id);
        $products                   = sale_return_item::where('sale_return_id', $id)->get();
        $pi_history                 = sale_return::where('selected_si_id', $pi->selected_si_id)->where('id', '!=', $id)->get();
        $numbercoadetail            = 'Sales Return #' . $pi->number;
        $get_all_detail             = coa_detail::where('number', $numbercoadetail)->where('type', 'sales return')->with('coa')->get();
        $total_debit                = $get_all_detail->sum('debit');
        $total_credit               = $get_all_detail->sum('credit');
        return view(
            'admin.sales.return.show',
            compact([
                'pi',
                'products',
                'pi_history',
                'get_all_detail',
                'total_debit',
                'total_credit'
            ])
        );
    }

    public function edit($id)
    {
        $header                     = sale_return::find($id);
        if($header->status != 1){
            return redirect('/sales_return');
        }
        $item                       = sale_return_item::where('sale_return_id', $id)->get();
        $other_return               = sale_return::where('selected_si_id', $header->selected_si_id)->where('id', '!=', $id)->sum('grandtotal');
        //dd($other_return);
        return view(
            'admin.sales.return.edit',
            compact([
                'header',
                'item',
                'other_return'
            ])
        );
    }

    public function update(Request $request)
    {
        $user                                   = User::find(Auth::id());
        DB::beginTransaction();
        try {
            $id                                 = $request->hidden_id;
            $pi                                 = sale_return::find($id);
            $transactions                       = other_transaction::where('type', 'sales return')->where('number', $pi->number)->first();
            // UPDATE STATUS ON QUOTE & OTHER TRANSACTION QUOTE'S
            $ambilpi                            = sale_invoice::find($pi->selected_si_id);
            if ($ambilpi->credit_memo > 0) {
                $ambilpi->update([
                    'total_return'              => $ambilpi->total_return - $pi->grandtotal,
                    'credit_memo'               => $ambilpi->credit_memo - $pi->grandtotal,
                ]);
            } else {
                $ambilpi->update([
                    'total_return'              => $ambilpi->total_return - $pi->grandtotal,
                    'balance_due'               => $ambilpi->balance_due + $pi->grandtotal
                ]);
            }
            if ($ambilpi->balance_due == $ambilpi->grandtotal) {
                $ambilpi->update(['status'          => 1]);
                other_transaction::where('type', 'sales invoice')
                    ->where('number', $pi->transaction_no_si)
                    ->update([
                        'status'                    => 1
                    ]);
            } elseif ($ambilpi->balance_due == 0) {
                $ambilpi->update(['status'          => 3]);
                other_transaction::where('type', 'sales invoice')
                    ->where('number', $pi->transaction_no_si)
                    ->update([
                        'status'                    => 3
                    ]);
            } else {
                $ambilpi->update(['status'          => 4]);
                other_transaction::where('type', 'sales invoice')
                    ->where('number', $pi->transaction_no_si)
                    ->update([
                        'status'                    => 4
                    ]);
            }
            // HAPUS BALANCE PER ITEM RETURN
            $pi_details                             = sale_return_item::where('sale_return_id', $id)->get();
            foreach ($pi_details as $a) {
                $ambil_pii                          = sale_invoice_item::find($a->sale_invoice_item_id);
                $default_product_account            = product::find($a->product_id);
                if ($default_product_account->is_track == 1) {
                    $ambil_pii->update([
                        'qty_remaining_return'      => $ambil_pii->qty_remaining_return + $a->qty
                    ]);
                } else {
                    $ambil_pii->update([
                        'qty_remaining_return'      => $ambil_pii->qty_remaining_return + $a->qty
                    ]);
                }
                // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                warehouse_detail::where('type', 'sales return')
                    ->where('number', 'Sales Return #' . $pi->number)
                    ->where('product_id', $a->product_id)
                    ->where('warehouse_id', $pi->warehouse_id)
                    ->delete();
                // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                $produk                             = product::find($a->product_id);
                $qty                                = $a->qty;
                //menyimpan jumlah perubahan pada produk
                product::where('id', $a->product_id)->update([
                    'qty'                           => $produk->qty - $qty,
                ]);
            }
            // DELETE ALL COA DETAILS
            coa_detail::where('type', 'sales return')->where('number', 'Sales Return #' . $pi->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'sales return')->where('number', 'Sales Return #' . $pi->number)->where('credit', 0)->delete();
            sale_return_item::where('sale_return_id', $id)->delete();
            // UPDATE ROOT OTHER TRANSACTION
            other_transaction::where('type', 'sales return')->where('number', $pi->number)->update([
                'transaction_date'                  => $request->get('return_date'),
                'memo'                              => $request->get('memo'),
            ]);
            // FINALLY UPDATE THE RETURN
            $pi->update([
                'return_date'                       => $request->get('return_date'),
                'message'                           => $request->get('message'),
                'memo'                              => $request->get('memo'),
                'subtotal'                          => $request->get('subtotal'),
                'taxtotal'                          => $request->get('taxtotal'),
                'grandtotal'                        => $request->get('balance'),
            ]);
            // CREATE COA DETAIL BASED ON CONTACT SETTING ACCOUNT
            $contact_account                        = contact::find($request->vendor_name);
            coa_detail::create([
                'company_id'                        => $user->company_id,
                'user_id'                           => Auth::id(),
                'ref_id'                            => $pi->id,
                'other_transaction_id'              => $transactions->id,
                'coa_id'                            => $contact_account->account_receivable_id,
                'date'                              => $request->get('return_date'),
                'type'                              => 'sales return',
                'number'                            => 'Sales Return #' . $pi->number,
                'contact_id'                        => $request->get('vendor_name'),
                'debit'                             => 0,
                'credit'                            => $request->get('balance'),
            ]);
            // UPDATE STATUS ON PURCHASE INVOICE & OTHER TRANSACTION INVOICE'S
            $ambilpi                                = sale_invoice::find($pi->selected_si_id);
            $ambilpi->update([
                'total_return'                      => $ambilpi->total_return + $request->balance,
                'balance_due'                       => $ambilpi->balance_due - $request->balance
            ]);
            if ($ambilpi->balance_due <= 0) {
                $ambilpi->update([
                    'credit_memo'                   => $ambilpi->credit_memo + abs($ambilpi->balance_due),
                ]);
                $ambilpi->update([
                    'balance_due'                   => 0,
                ]);
            }
            $ambilot                                = other_transaction::where('number', $pi->transaction_no_si)->where('type', 'sales invoice')->first();
            $ambilot->update([
                'balance_due'                       => $ambilpi->balance_due,
            ]);
            if ($ambilpi->balance_due == 0) {
                $updatestatus = array(
                    'status'                        => 3,
                );
            } else if ($request->balance == 0) {
                DB::rollBack();
                return response()->json(['errors' => 'Quantity at least must be more than zero']);
            } else {
                $updatestatus = array(
                    'status'                        => 4,
                );
            }
            $ambilpi->update($updatestatus);
            $ambilot->update($updatestatus);

            if ($request->taxtotal > 0) {
                $default_tax                        = default_account::find(8);
                coa_detail::create([
                    'company_id'                    => $user->company_id,
                    'user_id'                       => Auth::id(),
                    'ref_id'                        => $pi->id,
                    'other_transaction_id'          => $transactions->id,
                    'coa_id'                        => $default_tax->account_id,
                    'date'                          => $request->get('return_date'),
                    'type'                          => 'sales return',
                    'number'                        => 'Sales Return #' . $pi->number,
                    'contact_id'                    => $request->get('vendor_name'),
                    'debit'                         => $request->get('taxtotal'),
                    'credit'                        => 0,
                ]);
            }

            // CREATE PURCHASE RETURN DETAILS
            foreach ($request->products as $i => $keys) {
                if ($request->qty[$i] > 0) {
                    $pp[$i] = new sale_return_item([
                        'sale_invoice_item_id'      => $request->invoice_item[$i],
                        'product_id'                => $request->products[$i],
                        'qty_invoice'               => $request->qty_invoice[$i],
                        'qty_remaining_invoice'     => $request->qty_remaining_return[$i],
                        'qty'                       => $request->qty[$i],
                        'unit_id'                   => $request->units[$i],
                        'unit_price'                => $request->unit_price[$i],
                        'tax_id'                    => $request->tax[$i],
                        'amountsub'                 => $request->total_price_sub[$i],
                        'amounttax'                 => $request->total_price_tax[$i],
                        'amountgrand'               => $request->total_price_grand[$i],
                        'amount'                    => $request->total_price[$i],
                    ]);
                    $pi->sale_return_item()->save($pp[$i]);
                    // UPDATE ITEM INVOICE
                    if ($request->qty[$i] > $request->qty_remaining_return[$i]) {
                        DB::rollBack();
                        return response()->json(['errors' => 'Quantity cannot be more than order']);
                    } else {
                        $ambil_pii                  = sale_invoice_item::find($request->invoice_item[$i]);
                        $ambil_pii->update([
                            'qty_remaining_return'  => $ambil_pii->qty_remaining_return - $request->qty[$i]
                        ]);
                    }
                    // CREATE COA DETAIL BASED ON PRODUCT SETTING
                    $avg_price                      = product::find($request->products[$i]);
                    $total_avg                      = $request->qty[$i] * $avg_price->avg_price;
                    $default_product_account        = product::find($request->products[$i]);
                    $default_sales_return           = default_account::find(3);
                    if ($default_product_account->is_track == 1) {
                        // DEFAULT BUY ACCOUNT
                        coa_detail::create([
                            'company_id'            => $user->company_id,
                            'user_id'               => Auth::id(),
                            'ref_id'                => $pi->id,
                            'other_transaction_id'  => $transactions->id,
                            'coa_id'                => $default_product_account->buy_account,
                            'date'                  => $request->get('return_date'),
                            'type'                  => 'sales return',
                            'number'                => 'Sales Return #' . $pi->number,
                            'contact_id'            => $request->get('vendor_name'),
                            'debit'                 => 0,
                            'credit'                => $total_avg,
                        ]);
                        // DEFAULT SELL ACCOUNT (KARENA RETURN, DIA JADINYA MASUK KE SALES RETURN)
                        coa_detail::create([
                            'company_id'            => $user->company_id,
                            'user_id'               => Auth::id(),
                            'ref_id'                => $pi->id,
                            'other_transaction_id'  => $transactions->id,
                            'coa_id'                => $default_sales_return->account_id,
                            'date'                  => $request->get('return_date'),
                            'type'                  => 'sales return',
                            'number'                => 'Sales Return #' . $pi->number,
                            'contact_id'            => $request->get('vendor_name'),
                            'debit'                 => $request->total_price[$i],
                            'credit'                => 0,
                        ]);
                        // DEFAULT INVENTORY ACCOUNT
                        coa_detail::create([
                            'company_id'            => $user->company_id,
                            'user_id'               => Auth::id(),
                            'ref_id'                => $pi->id,
                            'other_transaction_id'  => $transactions->id,
                            'coa_id'                => $default_product_account->default_inventory_account,
                            'date'                  => $request->get('return_date'),
                            'type'                  => 'sales return',
                            'number'                => 'Sales Return #' . $pi->number,
                            'contact_id'            => $request->get('vendor_name'),
                            'debit'                 => $total_avg,
                            'credit'                => 0,
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
                            'date'                  => $request->get('return_date'),
                            'type'                  => 'sales return',
                            'number'                => 'Sales Return #' . $pi->number,
                            'contact_id'            => $request->get('vendor_name'),
                            'debit'                 => $request->total_price[$i],
                            'credit'                => 0,
                            //'from_product_id'   => $request->products[$i],
                        ]);
                    }
                    //menambahkan stok barang ke gudang
                    warehouse_detail::create([
                        'type'                      => 'sales return',
                        'number'                    => 'Sales Return #' . $pi->number,
                        'product_id'                => $request->products[$i],
                        'warehouse_id'              => $request->warehouse,
                        'qty_in'                    => $request->qty[$i],
                    ]);
                    //merubah harga average produk
                    $produk                         = product::find($request->products[$i]);
                    $qty                            = $request->qty[$i];
                    //menyimpan jumlah perubahan pada produk
                    product::where('id', $request->products[$i])->update([
                        'qty'                       => $qty + $produk->qty,
                    ]);
                }
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
        $user       = User::find(Auth::id());
        $cs         = company_setting::where('company_id', $user->company_id)->first();
        if ($cs->company_id == 5) {
            if(Auth::id() != 999999){
                return redirect('/dashboard');
            }
        }
        DB::beginTransaction();
        try {
            $pi                                     = sale_return::find($id);
            // UPDATE STATUS ON PURCHASE QUOTE & OTHER TRANSACTION QUOTE'S
            $ambilpi                                = sale_invoice::find($pi->selected_si_id);
            if ($ambilpi->credit_memo > 0) {
                $ambilpi->update([
                    'total_return'                  => $ambilpi->total_return - $pi->grandtotal,
                    'credit_memo'                   => $ambilpi->credit_memo - $pi->grandtotal,
                ]);
            } else {
                $ambilpi->update([
                    'total_return'                  => $ambilpi->total_return - $pi->grandtotal,
                    'balance_due'                   => $ambilpi->balance_due + $pi->grandtotal
                ]);
            }
            if ($ambilpi->balance_due == $ambilpi->grandtotal) {
                $ambilpi->update(['status'          => 1]);
                other_transaction::where('type', 'sales invoice')
                    ->where('number', $pi->transaction_no_si)
                    ->update([
                        'status'                    => 1
                    ]);
            } elseif ($ambilpi->balance_due == 0) {
                $ambilpi->update(['status'          => 3]);
                other_transaction::where('type', 'sales invoice')
                    ->where('number', $pi->transaction_no_si)
                    ->update([
                        'status'                    => 3
                    ]);
            } else {
                $ambilpi->update(['status'          => 4]);
                other_transaction::where('type', 'sales invoice')
                    ->where('number', $pi->transaction_no_si)
                    ->update([
                        'status'                    => 4
                    ]);
            }
            // HAPUS BALANCE PER ITEM RETURN
            $pi_details                             = sale_return_item::where('sale_return_id', $id)->get();
            foreach ($pi_details as $a) {
                $ambil_pii                          = sale_invoice_item::find($a->sale_invoice_item_id);
                $default_product_account            = product::find($a->product_id);
                if ($default_product_account->is_track == 1) {
                    $ambil_pii->update([
                        'qty_remaining_return'      => $ambil_pii->qty_remaining_return + $a->qty
                    ]);
                } else {
                    $ambil_pii->update([
                        'qty_remaining_return'      => $ambil_pii->qty_remaining_return + $a->qty
                    ]);
                }
                // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                warehouse_detail::where('type', 'sales return')
                    ->where('number', 'Sales Return #' . $pi->number)
                    ->where('product_id', $a->product_id)
                    ->where('warehouse_id', $pi->warehouse_id)
                    ->delete();
                // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                $produk                             = product::find($a->product_id);
                $qty                                = $a->qty;
                //menyimpan jumlah perubahan pada produk
                product::where('id', $a->product_id)->update([
                    'qty'                           => $produk->qty - $qty,
                ]);
            }
            // DELETE ALL COA DETAILS
            coa_detail::where('type', 'sales return')->where('number', 'Sales Return #' . $pi->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'sales return')->where('number', 'Sales Return #' . $pi->number)->where('credit', 0)->delete();
            sale_return_item::where('sale_return_id', $id)->delete();
            // DELETE ROOT OTHER TRANSACTION
            other_transaction::where('type', 'sales return')->where('number', $pi->number)->delete();
            // FINALLY DELETE THE RETURN
            $pi->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted', 'id' => $ambilpi->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function cetak_pdf_1($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_return::find($id);
        $pp_item                    = sale_return_item::where('sale_return_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $logo                       = company_logo::where('company_id', $user->company_id)->latest()->first();
        $pdf = PDF::loadview('admin.sales.return.PrintPDF_1', compact(['pp', 'pp_item', 'today', 'company', 'logo']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_2($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_return::find($id);
        $pp_item                    = sale_return_item::where('sale_return_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $logo                       = company_logo::where('company_id', $user->company_id)->latest()->first();
        $pdf = PDF::loadview('admin.sales.return.PrintPDF_2', compact(['pp', 'pp_item', 'today', 'company', 'logo']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_fas($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_return::find($id);
        $pp_item                    = sale_return_item::where('sale_return_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.return.PrintPDF_FAS', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_gg($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_return::find($id);
        $pp_item                    = sale_return_item::where('sale_return_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.return.PrintPDF_GG', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_return::find($id);
        $pp_item                    = sale_return_item::where('sale_return_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.return.PrintPDF_Sukses', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses_surabaya($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_return::find($id);
        $pp_item                    = sale_return_item::where('sale_return_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.return.PrintPDF_Sukses_Surabaya', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
