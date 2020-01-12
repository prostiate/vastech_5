<?php

namespace App\Http\Controllers;

use App\purchase_payment;
use Illuminate\Http\Request;
use App\purchase_invoice;
use App\purchase_payment_item;
use Carbon\Carbon;
use App\other_payment_method;
use App\other_transaction;
use App\coa;
use App\coa_detail;
use App\company_logo;
use App\company_setting;
use PDF;
use App\contact;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchasePaymentController extends Controller
{
    public function index()
    {
        $user               = User::find(Auth::id());
        $open_po            = purchase_payment::where('status', 1)->count();
        $payment_last       = purchase_payment::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->count();
        $overdue            = purchase_payment::where('status', 5)->count();
        $open_po_total            = purchase_payment::where('status', 1)->sum('grandtotal');
        $payment_last_total       = purchase_payment::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->sum('grandtotal');
        $overdue_total            = purchase_payment::where('status', 5)->sum('grandtotal');
        if (request()->ajax()) {
            return datatables()->of(purchase_payment::with('status', 'payment_method', 'coa', 'contact')->get())
                ->make(true);
        }

        return view('admin.purchases.payment.index', compact(['user', 'open_po', 'payment_last', 'overdue', 'open_po_total', 'payment_last_total', 'overdue_total']));
    }

    public function createFromPurchase($id)
    {
        //$all_item_invoice       = purchase_invoice::get();
        $po                     = purchase_invoice::find($id);
        // BUAT SEMENTARA YANG ALL INVOICE DI CLOSE DULU
        $get_all_invoice        = purchase_invoice::where('contact_id', $po->contact_id)->where('balance_due', '>', 0)->get();
        //$po_item                = purchase_invoice_item::where('purchase_invoice_id', $id)->get();
        $today                  = Carbon::today()->toDateString();
        $coa                    = coa::where('coa_category_id', 3)->get();
        $payment_method         = other_payment_method::get();
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number                 = purchase_payment::latest()->first();
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
            $number                 = purchase_payment::max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }
        return view('admin.purchases.payment.createFromPurchase', compact(['today', 'trans_no', 'po', 'get_all_invoice', 'coa', 'payment_method']));
    }

    public function store(Request $request)
    {
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = purchase_payment::latest()->first();
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
            $number             = purchase_payment::max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }
        DB::beginTransaction();
        try {
            // AMBIL NUMBER PUNYA PURCHASE INVOICE
            $id_hidden_id_number                = $request->hidden_id_number;
            // AMBIL CONTACT COA
            $contact_id                         = contact::find($request->vendor_name);
            // CREATE OTHER TRANSACTION PAYMENT
            $transactions                       = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'number_complete'               => 'Purchase Payment #' . $trans_no,
                'type'                          => 'purchase payment',
                'memo'                          => $request->get('memo'),
                'transaction_date'              => $request->get('payment_date'),
                'due_date'                      => $request->get('due_date'),
                'contact'                       => $request->get('vendor_name'),
                'status'                        => 3,
                'balance_due'                   => 0,
                'total'                         => $request->get('balance'),
            ]);
            // CREATE HEADER PAYMENT
            $pd                                 = new purchase_payment([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'transaction_date'              => $request->get('payment_date'),
                'due_date'                      => $request->get('due_date'),
                'account_id'                    => $request->get('pay_from'),
                'other_payment_method_id'       => $request->get('payment_method'),
                'transaction_no_pi'             => $id_hidden_id_number,
                'grandtotal'                    => $request->get('balance'),
                'memo'                          => $request->get('memo'),
                'status'                        => 3,
            ]);
            $transactions->purchase_payment()->save($pd);
            // MASUKKIN ID PAYMENT KE OTHER TRANSACTION PAYMENT
            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $pd->id,
            ]);
            // CREATE COA DETAIL YANG DARI PAY FROM
            coa_detail::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'coa_id'                        => $request->pay_from,
                'date'                          => $request->get('payment_date'),
                'type'                          => 'purchase payment',
                'number'                        => 'Purchase Payment #' . $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => 0,
                'credit'                        => $request->get('balance'),
            ]);
            $get_current_balance_on_coa         = coa::find($request->pay_from);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance - $request->get('balance'),
            ]);
            // NGULANG SEBANYAK PURCHASE INVOICE YANG NONGOL DI CREATE PAYMENT
            foreach ($request->pinumber as $i => $keys) {
                // AMBIL ID MASING2 INVOICE
                //$id                             = $request->hidden_id[$i];
                // CEK APAKAH SETIAP INVOICE DIISI ATAU TIDAK
                if ($request->pipayment_amount[$i] > 0) {
                    // CREATE PAYMENT DETAILS
                    $pp[$i]                     = new purchase_payment_item([
                        'purchase_invoice_id'   => $request->pinumber[$i],
                        'desc'                  => $request->pidesc[$i],
                        'payment_amount'        => $request->pipayment_amount[$i],
                    ]);
                    $pd->purchase_payment_item()->save($pp[$i]);
                    // CREATE COA DETAIL YANG DARI CONTACT
                    coa_detail::create([
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'                => $contact_id->account_payable_id,
                        'date'                  => $request->get('payment_date'),
                        'type'                  => 'purchase payment',
                        'number'                => 'Purchase Payment #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $request->pipayment_amount[$i],
                        'credit'                => 0,
                    ]);
                    $get_current_balance_on_coa = coa::find($contact_id->account_payable_id);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $request->pipayment_amount[$i],
                    ]);
                    // CHECK YANG DIBAYAR SAMA GA DENGAN BALANCE DUENYA BUAT NENTUIN STATUS DI INVOICE
                    $total_balance[$i]          = $request->pibalancedue[$i] - $request->pipayment_amount[$i];
                    $pi                         = purchase_invoice::find($request->pinumber[$i]);
                    if ($total_balance[$i] == 0) {
                        purchase_invoice::find($request->pinumber[$i])->update([
                            'balance_due'           => $total_balance[$i],
                            'status'                => 3,
                            'amount_paid'           => $pi->amount_paid + $request->pipayment_amount[$i],
                        ]);
                        other_transaction::where('type', 'purchase invoice')->where('number', $pi->number)->where('ref_id', $request->pinumber[$i])->update([
                            'balance_due'           => $total_balance[$i],
                            'status'                => 3,
                        ]);
                    } else {
                        purchase_invoice::find($request->pinumber[$i])->update([
                            'balance_due'           => $total_balance[$i],
                            'status'                => 4,
                            'amount_paid'           => $pi->amount_paid + $request->pipayment_amount[$i],
                        ]);
                        other_transaction::where('type', 'purchase invoice')->where('number', $pi->number)->where('ref_id', $request->pinumber[$i])->update([
                            'balance_due'           => $total_balance[$i],
                            'status'                => 4,
                        ]);
                    }
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
        $pp                         = purchase_payment::with('status', 'payment_method', 'coa')->find($id);
        $pp_item                    = purchase_payment_item::where('purchase_payment_id', $id)->with('purchase_invoice')->get();
        $checknumberpd              = purchase_payment::whereId($id)->first();
        $numbercoadetail            = 'Purchase Payment #' . $checknumberpd->number;
        $get_all_detail             = coa_detail::where('number', $numbercoadetail)->where('type', 'purchase payment')->with('coa')->get();
        $total_debit                = $get_all_detail->sum('debit');
        $total_credit               = $get_all_detail->sum('credit');

        return view(
            'admin.purchases.payment.show',
            compact([
                'pp', 'pp_item', 'get_all_detail', 'total_debit', 'total_credit'
            ])
        );
    }

    public function edit($id)
    {
        $po                     = purchase_payment::find($id);
        $get_all_invoice        = purchase_payment_item::where('purchase_payment_id', $id)->with('purchase_invoice', 'purchase_payment')->get();
        $coa                    = coa::where('coa_category_id', 3)->get();
        $payment_method         = other_payment_method::get();
        return view('admin.purchases.payment.edit', compact(['po', 'get_all_invoice', 'coa', 'payment_method']));
    }

    public function update(Request $request)
    {
        $user               = User::find(Auth::id());
        DB::beginTransaction();
        try {
            $id                                 = $request->hidden_id_payment;
            // AMBIL HEADER SESUAI DENGAN ID
            $pp                                 = purchase_payment::find($id);
            $contact_id                         = contact::find($pp->contact_id);
            // DELETE COA DETAIL PUNYA PAYMENT
            coa_detail::where('type', 'purchase payment')->where('number', 'Purchase Payment #' . $pp->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'purchase payment')->where('number', 'Purchase Payment #' . $pp->number)->where('credit', 0)->delete();
            // DELETE BALANCE DARI YANG PENGEN DI DELETE (PAY FROM)
            $get_current_balance_on_coa         = coa::find($pp->account_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance + $pp->grandtotal,
            ]);
            // HAPUS BALANCE PER ITEM CASHBANK
            $pp_details                         = purchase_payment_item::where('purchase_payment_id', $id)->get();
            foreach ($pp_details as $a) {
                $get_current_balance_on_coa     = coa::find($contact_id->account_payable_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                   => $get_current_balance_on_coa->balance + $a->payment_amount,
                ]);
                $get_pi_data                    = purchase_invoice::find($a->purchase_invoice_id);
                purchase_invoice::find($a->purchase_invoice_id)->update([
                    'amount_paid'               => $get_pi_data->amount_paid - $a->payment_amount,
                    'balance_due'               => $get_pi_data->balance_due + $a->payment_amount,
                ]);
                other_transaction::where('type', 'purchase invoice')->where('number', $a->purchase_invoice->number)->where('ref_id', $a->purchase_invoice_id)->update([
                    'balance_due'               => $get_pi_data->balance_due + $a->payment_amount,
                ]);
            }
            foreach ($pp_details as $b) {
                $get_pi_data2                    = purchase_invoice::find($b->purchase_invoice_id);
                if ($get_pi_data2->amount_paid == 0) {
                    purchase_invoice::find($b->purchase_invoice_id)->update([
                        'status'                 => 1,
                    ]);
                    other_transaction::where('type', 'purchase invoice')->where('number', $a->purchase_invoice->number)->where('ref_id', $a->purchase_invoice_id)->update([
                        'status'                => 1,
                    ]);
                } else if ($get_pi_data2->amount_paid == $get_pi_data2->grandtotal) {
                    purchase_invoice::find($b->purchase_invoice_id)->update([
                        'status'                 => 3,
                    ]);
                    other_transaction::where('type', 'purchase invoice')->where('number', $a->purchase_invoice->number)->where('ref_id', $a->purchase_invoice_id)->update([
                        'status'                => 3,
                    ]);
                } else {
                    purchase_invoice::find($b->purchase_invoice_id)->update([
                        'status'                 => 4,
                    ]);
                    other_transaction::where('type', 'purchase invoice')->where('number', $a->purchase_invoice->number)->where('ref_id', $a->purchase_invoice_id)->update([
                        'status'                => 4,
                    ]);
                }
            }
            purchase_payment_item::where('purchase_payment_id', $id)->delete();
            // UPDATE
            other_transaction::where('type', 'purchase payment')->where('number', $pp->number)->update([
                'memo'                          => $request->get('memo'),
                'transaction_date'              => $request->get('payment_date'),
                'due_date'                      => $request->get('due_date'),
                'total'                         => $request->get('balance'),
            ]);
            $pp->update([
                'contact_id'                    => $request->get('vendor_name'),
                'transaction_date'              => $request->get('payment_date'),
                'due_date'                      => $request->get('due_date'),
                'account_id'                    => $request->get('pay_from'),
                'other_payment_method_id'       => $request->get('payment_method'),
                'grandtotal'                    => $request->get('balance'),
                'memo'                          => $request->get('memo'),
            ]);
            // CREATE COA DETAIL YANG DARI PAY FROM
            coa_detail::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'coa_id'                        => $request->pay_from,
                'date'                          => $request->get('payment_date'),
                'type'                          => 'purchase payment',
                'number'                        => 'Purchase Payment #' . $pp->number,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => 0,
                'credit'                        => $request->get('balance'),
            ]);
            $get_current_balance_on_coa         = coa::find($request->pay_from);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance - $request->get('balance'),
            ]);
            // NGULANG SEBANYAK PURCHASE INVOICE YANG NONGOL DI CREATE PAYMENT
            foreach ($request->pinumber as $i => $keys) {
                // AMBIL ID MASING2 INVOICE
                //$id                             = $request->hidden_id[$i];
                // CEK APAKAH SETIAP INVOICE DIISI ATAU TIDAK
                if ($request->pipayment_amount[$i] > 0) {
                    // CREATE PAYMENT DETAILS
                    $ppp[$i]                     = new purchase_payment_item([
                        'purchase_payment_id'   => $id,
                        'purchase_invoice_id'   => $request->pinumber[$i],
                        'desc'                  => $request->pidesc[$i],
                        'payment_amount'        => $request->pipayment_amount[$i],
                    ]);
                    $ppp[$i]->save();
                    // CREATE COA DETAIL YANG DARI CONTACT
                    coa_detail::create([
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'                => $contact_id->account_payable_id,
                        'date'                  => $request->get('payment_date'),
                        'type'                  => 'purchase payment',
                        'number'                => 'Purchase Payment #' . $pp->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => $request->pipayment_amount[$i],
                        'credit'                => 0,
                    ]);
                    $get_current_balance_on_coa = coa::find($contact_id->account_payable_id);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $request->pipayment_amount[$i],
                    ]);
                    // CHECK YANG DIBAYAR SAMA GA DENGAN BALANCE DUENYA BUAT NENTUIN STATUS DI INVOICE
                    $pi                         = purchase_invoice::find($request->pinumber[$i]);
                    $total_balance[$i]          = $pi->balance_due - $request->pipayment_amount[$i];
                    if ($total_balance[$i] == 0) {
                        purchase_invoice::find($request->pinumber[$i])->update([
                            'balance_due'           => $total_balance[$i],
                            'status'                => 3,
                            'amount_paid'           => $pi->amount_paid + $request->pipayment_amount[$i],
                        ]);
                        other_transaction::where('type', 'purchase invoice')->where('number', $pi->number)->where('ref_id', $request->pinumber[$i])->update([
                            'balance_due'           => $total_balance[$i],
                            'status'                => 3,
                        ]);
                    } else {
                        purchase_invoice::find($request->pinumber[$i])->update([
                            'balance_due'           => $total_balance[$i],
                            'status'                => 4,
                            'amount_paid'           => $pi->amount_paid + $request->pipayment_amount[$i],
                        ]);
                        other_transaction::where('type', 'purchase invoice')->where('number', $pi->number)->where('ref_id', $request->pinumber[$i])->update([
                            'balance_due'           => $total_balance[$i],
                            'status'                => 4,
                        ]);
                    }
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
        DB::beginTransaction();
        try {
            // AMBIL HEADER SESUAI DENGAN ID
            $pp                                 = purchase_payment::find($id);
            $contact_id                         = contact::find($pp->contact_id);
            // DELETE COA DETAIL PUNYA PAYMENT
            coa_detail::where('type', 'purchase payment')->where('number', 'Purchase Payment #' . $pp->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'purchase payment')->where('number', 'Purchase Payment #' . $pp->number)->where('credit', 0)->delete();
            // DELETE BALANCE DARI YANG PENGEN DI DELETE (PAY FROM)
            $get_current_balance_on_coa         = coa::find($pp->account_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance + $pp->grandtotal,
            ]);
            // HAPUS BALANCE PER ITEM CASHBANK
            $pp_details                         = purchase_payment_item::where('purchase_payment_id', $id)->get();
            foreach ($pp_details as $a) {
                $get_current_balance_on_coa     = coa::find($contact_id->account_payable_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                   => $get_current_balance_on_coa->balance + $a->payment_amount,
                ]);
                $get_pi_data                    = purchase_invoice::find($a->purchase_invoice_id);
                purchase_invoice::find($a->purchase_invoice_id)->update([
                    'amount_paid'               => $get_pi_data->amount_paid - $a->payment_amount,
                    'balance_due'               => $get_pi_data->balance_due + $a->payment_amount,
                ]);
                other_transaction::where('type', 'purchase invoice')->where('number', $a->purchase_invoice->number)->where('ref_id', $a->purchase_invoice_id)->update([
                    'balance_due'               => $get_pi_data->balance_due + $a->payment_amount,
                ]);
            }
            foreach ($pp_details as $b) {
                $get_pi_data2                    = purchase_invoice::find($b->purchase_invoice_id);
                if ($get_pi_data2->amount_paid == 0) {
                    purchase_invoice::find($b->purchase_invoice_id)->update([
                        'status'                 => 1,
                    ]);
                    other_transaction::where('type', 'purchase invoice')->where('number', $a->purchase_invoice->number)->where('ref_id', $a->purchase_invoice_id)->update([
                        'status'                => 1,
                    ]);
                } else if ($get_pi_data2->amount_paid == $get_pi_data2->grandtotal) {
                    purchase_invoice::find($b->purchase_invoice_id)->update([
                        'status'                 => 3,
                    ]);
                    other_transaction::where('type', 'purchase invoice')->where('number', $a->purchase_invoice->number)->where('ref_id', $a->purchase_invoice_id)->update([
                        'status'                => 3,
                    ]);
                } else {
                    purchase_invoice::find($b->purchase_invoice_id)->update([
                        'status'                 => 4,
                    ]);
                    other_transaction::where('type', 'purchase invoice')->where('number', $a->purchase_invoice->number)->where('ref_id', $a->purchase_invoice_id)->update([
                        'status'                => 4,
                    ]);
                }
            }
            purchase_payment_item::where('purchase_payment_id', $id)->delete();
            // DELETE ROOT OTHER TRANSACTION
            other_transaction::where('type', 'purchase payment')->where('number', $pp->number)->delete();
            // FINALLY DELETE THE CASHBANK ID
            $pp->delete();
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
        $pp                         = purchase_payment::find($id);
        $pp_item                    = purchase_payment_item::where('purchase_payment_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $logo                       = company_logo::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.purchases.payment.PrintPDF', compact(['pp', 'pp_item', 'today', 'company', 'logo']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_fas($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = purchase_payment::find($id);
        $pp_item                    = purchase_payment_item::where('purchase_payment_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.purchases.payment.PrintPDF_FAS', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_gg($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = purchase_payment::find($id);
        $pp_item                    = purchase_payment_item::where('purchase_payment_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.purchases.payment.PrintPDF_GG', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = purchase_payment::find($id);
        $pp_item                    = purchase_payment_item::where('purchase_payment_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.purchases.payment.PrintPDF_Sukses', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses_surabaya($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = purchase_payment::find($id);
        $pp_item                    = purchase_payment_item::where('purchase_payment_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.purchases.payment.PrintPDF_Sukses_Surabaya', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
