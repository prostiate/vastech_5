<?php

namespace App\Observers;

use App\sale_quote;
use App\other_transaction;
use Carbon\Carbon;

class sale_quote_observer
{
    /**
     * Handle the sale_quote "saving" event.
     *
     * @param  \App\sale_quote  $saleQuote
     * @return void
     */
    public function saving(sale_quote $saleQuote)
    {
        if ($saleQuote->due_date < Carbon::today()->toDateString()) {
            $saleQuote->status = 5;
            other_transaction::where('type', 'sales quote')
                ->where('number', $saleQuote->number)
                ->where('number_complete', 'Sales Quote #' . $saleQuote->number)->update([
                    'status'    => 5
                ]);
        } else {
            $saleQuote->status = 1;
            other_transaction::where('type', 'sales quote')
                ->where('number', $saleQuote->number)
                ->where('number_complete', 'Sales Quote #' . $saleQuote->number)->update([
                    'status'    => 1
                ]);
        }
    }

    /**
     * Handle the sale_quote "created" event.
     *
     * @param  \App\sale_quote  $saleQuote
     * @return void
     */
    public function created(sale_quote $saleQuote)
    {
        //
    }

    /**
     * Handle the sale_quote "updated" event.
     *
     * @param  \App\sale_quote  $saleQuote
     * @return void
     */
    public function updated(sale_quote $saleQuote)
    {
        //
    }

    /**
     * Handle the sale_quote "deleted" event.
     *
     * @param  \App\sale_quote  $saleQuote
     * @return void
     */
    public function deleted(sale_quote $saleQuote)
    {
        //
    }

    /**
     * Handle the sale_quote "restored" event.
     *
     * @param  \App\sale_quote  $saleQuote
     * @return void
     */
    public function restored(sale_quote $saleQuote)
    {
        //
    }

    /**
     * Handle the sale_quote "force deleted" event.
     *
     * @param  \App\sale_quote  $saleQuote
     * @return void
     */
    public function forceDeleted(sale_quote $saleQuote)
    {
        //
    }
}
