<?php

namespace Studio1902\PeakSeo\Updates;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Statamic\UpdateScripts\UpdateScript;

class AddRejectAll extends UpdateScript
{
    public function shouldUpdate($newVersion, $oldVersion)
    {
        return $this->isUpdatingTo('8.3.0');
    }

    public function update()
    {
        // Update string files.
        $disk = Storage::build([
            'driver' => 'local',
            'root' => base_path('/lang'),
        ]);

        collect($disk->allFiles())
            ->filter(function($file) use ($disk) {
                return Str::contains($disk->get($file), "'consent_ads");
            })
            ->each(function ($file) use ($disk) {
                $contents = Str::of($disk->get($file))
                    ->replace("'consent_ads'", "'consent_reject_all' => 'Reject all',\n\t'consent_ads'" );

                $disk->put($file, $contents);

                $this->console()->info("Add a `consent_reject_all` string to: `$file`.");
            }
        );

        $this->console()->info("Updated translation files.");
    }
}
