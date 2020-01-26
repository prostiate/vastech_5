<?php

namespace App\Console\Commands;

use App\asset;
use App\asset_detail;
use App\User;
use App\coa;
use App\coa_detail;
use App\other_transaction;
use App\journal_entry;
use App\journal_entry_item;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class CheckDepreciateStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:depreciate';

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
        $today                                  = Carbon::today()->toDateString();
        $user                                   = User::find(1);
        $assets                                 = asset::where('is_depreciable', 1)->where('actual_cost', '>', 0)->get();       

        try {
            foreach ($assets as $i => $a) {            
                $this->info($a);

                if ($user->company_id == 5) {
                    $number             = journal_entry::latest()->first();
                    if ($number != null) {
                        $misahm             = explode("/", $number->number);
                        $misahy             = explode(".", $misahm[1]);
                    }
                    if (isset($misahy[1]) == 0) {
                        $misahy[1]      = 10000;
                    }
                    $number1                    = $misahy[1] + 1;
                    $trans_no                   = now()->format('m') . '/' . now()->format('y') . '.' . $number1;
                } else {
                    $number             = journal_entry::max('number');
                    if ($number == 0)
                        $number = 10000;
                    $trans_no = $number + 1;
                }
                $this->info($trans_no);

                $d[$i]                                  = asset_detail::where('asset_id', $a->id)->first();
                $d[$i]->update([
                    'accumulated_depreciate'            => $d[$i]->accumulated_depreciate + ($a->cost / ($d[$i]->life * 12))
                ]);
                $this->info($d[$i]);

                $depreciate                         = $a->cost / ($d[$i]->life * 12);
                $a->actual_cost                     = $a->actual_cost - $depreciate;
                $a->save();

                $transactions           = other_transaction::create([
                    'company_id'        => $user->company_id,
                    'user_id'           => Auth::id(),
                    'transaction_date'  => $today,
                    'number'            => $trans_no,
                    'number_complete'   => 'Journal Entry #' . $trans_no,
                    'type'              => 'journal',
                    'status'            => 2,
                    'balance_due'       => 0,
                    'total'             => 0,
                ]);

                $cd1 = new coa_detail([
                    'company_id'                    => $user->company_id,
                    'user_id'                       => Auth::id(),
                    'coa_id'                    => $d[$i]->depreciate_account,
                    'date'                      => $today,
                    'type'                      => 'journal',
                    'number'                    => 'Journal Entry #' . $trans_no,
                    'debit'                     => $depreciate,
                    'credit'                    => 0,
                ]);
                $transactions->coa_detail()->save($cd1);

                $cd2 = new coa_detail([
                    'company_id'                    => $user->company_id,
                    'user_id'                       => Auth::id(),
                    'coa_id'                    => $d[$i]->accumulated_depreciate_account,
                    'date'                      => $today,
                    'type'                      => 'journal',
                    'number'                    => 'Journal Entry #' . $trans_no,
                    'debit'                     => 0,
                    'credit'                    => $depreciate,
                ]);
                $transactions->coa_detail()->save($cd2);

                $je = journal_entry::create([
                    'company_id'                    => $user->company_id,
                    'user_id'                       => Auth::id(),
                    'ref_id'                        => $a->id,
                    'other_transaction_id'          => $transactions->id,
                    'number'                    => 'Journal Entry #' . $trans_no,
                    'transaction_date'          => $today,
                    'status'                    => 2,
                    'total_debit'               => $depreciate,
                    'total_credit'              => $depreciate,
                ]);

                $jei1 = new journal_entry_item([
                    'coa_id'                   => $d[$i]->depreciate_account,
                    'debit'                    => $depreciate,
                ]);
                $je->journal_entry_item()->save($jei1);

                $jei2 = new journal_entry_item([
                    'coa_id'                   => $d[$i]->accumulated_depreciate_account,
                    'credit'                   => $depreciate,
                ]);
                $je->journal_entry_item()->save($jei2);

                $this->info("berhasil gan");
            }
        } catch (\Exception $e) {
            $this->info($e->getMessage());
        }
    }
}
