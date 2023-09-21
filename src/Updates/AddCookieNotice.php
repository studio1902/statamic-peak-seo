<?php

namespace Studio1902\PeakSeo\Updates;

use Statamic\Facades\GlobalSet;
use Statamic\UpdateScripts\UpdateScript;

class AddCookieNotice extends UpdateScript
{
    public function shouldUpdate($newVersion, $oldVersion)
    {
        return $this->isUpdatingTo('7.0');
    }

    public function update()
    {
        $blueprint = GlobalSet::findByHandle('configuration')->blueprint();
        $contents = $blueprint->contents();

        if (collect($contents['tabs']['general']['sections'])->where('display', 'Cookie notice')->isEmpty()) {

            $newSection = [
                'display' => 'Cookie notice',
                'instructions' => 'Configure an optional cookie notice.',
                'fields' => [
                0 => [
                    'handle' => 'cookie_notice_type',
                    'field' => [
                    'options' => [
                        'none' => 'None',
                        'entry' => 'Entry',
                        'pdf' => 'PDF',
                    ],
                    'default' => 'none',
                    'type' => 'button_group',
                    'instructions' => 'This will be used in form consent and in the optional cookie banner.',
                    'instructions_position' => 'below',
                    'listable' => false,
                    'localizable' => true,
                    'display' => 'Cookie notice',
                    'width' => 50,
                    ],
                ],
                1 => [
                    'handle' => 'cookie_notice_asset',
                    'field' => 'common.image',
                    'config' => [
                    'container' => 'files',
                    'localizable' => true,
                    'listable' => 'hidden',
                    'display' => 'Cookie notice (PDF)',
                    'width' => 50,
                    'if' => [
                        'cookie_notice_type' => 'equals pdf',
                    ],
                    'validate' => [
                        0 => 'required_if:cookie_notice_type,pdf',
                    ],
                    ],
                ],
                2 => [
                    'handle' => 'cookie_notice_entry',
                    'field' => 'common.entry',
                    'config' => [
                    'localizable' => true,
                    'listable' => 'hidden',
                    'display' => 'Cookie notice (entry)',
                    'width' => 50,
                    'if' => [
                        'cookie_notice_type' => 'equals entry',
                    ],
                    'validate' => [
                        0 => 'required_if:cookie_notice_type,entry',
                    ],
                    ],
                ],
                ],
            ];
            $contents['tabs']['general']['sections'][] = $newSection;
            $blueprint->setContents($contents);
            $blueprint->save();

            $this->console()->info('Global Configuration Blueprint succesfully expanded with Cookie Notice fields.');
        } else {
            $this->console()->info('Global Configuration Blueprint already contains Cookie Notice fields.');
        }
    }
}
