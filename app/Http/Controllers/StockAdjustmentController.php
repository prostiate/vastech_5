<?php

namespace App\Http\Controllers;

use App\stock_adjustment;
use App\stock_adjustment_detail;
use Illuminate\Http\Request;
use App\product;
use App\warehouse;
use App\coa;
use App\default_account;
use Carbon\Carbon;
use App\other_transaction;
use App\coa_detail;
use App\warehouse_detail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\User;

class StockAdjustmentController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            //return datatables()->of(Product::all())
            return datatables()->of(stock_adjustment::with('coa', 'warehouse')->get())
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.products.stock_adjustment.index');
    }

    public function createPartOne()
    {
        $warehouses                 = warehouse::get();

        return view(
            'admin.products.stock_adjustment.createPartOne',
            compact([
                'warehouses',
            ])
        );
    }

    public function createPartTwoStockCount($type, $cat, $war)
    {
        $products                   = product::where('is_track', 1)->get();
        $accounts                   = coa::get();
        $warehouses                 = warehouse::find($war);
        $warehouse_detail_from2     = warehouse_detail::where('warehouse_id', $war)->groupBy('product_id')->get();
        $warehouse_detail_from      = warehouse_detail::selectRaw('SUM(qty_in - qty_out) as qty, product_id')->groupBy('product_id')->get();
        $today                      = Carbon::today()->toDateString();
        $default_inventory1         = default_account::find(17);
        $default_inventory2         = default_account::find(18);
        $default_inventory3         = default_account::find(19);
        $default_inventory4         = default_account::find(20);

        $adtype                     = $type;
        $adcat                      = $cat;

        return view(
            'admin.products.stock_adjustment.createPartTwoStockCount',
            compact([
                'products',
                'accounts',
                'today',
                'warehouses',
                'warehouse_detail_from',
                'default_inventory1',
                'default_inventory2',
                'default_inventory3',
                'default_inventory4',
                'adtype',
                'adcat',
            ])
        );
    }

    public function createPartTwoStockInOut($type, $cat, $war)
    {
        $products                   = product::where('is_track', 1)->get();
        $accounts                   = coa::get();
        $warehouses                 = warehouse::find($war);
        $warehouse_detail_from2      = warehouse_detail::where('warehouse_id', $war)->groupBy('product_id')->get();
        $warehouse_detail_from      = warehouse_detail::selectRaw('SUM(qty_in - qty_out) as qty, product_id')->groupBy('product_id')->get();
        $today                      = Carbon::today()->toDateString();
        $default_inventory1         = default_account::find(17);
        $default_inventory2         = default_account::find(18);
        $default_inventory3         = default_account::find(19);
        $default_inventory4         = default_account::find(20);

        $adtype                     = $type;
        $adcat                      = $cat;

        return view(
            'admin.products.stock_adjustment.createPartTwoStockInOut',
            compact([
                'products',
                'accounts',
                'today',
                'warehouses',
                'warehouse_detail_from',
                'default_inventory1',
                'default_inventory2',
                'default_inventory3',
                'default_inventory4',
                'adtype',
                'adcat',
            ])
        );
    }

    public function store(Request $request)
    {
        $rules = array(
            'adjustment_category'   => 'required',
            'trans_date'            => 'required',
            'actual_qty'            => 'required|array|min:1',
            'actual_qty.*'          => 'required',
            'difference_qty'        => 'required|array|min:1',
            'difference_qty.*'      => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        // GET MAX NUMBER TRANSACTION
        $user               = User::find(Auth::id());
        $total_semua                = 0;
        if ($user->company_id == 5) {
            $number                     = stock_adjustment::latest()->first();
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
            $number                     = stock_adjustment::max('number');
            if ($number == 0)
                $number = 10000;
            $trans_no = $number + 1;
        }
        // CREATE LIST TRANSACTION OF STOCK ADJUSTMENT
        $transactions = other_transaction::create([
            'company_id'                    => $user->company_id,
            'user_id'                       => Auth::id(),
            'transaction_date'              => $request->get('trans_date'),
            'number'                        => $trans_no,
            'number_complete'               => 'Stock Adjustment #' . $trans_no,
            'type'                          => 'stock adjustment',
            'memo'                          => $request->get('memo'),
            'status'                        => 2,
            'balance_due'                   => 0,
            'total'                         => 0,
        ]);
        // NGECEK APAKAH STOCK COUNT ATAU STOCK IN / OUT
        if ($request->iCheck == 1) {
            $sa = new stock_adjustment([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'stock_type'            => 1,
                'number'                => $trans_no,
                'adjustment_type'       => $request->get('adjustment_category'),
                'coa_id'                => $request->get('account'),
                'date'                  => $request->get('trans_date'),
                'warehouse_id'          => $request->get('warehouse'),
                'memo'                  => $request->get('memo'),
            ]);
        } else {
            $sa = new stock_adjustment([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'stock_type'            => 2,
                'number'                => $trans_no,
                'adjustment_type'       => $request->get('adjustment_category'),
                'coa_id'                => $request->get('account'),
                'date'                  => $request->get('trans_date'),
                'warehouse_id'          => $request->get('warehouse'),
                'memo'                  => $request->get('memo'),
            ]);
        };
        // SAVE YANG DIATAS SEKALIAN MASUKKIN ID OTHER TRANSACTIONNYA
        $transactions->stock_adjustment()->save($sa);

        foreach ($request->product_id as $i => $keys) {
            // EXECUTE KALAU ACTUAL QTY DI INPUT, JADI KALAU ADA 5 BARANG TAPI CUMA 2 INPUT ACTUAL QTY MAKA CUMA YANG DIINPUT YANG DI EXECUTE
            if ($request->actual_qty[$i]) {
                //menyimpan data untuk detail transaksi per produk pada stock adjustment SEKALIAN MASUKKIN ID STOCK ADJUSTMENT HEADER
                $pp[$i] = new stock_adjustment_detail([
                    'product_id'        => $request->product_id[$i],
                    'recorded'          => $request->recorded_qty[$i],
                    'actual'            => $request->actual_qty[$i],
                    'difference'        => $request->difference_qty[$i],
                    'avg_price'         => $request->avg_price[$i],
                ]);
                $sa->stock_adjustment_detail()->save($pp[$i]);
                // NGAMBIL PRODUCT ID YANG MUNCUL
                $default_product_account = product::find($request->product_id[$i]);
                // KALAU ACTUAL QTY SAMA DENGAN RECORDED QTY TIDAK DIKALIKAN DENGAN AVERAGE PRICE PRODUCT DAN GA MASUK KE COA DETAILS
                if ($request->actual_qty[$i] >= $request->recorded_qty[$i]) {
                    $total              = $request->recorded_qty[$i] - $request->actual_qty[$i];
                    $total_avg          = $total * $request->avg_price[$i];
                    // COA BERDASARKAN PRODUCTc
                    $cd = new coa_detail([
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'        => $default_product_account->default_inventory_account,
                        'date'          => $request->get('trans_date'),
                        'type'          => 'stock adjustment',
                        'number'        => 'Stock Adjustment #' . $trans_no,
                        'debit'         => abs($total_avg),
                        'credit'        => $total,
                    ]);
                    $transactions->coa_detail()->save($cd);

                    $total_semua        += $total_avg;
                    // KALAU ACTUAL QTY LEBIH KECIL SAMA DENGAN RECORDED QTY, MEREKA BERDUA DI KURANGIN DULU ABIS TU DIKALI AVERAGE PRICE
                } else if ($request->actual_qty[$i] <= $request->recorded_qty[$i]) {
                    $total              = $request->recorded_qty[$i] - $request->actual_qty[$i];
                    $total_avg          = $total * $request->avg_price[$i];
                    // COA BERDASARKAN INPUT ACCOUNT
                    $cd = new coa_detail([
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'        => $default_product_account->default_inventory_account,
                        'date'          => $request->get('trans_date'),
                        'type'          => 'stock adjustment',
                        'number'        => 'Stock Adjustment #' . $trans_no,
                        'debit'         => $total,
                        'credit'        => abs($total_avg),
                    ]);
                    $transactions->coa_detail()->save($cd);

                    $total_semua        += $total_avg;
                } else if ($request->actual_qty[$i] == $request->recorded_qty[$i]) {
                    $total              = $request->recorded_qty[$i] - $request->actual_qty[$i];
                    $total_avg          = $total * $request->avg_price[$i];
                    // COA BERDASARKAN PRODUCT
                    $cd = new coa_detail([
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'        => $default_product_account->default_inventory_account,
                        'date'          => $request->get('trans_date'),
                        'type'          => 'stock adjustment',
                        'number'        => 'Stock Adjustment #' . $trans_no,
                        'debit'         => 0,
                        'credit'        => 0,
                    ]);
                    $transactions->coa_detail()->save($cd);

                    $total_semua        += $total_avg;
                    // KALAU ACTUAL QTY SAMA DENGAN LEBIH BESAR DARI RECORDED QTY, DIFFERENCE QTY HARUS DIKALIKAN DENGAN AVERAGE PRICE
                }

                // UPDATE QTY DAN AVG_PRICE DI PRODUCT
                product::where('id', $request->product_id[$i])->update([
                    'qty'           => $request->actual_qty[$i],
                    'avg_price'     => $request->avg_price[$i]
                ]);
                //menambahkan stok barang ke gudang / UPDATE QTY DI WAREHOUSES DETAILS
                $wh = new warehouse_detail();
                $wh->type           = 'stock adjustment';
                $wh->number         = 'Stock Adjustment #' . $trans_no;
                $wh->product_id     = $request->product_id[$i];
                $wh->warehouse_id   = $request->warehouse;
                $wh->qty            = $request->actual_qty[$i];
                $wh->save();
            }
        };

        if ($total_semua >= 0) {
            // COA BERDASARKAN INPUT ACCOUNT
            $cd = new coa_detail([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'coa_id'        => $request->get('account'),
                'date'          => $request->get('trans_date'),
                'type'          => 'stock adjustment',
                'number'        => 'Stock Adjustment #' . $trans_no,
                'debit'         => abs($total_semua),
                'credit'        => 0,
            ]);
            $transactions->coa_detail()->save($cd);
        } else {
            // COA BERDASARKAN INPUT ACCOUNT
            $cd = new coa_detail([
                'company_id'                    => $user->company_id,
                'user_id'                       => Auth::id(),
                'coa_id'        => $request->get('account'),
                'date'          => $request->get('trans_date'),
                'type'          => 'stock adjustment',
                'number'        => 'Stock Adjustment #' . $trans_no,
                'debit'         => 0,
                'credit'        => abs($total_semua),
            ]);
            $transactions->coa_detail()->save($cd);
        }

        return response()->json(['success' => 'Data Added Successfully!']);
    }

    public function storeStockCount(Request $request)
    {
        $user                           = User::find(Auth::id());
        if ($user->company_id == 5) {
            $number                     = stock_adjustment::latest()->first();
            if ($number != null) {
                $misahm                 = explode("/", $number->number);
                $misahy                 = explode(".", $misahm[1]);
            }
            if (isset($misahy[1]) == 0) {
                $misahy[1]              = 10000;
            }
            $number1                    = $misahy[1] + 1;
            $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;
        } else {
            $number                     = stock_adjustment::max('number');
            if ($number == 0)
                $number                 = 10000;
            $trans_no                   = $number + 1;
        }
        $rules = array(
            'adjustment_category'       => 'required',
            'trans_date'                => 'required',
            'actual_qty'                => 'required|array|min:1',
            'actual_qty.*'              => 'required',
            'product'                   => 'required|array|min:1',
            'product.*'                 => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        DB::beginTransaction();
        try {
            $transactions = other_transaction::create([
                'transaction_date'      => $request->trans_date,
                'number'                => $trans_no,
                'number_complete'       => 'Stock Adjustment #' . $trans_no,
                'type'                  => 'stock adjustment',
                'memo'                  => $request->memo,
                'status'                => 2,
                'balance_due'           => 0,
                'total'                 => 0,
            ]);

            $sa = new stock_adjustment([
                'user_id'               => Auth::id(),
                'stock_type'            => 1,
                'number'                => $trans_no,
                'adjustment_type'       => $request->adjustment_category,
                'coa_id'                => $request->account,
                'date'                  => $request->trans_date,
                'warehouse_id'          => $request->warehouse,
                'memo'                  => $request->memo,
            ]);
            $transactions->stock_adjustment()->save($sa);
            other_transaction::find($transactions->id)->update([
                'ref_id'                => $sa->id,
            ]);

            $total_semua                = 0;
            foreach ($request->product as $i => $keys) {
                $default_product_account = product::find($request->product[$i]);
                if ($default_product_account->avg_price == $request->avg_price[$i]) {
                    $product_avg_price  = $default_product_account->avg_price;
                } else {
                    $product_avg_price  = $request->avg_price[$i];
                }
                $difference             = $request->recorded_qty[$i] - $request->actual_qty[$i];
                $total                  = $difference;
                $total_avg              = $total * $product_avg_price;

                $pp[$i] = new stock_adjustment_detail([
                    'product_id'        => $request->product[$i],
                    'recorded'          => $request->recorded_qty[$i],
                    'actual'            => $request->actual_qty[$i],
                    'difference'        => $difference,
                    'avg_price'         => $request->avg_price[$i],
                ]);
                $sa->stock_adjustment_detail()->save($pp[$i]);

                if ($request->actual_qty[$i] > $request->recorded_qty[$i]) {
                    $cd = new coa_detail([
                        'company_id'    => $user->company_id,
                        'user_id'       => Auth::id(),
                        'ref_id'        => $sa->id,
                        'coa_id'        => $default_product_account->default_inventory_account,
                        'date'          => $request->trans_date,
                        'type'          => 'stock adjustment',
                        'number'        => 'Stock Adjustment #' . $trans_no,
                        'debit'         => abs($total_avg),
                        'credit'        => 0,
                    ]);
                    $transactions->coa_detail()->save($cd);
                    $total_semua        += $total_avg;
                    $avgprice           = $request->avg_price[$i];

                    // KALAU ACTUAL QTY LEBIH KECIL SAMA DENGAN RECORDED QTY, MEREKA BERDUA DI KURANGIN DULU ABIS TU DIKALI AVERAGE PRICE
                } else if ($request->actual_qty[$i] < $request->recorded_qty[$i]) {
                    $cd = new coa_detail([
                        'company_id'    => $user->company_id,
                        'user_id'       => Auth::id(),
                        'ref_id'        => $sa->id,
                        'coa_id'        => $default_product_account->default_inventory_account,
                        'date'          => $request->trans_date,
                        'type'          => 'stock adjustment',
                        'number'        => 'Stock Adjustment #' . $trans_no,
                        'debit'         => 0,
                        'credit'        => abs($total_avg),
                    ]);
                    $transactions->coa_detail()->save($cd);
                    $total_semua        += $total_avg;
                    $avgprice           = $default_product_account->avg_price;

                    // KALAU ACTUAL QTY SAMA DENGAN LEBIH BESAR DARI RECORDED QTY, DIFFERENCE QTY HARUS DIKALIKAN DENGAN AVERAGE PRICE
                } else if ($request->actual_qty[$i] == $request->recorded_qty[$i]) {
                    $cd = new coa_detail([
                        'company_id'    => $user->company_id,
                        'user_id'       => Auth::id(),
                        'ref_id'        => $sa->id,
                        'coa_id'        => $default_product_account->default_inventory_account,
                        'date'          => $request->trans_date,
                        'type'          => 'stock adjustment',
                        'number'        => 'Stock Adjustment #' . $trans_no,
                        'debit'         => 0,
                        'credit'        => 0,
                    ]);
                    $transactions->coa_detail()->save($cd);
                    $total_semua        += $total_avg;
                }
                if ($request->actual_qty[$i] == 0) {
                    $product_avg_price      = (($default_product_account->qty * $default_product_account->avg_price) + ($difference * $request->avg_price[$i]));
                } else {
                    $product_avg_price      = (($default_product_account->qty * $default_product_account->avg_price) + ($difference * $request->avg_price[$i]) / $request->actual_qty[$i]);
                }
                // UPDATE QTY DI PRODUCT
                product::where('id', $request->product[$i])->update([
                    'qty'               => $request->actual_qty[$i],
                    'avg_price'         => $product_avg_price,
                ]);
                //menambahkan stok barang ke gudang / UPDATE QTY DI WAREHOUSES DETAILS
                $wh = new warehouse_detail();
                $wh->type               = 'stock adjustment';
                $wh->number             = 'Stock Adjustment #' . $trans_no;
                $wh->product_id         = $request->product[$i];
                $wh->warehouse_id       = $request->warehouse;
                $wh->date               = $request->trans_date;
                $wh->qty_in             = $request->actual_qty[$i];
                $wh->qty_out            = $request->recorded_qty[$i];
                $wh->save();
            }

            if ($total_semua >= 0) {
                $cd = new coa_detail([
                    'company_id'        => $user->company_id,
                    'user_id'           => Auth::id(),
                    'ref_id'            => $sa->id,
                    'coa_id'            => $request->account,
                    'date'              => $request->trans_date,
                    'type'              => 'stock adjustment',
                    'number'            => 'Stock Adjustment #' . $trans_no,
                    'debit'             => abs($total_semua),
                    'credit'            => 0,
                ]);
                $transactions->coa_detail()->save($cd);
            } else {
                $cd = new coa_detail([
                    'company_id'        => $user->company_id,
                    'user_id'           => Auth::id(),
                    'ref_id'            => $sa->id,
                    'coa_id'            => $request->account,
                    'date'              => $request->trans_date,
                    'type'              => 'stock adjustment',
                    'number'            => 'Stock Adjustment #' . $trans_no,
                    'debit'             => 0,
                    'credit'            => abs($total_semua),
                ]);
                $transactions->coa_detail()->save($cd);
            }

            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $sa->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $header                     = stock_adjustment::find($id);
        $details                    = stock_adjustment_detail::where('stock_adjustment_id', $id)->get();
        $checknumberpd              = stock_adjustment::whereId($id)->first();
        $numbercoadetail            = 'Stock Adjustment #' . $checknumberpd->number;
        //$numberothertransaction     = $checknumberpd->number;
        $get_all_detail             = coa_detail::where('number', $numbercoadetail)->where('type', 'stock adjustment')->with('coa')->get();
        $total_debit                = $get_all_detail->sum('debit');
        $total_credit               = $get_all_detail->sum('credit');

        return view('admin.products.stock_adjustment.show', compact(['header', 'details', 'get_all_detail', 'total_debit', 'total_credit']));
    }

    public function edit($id)
    {

        $products                   = product::where('is_track', 1)->get();
        $accounts                   = coa::get();
        $warehouses                 = warehouse::find($id);
        $warehouse_detail_from2     = warehouse_detail::where('warehouse_id', $id)->groupBy('product_id')->get();
        $warehouse_detail_from      = warehouse_detail::selectRaw('SUM(qty_in - qty_out) as qty, product_id')->groupBy('product_id')->get();
        $today                      = Carbon::today()->toDateString();
        $default_inventory1         = default_account::find(17);
        $default_inventory2         = default_account::find(18);
        $default_inventory3         = default_account::find(19);
        $default_inventory4         = default_account::find(20);

        $adtype                     = $id;
        $adcat                      = $id;


        $header                     = stock_adjustment::find($id);
        $details                    = stock_adjustment_detail::where('stock_adjustment_id', $id)->get();
        $products                   = product::where('is_track', 1)->get();
        $accounts                   = coa::get();
        $warehouses                 = warehouse::/*where('id', '>', 0)->*/get();
        $today                      = Carbon::today()->toDateString();
        $default_inventory1         = default_account::find(17);
        $default_inventory2         = default_account::find(18);
        $default_inventory3         = default_account::find(19);
        $default_inventory4         = default_account::find(20);

        return view(
            'admin.products.stock_adjustment.edit',
            compact([
                'header',
                'details',
                'products',
                'accounts',
                'today',
                'warehouses',
                'default_inventory1',
                'default_inventory2',
                'default_inventory3',
                'default_inventory4',
                'warehouse_detail_from'
            ])
        );
    }

    public function editStockCount($id)
    {
        $header                     = stock_adjustment::find($id);
        $warehouse_detail_from      = warehouse_detail::selectRaw('SUM(qty_in - qty_out) as qty, product_id')->groupBy('product_id')->get();
        $details                    = stock_adjustment_detail::where('stock_adjustment_id', $id)->get();
        $products                   = product::where('is_track', 1)->get();
        $accounts                   = coa::get();
        $warehouses                 = warehouse::/*where('id', '>', 0)->*/get();
        $today                      = Carbon::today()->toDateString();
        $default_inventory1         = default_account::find(17);
        $default_inventory2         = default_account::find(18);
        $default_inventory3         = default_account::find(19);
        $default_inventory4         = default_account::find(20);

        return view(
            'admin.products.stock_adjustment.editStockCount',
            compact([
                'header',
                'details',
                'products',
                'accounts',
                'today',
                'warehouses',
                'default_inventory1',
                'default_inventory2',
                'default_inventory3',
                'default_inventory4',
                'warehouse_detail_from'
            ])
        );
    }

    public function update(Request $request)
    {
        $rules = array(
            'adjustment_category'   => 'required',
            'trans_date'            => 'required',
            'actual_qty'            => 'required|array|min:1',
            'actual_qty.*'          => 'required',
            'difference_qty'        => 'required|array|min:1',
            'difference_qty.*'      => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $id                         = $request->hidden_id;
        $total_semua                = 0;
        $curr_stock_adjustment      = stock_adjustment::find($id);
        $curr_stock_adjustment_d    = stock_adjustment_detail::where('stock_adjustment_id', $curr_stock_adjustment->id)->get();
        $curr_other_transaction     = other_transaction::find($curr_stock_adjustment->other_transaction_id);
        $curr_coa_detail            = coa_detail::where('other_transaction_id', $curr_other_transaction->id)->get();

        //dd($default_sale_account->account_id);
        // CREATE LIST TRANSACTION OF STOCK ADJUSTMENT       

        // SAVE YANG DIATAS SEKALIAN MASUKKIN ID OTHER TRANSACTIONNYA
        foreach ($request->product_id as $i => $keys) {
            // EXECUTE KALAU ACTUAL QTY DI INPUT, JADI KALAU ADA 5 BARANG TAPI CUMA 2 INPUT ACTUAL QTY MAKA CUMA YANG DIINPUT YANG DI EXECUTE
            if ($request->actual_qty[$i]) {
                //menyimpan data untuk detail transaksi per produk pada stock adjustment SEKALIAN MASUKKIN ID STOCK ADJUSTMENT HEADER
                $curr_stock_adjustment_d[$i]->update([
                    'product_id'        => $request->product_id[$i],
                    'recorded'          => $request->recorded_qty[$i],
                    'actual'            => $request->actual_qty[$i],
                    'difference'        => $request->difference_qty[$i],
                    'avg_price'         => $request->avg_price[$i],
                ]);

                // NGAMBIL PRODUCT ID YANG MUNCUL
                $default_product_account = product::find($request->product_id[$i]);
                // KALAU ACTUAL QTY SAMA DENGAN RECORDED QTY TIDAK DIKALIKAN DENGAN AVERAGE PRICE PRODUCT DAN GA MASUK KE COA DETAILS
                if ($request->actual_qty[$i] == $request->recorded_qty[$i]) {
                    $total              = $request->recorded_qty[$i] - $request->actual_qty[$i];
                    $total_avg          = $total * $request->avg_price[$i];
                    //$curr_total_avg     = $curr_stock_adjustment_d[$i]->difference[$i] * $request->avg_price[$i];

                    // COA BERDASARKAN PRODUCT
                    $curr_coa_detail[$i]->update([
                        'coa_id'        => $default_product_account->default_inventory_account,
                        'debit'         => 0,
                        'credit'        => 0,
                    ]);

                    $get_current_coa[$i] = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_coa[$i]->id)->update([
                        'balance'                       => $total_avg,
                    ]);

                    $total_semua        += $total_avg;

                    // KALAU ACTUAL QTY SAMA DENGAN LEBIH BESAR DARI RECORDED QTY, DIFFERENCE QTY HARUS DIKALIKAN DENGAN AVERAGE PRICE
                } else if ($request->actual_qty[$i] >= $request->recorded_qty[$i]) {
                    $total              = $request->recorded_qty[$i] - $request->actual_qty[$i];
                    $total_avg          = $total * $request->avg_price[$i];
                    //$curr_total_avg     = $curr_stock_adjustment_d[$i]->difference[$i] * $request->avg_price[$i];

                    // COA BERDASARKAN PRODUCT
                    $curr_coa_detail[$i]->update([
                        'coa_id'        => $default_product_account->default_inventory_account,
                        'debit'         => abs($total_avg),
                        'credit'        => 0,
                    ]);

                    // UPDATE COA BALANCE BERDASARKAN PRODUCT
                    $get_current_coa[$i] = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_coa[$i]->id)->update([
                        'balance'       => $total_avg,
                    ]);

                    $total_semua        += $total_avg;
                    // KALAU ACTUAL QTY LEBIH KECIL SAMA DENGAN RECORDED QTY, MEREKA BERDUA DI KURANGIN DULU ABIS TU DIKALI AVERAGE PRICE
                } else if ($request->actual_qty[$i] <= $request->recorded_qty[$i]) {
                    $total              = $request->recorded_qty[$i] - $request->actual_qty[$i];
                    $total_avg          = $total * $request->avg_price[$i];
                    //$curr_total_avg     = $curr_stock_adjustment_d[$i]->difference[$i] * $request->avg_price[$i];

                    // COA BERDASARKAN INPUT ACCOUNT
                    $curr_coa_detail[$i]->update([
                        'coa_id'        => $default_product_account->default_inventory_account,
                        'debit'         => 0,
                        'credit'        => abs($total_avg),
                    ]);

                    // UPDATE COA BALANCE BERDASARKAN PRODUCT
                    $get_current_coa[$i] = coa::find($default_product_account->default_inventory_account);
                    coa::find($get_current_coa[$i]->id)->update([
                        'balance'       => $get_current_coa[$i]->balance + $total_avg,
                    ]);

                    $total_semua        += $total_avg;
                }

                // UPDATE QTY DI PRODUCT
                product::where('id', $request->product_id[$i])->update([
                    'qty'           => $request->actual_qty[$i],
                ]);

                //menambahkan stok barang ke gudang / UPDATE QTY DI WAREHOUSES DETAILS
                $wh = warehouse_detail::where('warehouse_id', $request->warehouse)->where('product_id', $request->product_id[$i])->first();
                $wh->warehouse_id   = $request->warehouse;
                $wh->qty            = $request->actual_qty[$i];
                $wh->update();
            }
        };

        if ($total_semua >= 0) {
            // COA BERDASARKAN INPUT ACCOUNT
            $get_current_coa = coa::find($curr_stock_adjustment->coa_id);
            $curr_coa_d_balance     =  coa_detail::where('other_transaction_id', $curr_stock_adjustment->other_transaction_id)->where('coa_id', $curr_stock_adjustment->coa_id)->latest()->first();

            if ($curr_coa_d_balance->debit >= 0 || $curr_coa_d_balance->credit < 0) {
                coa::find($get_current_coa->id)->update([
                    'balance'       => $get_current_coa->balance - $curr_coa_d_balance->debit,
                ]);
            } else {
                coa::find($get_current_coa->id)->update([
                    'balance'       => $get_current_coa->balance - $curr_coa_d_balance->credit,
                ]);
            }

            // COA BERDASARKAN INPUT ACCOUNT
            coa_detail::where('other_transaction_id', $curr_stock_adjustment->other_transaction_id)->where('coa_id', $curr_stock_adjustment->coa_id)->latest()->update([
                'coa_id'        => $request->get('account'),
                'debit'         => abs($total_semua),
                'credit'        => 0,
            ]);

            // UPDATE COA BALANCE BERDASARKAN PRODUCT
            $get_current_coa = coa::find($default_product_account->default_inventory_account);
            coa::find($get_current_coa->id)->update([
                'balance'       => $get_current_coa->balance + $total_semua,
            ]);
        } else {
            // COA BERDASARKAN INPUT ACCOUNT
            $get_current_coa    = coa::find($curr_stock_adjustment->coa_id);
            $curr_coa_d_balance     =  coa_detail::where('other_transaction_id', $curr_stock_adjustment->other_transaction_id)->where('coa_id', $curr_stock_adjustment->coa_id)->latest()->first();;

            if ($curr_coa_d_balance->debit <= 0 || $curr_coa_d_balance->credit > 0) {
                coa::find($get_current_coa->id)->update([
                    'balance'       => $get_current_coa->balance - $curr_coa_d_balance->debit,
                ]);
            } else {
                coa::find($get_current_coa->id)->update([
                    'balance'       => $get_current_coa->balance - $curr_coa_d_balance->credit,
                ]);
            }

            // COA BERDASARKAN INPUT ACCOUNT
            coa_detail::where('other_transaction_id', $curr_stock_adjustment->other_transaction_id)->where('coa_id', $curr_stock_adjustment->coa_id)->latest()->update([
                'coa_id'            => $request->get('account'),
                'debit'             => 0,
                'credit'            => abs($total_semua),
            ]);

            // UPDATE COA BALANCE BERDASARKAN PRODUCT
            $get_current_coa    = coa::find($default_product_account->default_inventory_account);
            coa::find($get_current_coa->id)->update([
                'balance'           => $get_current_coa->balance + $total_semua,
            ]);
        }

        // NGECEK APAKAH STOCK COUNT ATAU STOCK IN / OUT
        if ($request->iCheck == 1) {
            $curr_stock_adjustment->update([
                'stock_type'            => 1,
                'adjustment_type'       => $request->get('adjustment_category'),
                'coa_id'                => $request->get('account'),
                'warehouse_id'          => $request->get('warehouse'),
                'memo'                  => $request->get('memo'),
            ]);
        } else {
            $curr_stock_adjustment->update([
                'stock_type'            => 2,
                'adjustment_type'       => $request->get('adjustment_category'),
                'coa_id'                => $request->get('account'),
                'warehouse_id'          => $request->get('warehouse'),
                'memo'                  => $request->get('memo'),
            ]);
        };
        return response()->json(['success' => 'Data Added Successfully!']);
    }

    public function updateStockCount(Request $request)
    {
        $user                               = User::find(Auth::id());
        $id                                 = $request->hidden_id;
        $sa                                 = stock_adjustment::find($id);
        $sd                                 = stock_adjustment_detail::where('stock_adjustment_id', $id)->get();
        $rules = array(
            'adjustment_category'   => 'required',
            'trans_date'            => 'required',
            'actual_qty'            => 'required|array|min:1',
            'actual_qty.*'          => 'required',
            'product'               => 'required|array|min:1',
            'product.*'             => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        DB::beginTransaction();
        try {
            // uPDATE OTHER TRANSACTION, HANYA MEMO KARENA BALANCE DAN BALANCE DUE -NYA PASTI 0
            $transactions           = other_transaction::where('type', 'stock adjustment')->where('number', $sa->number)->first();
            $transactions->update([
                'memo'              => $request->get('memo'),
            ]);

            // HAPUS BALANCE PER ITEM STOCK ADJUSTMENT
            foreach ($sd as $a) {
                // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                $produk                     = product::find($a->product_id);
                $qty                        = $a->qty;
                //menyimpan jumlah perubahan pada produk
                product::where('id', $a->product_id)->update([
                    'qty'                   => $produk->qty + $qty,
                ]);
            }

            // DELETE COA DETAIL WITH DEBIT = 0
            coa_detail::where('type', 'stock adjustment')->where('number', 'Stock Adjustment #' . $sa->number)->where('debit', 0)->delete();
            coa_detail::where('type', 'stock adjustment')->where('number', 'Stock Adjustment #' . $sa->number)->where('credit', 0)->delete();
            stock_adjustment_detail::where('stock_adjustment_id', $id)->delete();
            warehouse_detail::where('type', 'stock adjustment')
                ->where('number', 'Stock Adjustment #' . $sa->number)
                ->where('warehouse_id', $sa->warehouse_id)
                ->delete();

            $sa->update([
                'user_id'               => Auth::id(),
                'stock_type'            => 1,
                'number'                => $sa->number,
                'adjustment_type'       => $request->get('adjustment_category'),
                'coa_id'                => $request->get('account'),
                'date'                  => $request->get('trans_date'),
                'warehouse_id'          => $request->get('warehouse'),
                'memo'                  => $request->get('memo'),
            ]);

            $total_semua                = 0;
            foreach ($request->product as $i => $keys) {
                $pp[$i]                 = new stock_adjustment_detail([
                    'product_id'        => $request->product[$i],
                    'recorded'          => $request->recorded_qty[$i],
                    'actual'            => $request->actual_qty[$i],
                    'difference'        => $request->actual_qty[$i] - $request->recorded_qty[$i],
                    'avg_price'         => $request->avg_price[$i],
                ]);
                $sa->stock_adjustment_detail()->save($pp[$i]);
                // NGAMBIL PRODUCT ID YANG MUNCUL
                $default_product_account = product::find($request->product[$i]);

                if ($request->actual_qty[$i] > $request->recorded_qty[$i]) {
                    $total              = $request->recorded_qty[$i] - $request->actual_qty[$i];
                    $total_avg          = $total * $request->avg_price[$i];
                    // COA BERDASARKAN PRODUCT
                    $cd = new coa_detail([
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'        => $default_product_account->default_inventory_account,
                        'date'          => $request->get('trans_date'),
                        'type'          => 'stock adjustment',
                        'number'        => 'Stock Adjustment #' . $sa->number,
                        'debit'         => abs($total_avg),
                        'credit'        => 0,
                    ]);
                    $transactions->coa_detail()->save($cd);
                    $total_semua        += $total_avg;
                    // KALAU ACTUAL QTY LEBIH KECIL SAMA DENGAN RECORDED QTY, MEREKA BERDUA DI KURANGIN DULU ABIS TU DIKALI AVERAGE PRICE
                } else if ($request->actual_qty[$i] < $request->recorded_qty[$i]) {
                    $total              = $request->recorded_qty[$i] - $request->actual_qty[$i];
                    $total_avg          = $total * $request->avg_price[$i];
                    // COA BERDASARKAN INPUT ACCOUNT
                    $cd = new coa_detail([
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'        => $default_product_account->default_inventory_account,
                        'date'          => $request->get('trans_date'),
                        'type'          => 'stock adjustment',
                        'number'        => 'Stock Adjustment #' . $sa->number,
                        'debit'         => 0,
                        'credit'        => abs($total_avg),
                    ]);
                    $transactions->coa_detail()->save($cd);

                    $total_semua        += $total_avg;
                } else if ($request->actual_qty[$i] == $request->recorded_qty[$i]) {
                    $total              = $request->recorded_qty[$i] - $request->actual_qty[$i];
                    $total_avg          = $total * $request->avg_price[$i];
                    // COA BERDASARKAN PRODUCT
                    $cd = new coa_detail([
                        'company_id'                    => $user->company_id,
                        'user_id'                       => Auth::id(),
                        'coa_id'        => $default_product_account->default_inventory_account,
                        'date'          => $request->get('trans_date'),
                        'type'          => 'stock adjustment',
                        'number'        => 'Stock Adjustment #' . $sa->number,
                        'debit'         => 0,
                        'credit'        => 0,
                    ]);
                    $transactions->coa_detail()->save($cd);

                    $total_semua        += $total_avg;
                    // KALAU ACTUAL QTY SAMA DENGAN LEBIH BESAR DARI RECORDED QTY, DIFFERENCE QTY HARUS DIKALIKAN DENGAN AVERAGE PRICE
                }

                // UPDATE QTY DI PRODUCT
                product::where('id', $request->product[$i])->update([
                    'qty'           => $request->actual_qty[$i],
                    'avg_price'     => $request->avg_price[$i]
                ]);
                //menambahkan stok barang ke gudang / UPDATE QTY DI WAREHOUSES DETAILS
                $wh = new warehouse_detail();
                $wh->type           = 'stock adjustment';
                $wh->number         = 'Stock Adjustment #' . $sa->number;
                $wh->product_id     = $request->product[$i];
                $wh->warehouse_id   = $request->warehouse;
                $wh->date           = $request->trans_date;
                $wh->qty_in         = $request->actual_qty[$i];
                $wh->qty_out        = $request->recorded_qty[$i];
                $wh->save();
            }

            if ($total_semua >= 0) {
                // COA BERDASARKAN INPUT ACCOUNT
                $cd = new coa_detail([
                    'company_id'                    => $user->company_id,
                    'user_id'                       => Auth::id(),
                    'coa_id'        => $request->get('account'),
                    'date'          => $request->get('trans_date'),
                    'type'          => 'stock adjustment',
                    'number'        => 'Stock Adjustment #' . $sa->number,
                    'debit'         => abs($total_semua),
                    'credit'        => 0,
                ]);
                $transactions->coa_detail()->save($cd);
            } else {
                // COA BERDASARKAN INPUT ACCOUNT
                $cd = new coa_detail([
                    'company_id'                    => $user->company_id,
                    'user_id'                       => Auth::id(),
                    'coa_id'        => $request->get('account'),
                    'date'          => $request->get('trans_date'),
                    'type'          => 'stock adjustment',
                    'number'        => 'Stock Adjustment #' . $sa->number,
                    'debit'         => 0,
                    'credit'        => abs($total_semua),
                ]);
                $transactions->coa_detail()->save($cd);
            }

            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $sa->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroyStockCount($id)
    {
        $sa                                 = stock_adjustment::find($id);
        $sd                                 = stock_adjustment_detail::where('stock_adjustment_id', $id)->get();

        DB::beginTransaction();
        try {
            // uPDATE OTHER TRANSACTION, HANYA MEMO KARENA BALANCE DAN BALANCE DUE -NYA PASTI 0
            $transactions                   = other_transaction::where('type', 'stock adjustment')->where('number', $sa->number)->first();
            $transactions->update([
                'number'                    => $sa->number,
                'number_complete'           => 'Stock Adjustment #' . $sa->number,
                'type'                      => 'stock adjustment',
                'memo'                      => '',
                'status'                    => 2,
                'balance_due'               => 0,
                'total'                     => 0,
            ]);

            // HAPUS BALANCE PER ITEM STOCK ADJUSTMENT
            foreach ($sd as $a) {
                // DELETE WAREHOUSE DETAIL SESUAI DENGAN PRODUCT
                warehouse_detail::where('type', 'stock adjustment')
                    ->where('number', 'Stock Adjustment #' . $sa->number)
                    ->where('product_id', $a->product_id)
                    ->where('warehouse_id', $sa->warehouse_id)
                    ->delete();

                // DELETE QTY PRODUCT DAN KURANGIN AVG PRICE PRODUCT
                $produk                     = product::find($a->product_id);
                $qty                        = $a->difference;

                //menyimpan jumlah perubahan pada produk
                product::where('id', $a->product_id)->update([
                    'qty'                   => $produk->qty + $qty,
                ]);
            }

            // DELETE COA DETAIL WITH DEBIT = 0
            coa_detail::where('type', 'stock adjustment')->where('number', 'Stock Adjustment #' . $sa->number)->delete();
            stock_adjustment_detail::where('stock_adjustment_id', $id)->delete();
            $sa->delete();

            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted', 'id' => $sa->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }
}
