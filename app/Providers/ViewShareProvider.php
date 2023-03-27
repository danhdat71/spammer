<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\SpamMessage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewShareProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $spamMessages = SpamMessage::all();
        $customerCount = Customer::count();

        View::share('spamMessages', $spamMessages);
        View::share('customerCount', $customerCount);
    }
}
