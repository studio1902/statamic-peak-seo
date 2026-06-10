<?php

namespace Studio1902\PeakSeo\Updates;

use Illuminate\Support\Facades\File;
use Statamic\Facades\GlobalSet;
use Statamic\UpdateScripts\UpdateScript;

class AddRobots extends UpdateScript
{
    public function shouldUpdate($newVersion, $oldVersion)
    {
        return $this->isUpdatingTo('11.3.0');
    }

    public function update()
    {
        $this->updateSEOGlobal();
        $this->parseAndTrashRobots();
    }

    protected function updateSEOGlobal() {
        $globalSet = GlobalSet::findByHandle('seo');

        if (! $globalSet) {
            $this->console()->warn('SEO global set not found. Skipping blueprint migration.');

            return;
        }

        $blueprint = $globalSet->blueprint();
        $contents = $blueprint->contents();

        // Check if the Indexing tab already has the environment section.
        $indexingHasEnv = isset($contents['tabs']['seo']['sections'])
            && collect($contents['tabs']['seo']['sections'])->contains(function ($section) {
                return collect($section['fields'] ?? [])->contains(function ($field) {
                    return ($field['import'] ?? null) === 'statamic-peak-seo::globals_seo_robots';
                });
            });

        if ($indexingHasEnv) {
            $this->console()->info('SEO global already contains robots settings. Skipping blueprint migration.');

            return;
        }

        // Build a new Robots tab and insert after Sitmap.
        $robotsTab = [
            'display' => 'Robots',
            'sections' => [
                [
                    'display' => 'Robots',
                    'instructions' => 'Configure the robots.txt',
                    'fields' => [
                        ['import' => 'statamic-peak-seo::globals_seo_robots'],
                    ]
                ]
            ]
        ];

        $tabs = [];
        foreach ($contents['tabs'] as $handle => $tab) {
            $tabs[$handle] = $tab;
            if ($handle === 'sitemap') {
                $tabs['robots'] = $robotsTab;
            }
        }
        $contents['tabs'] = $tabs;

        $blueprint->setContents($contents);
        $blueprint->save();

        $this->console()->info('Added Robots tab to SEO globals blueprint with a field to configure robots.txt.');
    }

    protected function parseAndTrashRobots() {
        $path = public_path('robots.txt');

        if (! File::exists($path)) {
            return;
        }

        $filteredContents = collect(file($path, FILE_IGNORE_NEW_LINES))
            ->reject(fn ($line) => str_starts_with(trim($line), 'Sitemap:'))
            ->implode(PHP_EOL);

        $seo = GlobalSet::findByHandle('seo')->inDefaultSite();
        $seo->set('robots', $filteredContents);
        $seo->save();

        File::delete($path);

        $this->console()->info('Migrated robots.txt content to SEO robots global.');
    }
}
