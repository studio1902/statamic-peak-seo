<?php

namespace Studio1902\PeakSeo\Updates;

use Statamic\Facades\Entry;
use Statamic\Facades\GlobalSet;
use Statamic\UpdateScripts\UpdateScript;

class MigrateNoindexToButtonGroup extends UpdateScript
{
    public function shouldUpdate($newVersion, $oldVersion)
    {
        return $this->isUpdatingTo('11.2.0');
    }

    public function update()
    {
        $this->migrateEntryData();
        $this->migrateGlobalsBlueprint();
    }

    /**
     * Convert existing boolean seo_noindex values to button_group string equivalents.
     */
    protected function migrateEntryData(): void
    {
        $updated = 0;

        Entry::all()->each(function ($entry) use (&$updated) {
            $value = $entry->get('seo_noindex');

            if ($value === true) {
                $entry->set('seo_noindex', 'noindex')->saveQuietly();
                $updated++;
            } elseif ($value === false || is_null($value)) {
                $entry->set('seo_noindex', 'inherit')->saveQuietly();
                $updated++;
            }
        });

        $this->console()->info("Migrated {$updated} entries from toggle to button group for `seo_noindex`.");
    }

    /**
     * Add Indexing tab to SEO globals blueprint and move environment toggles into it.
     */
    protected function migrateGlobalsBlueprint(): void
    {
        $globalSet = GlobalSet::findByHandle('seo');

        if (! $globalSet) {
            $this->console()->warn('SEO global set not found. Skipping blueprint migration.');

            return;
        }

        $blueprint = $globalSet->blueprint();
        $contents = $blueprint->contents();

        // Check if the Indexing tab already has the environment section.
        $indexingHasEnv = isset($contents['tabs']['indexing']['sections'])
            && collect($contents['tabs']['indexing']['sections'])->contains(function ($section) {
                return collect($section['fields'] ?? [])->contains(function ($field) {
                    return ($field['import'] ?? null) === 'statamic-peak-seo::globals_seo_page_environments';
                });
            });

        if ($indexingHasEnv) {
            $this->console()->info('Indexing tab already contains environment settings. Skipping blueprint migration.');

            return;
        }

        // Find and move the Environments section from Page meta tab.
        $envSection = null;

        if (isset($contents['tabs']['page_titles']['sections'])) {
            $sections = collect($contents['tabs']['page_titles']['sections']);

            $envSection = $sections->first(function ($section) {
                return collect($section['fields'] ?? [])->contains(function ($field) {
                    return ($field['import'] ?? null) === 'statamic-peak-seo::globals_seo_page_environments';
                });
            });

            if ($envSection) {
                $contents['tabs']['page_titles']['sections'] = $sections
                    ->reject(fn ($s) => $s === $envSection)
                    ->values()
                    ->all();
            }
        }

        // Fall back to a default if the section wasn't found in Page meta.
        $envSection ??= [
            'display' => 'Environments',
            'instructions' => 'When to noindex and nofollow by default.',
            'fields' => [
                ['import' => 'statamic-peak-seo::globals_seo_page_environments'],
            ],
        ];

        if (isset($contents['tabs']['indexing'])) {
            // Indexing tab exists but missing env section — prepend it.
            array_unshift($contents['tabs']['indexing']['sections'], $envSection);
        } else {
            // Build a new Indexing tab and insert after Page meta.
            $indexingTab = [
                'display' => 'Indexing',
                'sections' => [
                    $envSection,
                    [
                        'display' => 'Collections',
                        'instructions' => 'Set default indexing behavior per collection. Individual entries can override. Defaults to "Index" if not configured.',
                        'fields' => [
                            ['import' => 'statamic-peak-seo::globals_seo_indexing_collections'],
                        ],
                    ],
                    [
                        'display' => 'Taxonomies',
                        'instructions' => 'Set default indexing behavior per taxonomy. Individual terms can override. Defaults to "Index" if not configured.',
                        'fields' => [
                            ['import' => 'statamic-peak-seo::globals_seo_indexing_taxonomies'],
                        ],
                    ],
                ],
            ];

            $tabs = [];
            foreach ($contents['tabs'] as $handle => $tab) {
                $tabs[$handle] = $tab;
                if ($handle === 'page_titles') {
                    $tabs['indexing'] = $indexingTab;
                }
            }
            $contents['tabs'] = $tabs;
        }

        $blueprint->setContents($contents);
        $blueprint->save();

        $this->console()->info('Added Indexing tab to SEO globals blueprint with environment toggles and collection/taxonomy defaults.');
    }
}
