<?php

namespace App\Http\Controllers;

use App\purchase_invoice;
use App\purchase_invoice_item;
use App\contact;
use App\warehouse;
use App\product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\coa_detail;
use App\default_account;
use App\warehouse_detail;
use App\other_transaction;
use PDF;
use App\coa;
use App\company_logo;
use App\company_setting;
use App\purchase_return;
use App\purchase_return_item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class PurchaseReturnController extends Controller
{
    public function index()
    {
        $user               = User::find(Auth::id());
        if (request()->ajax()) {
            return datatables()->of(purchase_return::with('purchase_invoice')->get())
                ->make(true);
        }

        return view('admin.purchases.return.index', compact(['user']));
    }

    public function create($id)
    {
        $po                 = purchase_invoice::find($id);
        $po_item            = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
        $today              = Carbon::today()->toDateString();
        $warehouses         = warehouse::all();
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = purchase_return::latest()->first();
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
            $number             = purchase_return::max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }
        return view('admin.purchases.return.create', compact(['today', 'trans_no', 'warehouses', 'po', 'po_item']));
    }

    public function store(Request $request)
    {
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = purchase_return::latest()->first();
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
            $number             = purchase_return::max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }
        DB::beginTransaction();
        try {
            // AMBIL ID DAN NUMBER SI PURCHASE INVOICE
            $id_pi                          = $request->hidden_id;
            $number_pi                      = $request->hidden_id_number;
            // CREATE COA DETAIL BASED ON CONTACT SETTING ACCOUNT
            $contact_account                = contact::find($request->vendor_name);
            coa_detail::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'coa_id'                    => $contact_account->account_payable_id,
                'date'                      => $request->get('trans_date'),
                'type'                      => 'purchase return',
                'number'                    => 'Purchase Return #' . $trans_no,
                'contact_id'                => $request->get('vendor_name'),
                'debit'                     => $request->get('balance'),
                'credit'                    => 0,
            ]);
            $get_current_balance_on_coa = coa::find($contact_account->account_payable_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                   => $get_current_balance_on_coa->balance - $request->get('balance'),
            ]);
            // CREATE OTHER TRANSACTION PUNYA RETURN
            $transactions = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'transaction_date'          => $request->get('trans_date'),
                'number'                    => $trans_no,
                'number_complete'           => 'Purchase Return #' . $trans_no,
                'type'                      => 'purchase return',
                'memo'                      => $request->get('memo'),
                'contact'                   => $request->get('vendor_name'),
                'due_date'                  => $request->get('due_date'),
                'status'                    => 2,
                'balance_due'               => 0,
                'total'                     => 0,
            ]);
            // CREATE PURCHASE RETURN HEADER
            $pd = new purchase_return([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                    => $trans_no,
                'contact_id'                => $request->get('vendor_name'),
                'email'                     => $request->get('email'),
                'address'                   => $request->get('vendor_address'),
                'transaction_date'          => $request->get('trans_date'),
                'due_date'                  => $request->get('due_date'),
                'return_date'               => $request->get('return_date'),
                'transaction_no_pi'         => $number_pi,
                'warehouse_id'              => $request->get('warehouse'),
                'message'                   => $request->get('message'),
                'memo'                      => $request->get('memo'),
                'subtotal'                  => $request->get('subtotal'),
                'taxtotal'                  => $request->get('taxtotal'),
                'grandtotal'                => $request->get('balance'),
                'status'                    => 2,
                'selected_pi_id'            => $id_pi,
            ]);
            $transactions->purchase_return()->save($pd);
            other_transaction::find($transactions->id)->update([
                'ref_id'                    => $pd->id,
            ]);
            // UPDATE STATUS ON PURCHASE INVOICE & OTHER TRANSACTION INVOICE'S
            $ambilpi                        = purchase_invoice::find($id_pi);
            $ambilpi->update([
                'total_return'              => $ambilpi->total_return + $request->balance,
                'balance_due'               => $ambilpi->balance_due - $request->balance
            ]);
            if ($ambilpi->balance_due <= 0) {
                $ambilpi->update([
                    'debit_memo'           => $ambilpi->debit_memo + abs($ambilpi->balance_due),
                ]);
                $ambilpi->update([
                    'balance_due'           => 0,
                ]);
            }
            $ambilot                        = other_transaction::where('number', $number_pi)->where('type', 'purchase invoice')->first();
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
                $default_tax                = default_account::find(14);
                coa_detail::create([
                    'company_id'                    => $user->company_id,
                    'user_id'                       => Auth::id(),
                    'coa_id'                => $default_tax->account_id,
                    'date'                  => $request->get('trans_date'),
                    'type'                  => 'purchase return',
                    'number'                => 'Purchase Return #' . $trans_no,
                    'contact_id'            => $request->get('vendor_name'),
                    'debit'                 => 0,
                    'credit'                => $request->get('taxtotal'),
                ]);
                $get_current_balance_on_coa = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'               => $get_current_balance_on_coa->balance - $request->get('taxtotal'),
                ]);
            }

            // CREATE PURCHASE RETURN DETAILS
            foreach ($request->products as $i => $keys) {
                if ($request->qty[$i] > 0) {
                    $pp[$i]                     = new purchase_return_item([
                        'purchase_invoice_item_id'            => $request->invoice_item[$i],
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
                    $pd->purchase_return_item()->save($pp[$i]);
                    // UPDATE ITEM INVOICE
                    if ($request->qty[$i] > $request->qty_remaining_return[$i]) {
                        DB::rollBack();
                        return response()->json(['errors' => 'Quantity cannot be more than order']);
                    } else {
                        $ambil_pii              = purchase_invoice_item::find($request->invoice_item[$i]);
                        $ambil_pii->update([
                            'qty_remaining_return' => $ambil_pii->qty_remaining_return - $request->qty[$i]
                        ]);
                    }
                    // CREATE COA DETAIL BASED ON PRODUCT SETTING
                    $default_product_account = product::find($request->products[$i]);
                    if ($default_product_account->is_track == 1) {
                        coa_detail::create([
                            'company_id'                    => $user->company_id,
                            'user_id'                       => Auth::id(),
                            'coa_id'            => $default_product_account->default_inventory_account,
                            'date'              => $request->get('trans_date'),
                            'type'              => 'purchase return',
                            'number'            => 'Purchase Return #' . $trans_no,
                            'contact_id'        => $request->get('vendor_name'),
                            'debit'             => 0,
                            'credit'            => $request->total_price[$i],
                        ]);
                        $get_current_balance_on_coa = coa::find($default_product_account->default_inventory_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'           => $get_current_balance_on_coa->balance - $request->total_price[$i],
                        ]);
                    } else {
                        coa_detail::create([
                            'company_id'                    => $user->company_id,
                            'user_id'                       => Auth::id(),
                            'coa_id'            => $default_product_account->buy_account,
                            'date'              => $request->get('trans_date'),
                            'type'              => 'purchase return',
                            'number'            => 'Purchase Return #' . $trans_no,
                            'contact_id'        => $request->get('vendor_name'),
                            'debit'             => 0,
                            'credit'            => $request->total_price[$i],
                        ]);
                        $get_current_balance_on_coa = coa::find($default_product_account->buy_account);
                        coa::find($get_current_balance_on_coa->id)->update([
                            'balance'           => $get_current_balance_on_coa->balance - $request->total_price[$i],
                        ]);
                    }
                    //menambahkan stok barang ke gudang
                    warehouse_detail::create([
                        'type'                  => 'purchase return',
                        'number'                => 'Purchase Return #' . $trans_no,
                        'product_id'            => $request->products[$i],
                        'warehouse_id'          => $request->warehouse,
                        'qty_out'               => $request->qty[$i],
                    ]);
                    //merubah harga average produk
                    $produk                     = product::find($request->products[$i]);
                    $qty                        = $request->qty[$i];
                    //menyimpan jumlah perubahan pada produk
                    product::where('id', $request->products[$i])->update([
                        'qty'                   => $produk->qty - $qty,
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
        $pi                         = purchase_return::find($id);
        $products                   = purchase_return_item::where('purchase_return_id', $id)->get();
        $pi_history                 = purchase_return::where('selected_pi_id', $pi->selected_pi_id)->where('id', '!=', $id)->get();
        $numbercoadetail            = 'Purchase Return #' . $pi->number;
        $get_all_detail             = coa_detail::where('number', $numbercoadetail)->where('type', 'purchase return')->with('coa')->get();
        $total_debit                = $get_all_detail->sum('debit');
        $total_credit               = $get_all_detail->sum('credit');
        return view(
            'admin.purchases.return.show',
            compact(
                'pi',
                'products',
                'pi_history',
                'get_all_detail',
                'total_debit',
                'total_credit'
            )
        );
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {
        //
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $pi                                     = purchase_return::find($id);
            $contact_id                             = contact::find($pi->contact_id);
            $default_tax                            = default_account::find(14);
            // UPDATE STATUS ON PURCHASE QUOTE & OTHER TRANSACTION QUOTE'S
            $ambilpi                                = purchase_invoice::find($pi->selected_pi_id);
            if ($ambilpi->debit_memo > 0) {
                $ambilpi->update([
                    'total_return'                      => $ambilpi->total_return - $pi->grandtotal,
                    'debit_memo'                        => $ambilpi->debit_memo - $pi->grandtotal,
                ]);
            } else {
                $ambilpi->update([
                    'total_return'                      => $ambilpi->total_return - $pi->grandtotal,
                    'balance_due'                       => $ambilpi->balance_due + $pi->grandtotal
                ]);
            }
            if ($ambilpi->balance_due == $ambilpi->grandtotal) {
                $ambilpi->update(['status'          => 1]);
                other_transaction::where('type', 'purchase invoice')
                    ->where('number', $pi->transaction_no_pi)
                    ->update([
                        'status'                    => 1
                    ]);
            } elseif ($ambilpi->balance_due == 0) {
                $ambilpi->update(['status'          => 3]);
                other_transaction::where('type', 'purchase invoice')
                    ->where('number', $pi->transaction_no_pi)
                    ->update([
                        'status'                    => 3
                    ]);
            } else {
                $ambilpi->update(['status'          => 4]);
                other_transaction::where('type', 'purchase invoice')
                    ->where('number', $pi->transaction_no_pi)
                    ->update([
                        'status'                    => 4
                    ]);
            }
            // DELETE ALL COA DETAILS
            coa_detail::where('type', 'purchase return')->where('number', 'Purchase Return #' . $pi->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'purchase return')->where('number', 'Purchase Return #' . $pi->number)->where('credit', 0)->delete();
            // DELETE BALANCE DARI YANG PENGEN DI DELETE (CONTACT)
            $get_current_balance_on_coa         = coa::find($contact_id->account_payable_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance + $pi->grandtotal,
            ]);
            // HAPUS PAJAK
            if ($pi->taxtotal > 0) {
                $get_current_balance_on_coa = coa::find($default_tax->account_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'               => $get_current_balance_on_coa->balance + $pi->taxtotal,
                ]);
            }
            // HAPUS BALANCE PER ITEM RETURN
            $pi_details                         = purchase_return_item::where('purchase_return_id', $id)->get();
            foreach ($pi_details as $a) {
                $ambil_pii                      = purchase_invoice_item::find($a->purchase_invoice_item_id);
                $default_product_account        = product::find($a->product_id);
                if ($default_product_account->is_track == 1) {
                    $ambil_pii->update([
                        'qty_remaining_return' => $ambil_pii->qty_remaining_return + $a->qty
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $a->amount,
                    ]);
                } else {
                    $ambil_pii->update([
                        'qty_remaining_return' => $ambil_pii->qty_remaining_return + $a->qty
                    ]);
                    $get_current_balance_on_coa = coa::find($default_product_account->buy_account);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance + $a->amount,
                    ]);
                }
                // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                warehouse_detail::where('type', 'purchase return')
                    ->where('number', 'Purchase Return #' . $pi->number)
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
            purchase_return_item::where('purchase_return_id', $id)->delete();
            // DELETE ROOT OTHER TRANSACTION
            other_transaction::where('type', 'purchase return')->where('number', $pi->number)->delete();
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
        $pp                         = purchase_return::find($id);
        $pp_item                    = purchase_return_item::where('purchase_return_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $logo                       = company_logo::where('company_id', $user->company_id)->latest()->first();
        $pdf = PDF::loadview('admin.purchases.return.PrintPDF_1', compact(['pp', 'pp_item', 'today', 'company', 'logo']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_2($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = purchase_return::find($id);
        $pp_item                    = purchase_return_item::where('purchase_return_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $logo                       = company_logo::where('company_id', $user->company_id)->latest()->first();
        $pdf = PDF::loadview('admin.purchases.return.PrintPDF_2', compact(['pp', 'pp_item', 'today', 'company', 'logo']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_fas($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = purchase_return::find($id);
        $pp_item                    = purchase_return_item::where('purchase_return_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.purchases.return.PrintPDF_FAS', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_gg($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = purchase_return::find($id);
        $pp_item                    = purchase_return_item::where('purchase_return_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.purchases.return.PrintPDF_GG', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = purchase_return::find($id);
        $pp_item                    = purchase_return_item::where('purchase_return_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.purchases.return.PrintPDF_Sukses', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses_surabaya($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = purchase_return::find($id);
        $pp_item                    = purchase_return_item::where('purchase_return_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.purchases.return.PrintPDF_Sukses_Surabaya', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
