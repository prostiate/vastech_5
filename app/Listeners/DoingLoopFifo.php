<?php

namespace App\Listeners;

use App\Model\coa\coa_detail;
use App\Model\product\product;
use App\Model\product\product_fifo_in;
use App\Model\product\product_fifo_out;
use App\Model\purchase\purchase_invoice;
use App\Model\sales\sale_invoice;
use App\Model\stock_adjustment\stock_adjustment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class DoingLoopFifo implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        DB::beginTransaction();
        try {
            $get_purchase_invoice       = purchase_invoice::with('purchase_invoice_item')->get()->sortBy(function ($header) {
                return $header->transaction_date;
            });
            $get_sale_invoice           = sale_invoice::with('sale_invoice_item')->get()->sortBy(function ($header) {
                return $header->transaction_date;
            });
            $get_product                = product::get();
            // UPDATE PRODUCT QTY BASED ON STOCK ADJUSTMENT
            $get_stock_adjustment       = stock_adjustment::with('stock_adjustment_detail')->get()->sortBy(function ($header) {
                return $header->date;
            });
            product::where('id', '>', 0)->update(['qty' => 0, 'avg_price' => 0]);
            product_fifo_in::query()->truncate();
            product_fifo_out::query()->truncate();
            foreach ($get_stock_adjustment as $key_gsa => $gsa) {
                echo '<pre><strong>stock adjustment tanggal: ', var_dump($gsa->date), '</strong></pre>';
                foreach ($gsa->stock_adjustment_detail as $key_gsad => $gsad) {
                    foreach ($get_product as $key_gp2 => $gp2) {
                        if ($gp2->id == $gsad->product_id) {
                            echo '<pre><strong>qty_sebelum: ', var_dump($gp2->qty), '</strong></pre>';
                            $gp2->update([
                                'qty'                   => $gsad->actual
                            ]);
                            $create_product_fifo_in = new product_fifo_in([
                                //'purchase_invoice_item_id'    => 1, // ID SI PURCHASE INVOICE ITEM
                                'type'          => 'stock adjustment',
                                'number'        => $gsa->number,
                                'product_id'    => $gsad->product_id,
                                'warehouse_id'  => $gsa->warehouse_id,
                                'qty'           => $gsad->actual,
                                'unit_price'    => 0,
                                'total_price'   => 0,
                                'date'          => $gsa->date,
                            ]);
                            $create_product_fifo_in->save();
                            echo '<pre><strong>qty_sesudah: ', var_dump($gp2->qty), '</strong></pre>';
                        }
                    }
                }
            }
            foreach ($get_purchase_invoice as $key_gpi => $gpi) {
                foreach ($gpi->purchase_invoice_item as $key_gpii => $gpii) {
                    foreach ($get_product as $key_gp => $gp) {
                        if ($gp->id == $gpii->product_id) {
                            $gp->update([
                                'qty'                   => $gp->qty + $gpii->qty,
                                'avg_price'             => abs($gpii->unit_price),
                                'last_buy_price'        => abs($gpii->unit_price),
                            ]);
                            $create_product_fifo_in = new product_fifo_in([
                                'purchase_invoice_item_id'    => $gpii->id, // ID SI PURCHASE INVOICE ITEM
                                'type'          => 'purchase invoice',
                                'number'        => $gpi->number,
                                'product_id'    => $gpii->product_id,
                                'warehouse_id'  => $gpi->warehouse_id,
                                'qty'           => $gpii->qty,
                                'unit_price'    => $gpii->unit_price,
                                'total_price'   => $gpii->amount,
                                'date'          => $gpi->transaction_date,
                            ]);
                            $create_product_fifo_in->save();
                        }
                    }
                }
            }
            foreach ($get_sale_invoice as $key_gsi => $gsi) {
                foreach ($gsi->sale_invoice_item as $key_gsii => $gsii) {
                    foreach ($get_product as $key_gp => $gp) { // PRODUCT PUNYA TABLE
                        if ($gp->id == $gsii->product_id) {
                            $gp->update([
                                'qty'                   => $gp->qty - $gsii->qty,
                            ]);
                            $create_product_fifo_out    = new product_fifo_out([
                                'sale_invoice_item_id'  => $gsii->id, // ID SI SALES INVOICE ITEM
                                'type'                  => 'sales invoice',
                                'number'                => $gsi->number,
                                'product_id'            => $gsii->product_id,
                                'warehouse_id'          => $gsi->warehouse_id,
                                'qty'                   => $gsii->qty,
                                'unit_price'            => $gsii->unit_price,
                                'total_price'           => $gsii->amount,
                                'date'                  => $gsi->transaction_date,
                            ]);
                            $create_product_fifo_out->save(); // SAVE FIFO OUT
                            $get_product_fifo_in        = product_fifo_in::where('product_id', $gsii->product_id)->where('qty', '>', 0)
                                ->get()->sortBy(function ($item) { // GET FIFO IN AND SORT BY TRANSACTION DATE HEADER
                                    return $item->transaction_date;
                                });
                            $ambil_qty_fifo_out         = $gsii->qty;
                            $qty_pool                   = collect([]);
                            foreach ($get_product_fifo_in as $key_gpfi => $gpfi) {
                                $deducted_qty           = $ambil_qty_fifo_out - $gpfi->qty;
                                //dd($deducted_qty);
                                $next                   = isset($get_product_fifo_in[$key_gpfi + 1]);
                                if ($deducted_qty >= 0) {
                                    if ($next) {
                                        $qty_pool->push([
                                            'qty' => $gpfi->qty,
                                            'unit_price' => $gpfi->unit_price,
                                            'product_id' => $gpfi->product_id,
                                            'gpfi_id' => $gpfi->id
                                        ]);
                                        $ambil_qty_fifo_out -= $gpfi->qty;
                                        $gpfi->update([
                                            'qty' => 0
                                        ]);
                                    } else {
                                        $qty_pool->push([
                                            'qty' => $ambil_qty_fifo_out,
                                            'unit_price' => $gpfi->unit_price,
                                            'product_id' => $gpfi->product_id,
                                            'gpfi_id' => $gpfi->id
                                        ]);
                                        $gpfi->update([
                                            'qty' => 0
                                        ]);
                                        break;
                                    }
                                } else {
                                    $gpfi->update([
                                        'qty' => abs($deducted_qty)
                                    ]);
                                    $qty_pool->push([
                                        'qty' => $ambil_qty_fifo_out,
                                        'unit_price' => $gpfi->unit_price,
                                        'product_id' => $gpfi->product_id,
                                        'gpfi_id' => $gpfi->id
                                    ]);
                                    break;
                                }
                            }
                            $total_sum_qty_pool         = 0;
                            foreach ($qty_pool as $key_qp => $qp) {
                                $total_sum_qty_pool     += $qp['qty'] * $qp['unit_price'];
                            }
                            $coa_detail_debit           = coa_detail::where('type', 'sales invoice')
                                ->where('number', 'Sales Invoice #' . $gsi->number)->where('debit', 0)->where('coa_id', 7)->get();
                            foreach ($coa_detail_debit as $key_cdb => $cdb) {
                                if ($key_gsii == $key_cdb) {
                                    $cdb->update(['credit' => $total_sum_qty_pool]);
                                }
                            }
                            $coa_detail_credit      = coa_detail::where('type', 'sales invoice')
                                ->where('number', 'Sales Invoice #' . $gsi->number)->where('credit', 0)->where('coa_id', 69)->get();
                            foreach ($coa_detail_credit as $key_cdc => $cdc) {
                                if ($key_gsii == $key_cdc) {
                                    $cdc->update(['debit' => $total_sum_qty_pool]);
                                }
                            }
                        }
                    }
                }
            }
            DB::commit();
            return response()->json(['fifo_success' => 'fifo_berhasil']);
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
