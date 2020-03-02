<?php

namespace App\Console\Commands;

use App\Model\product\product;
use App\Model\purchase\purchase_invoice;
use App\Model\purchase\purchase_invoice_item;
use App\Model\sales\sale_invoice;
use App\Model\sales\sale_invoice_item;
use Carbon\Carbon;
use Illuminate\Console\Command;

class benerin_avg_price extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'benerin_avg_price';

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
        $ambil_semua_product                = product::get();
        foreach ($ambil_semua_product as $asp) {
            $ambil_pi_item                  = purchase_invoice_item::where('product_id', $asp->id)->get();
            $ambil_si_item                  = sale_invoice_item::where('product_id', $asp->id)->get();
            //$merged                         = $ambil_pi_item->merge($ambil_si_item);
            foreach ($ambil_pi_item as $apii) {
                //$order_transaction_date     = $apii->purchase_invoice->orderBy('transaction_date', 'asc');
                $order1_carbon = Carbon::create($apii->purchase_invoice->transaction_date);
                foreach ($ambil_si_item as $asii) {
                    //$order_transaction_date2        = $asii->sale_invoice->orderBy('transaction_date', 'asc');
                    $order2_carbon                  = Carbon::create($asii->sale_invoice->transaction_date);
                    if ($order1_carbon->lessThanOrEqualTo($order2_carbon)) {
                        $dibagi = $asp->qty - $apii->qty;
                        if ($dibagi == 0) {
                            $avg_price              = (($asp->qty * $asp->avg_price) - ($apii->qty * $apii->unit_price));
                        } else {
                            $avg_price              = (($asp->qty * $asp->avg_price) - ($apii->qty * $apii->unit_price)) / ($dibagi);
                        }
                        $asp->update([
                            'qty'                   => $asp->qty + $apii->qty,
                            'avg_price'             => abs($avg_price),
                        ]);
                    } else {
                        $asp->update([
                            'qty'                   => $asp->qty - $asii->qty,
                        ]);
                    }
                }
            }

            $ambil_pi                       = purchase_invoice::with(['purchase_invoice_item' => function ($query) use ($asp) {
                $query->where('product_id', $asp->id)->get();
            }]);
            $ambil_si                       = sale_invoice::with(['sale_invoice_item' => function ($query) use ($asp) {
                $query->where('product_id', $asp->id)->get();
            }]);
            $merged                         = $ambil_pi->merge($ambil_si);
            $sorted = $merged->sortBy('transaction_date');
        }
    }
}
