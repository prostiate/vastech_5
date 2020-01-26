<?php

namespace App\Console\Commands;

use App\sale_payment;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckSalesPaymentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:sales_payment:status';

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
        $payments = sale_payment::where('status', '<>', 2)->whereDate('due_date', '<',$date)->get();

        foreach ($payments as $payment) {
            $payment->status = 5;
            printf("Order %s is OVERDUE \n", $payment->number);
            $payment->save();
        }
    }
}
