<?php

namespace App\Console\Commands;

use App\purchase_invoice;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckPurchaseInvoiceStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:purchase_invoice:status';

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
        $invoices = purchase_invoice::where('status', '<>', 2)->whereDate('due_date', '<',$date)->get();

        foreach ($invoices as $invoice) {
            $invoice->status = 5;
            printf("Invoice %s is OVERDUE \n", $invoice->number);
            $invoice->save();
        }
    }
}
