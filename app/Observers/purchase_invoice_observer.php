<?php

namespace App\Observers;

use App\purchase_invoice;
use App\other_transaction;
use Carbon\Carbon;

class purchase_invoice_observer
{
    /**
     * Handle the purchase_invoice "saving" event.
     *
     * @param  \App\purchase_invoice  $purchaseInvoice
     * @return void
     */
    public function saving(purchase_invoice $purchaseInvoice)
    {
        if ($purchaseInvoice->due_date < Carbon::today()->toDateString()) {
            $purchaseInvoice->status = 5;
            other_transaction::where('type', 'purchase invoice')
                ->where('number', $purchaseInvoice->number)
                ->where('number_complete', 'Purchase Invoice #' . $purchaseInvoice->number)->update([
                    'status'    => 5
                ]);
        } else {
            $purchaseInvoice->status = 1;
            other_transaction::where('type', 'purchase invoice')
                ->where('number', $purchaseInvoice->number)
                ->where('number_complete', 'Purchase Invoice #' . $purchaseInvoice->number)->update([
                    'status'    => 1
                ]);
        }
    }

    /**
     * Handle the purchase_invoice "created" event.
     *
     * @param  \App\purchase_invoice  $purchaseInvoice
     * @return void
     */
    public function created(purchase_invoice $purchaseInvoice)
    {
        //
    }

    /**
     * Handle the purchase_invoice "updated" event.
     *
     * @param  \App\purchase_invoice  $purchaseInvoice
     * @return void
     */
    public function updated(purchase_invoice $purchaseInvoice)
    {
        //
    }

    /**
     * Handle the purchase_invoice "deleted" event.
     *
     * @param  \App\purchase_invoice  $purchaseInvoice
     * @return void
     */
    public function deleted(purchase_invoice $purchaseInvoice)
    {
        //
    }

    /**
     * Handle the purchase_invoice "restored" event.
     *
     * @param  \App\purchase_invoice  $purchaseInvoice
     * @return void
     */
    public function restored(purchase_invoice $purchaseInvoice)
    {
        //
    }

    /**
     * Handle the purchase_invoice "force deleted" event.
     *
     * @param  \App\purchase_invoice  $purchaseInvoice
     * @return void
     */
    public function forceDeleted(purchase_invoice $purchaseInvoice)
    {
        //
    }
}
