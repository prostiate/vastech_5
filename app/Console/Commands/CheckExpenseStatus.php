<?php

namespace App\Console\Commands;

use App\expense;
use App\other_transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckExpenseStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:expense:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date               = Carbon::today()->toDateString();
        $header             = expense::where('due_date', '!=', 'null')->whereIn('status', [1])->whereDate('due_date', '<', $date)->get();
        $other_transactions = other_transaction::where('type', 'expense')->where('due_date', '!=', 'null')->whereIn('status', [1])->whereDate('due_date', '<', $date)->get();

        foreach ($header as $h) {
            $h->status = 5;
            printf("Expense %s is OVERDUE \n", $h->number);
            $h->save();
        }
        foreach ($other_transactions as $ot) {
            $ot->status = 5;
            printf("Other Transaction %s is OVERDUE \n", $ot->number_complete);
            $ot->save();
        }
    }
}
