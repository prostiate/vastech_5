<?php

namespace App\Http\Controllers;

use App\other_transaction;
use App\product;
use App\purchase_delivery;
use App\purchase_invoice;
use App\purchase_order;
use App\purchase_quote;
use App\sale_delivery;
use App\sale_invoice;
use App\sale_order;
use App\sale_quote;
use App\stock_adjustment;
use App\warehouse;
use App\warehouse_detail;
use App\warehouse_transfer;
use App\warehouse_transfer_item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\User;

class WarehouseController extends Controller
{
    public function index()
    {
        $total_warehouse        = warehouse::where('id', '>', 0)->count('id');
        if (request()->ajax()) {
            return datatables()->of(warehouse::get())
                ->make(true);
        }

        return view('admin.products.warehouses.index', compact(['total_warehouse']));
    }

    public function create()
    {
        return view('admin.products.warehouses.create');
    }

    public function store(Request $request)
    {
        $rules = array(
            'warehouse_name'    => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $share = new warehouse([
                'user_id'                   => Auth::id(),
                'name'      => $request->get('warehouse_name'),
                'code'      => $request->get('warehouse_code'),
                'address'   => $request->get('warehouse_address'),
                'desc'      => $request->get('warehouse_description'),
            ]);
            $share->save();
            // CREATE INITIAL QTY PRODUCT
            /*$check_warehouse        = warehouse::get();
            $check_warehouse_d      = warehouse_detail::get();
            foreach ($check_warehouse as $cw) {
                foreach ($check_warehouse_d as $cwd) {
                    if (!$cwd->warehouse_id == $cw->id) {
                        warehouse_detail::create([
                            'warehouse_id'      => $cw->id,
                            'product_id'        => $product->id,
                            'qty'               => 0,
                        ]);
                    }
                }
            }*/
            $get_product        = product::get();
            foreach ($get_product as $gp) {
                warehouse_detail::create([
                    'warehouse_id'      => $share->id,
                    'product_id'        => $gp->id,
                    'qty_in'            => 0,
                    'qty_out'           => 0,
                    'type'              => 'initial qty warehouse'
                ]);
            }
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $share->id]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $warehouses     = warehouse::find($id);
        $product_list   = warehouse_detail::where('warehouse_id', $id)->selectRaw('SUM(qty_in - qty_out) as qty_total, product_id')->groupBy('product_id')->get();
        $po                 = purchase_order::where('warehouse_id', $id)->get();
        $pd                 = purchase_delivery::where('warehouse_id', $id)->get();
        $pi                 = purchase_invoice::where('warehouse_id', $id)->get();
        $so                 = sale_order::where('warehouse_id', $id)->get();
        $sd                 = sale_delivery::where('warehouse_id', $id)->get();
        $si                 = sale_invoice::where('warehouse_id', $id)->get();
        $sa                 = stock_adjustment::where('warehouse_id', $id)->get();

        return view('admin.products.warehouses.show', compact([
            'warehouses',
            'product_list', 'po', 'pd', 'pi', 'so', 'sd', 'si', 'sa'
        ]));
    }

    public function edit($id)
    {
        $warehouses = warehouse::find($id);

        return view('admin.products.warehouses.edit', compact(['warehouses']));
    }

