<?php

namespace Studio1902\PeakSeo;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $routes = [
        'web' => __DIR__ . '/../routes/web.php',
    ];

    public function bootAddon()
    {
        $this->registerPublishableViews();
    }

    protected function registerPublishableViews()
    {
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/statamic-peak-seo'),
        ], 'statamic-peak-seo-views');
    }
}
