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
            $set = GlobalSet::findByHandle('seo')->in($site->handle);
            $set->set('manipulate_title', $set->get('change_page_title'));
            $set->remove('change_page_title');
            $set->save();
        });

        $this->console()->info('Global "Change page title" configuration renamed `what_to_add` to `manipulate_title` succesfully.');
    }
}
