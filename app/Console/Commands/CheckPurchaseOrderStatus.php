<?php

namespace App\Console\Commands;

use App\purchase_order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckPurchaseOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:purchase_order:status';

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
        $date = Carbon::now();
        $orders = purchase_order::where('status', '<>', 2)->whereDate('due_date', '<',$date)->get();

        foreach ($orders as $order) {
            $order->status = 5;
            printf("Order %s is OVERDUE \n", $order->number);
            $order->save();
        }
    }
}
