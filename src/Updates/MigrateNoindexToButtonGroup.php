<?php

namespace Studio1902\PeakSeo\Updates;

use Statamic\Facades\Entry;
use Statamic\UpdateScripts\UpdateScript;

class MigrateNoindexToButtonGroup extends UpdateScript
{
    public function shouldUpdate($newVersion, $oldVersion)
    {
        return $this->isUpdatingTo('11.2.0');
    }

    public function update()
    {
        $updated = 0;

        Entry::all()->each(function ($entry) use (&$updated) {
            $value = $entry->get('seo_noindex');

            if ($value === true) {
                $entry->set('seo_noindex', 'noindex')->saveQuietly();
                $updated++;
            } elseif ($value === false || is_null($value)) {
                $entry->set('seo_noindex', 'default')->saveQuietly();
                $updated++;
            }
        });

        $this->console()->info("Migrated {$updated} entries from toggle to button group for `seo_noindex`.");
    }
}
