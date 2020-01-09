<?php

namespace App\Http\Controllers;

use App\sale_payment;
use Illuminate\Http\Request;
use App\sale_invoice;
use App\sale_payment_item;
use Carbon\Carbon;
use App\other_payment_method;
use App\other_transaction;
use App\coa;
use App\coa_detail;
use App\company_setting;
use App\contact;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\User;

class SalePaymentController extends Controller
{
    public function index()
    {
        $user               = User::find(Auth::id());
        $open_po            = sale_invoice::whereIn('status', [1, 4])->count();
        $payment_last       = sale_invoice::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->count();
        $overdue            = sale_invoice::where('status', 5)->count();
        $open_po_total            = sale_invoice::whereIn('status', [1, 4])->sum('grandtotal');
        $payment_last_total       = sale_invoice::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->sum('grandtotal');
        $overdue_total            = sale_invoice::where('status', 5)->sum('grandtotal');
        if (request()->ajax()) {
            //return datatables()->of(Product::all())
            return datatables()->of(sale_payment::with('status', 'payment_method', 'coa', 'contact')->get())
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.sales.payment.index', compact(['user', 'open_po', 'payment_last', 'overdue', 'open_po_total', 'payment_last_total', 'overdue_total']));
    }

    public function createFromSale($id)
    {
        //$all_item_invoice       = sale_invoice::get();
        $po                     = sale_invoice::find($id);
        $get_all_invoice        = sale_invoice::where('contact_id', $po->contact_id)->where('balance_due', '>', 0)->get();
        //$po_item                = sale_invoice_item::where('sale_invoice_id', $id)->get();
        $today                  = Carbon::today()->toDateString();
        $coa                    = coa::where('coa_category_id', 3)->get();
        $payment_method         = other_payment_method::get();
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number                 = sale_payment::latest()->first();
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
            $number                 = sale_payment::max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }

        return view('admin.sales.payment.createFromSale', compact(['today', 'trans_no', 'po', 'get_all_invoice', 'coa', 'payment_method']));
    }

