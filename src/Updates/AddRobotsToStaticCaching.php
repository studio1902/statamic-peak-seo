<?php

namespace Studio1902\PeakSeo\Updates;

use Statamic\Facades\File;
use Statamic\Support\Str;
use Statamic\UpdateScripts\UpdateScript;

class AddRobotsToStaticCaching extends UpdateScript
{
    public function shouldUpdate($newVersion, $oldVersion)
    {
        return $this->isUpdatingTo('11.6.0');
    }

    public function update()
    {
        if (! File::exists($path = config_path('statamic/static_caching.php'))) {
            return;
        }

        $config = File::get($path);

        $addBelow = <<<'EOT'
            '/site.webmanifest',
            '/sitemap.xml',
            '/sitemaps.xml',
EOT;

        $replacement = <<<'EOT'
            '/robots.txt',
            '/site.webmanifest',
            '/sitemap.xml',
            '/sitemaps.xml',
EOT;

        if (Str::contains($config, $replacement) || ! Str::contains($config, $addBelow)) {
            return;
        }

        $config = str_replace($addBelow, $replacement, $config);

        File::put($path, $config);

        $this->console()->info('Added robots.txt to the exclude from static caching array.');
    }
}
