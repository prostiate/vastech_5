<?php

namespace App\Observers;

use App\Model\purchase\purchase_quote;
use App\Model\other\other_transaction;
use Carbon\Carbon;

class purchase_quote_observer
{
    /**
     * Handle the purchase_quote "creating" event.
     *
     * @param  \App\Model\purchase\purchase_quote  $purchaseQuote
     * @return void
     */
    public function creating(purchase_quote $purchaseQuote)
    {
        if ($purchaseQuote->due_date < Carbon::today()->toDateString()) {
            $purchaseQuote->status = 5;
            other_transaction::where('type', 'purchase quote')
                ->where('number', $purchaseQuote->number)
                ->where('number_complete', 'Purchase Quote #' . $purchaseQuote->number)->update([
                    'status'    => 5
                ]);
        } else {
            $purchaseQuote->status = 1;
            other_transaction::where('type', 'purchase quote')
                ->where('number', $purchaseQuote->number)
                ->where('number_complete', 'Purchase Quote #' . $purchaseQuote->number)->update([
                    'status'    => 1
                ]);
        }
    }

    /**
     * Handle the purchase_quote "created" event.
     *
     * @param  \App\Model\purchase\purchase_quote  $purchaseQuote
     * @return void
     */
    public function created(purchase_quote $purchaseQuote)
    {
        //
    }

    /**
     * Handle the purchase_quote "updated" event.
     *
     * @param  \App\Model\purchase\purchase_quote  $purchaseQuote
     * @return void
     */
    public function updated(purchase_quote $purchaseQuote)
    {
        //
    }

    /**
     * Handle the purchase_quote "deleted" event.
     *
     * @param  \App\Model\purchase\purchase_quote  $purchaseQuote
     * @return void
     */
    public function deleted(purchase_quote $purchaseQuote)
    {
        //
    }

    /**
     * Handle the purchase_quote "restored" event.
     *
     * @param  \App\Model\purchase\purchase_quote  $purchaseQuote
     * @return void
     */
    public function restored(purchase_quote $purchaseQuote)
    {
        //
    }

    /**
     * Handle the purchase_quote "force deleted" event.
     *
     * @param  \App\Model\purchase\purchase_quote  $purchaseQuote
     * @return void
     */
    public function forceDeleted(purchase_quote $purchaseQuote)
    {
        //
    }
}
