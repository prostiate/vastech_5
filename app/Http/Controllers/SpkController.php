<?php

namespace App\Http\Controllers;

use App\contact;
use App\product;
use Illuminate\Http\Request;
use Validator;
use App\warehouse;
use Illuminate\Support\Carbon;
use App\spk;
use App\spk_item;
use App\other_transaction;
use App\sale_invoice;
use App\sale_invoice_item;
use App\warehouse_detail;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\wip_item;

class SpkController extends Controller
{
    public function select_product()
    {
        if (request()->ajax()) {
            $page = Input::get('page');
            $resultCount = 10;

            $offset = ($page - 1) * $resultCount;

            $breeds = product::where('name', 'LIKE',  '%' . Input::get("term") . '%')->orWhere('code', 'LIKE',  '%' . Input::get("term") . '%')
                ->where('is_track', 1)
                //->where('is_bundle', 1)
                ->orderBy('name')
                ->skip($offset)
                ->take($resultCount)
                ->get(['id', DB::raw('name as text', 'code')]);

            $count = product::where('is_track', 1)->count();
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
                //->where('type_vendor', 1)
                //->where('is_bundle', 0)
                ->orderBy('display_name')
                ->skip($offset)
                ->take($resultCount)
                ->get(['id', DB::raw('display_name as text'), 'term_id', 'email']);

            $count = contact::count();
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
        if (request()->ajax()) {
            return datatables()->of(spk::with('contact', 'spk_status', 'warehouse')->get())
                ->make(true);
        }

        return view('admin.request.sukses.spk.index');
    }

    public function create()
    {
        $products           = product::where('is_track', 1)->where('is_bundle', 1)->get();
        $warehouses         = warehouse::get();
        $contacts           = contact::get();
        $today              = Carbon::today()->toDateString();
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = spk::latest()->first();
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
            $number             = spk::max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }

        return view('admin.request.sukses.spk.create', compact(['products', 'trans_no', 'today', 'warehouses', 'contacts']));
    }

    public function store(Request $request)
    {
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = spk::latest()->first();
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
            $number             = spk::max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }
        $rules = array(
            'contact'           => 'required',
            'warehouse'         => 'required',
            'product'           => 'required|array|min:1',
            'product.*'         => 'required',
            'qty'               => 'required|array|min:1',
            'qty.*'             => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        DB::beginTransaction();
        try {
            $product                            = $request->product;
            $transactions                       = other_transaction::create([
                'company_id'        => $user->company_id,
                'user_id'           => Auth::id(),
                'transaction_date'              => $request->get('trans_date'),
                'number'                        => $trans_no,
                'number_complete'               => 'SPK #' . $trans_no,
                'type'                          => 'spk',
                'memo'                          => $request->get('desc'),
                'contact'                       => $request->get('contact'),
                'status'                        => 2,
                'balance_due'                   => 0,
                'total'                         => 0,
            ]);
            $transactions->save();

            $header                             = spk::create([
                'company_id'        => $user->company_id,
                'user_id'           => Auth::id(),
                'number'                        => $trans_no,
                'contact_id'                    => $request->contact,
                'desc'                          => $request->desc,
                'transaction_date'              => $request->trans_date,
                'other_transaction_id'          => $transactions->id,
                'vendor_ref_no'                 => $request->vendor_ref_no,
                'warehouse_id'                  => $request->warehouse,
                'status'                        => 2,
            ]);
            $header->save();
            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $header->id,
            ]);

