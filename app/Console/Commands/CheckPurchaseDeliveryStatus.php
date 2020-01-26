<?php

namespace App\Console\Commands;

use App\purchase_delivery;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckPurchaseDeliveryStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:purchase_delivery:status';

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
        $deliveries = purchase_delivery::where('status', '<>', 2)->whereDate('due_date', '<',$date)->get();

        foreach ($deliveries as $delivery) {
            $delivery->status = 5;
            printf("Delivery %s is OVERDUE \n", $delivery->number);
            $delivery->save();
        }
    }
}
