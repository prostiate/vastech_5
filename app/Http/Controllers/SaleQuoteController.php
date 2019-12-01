<?php

namespace App\Http\Controllers;

use App\sale_quote;
use App\contact;
use App\product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\warehouse;
use Validator;
use App\other_term;
use App\other_unit;
use App\other_tax;
use App\other_transaction;
use App\sale_quote_item;
use App\sale_order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use PDF;

class SaleQuoteController extends Controller
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
        $open_po            = sale_quote::whereIn('status', [1, 4])->count();
        $payment_last       = sale_quote::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->count();
        $overdue            = sale_quote::where('status', 5)->count();
        $open_po_total            = sale_quote::whereIn('status', [1, 4])->sum('grandtotal');
        $payment_last_total       = sale_quote::where('status', 3)->whereDate('transaction_date', '>', Carbon::now()->subDays(30))->sum('grandtotal');
        $overdue_total            = sale_quote::where('status', 5)->sum('grandtotal');
        if (request()->ajax()) {
            return datatables()->of(sale_quote::with('sale_quote_item', 'contact', 'status')->get())
                ->make(true);
        }

        return view('admin.sales.quote.index', compact(['open_po', 'payment_last', 'overdue', 'open_po_total', 'payment_last_total', 'overdue_total']));
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
        $number             = sale_quote::max('number');
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

        return view('admin.sales.quote.create', compact('vendors', 'warehouses', 'terms', 'products', 'units', 'taxes', 'today', 'todaytambahtiga', 'trans_no'));
    }

    public function store(Request $request)
    {
        $number             = sale_quote::max('number');
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
                'transaction_date'  => $request->get('trans_date'),
                'number'            => $trans_no,
                'number_complete'   => 'Sales Quote #' . $trans_no,
                'type'              => 'sales quote',
                'memo'              => $request->get('memo'),
                'contact'           => $request->get('vendor_name'),
                'due_date'          => $request->get('due_date'),
                'status'            => 1,
                'balance_due'       => $request->get('balance'),
                'total'             => $request->get('balance'),
            ]);

            $po = new sale_quote([
                'user_id'           => Auth::id(),
                'number'            => $trans_no,
                'contact_id'        => $request->get('vendor_name'),
                'email'             => $request->get('email'),
                'address'           => $request->get('vendor_address'),
                'transaction_date'  => $request->get('trans_date'),
                'due_date'          => $request->get('due_date'),
                'term_id'           => $request->get('term'),
                'vendor_ref_no'     => $request->get('vendor_no'),
                'subtotal'          => $request->get('subtotal'),
                'taxtotal'          => $request->get('taxtotal'),
                'balance_due'       => $request->get('balance'),
                'grandtotal'        => $request->get('balance'),
                'message'           => $request->get('message'),
                'memo'              => $request->get('memo'),
                'status'            => 1,
            ]);

            $transactions->sale_quote()->save($po);
            other_transaction::find($transactions->id)->update([
                'ref_id'            => $po->id,
            ]);

            foreach ($request->products as $i => $keys) {
                $pp[$i] = new sale_quote_item([
                    'product_id'    => $request->products[$i],
                    'desc'          => $request->desc[$i],
                    'qty'           => $request->qty[$i],
                    'unit_id'       => $request->units[$i],
                    'unit_price'    => $request->unit_price[$i],
                    'tax_id'        => $request->tax[$i],
                    'amountsub'     => $request->total_price_sub[$i],
                    'amounttax'     => $request->total_price_tax[$i],
                    'amountgrand'   => $request->total_price_grand[$i],
                    'amount'        => $request->total_price[$i],
                ]);

                $po->sale_quote_item()->save($pp[$i]);
            };
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $po->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $pi             = sale_quote::with(['contact', 'term', 'warehouse', 'product'])->find($id);
        $terms          = other_term::all();
        $products       = sale_quote_item::where('sale_quote_id', $id)->get();
        $units          = other_unit::all();
        $today          = Carbon::today();
        $pi_history     = sale_order::where('selected_sq_id', $id)->get();
        //$pd_history     = sale_delivery::where('selected_po_id', $id)->with('status')->get();

        return view(
            'admin.sales.quote.show',
            compact([
                'pi', 'terms', 'products', 'units', 'today', 'pi_history'

            ])
        );
    }

    public function edit(sale_quote $sale_quote, $id)
    {
        $sq             = sale_quote::find($id);
        $sq_item        = sale_quote_item::where('sale_quote_id', $id)->get();
        $vendors        = contact::where('type_customer', true)->get();
        $terms          = other_term::all();
        $products       = product::all();
        $units          = other_unit::all();
        $today          = Carbon::today();
        $taxes          = other_tax::all();

        return view('admin.sales.quote.edit', compact('vendors', 'terms', 'products', 'units', 'taxes', 'today', 'sq', 'sq_item'));
    }

    public function update(Request $request)
    {
        $rules = array(
            'vendor_name'   => 'required',
            'term'          => 'required',
            'trans_date'    => 'required',
            'due_date'      => 'required',
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
            $idd                                = sale_quote::find($id);

            other_transaction::where('type', 'sales quote')->where('number', $idd->number)->update([
                'transaction_date'              => $request->get('trans_date'),
                'contact'                       => $request->get('vendor_name2'),
                'memo'                          => $request->get('memo'),
                'due_date'                      => $request->get('due_date'),
                'balance_due'                   => $request->get('balance'),
                'total'                         => $request->get('balance'),
            ]);

            sale_quote::find($id)->update([
                'contact_id'                    => $request->get('vendor_name2'),
                'email'                         => $request->get('email'),
                'address'                       => $request->get('vendor_address'),
                'transaction_date'              => $request->get('trans_date'),
                'due_date'                      => $request->get('due_date'),
                'term_id'                       => $request->get('term'),
                'vendor_ref_no'                 => $request->get('vendor_no'),
                'message'                       => $request->get('message'),
                'memo'                          => $request->get('memo'),
                'subtotal'                      => $request->get('subtotal'),
                'taxtotal'                      => $request->get('taxtotal'),
                'balance_due'                   => $request->get('balance'),
                'grandtotal'                    => $request->get('balance'),
            ]);

            sale_quote_item::where('sale_quote_id', $id)->delete();

            foreach ($request->products2 as $i => $keys) {
                $pp[$i] = new sale_quote_item([
                    'sale_quote_id'             => $idd->id,
                    'product_id'                => $request->products2[$i],
                    'desc'                      => $request->desc[$i],
                    'qty'                       => $request->qty[$i],
                    'unit_id'                   => $request->units[$i],
                    'unit_price'                => $request->unit_price[$i],
                    'tax_id'                    => $request->tax[$i],
                    'amountsub'                 => $request->total_price_sub[$i],
                    'amounttax'                 => $request->total_price_tax[$i],
                    'amountgrand'               => $request->total_price_grand[$i],
                    'amount'                    => $request->total_price[$i],
                ]);
                $pp[$i]->save();
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
            $pq = sale_quote::find($id);
            other_transaction::where('type', 'sales quote')->where('number', $pq->number)->delete();
            sale_quote_item::where('sale_quote_id', $id)->delete();
            $pq->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function cetak_pdf($id)
    {
        $pp                         = sale_quote::find($id);
        $pp_item                    = sale_quote_item::where('sale_quote_id', $id)->get();
        $checknumberpd              = sale_quote::whereId($id)->first();
        $numbercoadetail            = 'Sales Quote #' . $checknumberpd->number;
        $numberothertransaction     = $checknumberpd->number;
        $today                      = Carbon::today()->toDateString();
        $pdf = PDF::loadview('admin.sales.quote.PrintPDF', compact('pp', 'pp_item', 'today'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
