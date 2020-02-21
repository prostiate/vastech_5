<?php

namespace App\Observers;

use App\closing_book;
use App\sale_order;
use App\other_transaction;
use Carbon\Carbon;

class sale_order_observer
{
    /**
     * Handle the sale_order "creating" event.
     *
     * @param  \App\sale_order  $saleOrder
     * @return void
     */
    public function creating(sale_order $saleOrder)
    {
        if ($saleOrder->due_date < Carbon::today()->toDateString()) {
            $saleOrder->status = 5;
            other_transaction::where('type', 'sales order')
                ->where('number', $saleOrder->number)
                ->where('number_complete', 'Sales Order #' . $saleOrder->number)->update([
                    'status'    => 5
                ]);
        } else {
            $saleOrder->status = 1;
            other_transaction::where('type', 'sales order')
                ->where('number', $saleOrder->number)
                ->where('number_complete', 'Sales Order #' . $saleOrder->number)->update([
                    'status'    => 1
                ]);
        }
    }

    /**
     * Handle the sale_order "created" event.
     *
     * @param  \App\sale_order  $saleOrder
     * @return void
     */
    public function created(sale_order $saleOrder)
    {
        //
    }

    /**
     * Handle the sale_order "updated" event.
     *
     * @param  \App\sale_order  $saleOrder
     * @return void
     */
    public function updated(sale_order $saleOrder)
    {
        //
    }

    /**
     * Handle the sale_order "deleted" event.
     *
     * @param  \App\sale_order  $saleOrder
     * @return void
     */
    public function deleted(sale_order $saleOrder)
    {
        //
    }

    /**
     * Handle the sale_order "restored" event.
     *
     * @param  \App\sale_order  $saleOrder
     * @return void
     */
    public function restored(sale_order $saleOrder)
    {
        //
    }

    /**
     * Handle the sale_order "force deleted" event.
     *
     * @param  \App\sale_order  $saleOrder
     * @return void
     */
    public function forceDeleted(sale_order $saleOrder)
    {
        //
    }
}
