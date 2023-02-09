<?php

namespace Studio1902\PeakSeo;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $actions = [
        \Studio1902\PeakSeo\Actions\GenerateSocialImages::class
    ];

    protected $routes = [
        'web' => __DIR__ . '/../routes/web.php',
    ];

    public function bootAddon()
    {
        $this->registerPublishableFieldsets();
        $this->registerPublishableViews();
    }

    protected function registerPublishableFieldsets()
    {
        $this->publishes([
            __DIR__ . '/../resources/fieldsets' => resource_path('fieldsets/vendor/statamic-peak-seo'),
        ], 'statamic-peak-seo-fieldsets');
    }

    protected function registerPublishableViews()
    {
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/statamic-peak-seo'),
        ], 'statamic-peak-seo-views');
    }
}
