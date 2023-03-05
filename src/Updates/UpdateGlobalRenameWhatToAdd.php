<?php

namespace Studio1902\PeakSeo\Updates;

use Statamic\Facades\GlobalSet;
use Statamic\Facades\Site;
use Statamic\UpdateScripts\UpdateScript;

class UpdateGlobalRenameWhatToAdd extends UpdateScript
{
    public function shouldUpdate($newVersion, $oldVersion)
    {
        return $this->isUpdatingTo('1.5');
    }

    public function update()
    {
        Site::all()->each(function ($site) {
            $set = GlobalSet::findByHandle('seo')->in($site->handle);
            $changePageTitle = $set->get('change_page_title');

            if ($changePageTitle) {
                foreach ($changePageTitle as $index => $values) {
                    if (array_key_exists('what_to_add', $changePageTitle[$index])) {
                        $changePageTitle[$index]['manipulate_title'] = $values['what_to_add'] ?? '';
                        unset($changePageTitle[$index]['what_to_add']);
                    }
                }

                $set->set('change_page_title', $changePageTitle);
                $set->save();
            }
        });

        $this->console()->info('Global "Change page title" configuration renamed `what_to_add` to `manipulate_title` succesfully.');
    }
}
