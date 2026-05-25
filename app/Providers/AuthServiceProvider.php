<?php

namespace App\Providers;

use App\Models\Tontine;
use App\Policies\TontinePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Tontine::class => TontinePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
