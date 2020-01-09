<?php

namespace App\Http\Controllers;

use App\coa;
use App\default_account;
use App\Exports\ProductExport;
use App\other_tax;
use App\product;
use App\other_product_category;
use App\other_unit;
use App\warehouse_detail;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;
use DB;
use App\other_transaction;
use App\product_bundle_cost;
use App\product_bundle_item;
use App\purchase_delivery_item;
use App\purchase_invoice_item;
use App\purchase_order_item;
use App\purchase_quote_item;
use App\sale_delivery_item;
use App\sale_invoice_item;
use App\sale_order_item;
use App\sale_quote_item;
use App\stock_adjustment_detail;
use App\warehouse;
use Illuminate\Support\Facades\DB as IlluminateDB;
use Illuminate\Support\Facades\Auth;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\product_discount_item;
use App\product_production_item;
use App\purchase_invoice_po_item;
use App\User;
use App\warehouse_transfer_item;
use App\wip;
use App\wip_item;
use Spatie\Permission\Models\Role;

class ProductController extends Controller
{
    public function select_product()
    {
        $user               = User::find(Auth::id());
        if ($user->getRoleNames()->first() == 'GT' or $user->getRoleNames()->first() == 'MT' or $user->getRoleNames()->first() == 'WS') {
            if (request()->ajax()) {
                $page = Input::get('page');
                $resultCount = 10;

                $offset = ($page - 1) * $resultCount;

                $breeds = product::where('name', 'LIKE',  '%' . Input::get("term") . '%')->orWhere('code', 'LIKE',  '%' . Input::get("term") . '%')
                    ->where('is_track', 1)
                    ->where('sales_type', $user->getRoleNames()->first())
                    //->where('is_bundle', 0)
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
        } else {
            if (request()->ajax()) {
                $page = Input::get('page');
                $resultCount = 10;

                $offset = ($page - 1) * $resultCount;

                $breeds = product::where('name', 'LIKE',  '%' . Input::get("term") . '%')->orWhere('code', 'LIKE',  '%' . Input::get("term") . '%')
                    ->where('is_track', 1)
                    //->where('is_bundle', 0)
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
    }

    public function index()
    {
        $user               = User::find(Auth::id());
        $avail_stock        = product::where('is_track', 1)->where('qty', '>', 0)->where('qty', '>=', 'min_qty')->count();
        $get_track_stock    = product::where('is_track', 1)->get();
        $low_stock          = product::where('is_track', 1)->where('qty', '>', 0)->where('qty', '<', 'min_qty')->count();
        $out_stock          = product::where('is_track', 1)->where('qty', '<', 0)->count();
        if ($user->getRoleNames()->first() == 'GT' or $user->getRoleNames()->first() == 'MT' or $user->getRoleNames()->first() == 'WS') {
            if (request()->ajax()) {
                return datatables()->of(product::where('id', '>', 0)->where('sales_type', $user->getRoleNames()->first())->with('other_product_category', 'other_unit'))
                    ->make(true);
            }
            //return view('admin.request.joyday.products.index', compact(['avail_stock', 'low_stock', 'out_stock']));
        } else {
            if (request()->ajax()) {
                return datatables()->of(product::where('id', '>', 0)->with('other_product_category', 'other_unit'))
                    ->make(true);
            }
        }
        return view('admin.products.products.index', compact(['avail_stock', 'low_stock', 'out_stock']));
    }
    // INI ADALAH SELECT ALL PRODUCT TAPI YANG DI SIMPAN DI API HANYA ID, TEXT, AVG_PRICE
    /*public function selectProduct()
    {
        if (request()->ajax()) {
            $page = Input::get('page');
            $resultCount = 10;

            $offset = ($page - 1) * $resultCount;

            $breeds = product::where('name', 'LIKE',  '%' . Input::get("term") . '%')
                ->orderBy('name')
                ->skip($offset)
                ->take($resultCount)
                ->get(['id', DB::raw('name as text'), 'avg_price']);

            $count = product::count();
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
    }*/

    public function create()
    {
        $user                       = User::find(Auth::id());
        //default account dari setting
        $default_sell_account       = default_account::where('name', 'default_sales_revenue')->first();
        $default_buy_account        = default_account::where('name', 'default_purchase')->first();
        $default_inventory_account  = default_account::where('name', 'default_inventory')->first();

        //menampilkan COA
        $sell_accounts      = coa::where('coa_category_id', 13)
            ->orWhere('coa_category_id', 14)
            ->orWhere('coa_category_id', 3)->get();
        $buy_accounts       = coa::where('coa_category_id', 5)
            ->orWhere('coa_category_id', 15)->get();
        $inventory_accounts = coa::where('coa_category_id', 4)->get();

        //menampilkan kategori produk & produk unit
        $categories = other_product_category::where('id', '>', 0)->get();
        $units      = other_unit::where('id', '>', 0)->get();
        $taxes      = other_tax::all();

        $products   = product::where('is_track', 1)->get();
        $costs      = coa::whereIn('coa_category_id', [15, 16, 17])->get();

        return view('admin.products.products.create', compact([
            'user',
            'categories',
            'units',
            'taxes',
            'products',
            'costs',
            'sell_accounts',
            'buy_accounts',
            'inventory_accounts',
            'default_sell_account',
            'default_buy_account',
            'default_inventory_account'
        ]));
    }

    public function store(Request $request)
    {
        $rules = array(
            'name_product'    => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        IlluminateDB::beginTransaction();
        try {
            $product_bundle                            = $request->product_id;
            $production_bundle                         = $request->product_id_production;
            $cost_bundle                               = $request->cost_acc;
            $user                                       = User::find(Auth::id());
            if ($request->has('is_sell')) {
                $is_sell = 1;
            } else {
                $is_sell = 0;
            };

            if ($request->has('is_buy')) {
                $is_buy = 1;
            } else {
                $is_buy = 0;
            };

            if ($request->has('is_track')) {
                $is_track = 1;
            } else {
                $is_track = 0;
            };

            if ($request->has('is_bundle')) {
                $is_bundle = 1;
            } else {
                $is_bundle = 0;
            };
            if ($request->has('is_production_bundle')) {
                $is_production_bundle = 1;
            } else {
                $is_production_bundle = 0;
            };
            if ($request->has('is_discount')) {
                $is_discount = 1;
            } else {
                $is_discount = 0;
            };
            if ($request->has('is_lock_sales')) {
                $is_lock_sales = 1;
            } else {
                $is_lock_sales = 0;
            };
            if ($request->has('is_lock_purchase')) {
                $is_lock_purchase = 1;
            } else {
                $is_lock_purchase = 0;
            };
            if ($request->has('is_lock_production')) {
                $is_lock_production = 1;
            } else {
                $is_lock_production = 0;
            };

            $product = new product([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'name'                          => $request->get('name_product'),
                'code'                          => $request->get('code_product'),
                'other_product_category_id'     => $request->get('category_product'),
                'other_unit_id'                 => $request->get('unit_product'),
                'desc'                          => $request->get('desc_product'),
                'is_buy'                        => $is_buy,
                'buy_price'                     => $request->get('buy_price'),
                'buy_tax'                       => $request->get('buy_tax'),
                'buy_account'                   => $request->get('buy_account_product'),
                'is_sell'                       => $is_sell,
                'sell_price'                    => $request->get('sell_price'),
                'sell_tax'                      => $request->get('sell_tax'),
                'sell_account'                  => $request->get('sell_account_product'),
                'is_track'                      => $is_track,
                'is_bundle'                     => $is_bundle,
                'is_production_bundle'          => $is_production_bundle,
                'is_discount'                   => $is_discount,
                'is_lock_sales'                 => $is_lock_sales,
                'is_lock_purchase'              => $is_lock_purchase,
                'is_lock_production'            => $is_lock_production,
                'sales_type'                    => $request->sales_type,
                'min_qty'                       => $request->get('min_stock'),
                'default_inventory_account'     => $request->get('default_inventory_account'),
            ]);
            $product->save();

            $check_warehouse                    = warehouse::get();
            foreach ($check_warehouse as $cw) {
                warehouse_detail::create([
                    'warehouse_id'              => $cw->id,
                    'product_id'                => $product->id,
                    'qty_in'                    => 0,
                    'qty_out'                   => 0,
                    'type'                      => 'initial qty import',
                ]);
            }

            if ($is_bundle == 1) {
                $rules = array(
                    'product_id'                    => 'required|array|min:1',
                    'product_id.*'                  => 'required',
                );

                $error = Validator::make($request->all(), $rules);
                // ngecek apakah semua inputan sudah valid atau belum
                if ($error->fails()) {
                    IlluminateDB::rollback();
                    return response()->json(['errors' => $error->errors()->all()]);
                }

                foreach ($product_bundle as $i => $p) {
                    $item_product[$i]               = new product_bundle_item([
                        'product_id'                => $product->id,
                        'bundle_product_id'         => $request->product_id[$i],
                        'qty'                       => $request->product_qty[$i],
                    ]);
                    $item_product[$i]->save();
                }
            }

            if ($is_discount == 1) {
                $rules = array(
                    'discount_qty_a'            => 'required',
                    'discount_price_a'          => 'required',
                );

                $error = Validator::make($request->all(), $rules);
                // ngecek apakah semua inputan sudah valid atau belum
                if ($error->fails()) {
                    IlluminateDB::rollback();
                    return response()->json(['errors' => $error->errors()->all()]);
                }
                $product_disc                   = new product_discount_item([
                    'product_id'                => $product->id,
                    'qty'                       => $request->discount_qty_a,
                    'price'                     => $request->discount_price_a,
                ]);
                $product_disc->save();
                if ($request->discount_qty_b != null) {
                    if ($request->discount_qty_b > $request->discount_qty_a) {
                        if ($request->discount_price_b == null) {
                            IlluminateDB::rollback();
                            return response()->json(['errors' => 'Discount price must be filled in!']);
                        } else {
                            $product_disc                   = new product_discount_item([
                                'product_id'                => $product->id,
                                'qty'                       => $request->discount_qty_b,
                                'price'                     => $request->discount_price_b,
                            ]);
                            $product_disc->save();
                        }
                    } else {
                        IlluminateDB::rollback();
                        return response()->json(['errors' => 'Discount quantity 2th cannot be less than quantity 1st!']);
                    }
                }
                if ($request->discount_qty_c != null) {
                    if ($request->discount_qty_c > $request->discount_qty_b) {
                        if ($request->discount_price_c == null) {
                            IlluminateDB::rollback();
                            return response()->json(['errors' => 'Discount price must be filled in!']);
                        } else {
                            $product_disc                   = new product_discount_item([
                                'product_id'                => $product->id,
                                'qty'                       => $request->discount_qty_c,
                                'price'                     => $request->discount_price_c,
                            ]);
                            $product_disc->save();
                        }
                    } else {
                        IlluminateDB::rollback();
                        return response()->json(['errors' => 'Discount quantity 3rd cannot be less than quantity 2nd!']);
                    }
                }
                if ($request->discount_qty_d != null) {
                    if ($request->discount_qty_d > $request->discount_qty_c) {
                        if ($request->discount_price_d == null) {
                            IlluminateDB::rollback();
                            return response()->json(['errors' => 'Discount price must be filled in!']);
                        } else {
                            $product_disc                   = new product_discount_item([
                                'product_id'                => $product->id,
                                'qty'                       => $request->discount_qty_d,
                                'price'                     => $request->discount_price_d,
                            ]);
                            $product_disc->save();
                        }
                    } else {
                        IlluminateDB::rollback();
                        return response()->json(['errors' => 'Discount quantity 4th cannot be less than quantity 3rd!']);
                    }
                }
            }

            if ($is_production_bundle == 1) {
                $rules = array(
                    'product_id_production'         => 'required|array|min:1',
                    'product_id_production.*'       => 'required',
                );

                $error = Validator::make($request->all(), $rules);
                // ngecek apakah semua inputan sudah valid atau belum
                if ($error->fails()) {
                    IlluminateDB::rollback();
                    return response()->json(['errors' => $error->errors()->all()]);
                }

                foreach ($production_bundle as $x => $p) {
                    $production_bun[$x]               = new product_production_item([
                        'product_id'                => $product->id,
                        'bundle_product_id'         => $request->product_id_production[$x],
                        'qty'                       => $request->product_qty_production[$x],
                        'price'                     => $request->product_price_production[$x],
                    ]);
                    $production_bun[$x]->save();
                }
            }
            /*
                if(cuma buat ngilangin aja kyk gini){
                    $warehouse = new warehouse_detail([
                    'warehouse_id' => 1,
                    ]);

                    $product->warehouse_detail()->save($warehouse);
                    // CREATE INITIAL QTY PRODUCT
                    $check_warehouse        = warehouse::get();
                    $check_warehouse_d      = warehouse_detail::get();
                    foreach ($check_warehouse as $cw) {
                        foreach ($check_warehouse_d as $cwd) {
                            if ($cwd->warehouse_id != $cw->id) {
                                warehouse_detail::create([
                                    'warehouse_id'      => $cw->id,
                                    'product_id'        => $product->id,
                                    'qty'               => 0,
                                ]);
                            }
                        }
                }
                }*/
            /*if ($cost_bundle != null) {
                foreach ($cost_bundle as $i => $p) {
                    if ($cost_bundle[$i] != null) {
                        $item_cost[$i]              = new product_bundle_cost([
                            'product_id'            => $product->id,
                            'coa_id'                => $request->cost_acc[$i],
                            'amount'                => $request->cost_amount[$i],
                        ]);
                        $item_cost[$i]->save();
                    }
                }
            }*/
            IlluminateDB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $product->id]);
        } catch (\Exception $e) {
            IlluminateDB::rollback();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $user                       = User::find(Auth::id());
        $products                   = product::find($id);
        $bundle_item                = product_bundle_item::where('product_id', $id)->get();
        $bundle_cost                = product_bundle_cost::where('product_id', $id)->get();
        $discount                   = product_discount_item::where('product_id', $id)->get();
        $production                 = product_production_item::where('product_id', $id)->get();
        //default account dari setting
        $default_sell_account       = default_account::where('name', 'default_sales_revenue')->first();
        $default_buy_account        = default_account::where('name', 'default_purchase')->first();
        $default_inventory_account  = default_account::where('name', 'default_inventory')->first();

        //menampilkan COA
        $sell_accounts      = coa::where('coa_category_id', 13)
            ->orWhere('coa_category_id', 14)
            ->orWhere('coa_category_id', 3)->get();
        $buy_accounts       = coa::where('coa_category_id', 5)
            ->orWhere('coa_category_id', 15)->get();
        $inventory_accounts = coa::where('coa_category_id', 4)->get();

        //menampilkan kategori produk & produk unit
        $categories = other_product_category::where('id', '>', 0)->get();
        $units = other_unit::where('id', '>', 0)->get();
        $taxes = other_tax::all();

        $other_transaction  = other_transaction::with('status')->get();
        $pq                 = purchase_quote_item::with(['purchase_quote' => function ($query) {
            $query->orderByDesc('transaction_date');
        }])->where('product_id', $id)->get();
        $po                 = purchase_order_item::with(['purchase_order' => function ($query) {
            $query->orderByDesc('transaction_date');
        }])->where('product_id', $id)->get();
        $pd                 = purchase_delivery_item::with(['purchase_delivery' => function ($query) {
            $query->orderByDesc('transaction_date');
        }])->where('product_id', $id)->get();
        $pi                 = purchase_invoice_item::with(['purchase_invoice' => function ($query) {
            $query->orderByDesc('transaction_date');
        }])->where('product_id', $id)->get();
        $sq                 = sale_quote_item::with(['sale_quote' => function ($query) {
            $query->orderByDesc('transaction_date');
        }])->where('product_id', $id)->get();
        $so                 = sale_order_item::with(['sale_order' => function ($query) {
            $query->orderByDesc('transaction_date');
        }])->where('product_id', $id)->get();
        $sd                 = sale_delivery_item::with(['sale_delivery' => function ($query) {
            $query->orderByDesc('transaction_date');
        }])->where('product_id', $id)->get();
        $si                 = sale_invoice_item::with(['sale_invoice' => function ($query) {
            $query->orderByDesc('transaction_date');
        }])->where('product_id', $id)->get();
        $sa                 = stock_adjustment_detail::with(['stock_adjustment' => function ($query) {
            $query->orderByDesc('date');
        }])->where('product_id', $id)->get();
        $wip                = wip::orderByDesc('transaction_date')->where('result_product', $id)->get();
        $wipi               = wip_item::with(['wip' => function ($query) {
            $query->orderByDesc('transaction_date');
        }])->where('product_id', $id)->get();
        $wt                 = warehouse_transfer_item::with(['warehouse_transfer' => function ($query) {
            $query->orderByDesc('transaction_date');
        }])->where('product_id', $id)->get();
        $pirs               = purchase_invoice_po_item::with(['purchase_invoice' => function ($query) {
            $query->orderByDesc('transaction_date');
        }])->where('product_id', $id)->get();

        $warehouse_detail   = warehouse_detail::whereNotIn('type', ['initial qty import', 'initial qty', 'initial warehouse'])
            ->where('product_id', $id)
            ->selectRaw('SUM(qty_in - qty_out) as qty_total, warehouse_id, MAX(created_at) as created_at')
            ->groupBy('warehouse_id')
            ->get();
        $warehouse          = warehouse::get();

        if ($user->getRoleNames()->first() == 'GT' or $user->getRoleNames()->first() == 'MT' or $user->getRoleNames()->first() == 'WS') {
            return view('admin.request.joyday.products.show', compact([
                'products',
                'bundle_item',
                'bundle_cost',
                'discount',
                'production',
                'categories',
                'units',
                'taxes',
                'sell_accounts',
                'buy_accounts',
                'inventory_accounts',
                'default_sell_account',
                'default_buy_account',
                'default_inventory_account',
                'other_transaction', 'pq', 'po', 'pd', 'pi', 'sq', 'so', 'sd', 'si', 'sa', 'wip', 'wipi', 'wt', 'pirs', 'warehouse_detail', 'warehouse'
            ]));
        } else {
            return view('admin.products.products.show', compact([
                'products',
                'bundle_item',
                'bundle_cost',
                'discount',
                'production',
                'categories',
                'units',
                'taxes',
                'sell_accounts',
                'buy_accounts',
                'inventory_accounts',
                'default_sell_account',
                'default_buy_account',
                'default_inventory_account',
                'other_transaction', 'pq', 'po', 'pd', 'pi', 'sq', 'so', 'sd', 'si', 'sa', 'wip', 'wipi', 'wt', 'pirs', 'warehouse_detail', 'warehouse'
            ]));
        }
    }

    public function edit($id)
    {
        $products                   = product::find($id);
        $bundle_item                = product_bundle_item::where('product_id', $id)->get();
        $bundle_cost                = product_bundle_cost::where('product_id', $id)->get();
        $check_bundle_cost          = product_bundle_cost::where('product_id', $id)->count();
        $discount                   = product_discount_item::where('product_id', $id)->get();
        $production                 = product_production_item::where('product_id', $id)->get();
        //default account dari setting
        $default_sell_account       = default_account::where('name', 'default_sales_revenue')->first();
        $default_buy_account        = default_account::where('name', 'default_purchase')->first();
        $default_inventory_account  = default_account::where('name', 'default_inventory')->first();

        //menampilkan COA
        $sell_accounts              = coa::where('coa_category_id', 13)
            ->orWhere('coa_category_id', 14)
            ->orWhere('coa_category_id', 3)->get();
        $buy_accounts               = coa::where('coa_category_id', 5)
            ->orWhere('coa_category_id', 15)->get();
        $inventory_accounts         = coa::where('coa_category_id', 4)->get();

        //menampilkan kategori produk & produk unit
        $categories                 = other_product_category::where('id', '>', 0)->get();
        $units                      = other_unit::where('id', '>', 0)->get();
        $taxes                      = other_tax::all();
        $product_bundle             = product::where('is_track', 1)->get();
        $costs                      = coa::whereIn('coa_category_id', [15, 16, 17])->get();

        return view('admin.products.products.edit', compact([
            'products',
            'bundle_item',
            'bundle_cost',
            'discount',
            'production',
            'check_bundle_cost',
            'product_bundle',
            'costs',
            'categories',
            'units',
            'taxes',
            'sell_accounts',
            'buy_accounts',
            'inventory_accounts',
            'default_sell_account',
            'default_buy_account',
            'default_inventory_account'
        ]));
    }

    public function update(Request $request)
    {
        $rules = array(
            'name_product'    => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        IlluminateDB::beginTransaction();
        try {
            $id                                     = $request->hidden_id;
            $find_product                           = product::find($id);
            $product_bundle                         = $request->product_id2;
            $production_bundle                      = $request->product_id_production2;
            $cost_bundle                            = $request->cost_acc;
            if ($request->has('is_sell')) {
                $is_sell = 1;
            } else {
                $is_sell = 0;
            };

            if ($request->has('is_buy')) {
                $is_buy = 1;
            } else {
                $is_buy = 0;
            };

            if ($request->has('is_track')) {
                $is_track = 1;
            } else {
                $is_track = 0;
            };

            if ($request->has('is_bundle')) {
                $is_bundle = 1;
            } else {
                $is_bundle = 0;
            };
            if ($request->has('is_production_bundle')) {
                $is_production_bundle = 1;
            } else {
                $is_production_bundle = 0;
            };
            if ($request->has('is_discount')) {
                $is_discount = 1;
            } else {
                $is_discount = 0;
            };
            if ($request->has('is_lock_sales')) {
                $is_lock_sales = 1;
            } else {
                $is_lock_sales = 0;
            };
            if ($request->has('is_lock_purchase')) {
                $is_lock_purchase = 1;
            } else {
                $is_lock_purchase = 0;
            };
            if ($request->has('is_lock_production')) {
                $is_lock_production = 1;
            } else {
                $is_lock_production = 0;
            };

            $find_product->update([
                'name'                          => $request->get('name_product'),
                'code'                          => $request->get('code_product'),
                'other_product_category_id'     => $request->get('category_product'),
                'other_unit_id'                 => $request->get('unit_product'),
                'desc'                          => $request->get('desc_product'),
                'is_buy'                        => $is_buy,
                'buy_price'                     => $request->get('buy_price'),
                'buy_tax'                       => $request->get('buy_tax'),
                'buy_account'                   => $request->get('buy_account_product'),
                'is_sell'                       => $is_sell,
                'sell_price'                    => $request->get('sell_price'),
                'sell_tax'                      => $request->get('sell_tax'),
                'sell_account'                  => $request->get('sell_account_product'),
                'is_track'                      => $is_track,
                'is_bundle'                     => $is_bundle,
                'is_production_bundle'          => $is_production_bundle,
                'is_discount'                   => $is_discount,
                'is_lock_sales'                 => $is_lock_sales,
                'is_lock_purchase'              => $is_lock_purchase,
                'is_lock_production'            => $is_lock_production,
                'sales_type'                    => $request->sales_type,
                'min_qty'                       => $request->get('min_stock'),
                'default_inventory_account'     => $request->get('default_inventory_account'),
            ]);

            if ($is_discount == 1) {
                $rules = array(
                    'discount_qty_a'            => 'required',
                    'discount_price_a'          => 'required',
                );

                $error = Validator::make($request->all(), $rules);
                // ngecek apakah semua inputan sudah valid atau belum
                if ($error->fails()) {
                    IlluminateDB::rollback();
                    return response()->json(['errors' => $error->errors()->all()]);
                }
                product_discount_item::where('product_id', $id)->delete();
                $product_disc                   = new product_discount_item([
                    'product_id'                => $id,
                    'qty'                       => $request->discount_qty_a,
                    'price'                     => $request->discount_price_a,
                ]);
                $product_disc->save();
                if ($request->discount_qty_b != null) {
                    if ($request->discount_qty_b > $request->discount_qty_a) {
                        if ($request->discount_price_b == null) {
                            IlluminateDB::rollback();
                            return response()->json(['errors' => 'Discount price must be filled in!']);
                        } else {
                            $product_disc                   = new product_discount_item([
                                'product_id'                => $id,
                                'qty'                       => $request->discount_qty_b,
                                'price'                     => $request->discount_price_b,
                            ]);
                            $product_disc->save();
                        }
                    } else {
                        IlluminateDB::rollback();
                        return response()->json(['errors' => 'Discount quantity 2th cannot be less than quantity 1st!']);
                    }
                }
                if ($request->discount_qty_c != null) {
                    if ($request->discount_qty_c > $request->discount_qty_b) {
                        if ($request->discount_price_c == null) {
                            IlluminateDB::rollback();
                            return response()->json(['errors' => 'Discount price must be filled in!']);
                        } else {
                            $product_disc                   = new product_discount_item([
                                'product_id'                => $id,
                                'qty'                       => $request->discount_qty_c,
                                'price'                     => $request->discount_price_c,
                            ]);
                            $product_disc->save();
                        }
                    } else {
                        IlluminateDB::rollback();
                        return response()->json(['errors' => 'Discount quantity 3rd cannot be less than quantity 2nd!']);
                    }
                }
                if ($request->discount_qty_d != null) {
                    if ($request->discount_qty_d > $request->discount_qty_c) {
                        if ($request->discount_price_d == null) {
                            IlluminateDB::rollback();
                            return response()->json(['errors' => 'Discount price must be filled in!']);
                        } else {
                            $product_disc                   = new product_discount_item([
                                'product_id'                => $id,
                                'qty'                       => $request->discount_qty_d,
                                'price'                     => $request->discount_price_d,
                            ]);
                            $product_disc->save();
                        }
                    } else {
                        IlluminateDB::rollback();
                        return response()->json(['errors' => 'Discount quantity 4th cannot be less than quantity 3rd!']);
                    }
                }
            }

            if ($is_production_bundle == 1) {
                $rules = array(
                    'product_id_production'         => 'required|array|min:1',
                    'product_id_production.*'       => 'required',
                );

                $error = Validator::make($request->all(), $rules);
                // ngecek apakah semua inputan sudah valid atau belum
                if ($error->fails()) {
                    IlluminateDB::rollback();
                    return response()->json(['errors' => $error->errors()->all()]);
                }
                $check_sama                         = 0;
                if ($find_product->wip_item()->exists()) {
                    $ambil_production_item          = product_production_item::where('product_id', $id)->get();
                    foreach ($ambil_production_item as $nomor => $api) {
                        if ($api->id != $request->product_id_production2[$nomor]) {
                            $check_sama             += 1;
                        }
                    }
                    if ($check_sama != 0) {
                        IlluminateDB::rollback();
                        return response()->json(['errors' => 'There already transaction on wip so you cannot change the product!<br>
                        You can only change the quantity and price']);
                    }
                }
                // DELETE DULU YANG LAMA
                product_production_item::where('product_id', $id)->delete();
                // BIKIN BARU LAGI
                foreach ($production_bundle as $x => $p) {
                    $production_bun[$x]               = new product_production_item([
                        'product_id'                => $id,
                        'bundle_product_id'         => $request->product_id_production2[$x],
                        'qty'                       => $request->product_qty_production[$x],
                        'price'                     => $request->product_price_production[$x],
                    ]);
                    $production_bun[$x]->save();
                }
            }

            IlluminateDB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
        } catch (\Exception $e) {
            IlluminateDB::rollback();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        IlluminateDB::beginTransaction();
        try {
            $product            = product::find($id);
            if (
                $product->sale_delivery_item()->exists() or $product->sale_invoice_item()->exists()
                or $product->sale_order_item()->exists() or $product->sale_quote_item()->exists()
                or $product->purchase_delivery_item()->exists() or $product->purchase_invoice_item()->exists()
                or $product->purchase_order_item()->exists() or $product->purchase_quote_item()->exists()
                or $product->product_bundle_item()->exists() or $product->spk_item()->exists() or $product->wip_item()->exists()
                or $product->stock_adjustment_detail()->exists() or $product->warehouse_transfer_item()->exists()
            ) {
                IlluminateDB::rollBack();
                return response()->json(['errors' => 'Cannot delete product with transactions!']);
            }
            $bundle_item        = product_bundle_item::where('bundle_product_id', $id)->first();
            if ($bundle_item) {
                IlluminateDB::rollBack();
                return response()->json(['errors' => 'Cannot delete product with transactions!']);
            } else {
                product_bundle_item::where('product_id', $id)->delete();
                product_bundle_cost::where('product_id', $id)->delete();
                warehouse_detail::where('product_id', $id)->delete();
                $product->delete();
            }
            IlluminateDB::commit();
            return response()->json(['success' => 'Data is successfully deleted']);
        } catch (\Exception $e) {
            IlluminateDB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function import_excel(Request $request)
    {
        /*$rules = array(
            'file' => 'required|mimes:csv,xls,xlsx'
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            \Session::flash('error', $error->errors());
            return redirect('/products');
        }*/
        try {
            /*// validasi
            $this->validate($request, [
                'file' => 'required|mimes:csv,xls,xlsx'
            ]);*/

            // menangkap file excel
            $file = $request->file('file');

            // membuat nama file unik
            $nama_file = rand() . $file->getClientOriginalName();

            // upload ke folder file_siswa di dalam folder public
            $file->move(public_path('/file_product/'), $nama_file);

            try {
                // import data
                Excel::import(new ProductImport, public_path('/file_product/' . $nama_file));
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                $failures = $e->failures();

                foreach ($failures as $failure) {
                    $failure->row(); // row that went wrong
                    $failure->attribute(); // either heading key (if using heading row concern) or column index
                    $failure->errors(); // Actual error messages from Laravel validator
                    $failure->values(); // The values of the row that has failed.
                }
                // notifikasi dengan session
                \Session::flash('error', $e->failures());
                // alihkan halaman kembali
                return redirect('/products');
            }
            // notifikasi dengan session
            \Session::flash('sukses', 'Data Product Berhasil Diimport!');

            // alihkan halaman kembali
            return redirect('/products');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return redirect('/products');
        }
    }

    public function export_excel()
    {
        return Excel::download(new ProductExport, 'product.xlsx');
    }

    public function export_csv()
    {
        return Excel::download(new ProductExport, 'product.csv');
    }

    public function export_pdf()
    {
        $products                             = product::get();
        $no                                   = count($products);

        if ($no <= 1000) {
            $view = view('admin.products.products.printPDF')->with(compact(['products']));
            $html = $view->render();
            $pdf = PDF::loadHTML($html);
            return $pdf->download('product.pdf');
        } else {
            \Session::flash('error', 'Failed, data product is more than 1000!');
            return redirect('/products');
        }
    }
}
