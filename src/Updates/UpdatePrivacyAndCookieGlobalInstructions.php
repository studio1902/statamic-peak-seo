<?php

namespace Studio1902\PeakSeo\Updates;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Statamic\UpdateScripts\UpdateScript;

class UpdatePrivacyAndCookieGlobalInstructions extends UpdateScript
{
    public function shouldUpdate($newVersion, $oldVersion)
    {
        return $this->isUpdatingTo('7.0.2');
    }

    public function update()
    {
        $global = base_path("resources/blueprints/globals/configuration.yaml");

        if (File::exists($global)) {
            $contents = Str::of(File::get($global))
                ->replaceFirst('This will be used in form consent and in the optional cookie banner.', 'Form consent fields will link to this Privacy Policy.')
                ->replaceLast('This will be used in form consent and in the optional cookie banner.', 'The Cookie Banner will link to this Cookie Notice.');

            File::put($global, $contents);

            $this->console()->info('Replaced Cookie Notice and Privacy Policy instructions in your global configuration blueprint..');
        }
    }
}
