<?php

namespace Studio1902\PeakSeo;

use Statamic\Providers\AddonServiceProvider;
use Studio1902\PeakSeo\Actions\GenerateSocialImages;

class ServiceProvider extends AddonServiceProvider
{
    protected $actions = [
        GenerateSocialImages::class
    ];

    protected $routes = [
        'web' => __DIR__ . '/../routes/web.php',
    ];

    protected $updateScripts = [
        \Studio1902\PeakSeo\Updates\UpdateGlobalRenameWhatToAdd::class,
        \Studio1902\PeakSeo\Updates\LayoutUpdateSectionToStack::class,
        \Studio1902\PeakSeo\Updates\AddCookieNotice::class,
        \Studio1902\PeakSeo\Updates\UpdatePrivacyAndCookieGlobalInstructions::class,
        \Studio1902\PeakSeo\Updates\UseConsentBanner::class,
        \Studio1902\PeakSeo\Updates\AddRejectAll::class,
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
