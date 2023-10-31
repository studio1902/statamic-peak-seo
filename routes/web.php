<?php

use Illuminate\Support\Facades\Route;
use Statamic\Facades\GlobalSet;
use Statamic\Facades\Site;
use Statamic\Facades\URL;

$useSocialImageGeneration = (bool)GlobalSet::findByHandle('seo')?->inDefaultSite()?->get('use_social_image_generation');

// The Sitemap Index route for listing sitemaps of all (multi)sites.
Route::statamic('/sitemaps.xml', 'statamic-peak-seo::sitemap/sitemaps', [
    'layout' => null,
    'content_type' => 'application/xml'
]);

// Register routes for each site.
Site::all()->each(function (\Statamic\Sites\Site $site) use ($useSocialImageGeneration) {
    $relativeSiteUrl = URL::makeRelative($site->url());

    // The Sitemap route.
    Route::statamic(URL::tidy($relativeSiteUrl . '/sitemap.xml'), 'statamic-peak-seo::sitemap/sitemap', [
        'layout' => null,
        'content_type' => 'application/xml'
    ]);

    // The Social Image route to generate social images.
    if ($useSocialImageGeneration) {
        Route::statamic(URL::tidy($relativeSiteUrl . '/social-images/{id}'), 'statamic-peak-seo::social_images', [
            'layout' => null,
        ]);
    }
});
