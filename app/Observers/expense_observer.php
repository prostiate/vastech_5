<?php

namespace App\Observers;

use App\Model\expense\expense;
use App\Model\other\other_transaction;
use Carbon\Carbon;

class expense_observer
{
    /**
     * Handle the expense "creating" event.
     *
     * @param  \App\Model\expense\expense  $expense
     * @return void
     */
    public function creating(expense $expense)
    {
        if ($expense->due_date != null) {
            if ($expense->due_date < Carbon::today()->toDateString()) {
                $expense->status = 5;
                other_transaction::where('type', 'expense')
                    ->where('number', $expense->number)
                    ->where('number_complete', 'Expense #' . $expense->number)->update([
                        'status'    => 5
                    ]);
            } else {
                $expense->status = 1;
                other_transaction::where('type', 'expense')
                    ->where('number', $expense->number)
                    ->where('number_complete', 'Expense #' . $expense->number)->update([
                        'status'    => 1
                    ]);
            }
        }
    }

    /**
     * Handle the expense "created" event.
     *
     * @param  \App\Model\expense\expense  $expense
     * @return void
     */
    public function created(expense $expense)
    {
        //
    }

    /**
     * Handle the expense "updated" event.
     *
     * @param  \App\Model\expense\expense  $expense
     * @return void
     */
    public function updated(expense $expense)
    {
        //
    }

    /**
     * Handle the expense "deleted" event.
     *
     * @param  \App\Model\expense\expense  $expense
     * @return void
     */
    public function deleted(expense $expense)
    {
        //
    }

    /**
     * Handle the expense "restored" event.
     *
     * @param  \App\Model\expense\expense  $expense
     * @return void
     */
    public function restored(expense $expense)
    {
        //
    }

    /**
     * Handle the expense "force deleted" event.
     *
     * @param  \App\Model\expense\expense  $expense
     * @return void
     */
    public function forceDeleted(expense $expense)
    {
        //
    }
}