    public function store(Request $request)
    {
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = sale_payment::latest()->first();
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
            $number             = sale_payment::max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }
        DB::beginTransaction();
        try {
            $id_hidden_id_number                = $request->hidden_id_number;
            $contact_id                         = contact::find($request->vendor_name);

            $transactions                       = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'number_complete'               => 'Sales Payment #' . $trans_no,
                'type'                          => 'sales payment',
                'memo'                          => $request->get('memo'),
                'transaction_date'              => $request->get('payment_date'),
                'due_date'                      => $request->get('due_date'),
                'contact'                       => $request->get('vendor_name'),
                'status'                        => 3,
                'balance_due'                   => 0,
                'total'                         => $request->get('balance'),
            ]);

            $pd                                 = new sale_payment([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'transaction_date'              => $request->get('payment_date'),
                'due_date'                      => $request->get('due_date'),
                'account_id'                    => $request->get('pay_from'),
                'other_payment_method_id'       => $request->get('payment_method'),
                'transaction_no_si'             => $id_hidden_id_number,
                'grandtotal'                    => $request->get('balance'),
                'memo'                          => $request->get('memo'),
                'status'                        => 3,
            ]);
            $transactions->sale_payment()->save($pd);
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
                'type'                          => 'sales payment',
                'number'                        => 'Sales Payment #' . $trans_no,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => $request->get('balance'),
                'credit'                        => 0,
            ]);
            $get_current_balance_on_coa         = coa::find($request->pay_from);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance + $request->get('balance'),
            ]);
            // KALAU MAU LIHAT PENJELASAN INI, LIAT DI PURCHASE PAYMENT
            foreach ($request->pinumber as $i => $keys) {
                //$id                             = $request->hidden_id[$i];
                if ($request->pipayment_amount[$i] > 0) {
                    $pp[$i]                     = new sale_payment_item([
                        'sale_invoice_id'       => $request->pinumber[$i],
                        'desc'                  => $request->pidesc[$i],
                        'payment_amount'        => $request->pipayment_amount[$i],
                    ]);
                    $pd->sale_payment_item()->save($pp[$i]);
                    // TRADE PAYABLE DEFAULT
                    coa_detail::create([
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'                => $contact_id->account_receivable_id,
                        'date'                  => $request->get('payment_date'),
                        'type'                  => 'sales payment',
                        'number'                => 'Sales Payment #' . $trans_no,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->pipayment_amount[$i],
                    ]);
                    $get_current_balance_on_coa = coa::find($contact_id->account_receivable_id);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $request->pipayment_amount[$i],
                    ]);
                    // CHECK YANG DIBAYAR SAMA GA DENGAN BALANCE DUENYA BUAT NENTUIN STATUS DI INVOICE
                    $total_balance[$i]          = $request->pibalancedue[$i] - $request->pipayment_amount[$i];
                    $pi                         = sale_invoice::find($request->pinumber[$i]);
                    $check_limit                = contact::find($pi->contact_id);
                    if ($check_limit->is_limit == 1) {
                        $check_limit->update([
                            'current_limit_balance' => $check_limit->current_limit_balance + $request->pipayment_amount[$i],
                        ]);
                    }
                    if ($total_balance[$i] == 0) {
                        sale_invoice::find($request->pinumber[$i])->update([
                            'balance_due'           => $total_balance[$i],
                            'status'                => 3,
                            'amount_paid'           => $pi->amount_paid + $request->pipayment_amount[$i],
                        ]);
                        other_transaction::where('type', 'sales invoice')->where('number', $pi->number)->where('ref_id', $request->pinumber[$i])->update([
                            'balance_due'           => $total_balance[$i],
                            'status'                => 3,
                        ]);
                    } else {
                        sale_invoice::find($request->pinumber[$i])->update([
                            'balance_due'           => $total_balance[$i],
                            'status'                => 4,
                            'amount_paid'           => $pi->amount_paid + $request->pipayment_amount[$i],
                        ]);
                        other_transaction::where('type', 'sales invoice')->where('number', $pi->number)->where('ref_id', $request->pinumber[$i])->update([
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
        $pp                         = sale_payment::with('status', 'payment_method', 'coa')->find($id);
        $pp_item                    = sale_payment_item::where('sale_payment_id', $id)->with('sale_invoice')->get();
        $checknumberpd              = sale_payment::whereId($id)->first();
        $numbercoadetail            = 'Sales Payment #' . $checknumberpd->number;
        $get_all_detail             = coa_detail::where('number', $numbercoadetail)->where('type', 'sales payment')->with('coa')->get();
        $total_debit                = $get_all_detail->sum('debit');
        $total_credit               = $get_all_detail->sum('credit');

        return view(
            'admin.sales.payment.show',
            compact([
                'pp', 'pp_item', 'get_all_detail', 'total_debit', 'total_credit'
            ])
        );
    }

    public function edit($id)
    {
        $po                     = sale_payment::find($id);
        $get_all_invoice        = sale_payment_item::where('sale_payment_id', $id)->with('sale_invoice', 'sale_payment')->get();
        $coa                    = coa::where('coa_category_id', 3)->get();
        $payment_method         = other_payment_method::get();
        return view('admin.sales.payment.edit', compact(['po', 'get_all_invoice', 'coa', 'payment_method']));
    }

    public function update(Request $request)
    {
        $user               = User::find(Auth::id());
        DB::beginTransaction();
        try {
            $id                                 = $request->hidden_id_payment;
            // AMBIL HEADER SESUAI DENGAN ID
            $pp                                 = sale_payment::find($id);
            $contact_id                         = contact::find($pp->contact_id);
            // DELETE COA DETAIL PUNYA PAYMENT
            coa_detail::where('type', 'sales payment')->where('number', 'Sales Payment #' . $pp->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'sales payment')->where('number', 'Sales Payment #' . $pp->number)->where('credit', 0)->delete();
            // DELETE BALANCE DARI YANG PENGEN DI DELETE (PAY FROM)
            $get_current_balance_on_coa         = coa::find($pp->account_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance - $pp->grandtotal,
            ]);
            // HAPUS BALANCE PER ITEM CASHBANK
            $pp_details                         = sale_payment_item::where('sale_payment_id', $id)->get();
            foreach ($pp_details as $a) {
                $get_current_balance_on_coa     = coa::find($contact_id->account_receivable_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                   => $get_current_balance_on_coa->balance + $a->payment_amount,
                ]);
                $get_pi_data                    = sale_invoice::find($a->sale_invoice_id);
                $check_limit                    = contact::find($get_pi_data->contact_id);
                if ($check_limit->is_limit == 1) {
                    $check_limit->update([
                        'current_limit_balance' => $check_limit->current_limit_balance - $a->payment_amount,
                    ]);
                }
                sale_invoice::find($a->sale_invoice_id)->update([
                    'amount_paid'               => $get_pi_data->amount_paid - $a->payment_amount,
                    'balance_due'               => $get_pi_data->balance_due + $a->payment_amount,
                ]);
                other_transaction::where('type', 'sales invoice')->where('number', $a->sale_invoice->number)->where('ref_id', $a->sale_invoice_id)->update([
                    'balance_due'               => $get_pi_data->balance_due + $a->payment_amount,
                ]);
            }
            foreach ($pp_details as $b) {
                $get_pi_data2                    = sale_invoice::find($b->sale_invoice_id);
                if ($get_pi_data2->amount_paid == 0) {
                    sale_invoice::find($b->sale_invoice_id)->update([
                        'status'                 => 1,
                    ]);
                    other_transaction::where('type', 'sales invoice')->where('number', $b->sale_invoice->number)->where('ref_id', $b->sale_invoice_id)->update([
                        'status'                => 1,
                    ]);
                } else if ($get_pi_data2->amount_paid == $get_pi_data2->grandtotal) {
                    sale_invoice::find($b->sale_invoice_id)->update([
                        'status'                 => 3,
                    ]);
                    other_transaction::where('type', 'sales invoice')->where('number', $b->sale_invoice->number)->where('ref_id', $b->sale_invoice_id)->update([
                        'status'                => 3,
                    ]);
                } else {
                    sale_invoice::find($b->sale_invoice_id)->update([
                        'status'                 => 4,
                    ]);
                    other_transaction::where('type', 'sales invoice')->where('number', $b->sale_invoice->number)->where('ref_id', $b->sale_invoice_id)->update([
                        'status'                => 4,
                    ]);
                }
            }
            sale_payment_item::where('sale_payment_id', $id)->delete();
            // UPDATE
            other_transaction::where('type', 'sales payment')->where('number', $pp->number)->update([
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
                'type'                          => 'sales payment',
                'number'                        => 'Sales Payment #' . $pp->number,
                'contact_id'                    => $request->get('vendor_name'),
                'debit'                         => $request->get('balance'),
                'credit'                        => 0,
            ]);
            $get_current_balance_on_coa         = coa::find($request->pay_from);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance + $request->get('balance'),
            ]);
            // KALAU MAU LIHAT PENJELASAN INI, LIAT DI PURCHASE PAYMENT
            foreach ($request->pinumber as $i => $keys) {
                //$id                             = $request->hidden_id[$i];
                if ($request->pipayment_amount[$i] > 0) {
                    $ppp[$i]                     = new sale_payment_item([
                        'sale_payment_id'       => $id,
                        'sale_invoice_id'       => $request->pinumber[$i],
                        'desc'                  => $request->pidesc[$i],
                        'payment_amount'        => $request->pipayment_amount[$i],
                    ]);
                    $ppp[$i]->save();
                    // TRADE PAYABLE DEFAULT
                    coa_detail::create([
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'                => $contact_id->account_receivable_id,
                        'date'                  => $request->get('payment_date'),
                        'type'                  => 'sales payment',
                        'number'                => 'Sales Payment #' . $pp->number,
                        'contact_id'            => $request->get('vendor_name'),
                        'debit'                 => 0,
                        'credit'                => $request->pipayment_amount[$i],
                    ]);
                    $get_current_balance_on_coa = coa::find($contact_id->account_receivable_id);
                    coa::find($get_current_balance_on_coa->id)->update([
                        'balance'               => $get_current_balance_on_coa->balance - $request->pipayment_amount[$i],
                    ]);
                    // CHECK YANG DIBAYAR SAMA GA DENGAN BALANCE DUENYA BUAT NENTUIN STATUS DI INVOICE
                    $pi                         = sale_invoice::find($request->pinumber[$i]);
                    $check_limit                = contact::find($pi->contact_id);
                    if ($check_limit->is_limit == 1) {
                        $check_limit->update([
                            'current_limit_balance' => $check_limit->current_limit_balance + $request->pipayment_amount[$i],
                        ]);
                    }
                    $total_balance[$i]          = $pi->balance_due - $request->pipayment_amount[$i];
                    if ($total_balance[$i] == 0) {
                        sale_invoice::find($request->pinumber[$i])->update([
                            'balance_due'           => $total_balance[$i],
                            'status'                => 3,
                            'amount_paid'           => $pi->amount_paid + $request->pipayment_amount[$i],
                        ]);
                        other_transaction::where('type', 'sales invoice')->where('number', $pi->number)->where('ref_id', $request->pinumber[$i])->update([
                            'balance_due'           => $total_balance[$i],
                            'status'                => 3,
                        ]);
                    } else {
                        sale_invoice::find($request->pinumber[$i])->update([
                            'balance_due'           => $total_balance[$i],
                            'status'                => 4,
                            'amount_paid'           => $pi->amount_paid + $request->pipayment_amount[$i],
                        ]);
                        other_transaction::where('type', 'sales invoice')->where('number', $pi->number)->where('ref_id', $request->pinumber[$i])->update([
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
            $pp                                 = sale_payment::find($id);
            $contact_id                         = contact::find($pp->contact_id);
            // DELETE COA DETAIL PUNYA PAYMENT
            coa_detail::where('type', 'sales payment')->where('number', 'Sales Payment #' . $pp->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'sales payment')->where('number', 'Sales Payment #' . $pp->number)->where('credit', 0)->delete();
            // DELETE BALANCE DARI YANG PENGEN DI DELETE (PAY FROM)
            $get_current_balance_on_coa         = coa::find($pp->account_id);
            coa::find($get_current_balance_on_coa->id)->update([
                'balance'                       => $get_current_balance_on_coa->balance - $pp->grandtotal,
            ]);
            // HAPUS BALANCE PER ITEM CASHBANK
            $pp_details                         = sale_payment_item::where('sale_payment_id', $id)->get();
            foreach ($pp_details as $a) {
                $get_current_balance_on_coa     = coa::find($contact_id->account_receivable_id);
                coa::find($get_current_balance_on_coa->id)->update([
                    'balance'                   => $get_current_balance_on_coa->balance + $a->payment_amount,
                ]);
                $get_pi_data                    = sale_invoice::find($a->sale_invoice_id);
                $check_limit                    = contact::find($get_pi_data->contact_id);
                if ($check_limit->is_limit == 1) {
                    $check_limit->update([
                        'current_limit_balance' => $check_limit->current_limit_balance - $a->payment_amount,
                    ]);
                }
                sale_invoice::find($a->sale_invoice_id)->update([
                    'amount_paid'               => $get_pi_data->amount_paid - $a->payment_amount,
                    'balance_due'               => $get_pi_data->balance_due + $a->payment_amount,
                ]);
                other_transaction::where('type', 'sales invoice')->where('number', $a->sale_invoice->number)->where('ref_id', $a->sale_invoice_id)->update([
                    'balance_due'               => $get_pi_data->balance_due + $a->payment_amount,
                ]);
            }
            foreach ($pp_details as $b) {
                $get_pi_data2                    = sale_invoice::find($b->sale_invoice_id);
                if ($get_pi_data2->amount_paid == 0) {
                    sale_invoice::find($b->sale_invoice_id)->update([
                        'status'                 => 1,
                    ]);
                    other_transaction::where('type', 'sales invoice')->where('number', $b->sale_invoice->number)->where('ref_id', $b->sale_invoice_id)->update([
                        'status'                => 1,
                    ]);
                } else if ($get_pi_data2->amount_paid == $get_pi_data2->grandtotal) {
                    sale_invoice::find($b->sale_invoice_id)->update([
                        'status'                 => 3,
                    ]);
                    other_transaction::where('type', 'sales invoice')->where('number', $b->sale_invoice->number)->where('ref_id', $b->sale_invoice_id)->update([
                        'status'                => 3,
                    ]);
                } else {
                    sale_invoice::find($b->sale_invoice_id)->update([
                        'status'                 => 4,
                    ]);
                    other_transaction::where('type', 'sales invoice')->where('number', $b->sale_invoice->number)->where('ref_id', $b->sale_invoice_id)->update([
                        'status'                => 4,
                    ]);
                }
            }
            sale_payment_item::where('sale_payment_id', $id)->delete();
            // DELETE ROOT OTHER TRANSACTION
            other_transaction::where('type', 'sales payment')->where('number', $pp->number)->delete();
            // FINALLY DELETE THE CASHBANK ID
            $pp->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function cetak_pdf($id)
    {
        $pp                         = sale_payment::with('status', 'payment_method', 'coa')->find($id);
        $pp_item                    = sale_payment_item::where('sale_payment_id', $id)->with('sale_invoice')->get();
        $checknumberpd              = sale_payment::whereId($id)->first();
        $numbercoadetail            = 'Sales Payment #' . $checknumberpd->number;
        $numberothertransaction     = $checknumberpd->number;
        $get_all_detail             = coa_detail::where('number', $numbercoadetail)->where('type', 'sales payment')->with('coa')->get();
        $total_debit                = $get_all_detail->sum('debit');
        $total_credit               = $get_all_detail->sum('credit');
        $today                      = Carbon::today()->toDateString();

        $pegawai = sale_payment::all();

        $pdf = PDF::loadview('admin.sales.payment.PrintPDF', compact([
            'pegawai',
            'pp',
            'pp_item',
            'get_all_detail',
            'total_debit',
            'total_credit',
            'today'
        ]))->setPaper('a4', 'portrait');
        //return $pdf->download('laporan-pegawai-pdf');
        // TANDA DOWNLOAD
        return $pdf->stream();
    }

    public function cetak_pdf_1($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_payment::find($id);
        $pp_item                    = sale_payment_item::where('sale_payment_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.payment.PrintPDF', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_fas($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_payment::find($id);
        $pp_item                    = sale_payment_item::where('sale_payment_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.payment.PrintPDF_FAS', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_gg($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_payment::find($id);
        $pp_item                    = sale_payment_item::where('sale_payment_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.payment.PrintPDF_GG', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_payment::find($id);
        $pp_item                    = sale_payment_item::where('sale_payment_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.payment.PrintPDF_Sukses', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function cetak_pdf_sukses_surabaya($id)
    {
        $user                       = User::find(Auth::id());
        $pp                         = sale_payment::find($id);
        $pp_item                    = sale_payment_item::where('sale_payment_id', $id)->get();
        $today                      = Carbon::today()->format('d F Y');
        $company                    = company_setting::where('company_id', $user->company_id)->first();
        $pdf = PDF::loadview('admin.sales.payment.PrintPDF_Sukses_Surabaya', compact(['pp', 'pp_item', 'today', 'company']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
