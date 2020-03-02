<?php

namespace App\Observers;

use App\Model\purchase\purchase_order;
use App\Model\other\other_transaction;
use Carbon\Carbon;

class purchase_order_observer
{
    /**
     * Handle the purchase_order "creating" event.
     *
     * @param  \App\Model\purchase\purchase_order  $purchaseOrder
     * @return void
     */
    public function creating(purchase_order $purchaseOrder)
    {
        if ($purchaseOrder->due_date < Carbon::today()->toDateString()) {
            $purchaseOrder->status = 5;
            other_transaction::where('type', 'purchase order')
                ->where('number', $purchaseOrder->number)
                ->where('number_complete', 'Purchase Order #' . $purchaseOrder->number)->update([
                    'status'    => 5
                ]);
        } else {
            $purchaseOrder->status = 1;
            other_transaction::where('type', 'purchase order')
                ->where('number', $purchaseOrder->number)
                ->where('number_complete', 'Purchase Order #' . $purchaseOrder->number)->update([
                    'status'    => 1
                ]);
        }
    }

    /**
     * Handle the purchase_order "created" event.
     *
     * @param  \App\Model\purchase\purchase_order  $purchaseOrder
     * @return void
     */
    public function created(purchase_order $purchaseOrder)
    {
        //
    }

    /**
     * Handle the purchase_order "updated" event.
     *
     * @param  \App\Model\purchase\purchase_order  $purchaseOrder
     * @return void
     */
    public function updated(purchase_order $purchaseOrder)
    {
        //
    }

    /**
     * Handle the purchase_order "deleted" event.
     *
     * @param  \App\Model\purchase\purchase_order  $purchaseOrder
     * @return void
     */
    public function deleted(purchase_order $purchaseOrder)
    {
        //
    }

    /**
     * Handle the purchase_order "restored" event.
     *
     * @param  \App\Model\purchase\purchase_order  $purchaseOrder
     * @return void
     */
    public function restored(purchase_order $purchaseOrder)
    {
        //
    }

    /**
     * Handle the purchase_order "force deleted" event.
     *
     * @param  \App\Model\purchase\purchase_order  $purchaseOrder
     * @return void
     */
    public function forceDeleted(purchase_order $purchaseOrder)
    {
        //
    }
}
