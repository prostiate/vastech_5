<?php

namespace App\Http\Middleware;

use App\Model\expense\expense;
use App\Model\purchase\purchase_quote;
use App\Model\purchase\purchase_order;
use App\Model\purchase\purchase_delivery;
use App\Model\purchase\purchase_invoice;
use App\Model\purchase\purchase_return;
use App\Model\sales\sale_quote;
use App\Model\sales\sale_order;
use App\Model\sales\sale_delivery;
use App\Model\sales\sale_invoice;
use App\Model\sales\sale_return;
use App\Model\spk\spk_item;
use Closure;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $explode = explode('/', $request->path());
        if ($explode[0] == 'purchases_quote') {
            if (purchase_quote::where('id', $request->id)->where('status', '<>', 1)->orWhere('status', '<>', 6)->first()) {
                return redirect('/');
            }
        } else if ($explode[0] == 'purchases_order') {
            if (purchase_order::where('id', $request->id)->where('status', '<>', 1)->orWhere('status', '<>', 6)->first()) {
                return redirect('/');
            }
        } else if ($explode[0] == 'purchases_delivery') {
            if (purchase_delivery::where('id', $request->id)->where('status', '<>', 1)->orWhere('status', '<>', 6)->first()) {
                return redirect('/');
            }
        } else if ($explode[0] == 'purchases_invoice') {
            if (purchase_invoice::where('id', $request->id)->where('status', '<>', 1)->orWhere('status', '<>', 6)->first()) {
                return redirect('/');
            }
        } else if ($explode[0] == 'purchases_return') {
            if (purchase_return::where('id', $request->id)->where('status', '<>', 1)->orWhere('status', '<>', 6)->first()) {
                return redirect('/');
            }
        } else if ($explode[0] == 'sales_quote') {
            if (sale_quote::where('id', $request->id)->where('status', '<>', 1)->orWhere('status', '<>', 6)->first()) {
                return redirect('/');
            }
        } else if ($explode[0] == 'sales_order') {
            if (sale_order::where('id', $request->id)->where('status', '<>', 1)->orWhere('status', '<>', 6)->first()) {
                return redirect('/');
            }
        } else if ($explode[0] == 'sales_delivery') {
            if (sale_delivery::where('id', $request->id)->where('status', '<>', 1)->orWhere('status', '<>', 6)->first()) {
                return redirect('/');
            }
        } else if ($explode[0] == 'sales_invoice') {
            if (sale_invoice::where('id', $request->id)->where('status', '<>', 1)->orWhere('status', '<>', 6)->first()) {
                return redirect('/');
            }
        } else if ($explode[0] == 'sales_return') {
            if (sale_return::where('id', $request->id)->where('status', '<>', 1)->orWhere('status', '<>', 6)->first()) {
                return redirect('/');
            }
        } else if ($explode[0] == 'expenses') {
            if (expense::where('id', $request->id)->where('due_date', '!=', 'null')->where('status', '<>', 1)->orWhere('status', '<>', 6)->first()) {
                return redirect('/');
            }
        } else if ($explode[0] == 'spk') {
            $spk_item                       = spk_item::where('spk_id', $request->id)->get();
            $statusajah                     = 0;
            $can                            = 0;
            foreach ($spk_item as $sii) {
                if ($sii->qty_remaining_sent != 0) {
                    $can                    += 1;
                } else {
                    $can                    += 0;
                }
                if ($sii->status == 1) {
                    $statusajah             += 0;
                } else {
                    $statusajah             += 1;
                }
            }
            if ($statusajah != 0) {
                return redirect('/');
            }
        }
        return $next($request);
    }
}