            foreach ($product as $i => $p) {
                /*// CHECK QTY DI WAREHOUSE DETAIL
                $qty_in                         = warehouse_detail::where('warehouse_id', $request->warehouse)
                    ->where('product_id', $request->product[$i])
                    ->sum('qty_in');
                $qty_out                         = warehouse_detail::where('warehouse_id', $request->warehouse)
                    ->where('product_id', $request->product[$i])
                    ->sum('qty_out');
                $cek_wd = $qty_in - $qty_out;
                if ($cek_wd == $request->qty[$i]) {
                    $qty_remaining              = 0;
                    $status                     = 2;
                } else if ($cek_wd > $request->qty[$i]) {
                    $qty_remaining              = 0;
                    $status                     = 2;
                } else if ($cek_wd < $request->qty[$i]) {
                    $qty_remaining              = $request->qty[$i] - $cek_wd;
                    if ($cek_wd == 0) {
                        $status                 = 1;
                    } else {
                        $status                 = 4;
                    }
                }*/
                // CREATE ITEMNYA
                $item[$i]                       = new spk_item([
                    'product_id'                => $request->product[$i],
                    'qty'                       => $request->qty[$i],
                    'qty_remaining'             => $request->qty[$i],
                    'qty_remaining_sent'        => $request->qty[$i],
                    'status'                    => 1,
                ]);
                $header->spk_item()->save($item[$i]);
            }
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $header->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $spk                            = spk::find($id);
        $spk_item                       = spk_item::where('spk_id', $id)->get();
        $quantity_in_stock              = warehouse_detail::where('warehouse_id', $spk->warehouse_id)->get();
        $statusajah                     = 0;
        $can                            = 0;
        foreach ($spk_item as $sii) {
            if ($sii->qty_remaining_sent != 0) {
                $can                    += 1;
            } else {
                $can                    += 0;
            }
            if ($sii->status == 1) {
                $statusajah             += 0;
            } else {
                $statusajah             += 1;
            }
        }
        $wip_item                       = wip_item::groupBy('wip_id')->get();
        $sii                            = sale_invoice_item::groupBy('sale_invoice_id')->get();
        return view('admin.request.sukses.spk.show', compact(['spk', 'spk_item', 'quantity_in_stock', 'wip_item', 'sii', 'can', 'statusajah']));
    }

    public function edit($id)
    {
        $spk                = spk::find($id);
        $spk_item           = spk_item::where('spk_id', $id)->get();
        $products           = product::where('is_track', 1)->where('is_bundle', 1)->get();
        $warehouses         = warehouse::get();
        $contacts           = contact::get();

        return view('admin.request.sukses.spk.edit', compact([
            'spk',
            'spk_item',
            'products',
            'warehouses',
            'contacts',
        ]));
    }

    public function update(Request $request)
    {
        $rules = array(
            'contact'           => 'required',
            'warehouse'         => 'required',
            'product'           => 'required|array|min:1',
            'product.*'         => 'required',
            'qty'               => 'required|array|min:1',
            'qty.*'             => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $id                                 = $request->hidden_id;
            $product                            = $request->product2;
            $find_spk                           = spk::find($id);

            other_transaction::where('type', 'spk')->where('number', $find_spk->number)->update([
                'transaction_date'              => $request->get('trans_date'),
                'memo'                          => $request->get('desc'),
                'contact'                       => $request->get('contact2'),
            ]);

            $find_spk->update([
                'contact_id'                    => $request->contact2,
                'desc'                          => $request->desc,
                'transaction_date'              => $request->trans_date,
                'vendor_ref_no'                 => $request->vendor_ref_no,
                'warehouse_id'                  => $request->warehouse,
            ]);
            spk_item::where('spk_id', $id)->delete();
            foreach ($product as $i => $p) {
                $item[$i]                       = new spk_item([
                    'product_id'                => $request->product2[$i],
                    'qty'                       => $request->qty[$i],
                    'qty_remaining'             => $request->qty[$i],
                    'qty_remaining_sent'        => $request->qty[$i],
                    'status'                    => 1,
                ]);
                $find_spk->spk_item()->save($item[$i]);
            }
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
            $spk = spk::find($id);
            other_transaction::where('type', 'spk')->where('number', $spk->number)->delete();
            spk_item::where('spk_id', $id)->delete();
            $spk->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function cetak_pdf($id)
    {
        $pp                         = spk::find($id);
        $pp_item                    = spk_item::where('spk_id', $id)->get();
        $today                      = Carbon::today()->toDateString();
        $pdf = PDF::loadview('admin.request.sukses.spk.PrintPDF', compact(['pp', 'pp_item', 'today']))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
