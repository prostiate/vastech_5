<?php

namespace App\Console\Commands;

use App\expense;
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
        $date = Carbon::now();
        $expenses = expense::where('status', '<>', 3)->whereDate('due_date', '<',$date)->get();

        foreach ($expenses as $expense) {
            $expense->status = 5;
            printf("Expense %s is OVERDUE \n", $expense->number);
            $expense->save();
        }
    }
}
