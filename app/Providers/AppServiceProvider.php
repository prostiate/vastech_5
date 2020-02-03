<?php

namespace App\Providers;

use App\expense;
use App\Observers\expense_observer;
use App\Observers\purchase_invoice_observer;
use App\Observers\purchase_order_observer;
use App\Observers\purchase_quote_observer;
use App\Observers\purchase_return_observer;
use App\Observers\sale_invoice_observer;
use App\Observers\sale_order_observer;
use App\Observers\sale_quote_observer;
use App\Observers\sale_return_observer;
use App\purchase_invoice;
use App\purchase_order;
use App\purchase_quote;
use App\purchase_return;
use App\sale_invoice;
use App\sale_order;
use App\sale_quote;
use App\sale_return;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        Blade::directive('currency', function ($expression) {
            return "Rp. <?php echo number_format($expression, 2, '.', ','); ?>";
        });

        Blade::directive('number', function ($expression) {
            return "<?php echo number_format($expression, 2, '.', ','); ?>";
        });
        expense::observe(expense_observer::class);
        purchase_invoice::observe(purchase_invoice_observer::class);
        purchase_order::observe(purchase_order_observer::class);
        purchase_quote::observe(purchase_quote_observer::class);
        purchase_return::observe(purchase_return_observer::class);
        sale_invoice::observe(sale_invoice_observer::class);
        sale_order::observe(sale_order_observer::class);
        sale_quote::observe(sale_quote_observer::class);
        sale_return::observe(sale_return_observer::class);
    }
}
