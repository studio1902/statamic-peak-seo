<?php

namespace Studio1902\PeakSeo\Updates;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Statamic\UpdateScripts\UpdateScript;

class LayoutUpdateSectionToStack extends UpdateScript
{
    public function shouldUpdate($newVersion, $oldVersion)
    {
        return $this->isUpdatingTo('3.0');
    }

    public function update()
    {
        $layout = base_path("resources/views/layout.antlers.html");

        if (File::exists($layout)) {
            $contents = Str::of(File::get($layout))
                ->replace('yield:seo_body', 'stack:seo_body');

            File::put($layout, $contents);

            $this->console()->info('Replaced `yield:seo_body` with `stack:seo_body` in `layout.antlers.html. Update this manually for any other layout files you may have.');
        } else {
            $this->console()->info('Replace `yield:seo_body` with `stack:seo_body` in all your layout files.');
        }
    }
}
