<?php

namespace App\Http\Controllers;

use App\Model\coa\coa;
use App\Model\contact\contact;
use App\Model\coa\default_account;
use App\Model\other\other_tax;
use App\Model\product\product;
use App\Model\other\other_product_category;
use App\Model\other\other_unit;
use App\Model\warehouse\warehouse_detail;
use Illuminate\Http\Request;
use Validator;
use App\Model\production\production_one;
use App\Model\production\production_one_item;
use App\Model\warehouse\warehouse;
use Illuminate\Support\Carbon;
use App\Model\other\other_transaction;
use App\Model\coa\coa_detail;
use App\Model\production\production_one_cost;

class ProductionOneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(production_one::with('contact', 'status', 'warehouse')->get())
                ->make(true);
        }

        return view('admin.products.production_one.station_one.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products           = product::where('is_track', 1)->get();
        $warehouses         = warehouse::get();
        $contacts           = contact::get();
        $number             = production_one::latest()->first();
        $today              = Carbon::today()->toDateString();
        $units              = other_unit::get();
        $costs              = coa::whereIn('coa_category_id', [15, 16, 17])->get();
        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;

        return view('admin.products.production_one.station_one.create', compact(['products', 'trans_no', 'today', 'units', 'warehouses', 'contacts', 'costs']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'result_product'                    => 'required',
            'contact'                           => 'required',
            'result_qty'                        => 'required',
            'warehouse'                         => 'required',
            'result_unit'                       => 'required',
            'raw_product'                       => 'required|array|min:1',
            'raw_product.*'                     => 'required',
            'raw_qty'                           => 'required|array|min:1',
            'raw_qty.*'                         => 'required',
            'raw_amount'                        => 'required|array|min:1',
            'raw_amount.*'                      => 'required',
            'cost_acc'                          => 'required|array|min:1',
            'cost_acc.*'                        => 'required',
            'cost_est'                          => 'required|array|min:1',
            'cost_est.*'                        => 'required',
            'cost_multi'                        => 'required|array|min:1',
            'cost_multi.*'                      => 'required',
            'cost_total'                        => 'required|array|min:1',
            'cost_total.*'                      => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        try {
            $product                            = $request->raw_product;
            $cost                               = $request->cost_acc;
            $create_product                     = product::create([
                'avg_price'                     => 0,
                'name'                          => $request->result_product,
                'other_product_category_id'     => 3,
                'other_unit_id'                 => $request->result_unit,
                'desc'                          => $request->desc,
                'is_buy'                        => 0,
                'buy_price'                     => 0,
                'buy_tax'                       => 1,
                'buy_account'                   => 69,
                'is_sell'                       => 1,
                'sell_price'                    => 0,
                'sell_tax'                      => 1,
                'sell_account'                  => 65,
                'is_track'                      => 1,
                'min_qty'                       => 0,
                'default_inventory_account'     => 7,
                'qty'                           => $request->result_qty,
            ]);

            $create_product->save();
            // CREATE INITIAL QTY PRODUCT
            $check_warehouse                    = warehouse::get();
            foreach ($check_warehouse as $cw) {
                warehouse_detail::create([
                    'warehouse_id'              => $cw->id,
                    'product_id'                => $create_product->id,
                    'qty'                       => 0,
                ]);
            }
            warehouse_detail::where('warehouse_id', $request->warehouse)->update(['qty' => $request->result_qty]);

            $transactions                       = other_transaction::create([
                'transaction_date'              => $request->get('trans_date'),
                'number'                        => $request->trans_no,
                'number_complete'               => 'Station One #' . $request->trans_no,
                'type'                          => 'stationone',
                'memo'                          => $request->get('desc'),
                'contact'                       => $request->get('contact'),
                'status'                        => 2,
                'balance_due'                   => $request->get('total_grand'),
                'total'                         => $request->get('total_grand'),
            ]);

            $header                             = production_one::create([
                'product_id'                    => $create_product->id,
                'result_qty'                    => $request->result_qty,
                'unit_id'                       => $request->result_unit,
                'number'                        => $request->trans_no,
                'contact_id'                    => $request->contact,
                'transaction_date'              => $request->trans_date,
                'warehouse_id'                  => $request->warehouse,
                'desc'                          => $request->desc,
                'subtotal_raw'                  => $request->total_raw,
                'subtotal_cost'                 => $request->total_cost,
                'grandtotal'                    => $request->total_grand,
                'status'                        => 2,
            ]);
            $transactions->production_one()->save($header);
            // CREATE COA DETAIL PUNYA NYA RESULT PRODUCT
            coa_detail::create([
                'coa_id'                    => $create_product->default_inventory_account,
                'date'                      => $request->get('trans_date'),
                'type'                      => 'stationone',
                'number'                    => 'Station One #' . $request->trans_no,
                'contact_id'                => $request->get('contact'),
                'debit'                     => $request->total_grand,
                'credit'                    => 0,
            ]);

            foreach($product as $i => $p){
                $item[$i]                       = new production_one_item([
                    'product_id'                => $request->raw_product[$i],
                    'qty'                       => $request->raw_qty[$i],
                    'amount'                    => $request->raw_amount[$i],
                ]);
                $header->production_one_item()->save($item[$i]);
                $check_product                  = product::find($request->raw_product[$i]);
                coa_detail::create([
                    'coa_id'                    => $check_product->default_inventory_account,
                    'date'                      => $request->get('trans_date'),
                    'type'                      => 'stationone',
                    'number'                    => 'Station One #' . $request->trans_no,
                    'contact_id'                => $request->get('contact'),
                    'debit'                     => 0,
                    'credit'                    => $request->raw_amount[$i],
                ]);
            }
            foreach($cost as $i => $p){
                $item[$i]                       = new production_one_cost([
                    'coa_id'                    => $request->cost_acc[$i],
                    'estimated_cost'            => $request->cost_est[$i],
                    'multiplier'                => $request->cost_multi[$i],
                    'amount'                    => $request->cost_total[$i],
                ]);
                $header->production_one_cost()->save($item[$i]);
                coa_detail::create([
                    'coa_id'                    => $request->cost_acc[$i],
                    'date'                      => $request->get('trans_date'),
                    'type'                      => 'stationone',
                    'number'                    => 'Station One #' . $request->trans_no,
                    'contact_id'                => $request->get('contact'),
                    'debit'                     => 0,
                    'credit'                    => $request->cost_total[$i],
                ]);
            }
            $total_avg_price                    = (($create_product->avg_price * $create_product->qty) + ($request->total_grand * $request->result_qty)) / ($create_product->qty + $request->result_qty);
            product::find($create_product->id)->update(['avg_price' => $total_avg_price]);
            return response()->json(['success' => 'Data is successfully added', 'id' => $header->id]);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\product\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pro        = production_one::find($id);
        $pro_item   = production_one_item::where('production_one_id', $id)->get();
        $pro_cost   = production_one_cost::where('production_one_id', $id)->get();
        return view('admin.products.production_one.station_one.show', compact(['pro', 'pro_item', 'pro_cost']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\product\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products                   = product::find($id);
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

        return view('admin.products.products.edit', compact([
            'products',
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\product\product  $product
     * @return \Illuminate\Http\Response
     */
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

        try {
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

            $form_data = array(
                'name'                  => $request->get('name_product'),
                'code'                  => $request->get('code_product'),
                'other_product_category_id'   => $request->get('category_product'),
                'other_unit_id'         => $request->get('unit_product'),
                'desc'                  => $request->get('desc_product'),
                'is_buy'                => $is_buy,
                'buy_price'             => $request->get('buy_price'),
                'buy_tax'               => $request->get('buy_tax'),
                'buy_account'           => $request->get('buy_account_product'),
                'is_sell'               => $is_sell,
                'sell_price'            => $request->get('sell_price'),
                'sell_tax'              => $request->get('sell_tax'),
                'sell_account'          => $request->get('sell_account_product'),
                'is_track'              => $is_track,
                'min_qty'               => $request->get('min_stock'),
                'default_inventory_account'       => $request->get('default_inventory_account'),
            );

            $warehouse = array(
                'warehouse_id' => 0,
            );
            product::whereId($request->hidden_id)->update($form_data);
            warehouse_detail::where('product_id', $request->hidden_id)->update($warehouse);

            return response()->json(['success' => 'Data Added Successfully!']);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\product\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = product::findOrFail($id);
            $data->delete();

            return response()->json(['success' => 'Data is successfully deleted']);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['errors' => 'Cannot delete contact with transactions!']);
        }
    }
}
