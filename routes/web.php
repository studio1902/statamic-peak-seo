<?php

use Illuminate\Support\Facades\Route;
use Statamic\Facades\URL;

// The Sitemap Index route for listing sitemaps of all (multi)sites.
Route::statamic(URL::tidy('/sitemaps.xml'), 'statamic-peak-seo::sitemap/sitemaps', [
    'layout' => null,
    'content_type' => 'application/xml',
]);

// The Sitemap routes.
Route::statamic(URL::tidy('sitemap.xml'), 'statamic-peak-seo::sitemap/sitemap', [
    'layout' => null,
    'content_type' => 'application/xml',
]);

Route::statamic(URL::tidy('{current_site}/sitemap.xml'), 'statamic-peak-seo::sitemap/sitemap', [
    'layout' => null,
    'content_type' => 'application/xml',
]);

// The Social Image route to generate social images.
Route::statamic(URL::tidy('social-images/{id}'), 'statamic-peak-seo::social_images', [
    'layout' => null,
]);

// The Social Image route to generate social images.
Route::statamic(URL::tidy('{current_site}/social-images/{id}'), 'statamic-peak-seo::social_images', [
    'layout' => null,
]);
