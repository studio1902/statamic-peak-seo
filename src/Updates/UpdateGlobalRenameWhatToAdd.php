<?php

use Statamic\Facades\GlobalSet;
use Statamic\Facades\Site;
use Statamic\UpdateScripts\UpdateScript;

class UpdateGlobalRenameWhatToAdd extends UpdateScript
{
    public function shouldUpdate($newVersion, $oldVersion)
    {
        return $this->isUpdatingTo('2.0');
    }

    public function update()
    {
        Site::all()->each(function ($site) {
            $changePageTitles = GlobalSet::findByHandle('seo')->in($site->handle)->get('change_page_title');
        });

        $this->console()->info('Global "Change page title" configuration renamed `what_to_add` to `manipulate_title` succesfully.');
    }
}
