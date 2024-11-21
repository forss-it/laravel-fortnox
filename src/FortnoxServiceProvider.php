<?php

namespace Warbio\Fortnox;

use Illuminate\Support\ServiceProvider;
use Warbio\Fortnox\Commands\DisplayTokensCommand;
use Warbio\Fortnox\Commands\PurgeTokensCommand;
use Warbio\Fortnox\Commands\RefreshTokensCommand;

class FortnoxServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/fortnox.php', 'fortnox'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/fortnox.php' => config_path('fortnox.php'),
        ], 'fortnox-config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                DisplayTokensCommand::class,
                PurgeTokensCommand::class,
                RefreshTokensCommand::class,
            ]);
        }
    }
}
