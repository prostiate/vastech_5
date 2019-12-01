<?php

namespace App\Providers;

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
    }
}
