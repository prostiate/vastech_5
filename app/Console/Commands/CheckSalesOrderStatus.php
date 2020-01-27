<?php

namespace App\Console\Commands;

use App\sale_order;
use App\other_transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckSalesOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:sales_order:status';

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
        $date               = Carbon::now();
        $header             = sale_order::where('status', '<>', 2)->whereDate('due_date', '<',$date)->get();
        $other_transactions = other_transaction::where('type', 'sales order')->where('status', '<>', 2)->whereDate('due_date', '<', $date)->get();

        foreach ($header as $h) {
            $h->status = 5;
            printf("Order %s is OVERDUE \n", $h->number);
            $h->save();
        }
        foreach ($other_transactions as $ot) {
            $ot->status = 5;
            printf("Other Transaction %s is OVERDUE \n", $ot->number);
            $ot->save();
        }
    }
}
