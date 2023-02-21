<?php

use Illuminate\Support\Facades\Route;
use Statamic\Facades\GlobalSet;
use Statamic\Facades\Site;

// The Sitemap Index route for listing sitemaps of all (multi)sites.
Route::statamic('/sitemaps.xml', 'statamic-peak-seo::sitemap/sitemaps', [
    'layout' => null,
    'content_type' => 'application/xml'
]);

// The Default Site Sitemap route.
Route::statamic('/sitemap.xml', 'statamic-peak-seo::sitemap/sitemap', [
    'layout' => null,
    'content_type' => 'application/xml'
]);

// The Multisite Site Sitemap route(s).
Route::statamic('/{site_handle}/sitemap.xml', 'statamic-peak-seo::sitemap/sitemap', [
    'layout' => null,
    'content_type' => 'application/xml'
]);

// The Social Image route to generate social images.
if (GlobalSet::findByHandle('seo')?->inDefaultSite()?->get('use_social_image_generation')) {
    Site::all()->each(function ($site) {
        Route::statamic("{$site->url()}/social-images/{id}", 'statamic-peak-seo::social_images', [
            'layout' => null,
        ]);
    });
}
