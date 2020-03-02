<?php

namespace App\Observers;

use App\Model\purchase\purchase_return;
use App\Model\other\other_transaction;
use Carbon\Carbon;

class purchase_return_observer
{
    /**
     * Handle the purchase_return "creating" event.
     *
     * @param  \App\Model\purchase\purchase_return  $purchaseReturn
     * @return void
     */
    public function creating(purchase_return $purchaseReturn)
    {
        if ($purchaseReturn->due_date < Carbon::today()->toDateString()) {
            $purchaseReturn->status = 5;
            other_transaction::where('type', 'purchase return')
                ->where('number', $purchaseReturn->number)
                ->where('number_complete', 'Purchase Return #' . $purchaseReturn->number)->update([
                    'status'    => 5
                ]);
        } else {
            $purchaseReturn->status = 1;
            other_transaction::where('type', 'purchase return')
                ->where('number', $purchaseReturn->number)
                ->where('number_complete', 'Purchase Return #' . $purchaseReturn->number)->update([
                    'status'    => 1
                ]);
        }
    }

    /**
     * Handle the purchase_return "created" event.
     *
     * @param  \App\Model\purchase\purchase_return  $purchaseReturn
     * @return void
     */
    public function created(purchase_return $purchaseReturn)
    {
        //
    }

    /**
     * Handle the purchase_return "updated" event.
     *
     * @param  \App\Model\purchase\purchase_return  $purchaseReturn
     * @return void
     */
    public function updated(purchase_return $purchaseReturn)
    {
        //
    }

    /**
     * Handle the purchase_return "deleted" event.
     *
     * @param  \App\Model\purchase\purchase_return  $purchaseReturn
     * @return void
     */
    public function deleted(purchase_return $purchaseReturn)
    {
        //
    }

    /**
     * Handle the purchase_return "restored" event.
     *
     * @param  \App\Model\purchase\purchase_return  $purchaseReturn
     * @return void
     */
    public function restored(purchase_return $purchaseReturn)
    {
        //
    }

    /**
     * Handle the purchase_return "force deleted" event.
     *
     * @param  \App\Model\purchase\purchase_return  $purchaseReturn
     * @return void
     */
    public function forceDeleted(purchase_return $purchaseReturn)
    {
        //
    }
}
