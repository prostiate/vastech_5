<?php

namespace App\Observers;

use App\sale_return;

class sale_return_observer
{
    /**
     * Handle the sale_return "creating" event.
     *
     * @param  \App\sale_return  $saleReturn
     * @return void
     */
    public function creating(sale_return $saleReturn)
    {
        if ($saleReturn->due_date < Carbon::today()->toDateString()) {
            $saleReturn->status = 5;
            other_transaction::where('type', 'sales return')
                ->where('number', $saleReturn->number)
                ->where('number_complete', 'Sales Return #' . $saleReturn->number)->update([
                    'status'    => 5
                ]);
        } else {
            $saleReturn->status = 1;
            other_transaction::where('type', 'sales return')
                ->where('number', $saleReturn->number)
                ->where('number_complete', 'Sales Return #' . $saleReturn->number)->update([
                    'status'    => 1
                ]);
        }
    }

    /**
     * Handle the sale_return "created" event.
     *
     * @param  \App\sale_return  $saleReturn
     * @return void
     */
    public function created(sale_return $saleReturn)
    {
        //
    }

    /**
     * Handle the sale_return "updated" event.
     *
     * @param  \App\sale_return  $saleReturn
     * @return void
     */
    public function updated(sale_return $saleReturn)
    {
        //
    }

    /**
     * Handle the sale_return "deleted" event.
     *
     * @param  \App\sale_return  $saleReturn
     * @return void
     */
    public function deleted(sale_return $saleReturn)
    {
        //
    }

    /**
     * Handle the sale_return "restored" event.
     *
     * @param  \App\sale_return  $saleReturn
     * @return void
     */
    public function restored(sale_return $saleReturn)
    {
        //
    }

    /**
     * Handle the sale_return "force deleted" event.
     *
     * @param  \App\sale_return  $saleReturn
     * @return void
     */
    public function forceDeleted(sale_return $saleReturn)
    {
        //
    }
}
