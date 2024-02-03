<?php

namespace App\Providers;

use App\Models\Order;
use App\Policies\OrderDishesPolicy;
use App\Policies\OrderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Order::class => OrderPolicy::class,
//        Order::class => OrderDishesPolicy::class,  // se suprascria OrderPolicy => am mutat continutul din OrderDishesPolicy in OrderPolicy
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//      // gate version
//        Gate::define('modify-order', function ($order) {
//            return $order->paid_at === null;
//        });
    }
}
