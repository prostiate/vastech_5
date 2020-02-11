<?php

namespace App\Observers;

use App\sale_invoice;
use App\other_transaction;
use Carbon\Carbon;

class sale_invoice_observer
{
    /**
     * Handle the sale_invoice "creating" event.
     *
     * @param  \App\sale_invoice  $saleInvoice
     * @return void
     */
    public function creating(sale_invoice $saleInvoice)
    {
        if ($saleInvoice->due_date < Carbon::today()->toDateString()) {
            $saleInvoice->status = 5;
            other_transaction::where('type', 'sales invoice')
                ->where('number', $saleInvoice->number)
                ->where('number_complete', 'Sales Invoice #' . $saleInvoice->number)
                ->where('balance_due', $saleInvoice->grandtotal)
                ->update([
                    'status'    => 5
                ]);
        } else {
            $saleInvoice->status = 1;
            other_transaction::where('type', 'sales invoice')
                ->where('number', $saleInvoice->number)
                ->where('number_complete', 'Sales Invoice #' . $saleInvoice->number)
                ->where('balance_due', $saleInvoice->grandtotal)
                ->update([
                    'status'    => 1
                ]);
        }
    }

    /**
     * Handle the sale_invoice "created" event.
     *
     * @param  \App\sale_invoice  $saleInvoice
     * @return void
     */
    public function created(sale_invoice $saleInvoice)
    {
        //
    }

    /**
     * Handle the sale_invoice "updated" event.
     *
     * @param  \App\sale_invoice  $saleInvoice
     * @return void
     */
    public function updated(sale_invoice $saleInvoice)
    {
        //
    }

    /**
     * Handle the sale_invoice "deleted" event.
     *
     * @param  \App\sale_invoice  $saleInvoice
     * @return void
     */
    public function deleted(sale_invoice $saleInvoice)
    {
        //
    }

    /**
     * Handle the sale_invoice "restored" event.
     *
     * @param  \App\sale_invoice  $saleInvoice
     * @return void
     */
    public function restored(sale_invoice $saleInvoice)
    {
        //
    }

    /**
     * Handle the sale_invoice "force deleted" event.
     *
     * @param  \App\sale_invoice  $saleInvoice
     * @return void
     */
    public function forceDeleted(sale_invoice $saleInvoice)
    {
        //
    }
}
