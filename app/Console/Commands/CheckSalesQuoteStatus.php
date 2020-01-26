<?php

namespace App\Console\Commands;

use App\sale_quote;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckSalesQuoteStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:sales_quote:status';

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
        $quotes = sale_quote::where('status', '<>', 2)->whereDate('due_date', '<',$date)->get();

        foreach ($quotes as $quote) {
            $quote->status = 5;
            printf("Quote %s is OVERDUE \n", $quote->number);
            $quote->save();
        }
    }
}
