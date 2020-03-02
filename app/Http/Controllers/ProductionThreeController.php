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
use App\Model\production\production_three;
use App\Model\production\production_three_item;
use App\Model\warehouse\warehouse;
use Illuminate\Support\Carbon;

class ProductionThreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(production_three::with('contact', 'status', 'warehouse')->get())
                ->make(true);
        }

        return view('admin.products.production_three.station_one.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products           = product::get();
        $warehouses         = warehouse::get();
        $contacts           = contact::get();
        $number             = production_three::latest()->first();
        $today              = Carbon::today()->toDateString();
        $units              = other_unit::get();
        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;

        return view('admin.products.production_three.station_one.create', compact(['products', 'trans_no', 'today', 'units', 'warehouses', 'contacts']));
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
            'result_product'    => 'required',
            'result_qty'        => 'required',
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

        try {
            $product            = $request->product;
            $create_product     = product::create([
                'avg_price'                     => 0,
                'name'                          => $request->result_product,
                'other_product_category_id'     => 5,
                'other_unit_id'                 => $request->unit,
                'desc'                          => $request->unit,
                'is_buy'                        => 1,
                'buy_price'                     => 0,
                'buy_tax'                       => 0,
                'buy_account'                   => 69,
                'is_sell'                       => 1,
                'sell_price'                    => 0,
                'sell_tax'                      => 0,
                'sell_account'                  => 65,
                'is_track'                      => 1,
                'min_qty'                       => 0,
                'default_inventory_account'     => 7,
                'qty'                           => $request->result_qty,
            ]);
            $create_product->save();
            $header                             = production_three::create([
                'product_id'                    => $create_product->id,
                'result_qty'                    => $request->result_qty,
                'unit_id'                       => $request->unit,
                'number'                        => $request->trans_no,
                'contact_id'                    => $request->contact,
                'transaction_date'              => $request->trans_date,
                'warehouse_id'                  => $request->warehouse,
                'desc'                          => $request->desc,
                'status'                        => 2,
            ]);
            $header->save();
            foreach($product as $i => $p){
                $item[$i]                       = new production_three_item([
                    'product_id'                => $request->product[$i],
                    'qty'                       => $request->qty[$i],
                ]);
                $header->production_three_item()->save($item[$i]);
            }
            return response()->json(['success' => 'Data Added Successfully!']);
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
        $pro        = production_three::find($id);
        $pro_item   = production_three_item::where('production_three_id', $id)->get();
        return view('admin.products.production_three.station_one.show', compact(['pro', 'pro_item']));
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
