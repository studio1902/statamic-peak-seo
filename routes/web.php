<?php

use Illuminate\Support\Facades\Route;
use Statamic\Exceptions\NotFoundHttpException;
use Statamic\Facades\GlobalSet;
use Statamic\Facades\Site;
use Statamic\Facades\URL;

// The Sitemap Index route for listing sitemaps of all (multi)sites.
Route::statamic('/sitemaps.xml', 'statamic-peak-seo::sitemap/sitemaps', function () {
    if (! GlobalSet::findByHandle('seo')?->inDefaultSite()?->get('use_sitemap')) {
        throw new NotFoundHttpException;
    }

    return [
        'layout' => null,
        'content_type' => 'application/xml',
    ];
});

// Register routes for each site.
Site::all()->each(function (\Statamic\Sites\Site $site) {
    $relativeSiteUrl = URL::makeRelative($site->url());

    // The Sitemap route.
    Route::statamic(URL::tidy($relativeSiteUrl.'/sitemap.xml'), 'statamic-peak-seo::sitemap/sitemap', function () {
        if (! GlobalSet::findByHandle('seo')?->inDefaultSite()?->get('use_sitemap')) {
            throw new NotFoundHttpException;
        }

        return [
            'layout' => null,
            'content_type' => 'application/xml',
        ];
    });

    // The Social Image route to generate social images.
    Route::statamic(URL::tidy($relativeSiteUrl.'/social-images/{id}'), 'statamic-peak-seo::social_images', function ($id) {
        if (! GlobalSet::findByHandle('seo')?->inDefaultSite()?->get('use_social_image_generation')) {
            throw new NotFoundHttpException;
        }

        return [
            'layout' => null,
        ];
    });
});
