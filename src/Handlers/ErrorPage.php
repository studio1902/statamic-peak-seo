<?php

namespace Studio1902\PeakSeo\Handlers;

use Illuminate\Support\Facades\View;
use Statamic\Facades\GlobalSet;
use Symfony\Component\HttpFoundation\Response;

abstract class ErrorPage
{
    public static function handle404AsEntry(): void
    {
        static::handleErrorPageAsEntry(Response::HTTP_NOT_FOUND, ['layout', 'errors/404']);
    }

    public static function handleErrorPageAsEntry(int $code, array|string $views): void
    {
        View::composer($views, static function (\Illuminate\View\View $view) use ($code) {
            if ($view['response_code'] !== $code) {
                return;
            }

            $entryProperty = "error_{$code}_entry";

            $entry = GlobalSet::find('configuration')?->inCurrentSite()->$entryProperty;

            if (!$entry) {
                $entry = GlobalSet::find('configuration')?->inDefaultSite()->$entryProperty;
            }

            if (!$entry) {
                return;
            }

            $view->with($entry->toAugmentedArray());
        });
    }
}