    public function update(Request $request)
    {
        $rules = array(
            'warehouse_name'    => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $form_data = array(
                'name'      => $request->get('warehouse_name'),
                'code'      => $request->get('warehouse_code'),
                'address'   => $request->get('warehouse_address'),
                'desc'      => $request->get('warehouse_description'),
            );
            warehouse::whereId($request->hidden_id)->update($form_data);
            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $request->hidden_id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product                   = warehouse::findOrFail($id);
            if (
                $product->sale_delivery()->exists() or $product->sale_invoice()->exists()
                or $product->sale_order()->exists()
                or $product->purchase_delivery()->exists() or $product->purchase_invoice()->exists()
                or $product->purchase_order()->exists()
                or $product->spk()->exists() or $product->wip()->exists()
                or $product->stock_adjustment()->exists()
            ) {
                DB::rollBack();
                return response()->json(['errors' => 'Cannot delete warehouse with transactions!']);
            }

            $product->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function indexTransfer()
    {
        if (request()->ajax()) {
            return datatables()->of(warehouse_transfer::with('from_warehouse', 'to_warehouse')->get())
                /*->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                    return $button;
                })
                ->rawColumns(['action'])*/
                ->make(true);
        }

        return view('admin.products.warehouses_transfer.index');
    }

    public function createTransferPartOne()
    {
        $warehouses         = warehouse::get();
        return view('admin.products.warehouses_transfer.createPartOne', compact(['warehouses']));
    }

    public function createTransferPartTwo($from, $to)
    {
        $today                      = Carbon::today()->toDateString();
        $from_warehouse             = warehouse::find($from);
        $to_warehouse               = warehouse::find($to);
        $warehouse_detail_from      = warehouse_detail::where('warehouse_id', $from)->groupBy('product_id')->get();
        $warehouse_detail_to        = warehouse_detail::where('warehouse_id', $to)->groupBy('product_id')->get();
        $products                   = product::where('is_track', 1)->get();
        $number                     = warehouse_transfer::max('number');
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            if ($number != null) {
                $misahm             = explode("/", $number);
                $misahy             = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1                    = $misahy[1] + 1;
            $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;
        } else {
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }
        return view('admin.products.warehouses_transfer.createPartTwo', compact([
            'today', 'products', 'trans_no',
            'from_warehouse', 'to_warehouse', 'warehouse_detail_from', 'warehouse_detail_to'
        ]));
    }

    public function storeTransfer(Request $request)
    {
        $number             = warehouse_transfer::max('number');
        $user               = User::find(Auth::id());
        if ($user->company_id == 5) {
            if ($number != null) {
                $misahm             = explode("/", $number);
                $misahy             = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]      = 10000;
            }
            $number1                    = $misahy[1] + 1;
            $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;
        } else {
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }
        $rules = array(
            'product'       => 'required|array|min:1',
            'product.*'     => 'required',
            'qty'           => 'required|array|min:1',
            'qty.*'         => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $transactions = other_transaction::create([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'transaction_date'          => $request->get('transfer_date'),
                'number'                    => $trans_no,
                'number_complete'           => 'Warehouse Transfer #' . $trans_no,
                'type'                      => 'warehouse transfer',
                'memo'                      => $request->get('memo'),
                'status'                    => 2,
                'balance_due'               => 0,
                'total'                     => 0,
            ]);

            $header = new warehouse_transfer([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'number'                        => $trans_no,
                'transaction_date'              => $request->transfer_date,
                'from_warehouse_id'             => $request->from_warehouse,
                'to_warehouse_id'               => $request->to_warehouse,
                'memo'                          => $request->memo,
            ]);
            $transactions->warehouse_transfer()->save($header);
            // MASUKKIN ID PAYMENT KE OTHER TRANSACTION PAYMENT
            other_transaction::find($transactions->id)->update([
                'ref_id'                        => $header->id,
            ]);

            foreach ($request->product as $i => $keys) {
                $item[$i]                       = new warehouse_transfer_item([
                    'product_id'                => $request->product[$i],
                    'qty'                       => $request->qty[$i],
                ]);
                $header->warehouse_transfer_item()->save($item[$i]);

                //MINDAHIN QTY GUDANG FROM
                $wh                             = new warehouse_detail();
                $wh->type                       = 'warehouse transfer';
                $wh->number                     = 'Warehouse Transfer #' . $trans_no;
                $wh->product_id                 = $request->product[$i];
                $wh->warehouse_id               = $request->from_warehouse;
                $wh->qty_out                    = $request->qty[$i];
                $wh->save();

                $wh2                            = new warehouse_detail();
                $wh2->type                      = 'warehouse transfer';
                $wh2->number                    = 'Warehouse Transfer #' . $trans_no;
                $wh2->product_id                = $request->product[$i];
                $wh2->warehouse_id              = $request->to_warehouse;
                $wh2->qty_in                    = $request->qty[$i];
                $wh2->save();
            };
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $header->id]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function showTransfer($id)
    {
        $wt                         = warehouse_transfer::find($id);
        $wti                        = warehouse_transfer_item::where('warehouse_transfer_id', $id)->get();
        return view('admin.products.warehouses_transfer.show', compact(['wt', 'wti']));
    }

    public function editTransfer($id)
    {
        $wt                         = warehouse_transfer::find($id);
        $wti                        = warehouse_transfer_item::where('warehouse_transfer_id', $id)->get();
        $warehouse_detail_from      = warehouse_detail::where('warehouse_id', $wt->from_warehouse_id)->groupBy('product_id')->get();
        $warehouse_detail_to        = warehouse_detail::where('warehouse_id', $wt->to_warehouse_id)->groupBy('product_id')->get();
        return view('admin.products.warehouses_transfer.edit', compact(['wt', 'wti', 'warehouse_detail_from', 'warehouse_detail_to']));
    }

    public function updateTransfer(Request $request)
    {
        $rules = array(
            'product'       => 'required|array|min:1',
            'product.*'     => 'required',
            'qty'           => 'required|array|min:1',
            'qty.*'         => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $id                             = $request->hidden_id;
            $wt                             = warehouse_transfer::find($id);
            other_transaction::where('type', 'warehouse_transfer')->where('number', $wt->number)->update([
                'transaction_date'          => $request->get('transfer_date'),
                'memo'                      => $request->get('memo'),
            ]);

            $wt->update([
                'transaction_date'              => $request->transfer_date,
                'memo'                          => $request->memo,
            ]);
            warehouse_transfer_item::where('warehouse_transfer_id', $id)->delete();
            warehouse_detail::where('type', 'warehouse transfer')->where('number', 'Warehouse Transfer #' . $wt->number)->delete();

            foreach ($request->product as $i => $keys) {
                $item[$i]                       = new warehouse_transfer_item([
                    'product_id'                => $request->product[$i],
                    'qty'                       => $request->qty[$i],
                ]);
                $wt->warehouse_transfer_item()->save($item[$i]);

                //MINDAHIN QTY GUDANG FROM
                $wh                             = new warehouse_detail();
                $wh->type                       = 'warehouse transfer';
                $wh->number                     = 'Warehouse Transfer #' . $wt->number;
                $wh->product_id                 = $request->product[$i];
                $wh->warehouse_id               = $request->from_warehouse;
                $wh->qty_out                    = $request->qty[$i];
                $wh->save();

                $wh2                            = new warehouse_detail();
                $wh2->type                      = 'warehouse transfer';
                $wh2->number                    = 'Warehouse Transfer #' . $wt->number;
                $wh2->product_id                = $request->product[$i];
                $wh2->warehouse_id              = $request->to_warehouse;
                $wh2->qty_in                    = $request->qty[$i];
                $wh2->save();
            };
            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroyTransfer($id)
    {
        DB::beginTransaction();
        try {
            $data = warehouse_transfer::find($id);
            other_transaction::where('type', 'warehouse transfer')->where('number', $data->number)->delete();
            warehouse_transfer_item::where('warehouse_transfer_id', $id)->delete();
            warehouse_detail::where('type', 'warehouse transfer')->where('number', 'Warehouse Transfer #' . $data->number)->delete();
            $data->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }
}
