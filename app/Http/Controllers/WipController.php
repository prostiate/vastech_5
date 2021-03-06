<?php

namespace App\Http\Controllers;

use App\Model\contact\contact;
use App\Model\product\product;
use Illuminate\Http\Request;
use Validator;
use App\Model\warehouse\warehouse;
use Illuminate\Support\Carbon;
use App\Model\wip\wip;
use App\Model\wip\wip_item;
use App\Model\other\other_transaction;
use App\Model\product\product_bundle_item;
use App\Model\spk\spk;
use App\Model\spk\spk_item;
use App\Model\warehouse\warehouse_detail;
use App\Model\coa\coa_detail;
use App\Model\product\product_production_item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\User;

class WipController extends Controller
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
                ->get(['id', DB::raw('name as text'), 'code', 'avg_price']);

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

    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(wip::with('contact', 'status', 'warehouse', 'spk')->get())
                ->make(true);
        }

        return view('admin.request.sukses.wip.index');
    }

    public function create()
    {
        $products               = product::where('is_track', 1)->where('is_bundle', 1)->get();
        $warehouses             = warehouse::get();
        $contacts               = contact::get();
        $today                  = Carbon::today()->toDateString();
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = wip::latest()->first();
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
                    $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.WIP';
                } else {
                    $check_number   = wip::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.WIP';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.WIP';
                    }
                }
            } else {
                $check_number   = wip::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                if ($check_number) {
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.WIP';
                } else {
                    $number1    = 10001;
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.WIP';
                }
            }
        } else {
            $number             = wip::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }

        return view('admin.request.sukses.wip.create', compact(['products', 'trans_no', 'today', 'warehouses', 'contacts']));
    }

    public function createFromSPK($id, $uid)
    {
        $spk                            = spk::find($id);
        $spk_item                       = spk_item::find($uid);
        $production_bundle              = product_production_item::where('product_id', $spk_item->product_id)->get();
        $current_product_bundle_item    = product_bundle_item::where('product_id', $spk_item->product_id)->get();
        $quantity_in_stock              = warehouse_detail::where('warehouse_id', $spk->warehouse_id)->get();
        $today                          = Carbon::today()->toDateString();
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = wip::latest()->first();
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
                    $trans_no       = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.WIP';
                } else {
                    $check_number   = wip::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                    if ($check_number) {
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.WIP';
                    } else {
                        $number1    = 10001;
                        $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.WIP';
                    }
                }
            } else {
                $check_number   = wip::whereMonth('transaction_date', Carbon::parse($dt))->latest()->first();
                if ($check_number) {
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.WIP';
                } else {
                    $number1    = 10001;
                    $trans_no   = now()->format('m') . '/' . now()->format('y') . '.' . $number1 . '.WIP';
                }
            }
        } else {
            $number             = wip::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }
        $products                       = product::where('is_track', 1)->get();
        $wd                             = warehouse_detail::where('warehouse_id', $spk->warehouse_id)->groupBy('product_id')->get();

        if ($spk_item->product->is_production_bundle == 1) {
            return view('admin.request.sukses.wip_production_bundle.createFromSPK', compact([
                'spk',
                'spk_item',
                'production_bundle',
                'current_product_bundle_item',
                'quantity_in_stock',
                'trans_no',
                'today',
                'products',
                'wd',
            ]));
        } else {
            return view('admin.request.sukses.wip.createFromSPK', compact([
                'spk',
                'spk_item',
                'current_product_bundle_item',
                'quantity_in_stock',
                'trans_no',
                'today',
                'products',
                'wd',
            ]));
        }
    }

    public function store_per(Request $request)
    {
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = wip::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                $check_number   = wip::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.WIP';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.WIP';
                }
            } else {
                $check_number   = wip::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.WIP';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.WIP';
                }
            }
        } else {
            $number             = wip::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }
        $rules = array(
            'wip_product_id_per'   => 'required|array|min:1',
            'wip_product_id_per.*' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $product                            = $request->wip_product_id_per;
            $spk_id                             = $request->spk_id;
            if ($request->production_bundle == 0) {
                $force_submit                       = $request->force_submit_item_per;
                $number                             = 1;
                if (!$request->force_submit) {
                    if ($force_submit != null) {
                        foreach ($force_submit as $i => $p) {
                            $force_number               = $request->force_submit_item_per[$i];
                            if ($force_number == 1) {
                                $number++;
                            }
                        }
                    }
                    if ($number > 1) {
                        return response()->json(['errors' => 'Stock is not enough!<br>Please check again your input.']);
                    }
                }
            }

            if ($request->product_qty == $request->product_qty_to_make) {
                $qty_remaining                  = 0;
                spk_item::where('spk_id', $spk_id)
                    ->where('product_id', $request->product_id_to_make)
                    ->update([
                        'qty_remaining'         => $qty_remaining,
                        'status'                => 2,
                    ]);
            } else if ($request->product_qty < $request->product_qty_to_make && $request->product_qty != 0) {
                $qty_remaining                  = $request->product_qty_to_make - $request->product_qty;
                spk_item::where('spk_id', $spk_id)
                    ->where('product_id', $request->product_id_to_make)
                    ->update([
                        'qty_remaining'         => $qty_remaining,
                        'status'                => 4,
                    ]);
            } else if ($request->product_qty > $request->product_qty_to_make) {
                DB::rollback();
                return response()->json(['errors' => 'Quantity cannot be more than requirement! Requirement quantity is ' . $request->product_qty_to_make]);
            } else if ($request->product_qty == 0) {
                DB::rollback();
                return response()->json(['errors' => 'Quantity must be more than zero!']);
            }

            if ($request->margin_type_per == 'rp') {
                $margin_value                   = 0;
            } else {
                $margin_value                   = $request->margin_value_per;
            }

            $transactions                       = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'transaction_date'              => $request->get('trans_date'),
                'number'                        => $trans_no,
                'number_complete'               => 'WIP #' . $trans_no,
                'type'                          => 'wip',
                'memo'                          => $request->get('desc'),
                'contact'                       => $request->get('contact'),
                'status'                        => 2,
                'balance_due'                   => 0,
                'total'                         => $request->grandtotal_with_qty_per + $request->margin_total_per,
            ]);
            $transactions->save();

            $header                             = wip::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'transaction_no_spk'            => $request->spk_no,
                'selected_spk_id'               => $spk_id,
                'production_method'             => $request->production_method,
                'result_product'                => $request->product_name,
                'result_qty'                    => $request->product_qty,
                'number'                        => $trans_no,
                'contact_id'                    => $request->contact,
                'desc'                          => $request->desc,
                'transaction_date'              => $request->trans_date,
                'other_transaction_id'          => $transactions->id,
                'vendor_ref_no'                 => $request->vendor_ref_no,
                'warehouse_id'                  => $request->warehouse,
                'status'                        => 2,
                'margin_type'                   => $request->margin_type_per,
                'margin_value'                  => $margin_value,
                'margin_total'                  => $request->margin_total_per,
                'grandtotal_without_qty'        => $request->grandtotal_without_qty_per,
                'grandtotal_with_qty'           => $request->grandtotal_with_qty_per,
            ]);
            $header->save();
            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $header->id,
            ]);
            /*spk_item::where('spk_id', $spk_id)
                ->where('product_id', $request->product_id_to_make)
                ->update([
                    'selected_wip_id'           => $header->id,
                ]);*/
            //menambahkan stok barang ke gudang
            $wh                                 = new warehouse_detail();
            $wh->type                           = 'wip';
            $wh->number                         = 'WIP #' . $trans_no;
            $wh->product_id                     = $request->product_name;
            $wh->warehouse_id                   = $request->warehouse;
            $wh->qty_in                         = $request->product_qty;
            $wh->save();
            //merubah harga average produk
            $produk                             = product::find($request->product_name);
            $qty                                = $request->product_qty;
            $price                              = $request->grandtotal_with_qty_per + $request->margin_total_per;
            $dibagi                             = $produk->qty + $qty;
            if ($dibagi == 0) {
                $curr_avg_price                 = (($produk->qty * $produk->avg_price) + ($qty * $price));
            } else {
                $curr_avg_price                 = (($produk->qty * $produk->avg_price) + ($qty * $price)) / ($dibagi);
            }
            //dd($curr_avg_price);
            //menyimpan jumlah perubahan pada produk
            product::where('id', $request->product_name)->update([
                'qty'                           => $produk->qty + $qty,
                'avg_price'                     => abs($curr_avg_price),
            ]);
            // BIKIN COA DETAIL DAN BALANCE BUAT PRODUCT JADINYA
            coa_detail::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'ref_id'                        => $header->id,
                'other_transaction_id'          => $transactions->id,
                'coa_id'                        => $produk->default_inventory_account,
                'date'                          => $request->trans_date,
                'type'                          => 'wip',
                'number'                        => 'WIP #' . $trans_no,
                'contact_id'                    => $request->contact,
                'debit'                         => ($request->grandtotal_with_qty_per + $request->margin_total_per),
                'credit'                        => 0,
            ]);
            // BIKIN COA DETAIL DAN BALANCE BUAT MARGIN
            if ($request->margin_total_per > 0) {
                coa_detail::create([
                    'company_id'                => $user->company_id,
                    'user_id'                   => Auth::id(),
                    'ref_id'                    => $header->id,
                    'other_transaction_id'      => $transactions->id,
                    'coa_id'                    => 74, // COST OF PRODUCTION LANGSUNG DARI COA
                    'date'                      => $request->trans_date,
                    'type'                      => 'wip',
                    'number'                    => 'WIP #' . $trans_no,
                    'contact_id'                => $request->contact,
                    'debit'                     => 0,
                    'credit'                    => $request->margin_total_per,
                ]);
            }

            foreach ($product as $i => $p) {
                $item[$i]                       = new wip_item([
                    'product_id'                => $request->wip_product_id_per[$i],
                    //'qty_in_stock'              => $request->wip_product_qty_in_stock[$i],
                    'qty_require'               => $request->wip_product_req_qty_per[$i],
                    'qty_total'                 => $request->wip_product_req_qty_per[$i] * $request->product_qty,
                    'price'                     => $request->wip_product_price_per[$i],
                    'total_price'               => $request->wip_product_total_price_per[$i],
                ]);
                $header->wip_item()->save($item[$i]);

                //menambahkan stok barang ke gudang
                $wh                             = new warehouse_detail();
                $wh->type                       = 'wip';
                $wh->number                     = 'WIP #' . $trans_no;
                $wh->product_id                 = $request->wip_product_id_per[$i];
                $wh->warehouse_id               = $request->warehouse;
                $wh->qty_out                    = $request->wip_product_req_qty_per[$i] * $request->product_qty;
                $wh->save();
                //merubah harga average produk
                $produk                         = product::find($request->wip_product_id_per[$i]);
                $qty                            = $request->wip_product_req_qty_per[$i] * $request->product_qty;
                //menyimpan jumlah perubahan pada produk
                product::where('id', $request->wip_product_id_per[$i])->update([
                    'qty'                       => $produk->qty - $qty,
                ]);
                // BIKIN COA DETAIL DAN BALANCE BUAT PER BARANG RAW (MASUK KE INVENTORY CREDIT)
                $default_product_account        = product::find($request->wip_product_id_per[$i]);
                coa_detail::create([
                    'company_id'                => $user->company_id,
                    'user_id'                   => Auth::id(),
                    'ref_id'                    => $header->id,
                    'other_transaction_id'      => $transactions->id,
                    'coa_id'                    => $default_product_account->default_inventory_account,
                    'date'                      => $request->trans_date,
                    'type'                      => 'wip',
                    'number'                    => 'WIP #' . $trans_no,
                    'contact_id'                => $request->contact,
                    'debit'                     => 0,
                    'credit'                    => ($request->wip_product_total_price_per[$i] * $request->product_qty),
                ]);
            }
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $header->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function store_all(Request $request)
    {
        $dt                     = Carbon::now();
        $user                   = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number             = wip::latest()->first();
            if ($number != null) {
                $misahm         = explode("/", $number->number);
                $misahy         = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1            = $misahy[1] + 1;
            if (isset($number)) {
                $check_number   = wip::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.WIP';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.WIP';
                }
            } else {
                $check_number   = wip::whereMonth('transaction_date', Carbon::parse($request->trans_date))->latest()->first();
                if ($check_number) {
                    if ($check_number != null) {
                        $misahm = explode("/", $check_number->number);
                        $misahy = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number2    = $misahy[1] + 1;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number2 . '.WIP';
                } else {
                    $number1    = 10001;
                    $trans_no   = Carbon::parse($request->trans_date)->format('m') . '/' . Carbon::parse($request->trans_date)->format('y') . '.' . $number1 . '.WIP';
                }
            }
        } else {
            $number             = wip::max('number');
            if ($number == 0)
                $number         = 10000;
            $trans_no           = $number + 1;
        }
        $rules = array(
            'wip_product_id_all'   => 'required|array|min:1',
            'wip_product_id_all.*' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $product                            = $request->wip_product_id_all;
            $spk_id                             = $request->spk_id;
            if ($request->production_bundle == 0) {
                $force_submit                       = $request->force_submit_item_all;
                $number                             = 1;
                if (!$request->force_submit) {
                    if ($force_submit != null) {
                        foreach ($force_submit as $i => $p) {
                            $force_number               = $request->force_submit_item_all[$i];
                            if ($force_number == 1) {
                                $number++;
                            }
                        }
                    }
                    if ($number > 1) {
                        return response()->json(['errors' => 'Stock is not enough!<br>Please check again your input.']);
                    }
                }
            }

            if ($request->product_qty == $request->product_qty_to_make) {
                $qty_remaining                  = 0;
                spk_item::where('spk_id', $spk_id)
                    ->where('product_id', $request->product_id_to_make)
                    ->update([
                        'qty_remaining'         => $qty_remaining,
                        'status'                => 2,
                    ]);
            } else if ($request->product_qty < $request->product_qty_to_make && $request->product_qty != 0) {
                $qty_remaining                  = $request->product_qty_to_make - $request->product_qty;
                spk_item::where('spk_id', $spk_id)
                    ->where('product_id', $request->product_id_to_make)
                    ->update([
                        'qty_remaining'         => $qty_remaining,
                        'status'                => 4,
                    ]);
            } else if ($request->product_qty > $request->product_qty_to_make) {
                DB::rollback();
                return response()->json(['errors' => 'Quantity cannot be more than requirement! Requirement quantity is ' . $request->product_qty_to_make]);
            } else if ($request->product_qty == 0) {
                DB::rollback();
                return response()->json(['errors' => 'Quantity must be more than zero!']);
            }

            if ($request->margin_type_all == 'rp') {
                $margin_value                   = 0;
            } else {
                $margin_value                   = $request->margin_value_all;
            }

            $transactions                       = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'transaction_date'              => $request->get('trans_date'),
                'number'                        => $trans_no,
                'number_complete'               => 'WIP #' . $trans_no,
                'type'                          => 'wip',
                'memo'                          => $request->get('desc'),
                'contact'                       => $request->get('contact'),
                'status'                        => 2,
                'balance_due'                   => 0,
                'total'                         => ($request->grandtotal_with_qty_all) + $request->margin_total_all,
            ]);
            $transactions->save();

            $header                             = wip::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'transaction_no_spk'            => $request->spk_no,
                'selected_spk_id'               => $spk_id,
                'production_method'             => $request->production_method,
                'result_product'                => $request->product_name,
                'result_qty'                    => $request->product_qty,
                'number'                        => $trans_no,
                'contact_id'                    => $request->contact,
                'desc'                          => $request->desc,
                'transaction_date'              => $request->trans_date,
                'other_transaction_id'          => $transactions->id,
                'vendor_ref_no'                 => $request->vendor_ref_no,
                'warehouse_id'                  => $request->warehouse,
                'status'                        => 2,
                'margin_type'                   => $request->margin_type_all,
                'margin_value'                  => $margin_value,
                'margin_total'                  => $request->margin_total_all,
                'grandtotal_without_qty'        => $request->grandtotal_without_qty_all,
                'grandtotal_with_qty'           => $request->grandtotal_with_qty_all,
            ]);
            $header->save();
            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $header->id,
            ]);
            /*spk_item::where('spk_id', $spk_id)
                ->where('product_id', $request->product_id_to_make)
                ->update([
                    'selected_wip_id'           => $header->id,
                ]);*/
            //menambahkan stok barang ke gudang
            $wh                                 = new warehouse_detail();
            $wh->type                           = 'wip';
            $wh->number                         = 'WIP #' . $trans_no;
            $wh->product_id                     = $request->product_name;
            $wh->warehouse_id                   = $request->warehouse;
            $wh->qty_in                         = $request->product_qty;
            $wh->save();
            //merubah harga average produk
            $produk                             = product::find($request->product_name);
            $qty                                = $request->product_qty;
            $price                              = $request->grandtotal_with_qty_all + $request->margin_total_all;
            $dibagi                             = $produk->qty + $qty;
            if ($dibagi == 0) {
                $curr_avg_price                 = (($produk->qty * $produk->avg_price) + ($qty * $price));
            } else {
                $curr_avg_price                 = (($produk->qty * $produk->avg_price) + ($qty * $price)) / ($dibagi);
            }
            //dd($curr_avg_price);
            //menyimpan jumlah perubahan pada produk
            product::where('id', $request->product_name)->update([
                'qty'                           => $produk->qty + $qty,
                'avg_price'                     => abs($curr_avg_price),
            ]);
            // BIKIN COA DETAIL DAN BALANCE BUAT PRODUCT JADINYA
            coa_detail::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'ref_id'                        => $header->id,
                'other_transaction_id'          => $transactions->id,
                'coa_id'                        => $produk->default_inventory_account,
                'date'                          => $request->trans_date,
                'type'                          => 'wip',
                'number'                        => 'WIP #' . $trans_no,
                'contact_id'                    => $request->contact,
                'debit'                         => (($request->grandtotal_with_qty_all * $request->product_qty) + $request->margin_total),
                'credit'                        => 0,
            ]);
            // BIKIN COA DETAIL DAN BALANCE BUAT MARGIN
            if ($request->margin_total_all > 0) {
                coa_detail::create([
                    'company_id'                => $user->company_id,
                    'user_id'                   => Auth::id(),
                    'ref_id'                    => $header->id,
                    'other_transaction_id'      => $transactions->id,
                    'coa_id'                    => 74, // COST OF PRODUCTION LANGSUNG DARI COA
                    'date'                      => $request->trans_date,
                    'type'                      => 'wip',
                    'number'                    => 'WIP #' . $trans_no,
                    'contact_id'                => $request->contact,
                    'debit'                     => 0,
                    'credit'                    => $request->margin_total_all,
                ]);
            }

            foreach ($product as $i => $p) {
                $item[$i]                       = new wip_item([
                    'product_id'                => $request->wip_product_id_all[$i],
                    //'qty_in_stock'              => $request->wip_product_qty_in_stock[$i],
                    'qty_require'               => $request->wip_product_req_qty_all[$i],
                    'qty_total'                 => $request->wip_product_req_qty_all[$i],
                    'price'                     => $request->wip_product_price_all[$i],
                    'total_price'               => $request->wip_product_total_price_all[$i],
                ]);
                $header->wip_item()->save($item[$i]);

                //menambahkan stok barang ke gudang
                $wh                             = new warehouse_detail();
                $wh->type                       = 'wip';
                $wh->number                     = 'WIP #' . $trans_no;
                $wh->product_id                 = $request->wip_product_id_all[$i];
                $wh->warehouse_id               = $request->warehouse;
                $wh->qty_out                    = $request->wip_product_req_qty_all[$i];
                $wh->save();
                //merubah harga average produk
                $produk                         = product::find($request->wip_product_id_all[$i]);
                $qty                            = $request->wip_product_req_qty_all[$i];
                //menyimpan jumlah perubahan pada produk
                product::where('id', $request->wip_product_id_all[$i])->update([
                    'qty'                       => $produk->qty - $qty,
                ]);
                // BIKIN COA DETAIL DAN BALANCE BUAT PER BARANG RAW (MASUK KE INVENTORY CREDIT)
                $default_product_account        = product::find($request->wip_product_id_all[$i]);
                coa_detail::create([
                    'company_id'                => $user->company_id,
                    'user_id'                   => Auth::id(),
                    'ref_id'                    => $header->id,
                    'other_transaction_id'      => $transactions->id,
                    'coa_id'                    => $default_product_account->default_inventory_account,
                    'date'                      => $request->trans_date,
                    'type'                      => 'wip',
                    'number'                    => 'WIP #' . $trans_no,
                    'contact_id'                => $request->contact,
                    'debit'                     => 0,
                    'credit'                    => ($request->wip_product_total_price_all[$i]),
                ]);
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
        $wip                            = wip::find($id);
        $wip_item                       = wip_item::where('wip_id', $id)->get();
        $quantity_in_stock              = warehouse_detail::where('warehouse_id', $wip->warehouse_id)->get();
        $numbercoadetail                = 'WIP #' . $wip->number;
        $get_all_detail                 = coa_detail::where('number', $numbercoadetail)->where('type', 'wip')->with('coa')->get();
        $total_debit                    = $get_all_detail->sum('debit');
        $total_credit                   = $get_all_detail->sum('credit');
        if ($wip->production_method == 0) {
            return view('admin.request.sukses.wip.show_per', compact(['wip', 'wip_item', 'quantity_in_stock', 'get_all_detail', 'total_debit', 'total_credit']));
        } else {
            return view('admin.request.sukses.wip.show_all', compact(['wip', 'wip_item', 'quantity_in_stock', 'get_all_detail', 'total_debit', 'total_credit']));
        }
    }

    public function edit($id)
    {
        $wip                            = wip::find($id);
        $wip_item                       = wip_item::where('wip_id', $id)->get();
        $spk                            = spk::find($wip->selected_spk_id);
        $spk_item                       = spk_item::where('product_id', $wip->result_product)->first();
        $production_bundle              = product_production_item::where('product_id', $spk_item->product_id)->get();
        $current_product_bundle_item    = product_bundle_item::where('product_id', $spk_item->product_id)->get();
        $quantity_in_stock              = warehouse_detail::where('warehouse_id', $spk->warehouse_id)->get();
        $today                          = Carbon::today()->toDateString();
        $user                           = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number                         = wip::latest()->first();
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
            $number                         = wip::max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }
        $products                       = product::where('is_track', 1)->get();
        $wd                             = warehouse_detail::where('warehouse_id', $spk->warehouse_id)->groupBy('product_id')->get();

        if ($spk_item->product->is_production_bundle == 1) {
            return view('admin.request.sukses.wip_production_bundle.createFromSPK', compact([
                'spk',
                'spk_item',
                'production_bundle',
                'current_product_bundle_item',
                'quantity_in_stock',
                'trans_no',
                'today',
                'products',
                'wd',
            ]));
        } else {
            return view('admin.request.sukses.wip.edit', compact([
                'wip',
                'wip_item',
                'spk',
                'spk_item',
                'current_product_bundle_item',
                'quantity_in_stock',
                'trans_no',
                'today',
                'products',
                'wd',
            ]));
        }
    }

    public function update_per(Request $request)
    {
        $user               = User::find(Auth::id());
        $rules = array(
            'wip_product_id_per'   => 'required|array|min:1',
            'wip_product_id_per.*' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $product                            = $request->wip_product_id_per;
            $spk_id                             = $request->spk_id;
            if ($request->production_bundle == 0) {
                $force_submit                       = $request->force_submit_item_per;
                $number                             = 1;
                if (!$request->force_submit) {
                    if ($force_submit != null) {
                        foreach ($force_submit as $i => $p) {
                            $force_number               = $request->force_submit_item_per[$i];
                            if ($force_number == 1) {
                                $number++;
                            }
                        }
                    }
                    if ($number > 1) {
                        return response()->json(['errors' => 'Stock is not enough!<br>Please check again your input.']);
                    }
                }
            }

            if ($request->product_qty == $request->product_qty_to_make) {
                $qty_remaining                  = 0;
                spk_item::where('spk_id', $spk_id)
                    ->where('product_id', $request->product_id_to_make)
                    ->update([
                        'qty_remaining'         => $qty_remaining,
                        'status'                => 2,
                    ]);
            } else if ($request->product_qty < $request->product_qty_to_make && $request->product_qty != 0) {
                $qty_remaining                  = $request->product_qty_to_make - $request->product_qty;
                spk_item::where('spk_id', $spk_id)
                    ->where('product_id', $request->product_id_to_make)
                    ->update([
                        'qty_remaining'         => $qty_remaining,
                        'status'                => 4,
                    ]);
            } else if ($request->product_qty > $request->product_qty_to_make) {
                DB::rollback();
                return response()->json(['errors' => 'Quantity cannot be more than requirement! Requirement quantity is ' . $request->product_qty_to_make]);
            } else if ($request->product_qty == 0) {
                DB::rollback();
                return response()->json(['errors' => 'Quantity must be more than zero!']);
            }
            $id                                 = $request->hidden_wip_id;
            $wip                                = wip::find($id);
            /*$ambil_spk_item                     = spk_item::where('spk_id', $wip->selected_spk_id)
                ->where('product_id', $wip->result_product)->first();
            $ambil_spk_item->update([
                'qty_remaining'             => $ambil_spk_item->qty_remaining + $wip->result_qty,
            ]);

            if ($ambil_spk_item->qty_remaining == $ambil_spk_item->qty) {
                $ambil_spk_item->update([
                    'status'             => 1,
                ]);
            } else {
                $ambil_spk_item->update([
                    'status'             => 4,
                ]);
            }*/

            $wip_items = wip_item::where('wip_id', $id)->get();
            foreach ($wip_items as $i => $wi) {
                // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                warehouse_detail::where('type', 'wip')
                    ->where('number', 'WIP #' . $wip->number)
                    ->where('product_id', $wi->product_id)
                    ->where('warehouse_id', $wip->warehouse_id)
                    ->delete();
                // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                $produk                     = product::find($wi->product_id);
                $qty                        = $wi->qty_total;
                //menyimpan jumlah perubahan pada produk
                product::where('id', $wi->product_id)->update([
                    'qty'                   => $produk->qty + $qty,
                ]);
            }
            wip_item::where('wip_id', $id)->delete();
            // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
            warehouse_detail::where('type', 'wip')
                ->where('number', 'WIP #' . $wip->number)
                ->where('product_id', $wip->result_product)
                ->where('warehouse_id', $wip->warehouse_id)
                ->delete();
            // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
            $produk                     = product::find($wip->result_product);
            $qty                        = $wip->result_qty;
            $price                      = $wip->grandtotal_with_qty + $wip->margin_total;
            $dibagi                     = $produk->qty - $qty;
            if ($dibagi == 0) {
                $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price));
            } else {
                $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price)) / ($dibagi);
            }
            //menyimpan jumlah perubahan pada produk
            product::where('id', $wip->result_product)->update([
                'qty'                   => $produk->qty - $qty,
                'avg_price'             => abs($curr_avg_price),
            ]);
            // DELETE COA DETAILS
            coa_detail::where('type', 'wip')->where('number', 'WIP #' . $wip->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'wip')->where('number', 'WIP #' . $wip->number)->where('credit', 0)->delete();
            // UPDATE OTHER TRANSACTION
            $transactions                       = other_transaction::where('ref_id', $id)->where('type', 'wip')->where('number', $wip->number)->first();
            other_transaction::where('ref_id', $id)->where('type', 'wip')->where('number', $wip->number)
                ->update([
                    'transaction_date'              => $request->get('trans_date'),
                    'memo'                          => $request->get('desc'),
                    'total'                         => ($request->grandtotal_with_qty_per) + $request->margin_total_per,
                ]);

            if ($request->margin_type_per == 'rp') {
                $margin_value                   = 0;
            } else {
                $margin_value                   = $request->margin_value_per;
            }

            $wip->update([
                'production_method'             => $request->production_method,
                'result_qty'                    => $request->product_qty,
                'desc'                          => $request->desc,
                'transaction_date'              => $request->trans_date,
                'vendor_ref_no'                 => $request->vendor_ref_no,
                'margin_type'                   => $request->margin_type_per,
                'margin_value'                  => $margin_value,
                'margin_total'                  => $request->margin_total_per,
                'grandtotal_without_qty'        => $request->grandtotal_without_qty_per,
                'grandtotal_with_qty'           => $request->grandtotal_with_qty_per,
            ]);

            //menambahkan stok barang ke gudang
            $wh                                 = new warehouse_detail();
            $wh->type                           = 'wip';
            $wh->number                         = 'WIP #' . $request->trans_no;
            $wh->product_id                     = $request->product_name;
            $wh->warehouse_id                   = $request->warehouse;
            $wh->qty_in                         = $request->product_qty;
            $wh->save();
            //merubah harga average produk
            $produk                             = product::find($request->product_name);
            $qty                                = $request->product_qty;
            $price                              = $request->grandtotal_with_qty_per + $request->margin_total_per;
            $dibagi                             = $produk->qty + $qty;
            if ($dibagi == 0) {
                $curr_avg_price                 = (($produk->qty * $produk->avg_price) + ($qty * $price));
            } else {
                $curr_avg_price                 = (($produk->qty * $produk->avg_price) + ($qty * $price)) / ($dibagi);
            }
            //dd($curr_avg_price);
            //menyimpan jumlah perubahan pada produk
            product::where('id', $request->product_name)->update([
                'qty'                           => $produk->qty + $qty,
                'avg_price'                     => abs($curr_avg_price),
            ]);
            // BIKIN COA DETAIL DAN BALANCE BUAT PRODUCT JADINYA
            coa_detail::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'ref_id'                        => $wip->id,
                'other_transaction_id'          => $transactions->id,
                'coa_id'                        => $produk->default_inventory_account,
                'date'                          => $request->trans_date,
                'type'                          => 'wip',
                'number'                        => 'WIP #' . $request->trans_no,
                'contact_id'                    => $request->contact,
                'debit'                         => ($request->grandtotal_with_qty_per + $request->margin_total_per),
                'credit'                        => 0,
            ]);
            // BIKIN COA DETAIL DAN BALANCE BUAT MARGIN
            if ($request->margin_total_per > 0) {
                coa_detail::create([
                    'company_id'                => $user->company_id,
                    'user_id'                   => Auth::id(),
                    'ref_id'                    => $wip->id,
                    'other_transaction_id'      => $transactions->id,
                    'coa_id'                    => 74, // COST OF PRODUCTION LANGSUNG DARI COA
                    'date'                      => $request->trans_date,
                    'type'                      => 'wip',
                    'number'                    => 'WIP #' . $request->trans_no,
                    'contact_id'                => $request->contact,
                    'debit'                     => 0,
                    'credit'                    => $request->margin_total_per,
                ]);
            }

            foreach ($product as $i => $p) {
                $item[$i]                       = new wip_item([
                    'product_id'                => $request->wip_product_id_per[$i],
                    //'qty_in_stock'              => $request->wip_product_qty_in_stock[$i],
                    'qty_require'               => $request->wip_product_req_qty_per[$i],
                    'qty_total'                 => $request->wip_product_req_qty_per[$i] * $request->product_qty,
                    'price'                     => $request->wip_product_price_per[$i],
                    'total_price'               => $request->wip_product_total_price_per[$i],
                ]);
                $wip->wip_item()->save($item[$i]);

                //menambahkan stok barang ke gudang
                $wh                             = new warehouse_detail();
                $wh->type                       = 'wip';
                $wh->number                     = 'WIP #' . $request->trans_no;
                $wh->product_id                 = $request->wip_product_id_per[$i];
                $wh->warehouse_id               = $request->warehouse;
                $wh->qty_out                    = $request->wip_product_req_qty_per[$i] * $request->product_qty;
                $wh->save();
                //merubah harga average produk
                $produk                         = product::find($request->wip_product_id_per[$i]);
                $qty                            = $request->wip_product_req_qty_per[$i] * $request->product_qty;
                //menyimpan jumlah perubahan pada produk
                product::where('id', $request->wip_product_id_per[$i])->update([
                    'qty'                       => $produk->qty - $qty,
                ]);
                // BIKIN COA DETAIL DAN BALANCE BUAT PER BARANG RAW (MASUK KE INVENTORY CREDIT)
                $default_product_account        = product::find($request->wip_product_id_per[$i]);
                coa_detail::create([
                    'company_id'                => $user->company_id,
                    'user_id'                   => Auth::id(),
                    'ref_id'                    => $wip->id,
                    'other_transaction_id'      => $transactions->id,
                    'coa_id'                    => $default_product_account->default_inventory_account,
                    'date'                      => $request->trans_date,
                    'type'                      => 'wip',
                    'number'                    => 'WIP #' . $request->trans_no,
                    'contact_id'                => $request->contact,
                    'debit'                     => 0,
                    'credit'                    => ($request->wip_product_total_price_per[$i] * $request->product_qty),
                ]);
            }

            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function update_all(Request $request)
    {
        $user               = User::find(Auth::id());
        $rules = array(
            'wip_product_id_all'   => 'required|array|min:1',
            'wip_product_id_all.*' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $product                            = $request->wip_product_id_all;
            $spk_id                             = $request->spk_id;
            if ($request->production_bundle == 0) {
                $force_submit                       = $request->force_submit_item_all;
                $number                             = 1;
                if (!$request->force_submit) {
                    if ($force_submit != null) {
                        foreach ($force_submit as $i => $p) {
                            $force_number               = $request->force_submit_item_all[$i];
                            if ($force_number == 1) {
                                $number++;
                            }
                        }
                    }
                    if ($number > 1) {
                        return response()->json(['errors' => 'Stock is not enough!<br>Please check again your input.']);
                    }
                }
            }

            if ($request->product_qty == $request->product_qty_to_make) {
                $qty_remaining                  = 0;
                spk_item::where('spk_id', $spk_id)
                    ->where('product_id', $request->product_id_to_make)
                    ->update([
                        'qty_remaining'         => $qty_remaining,
                        'status'                => 2,
                    ]);
            } else if ($request->product_qty < $request->product_qty_to_make && $request->product_qty != 0) {
                $qty_remaining                  = $request->product_qty_to_make - $request->product_qty;
                spk_item::where('spk_id', $spk_id)
                    ->where('product_id', $request->product_id_to_make)
                    ->update([
                        'qty_remaining'         => $qty_remaining,
                        'status'                => 4,
                    ]);
            } else if ($request->product_qty > $request->product_qty_to_make) {
                DB::rollback();
                return response()->json(['errors' => 'Quantity cannot be more than requirement! Requirement quantity is ' . $request->product_qty_to_make]);
            } else if ($request->product_qty == 0) {
                DB::rollback();
                return response()->json(['errors' => 'Quantity must be more than zero!']);
            }
            $id                                 = $request->hidden_wip_id;
            $wip                                = wip::find($id);
            /*$ambil_spk_item                     = spk_item::where('spk_id', $wip->selected_spk_id)
                ->where('product_id', $wip->result_product)->first();
            $ambil_spk_item->update([
                'qty_remaining'             => $ambil_spk_item->qty_remaining + $wip->result_qty,
            ]);

            if ($ambil_spk_item->qty_remaining == $ambil_spk_item->qty) {
                $ambil_spk_item->update([
                    'status'             => 1,
                ]);
            } else {
                $ambil_spk_item->update([
                    'status'             => 4,
                ]);
            }*/

            $wip_items = wip_item::where('wip_id', $id)->get();
            foreach ($wip_items as $i => $wi) {
                // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                warehouse_detail::where('type', 'wip')
                    ->where('number', 'WIP #' . $wip->number)
                    ->where('product_id', $wi->product_id)
                    ->where('warehouse_id', $wip->warehouse_id)
                    ->delete();
                // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                $produk                     = product::find($wi->product_id);
                $qty                        = $wi->qty_total;
                //menyimpan jumlah perubahan pada produk
                product::where('id', $wi->product_id)->update([
                    'qty'                   => $produk->qty + $qty,
                ]);
            }
            wip_item::where('wip_id', $id)->delete();
            // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
            warehouse_detail::where('type', 'wip')
                ->where('number', 'WIP #' . $wip->number)
                ->where('product_id', $wip->result_product)
                ->where('warehouse_id', $wip->warehouse_id)
                ->delete();
            // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
            $produk                     = product::find($wip->result_product);
            $qty                        = $wip->result_qty;
            $price                      = $wip->grandtotal_with_qty + $wip->margin_total;
            $dibagi                     = $produk->qty - $qty;
            if ($dibagi == 0) {
                $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price));
            } else {
                $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price)) / ($dibagi);
            }
            //menyimpan jumlah perubahan pada produk
            product::where('id', $wip->result_product)->update([
                'qty'                   => $produk->qty - $qty,
                'avg_price'             => abs($curr_avg_price),
            ]);
            // DELETE COA DETAILS
            coa_detail::where('type', 'wip')->where('number', 'WIP #' . $wip->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'wip')->where('number', 'WIP #' . $wip->number)->where('credit', 0)->delete();
            // UPDATE OTHER TRANSACTION
            $transactions                       = other_transaction::where('ref_id', $id)->where('type', 'wip')->where('number', $wip->number)->first();
            other_transaction::where('ref_id', $id)->where('type', 'wip')->where('number', $wip->number)
                ->update([
                    'transaction_date'              => $request->get('trans_date'),
                    'memo'                          => $request->get('desc'),
                    'total'                         => ($request->grandtotal_with_qty_all) + $request->margin_total_all,
                ]);

            if ($request->margin_type_all == 'rp') {
                $margin_value                   = 0;
            } else {
                $margin_value                   = $request->margin_value_all;
            }

            $wip->update([
                'production_method'             => $request->production_method,
                'result_qty'                    => $request->product_qty,
                'desc'                          => $request->desc,
                'transaction_date'              => $request->trans_date,
                'vendor_ref_no'                 => $request->vendor_ref_no,
                'margin_type'                   => $request->margin_type_all,
                'margin_value'                  => $margin_value,
                'margin_total'                  => $request->margin_total_all,
                'grandtotal_without_qty'        => $request->grandtotal_without_qty_all,
                'grandtotal_with_qty'           => $request->grandtotal_with_qty_all,
            ]);

            //menambahkan stok barang ke gudang
            $wh                                 = new warehouse_detail();
            $wh->type                           = 'wip';
            $wh->number                         = 'WIP #' . $request->trans_no;
            $wh->product_id                     = $request->product_name;
            $wh->warehouse_id                   = $request->warehouse;
            $wh->qty_in                         = $request->product_qty;
            $wh->save();
            //merubah harga average produk
            $produk                             = product::find($request->product_name);
            $qty                                = $request->product_qty;
            $price                              = $request->grandtotal_with_qty_all + $request->margin_total_all;
            $dibagi                             = $produk->qty + $qty;
            if ($dibagi == 0) {
                $curr_avg_price                 = (($produk->qty * $produk->avg_price) + ($qty * $price));
            } else {
                $curr_avg_price                 = (($produk->qty * $produk->avg_price) + ($qty * $price)) / ($dibagi);
            }
            //dd($curr_avg_price);
            //menyimpan jumlah perubahan pada produk
            product::where('id', $request->product_name)->update([
                'qty'                           => $produk->qty + $qty,
                'avg_price'                     => abs($curr_avg_price),
            ]);
            // BIKIN COA DETAIL DAN BALANCE BUAT PRODUCT JADINYA
            coa_detail::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'ref_id'                        => $wip->id,
                'other_transaction_id'          => $transactions->id,
                'coa_id'                        => $produk->default_inventory_account,
                'date'                          => $request->trans_date,
                'type'                          => 'wip',
                'number'                        => 'WIP #' . $request->trans_no,
                'contact_id'                    => $request->contact,
                'debit'                         => (($request->grandtotal_with_qty_all * $request->product_qty) + $request->margin_total),
                'credit'                        => 0,
            ]);
            // BIKIN COA DETAIL DAN BALANCE BUAT MARGIN
            if ($request->margin_total_all > 0) {
                coa_detail::create([
                    'company_id'                => $user->company_id,
                    'user_id'                   => Auth::id(),
                    'ref_id'                    => $wip->id,
                    'other_transaction_id'      => $transactions->id,
                    'coa_id'                    => 74, // COST OF PRODUCTION LANGSUNG DARI COA
                    'date'                      => $request->trans_date,
                    'type'                      => 'wip',
                    'number'                    => 'WIP #' . $request->trans_no,
                    'contact_id'                => $request->contact,
                    'debit'                     => 0,
                    'credit'                    => $request->margin_total_all,
                ]);
            }

            foreach ($product as $i => $p) {
                $item[$i]                       = new wip_item([
                    'product_id'                => $request->wip_product_id_all[$i],
                    //'qty_in_stock'              => $request->wip_product_qty_in_stock[$i],
                    'qty_require'               => $request->wip_product_req_qty_all[$i],
                    'qty_total'                 => $request->wip_product_req_qty_all[$i],
                    'price'                     => $request->wip_product_price_all[$i],
                    'total_price'               => $request->wip_product_total_price_all[$i],
                ]);
                $wip->wip_item()->save($item[$i]);

                //menambahkan stok barang ke gudang
                $wh                             = new warehouse_detail();
                $wh->type                       = 'wip';
                $wh->number                     = 'WIP #' . $request->trans_no;
                $wh->product_id                 = $request->wip_product_id_all[$i];
                $wh->warehouse_id               = $request->warehouse;
                $wh->qty_out                    = $request->wip_product_req_qty_all[$i];
                $wh->save();
                //merubah harga average produk
                $produk                         = product::find($request->wip_product_id_all[$i]);
                $qty                            = $request->wip_product_req_qty_all[$i];
                //menyimpan jumlah perubahan pada produk
                product::where('id', $request->wip_product_id_all[$i])->update([
                    'qty'                       => $produk->qty - $qty,
                ]);
                // BIKIN COA DETAIL DAN BALANCE BUAT PER BARANG RAW (MASUK KE INVENTORY CREDIT)
                $default_product_account        = product::find($request->wip_product_id_all[$i]);
                coa_detail::create([
                    'company_id'                => $user->company_id,
                    'user_id'                   => Auth::id(),
                    'ref_id'                    => $wip->id,
                    'other_transaction_id'      => $transactions->id,
                    'coa_id'                    => $default_product_account->default_inventory_account,
                    'date'                      => $request->trans_date,
                    'type'                      => 'wip',
                    'number'                    => 'WIP #' . $request->trans_no,
                    'contact_id'                => $request->contact,
                    'debit'                     => 0,
                    'credit'                    => ($request->wip_product_total_price_all[$i]),
                ]);
            }

            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroy_per($id)
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
            $wip                                = wip::find($id);
            $id_spk                             = $wip->selected_spk_id;
            $ambil_spk_item                     = spk_item::where('spk_id', $wip->selected_spk_id)
                ->where('product_id', $wip->result_product)->first();
            $ambil_spk_item->update([
                'qty_remaining'             => $ambil_spk_item->qty_remaining + $wip->result_qty,
            ]);

            if ($ambil_spk_item->qty_remaining == $ambil_spk_item->qty) {
                $ambil_spk_item->update([
                    'status'             => 1,
                ]);
            } else {
                $ambil_spk_item->update([
                    'status'             => 4,
                ]);
            }

            $wip_items = wip_item::where('wip_id', $id)->get();
            foreach ($wip_items as $i => $wi) {
                // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                warehouse_detail::where('type', 'wip')
                    ->where('number', 'WIP #' . $wip->number)
                    ->where('product_id', $wi->product_id)
                    ->where('warehouse_id', $wip->warehouse_id)
                    ->delete();
                // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                $produk                     = product::find($wi->product_id);
                $qty                        = $wi->qty_total;
                //menyimpan jumlah perubahan pada produk
                product::where('id', $wi->product_id)->update([
                    'qty'                   => $produk->qty + $qty,
                ]);
            }
            wip_item::where('wip_id', $id)->delete();
            // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
            warehouse_detail::where('type', 'wip')
                ->where('number', 'WIP #' . $wip->number)
                ->where('product_id', $wip->result_product)
                ->where('warehouse_id', $wip->warehouse_id)
                ->delete();
            // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
            $produk                     = product::find($wip->result_product);
            $qty                        = $wip->result_qty;
            $price                      = $wip->grandtotal_with_qty + $wip->margin_total;
            $dibagi                     = $produk->qty - $qty;
            if ($dibagi == 0) {
                $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price));
            } else {
                $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price)) / ($dibagi);
            }
            //menyimpan jumlah perubahan pada produk
            product::where('id', $wip->result_product)->update([
                'qty'                   => $produk->qty - $qty,
                'avg_price'             => abs($curr_avg_price),
            ]);
            // DELETE COA DETAILS
            coa_detail::where('type', 'wip')->where('number', 'WIP #' . $wip->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'wip')->where('number', 'WIP #' . $wip->number)->where('credit', 0)->delete();
            // HAPUS OTHER TRANSACTION
            other_transaction::where('ref_id', $id)->where('type', 'wip')->where('number', $wip->number)->delete();
            $wip->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted', 'id' => $id_spk]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroy_all($id)
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
            $wip                                = wip::find($id);
            $id_spk                             = $wip->selected_spk_id;
            $ambil_spk_item                     = spk_item::where('spk_id', $wip->selected_spk_id)
                ->where('product_id', $wip->result_product)->first();
            $ambil_spk_item->update([
                'qty_remaining'             => $ambil_spk_item->qty_remaining + $wip->result_qty,
            ]);

            if ($ambil_spk_item->qty_remaining == $ambil_spk_item->qty) {
                $ambil_spk_item->update([
                    'status'             => 1,
                ]);
            } else {
                $ambil_spk_item->update([
                    'status'             => 4,
                ]);
            }

            $wip_items = wip_item::where('wip_id', $id)->get();
            foreach ($wip_items as $i => $wi) {
                // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                warehouse_detail::where('type', 'wip')
                    ->where('number', 'WIP #' . $wip->number)
                    ->where('product_id', $wi->product_id)
                    ->where('warehouse_id', $wip->warehouse_id)
                    ->delete();
                // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                $produk                     = product::find($wi->product_id);
                $qty                        = $wi->qty_total;
                //menyimpan jumlah perubahan pada produk
                product::where('id', $wi->product_id)->update([
                    'qty'                   => $produk->qty + $qty,
                ]);
            }
            wip_item::where('wip_id', $id)->delete();
            // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
            warehouse_detail::where('type', 'wip')
                ->where('number', 'WIP #' . $wip->number)
                ->where('product_id', $wip->result_product)
                ->where('warehouse_id', $wip->warehouse_id)
                ->delete();
            // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
            $produk                     = product::find($wip->result_product);
            $qty                        = $wip->result_qty;
            $price                      = $wip->grandtotal_with_qty + $wip->margin_total;
            $dibagi                     = $produk->qty - $qty;
            if ($dibagi == 0) {
                $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price));
            } else {
                $curr_avg_price             = (($produk->qty * $produk->avg_price) - ($qty * $price)) / ($dibagi);
            }
            //menyimpan jumlah perubahan pada produk
            product::where('id', $wip->result_product)->update([
                'qty'                   => $produk->qty - $qty,
                'avg_price'             => abs($curr_avg_price),
            ]);
            // DELETE COA DETAILS
            coa_detail::where('type', 'wip')->where('number', 'WIP #' . $wip->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'wip')->where('number', 'WIP #' . $wip->number)->where('credit', 0)->delete();
            // HAPUS OTHER TRANSACTION
            other_transaction::where('ref_id', $id)->where('type', 'wip')->where('number', $wip->number)->delete();
            $wip->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted', 'id' => $id_spk]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }
}
