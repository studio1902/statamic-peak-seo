<?php

namespace Studio1902\PeakSeo\Updates;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Statamic\UpdateScripts\UpdateScript;

class UseConsentBanner extends UpdateScript
{
    public function shouldUpdate($newVersion, $oldVersion)
    {
        // return $this->isUpdatingTo('8.0.0');
        return true;
    }

    public function update()
    {
        // Update global content.
        $global = base_path("content/globals/seo.yaml");

        if (File::exists($global)) {
            $contents = Str::of(File::get($global))
                ->replace('use_cookie_banner', 'use_consent_banner');

            File::put($global, $contents);

            $this->console()->info('Renamed `use_cookie_banner` to `use_consent_banner` in `content/globals/seo.yaml`.');
        }

        // Update published SEO view.
        $view = base_path("resources/views/vendor/statamic-peak-seo/snippets/_seo.antlers.html");

        if (File::exists($view)) {
            $contents = Str::of(File::get($view))
                ->replace('seo:use_cookie_banner', 'seo:use_consent_banner')
                ->replace('{{ trans:strings.cookie_', '{{ trans:strings.consent_');

            File::put($view, $contents);

            $this->console()->info('Renamed `seo:use_cookie_banner` to `seo:use_consent_banner` and `{{ trans:strings.cookie_` to `{{ trans:strings.consent_` in `resources/views/vendor/statamic-peak-seo/snippets/_seo.antlers.html`.');
        }

        // Update string files.
        $disk = Storage::build([
            'driver' => 'local',
            'root' => resource_path('/lang'),
        ]);

        collect($disk->allFiles())
            ->filter(function($file) use ($disk) {
                return Str::contains($disk->get($file), "'cookie_");
            })
            ->each(function ($file) use ($disk) {
                $contents = Str::of($disk->get($file))
                    ->replace("'cookie_", "'consent_" );

                $disk->put($file, $contents);

                $this->console()->info("Replaced `'cookie_'` with `'consent_'` in `$file`.");
            }
        );

        $this->console()->info("Updated translation files.");

        // Update SEO global.
        $view = base_path("resources/blueprints/globals/seo.yaml");

        if (File::exists($view)) {
            $contents = Str::of(File::get($view))
                ->replace('cookie banner', 'consent banner')
                ->replace('coookie consent', 'consent')
                ->replace('Consent and Cookie Banner', 'Consent banner');

            File::put($view, $contents);

            $this->console()->info('Updated cookie strings to consent in `resources/blueprints/globals/seo.yaml`.');
        }

        // Update video component.
        $view = base_path("resources/views/components/_video.antlers.html");

        if (File::exists($view)) {
            $contents = Str::of(File::get($view))
                ->replace('{{ if cookie_embeds }}', '{{ if consent_embeds }}')
                ->replace('!$store.cookieBanner.consent || !$store.cookieBanner.embeds', '!$store.consentBanner.getConsent() || !$store.consentBanner.getConsentValue(\'embeds\')')
                ->replace('$store.cookieBanner.setConsent(null)', '$store.consentBanner.revokeConsent()')
                ->replace('{{ trans:strings.cookie_', '{{ trans:strings.consent_')
                ->replace('$store.cookieBanner.consent && $store.cookieBanner.embeds', '$store.consentBanner.getConsent() && $store.consentBanner.getConsentValue(\'embeds\')');


            File::put($view, $contents);

            $this->console()->info('Updated `resources/views/components/_video.antlers.html` to work with the new consent store.');
        }

        // Update footer.
        $view = base_path("resources/views/layout/_footer.antlers.html");

        if (File::exists($view)) {
            $contents = Str::of(File::get($view))
                ->replace('{{ yield:reset_cookie_consent }}', '{{ yield:reset_consent }}');


            File::put($view, $contents);

            $this->console()->info('Replace `{{ yield:reset_cookie_consent }}` with `{{ yield:reset_consent }}` in `resources/views/layout/_footer.antlers.html`.');
        }

        // Update toggle.
        $view = base_path("resources/views/vendor/statamic/forms/fields/toggle.antlers.html");

        if (File::exists($view)) {
            $contents = Str::of(File::get($view))
                ->replace('{{ trans:strings.cookie_', '{{ trans:strings.consent_');


            File::put($view, $contents);

            $this->console()->info('Replace `{{ trans:strings.cookie_` to `{{ trans:strings.consent_` in `resources/views/vendor/statamic/forms/fields/toggle.antlers.html`.');
        }
    }
}
