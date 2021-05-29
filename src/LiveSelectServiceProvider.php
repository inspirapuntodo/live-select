<?php

namespace Inspirapuntodo\LiveSelect;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LiveSelectServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'live-select');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/live-select'),
            ], 'live-select-views');
        }

        /*
        Blade::directive('LiveSelectScripts', function () {
            return <<<'HTML'
                <script>
                        window.livewire.on('live-select-focus-search', (data) => {
                            const el = document.getElementById(`${data.name || 'invalid'}`);
                            if (!el) {
                                return;
                            }
                            el.focus();
                        });
                        window.livewire.on('live-select-focus-selected', (data) => {
                            const el = document.getElementById(`${data.name || 'invalid'}-selected`);
                            if (!el) {
                                return;
                            }
                            el.focus();
                        });
                    </script>
HTML;

        });                        */
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'live-select');
    }
}