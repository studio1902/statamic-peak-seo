<?php

namespace Studio1902\PeakSeo\Actions;

use Statamic\Actions\Action;
use Statamic\Contracts\Entries\Entry as EntryInstance;
use Statamic\Globals\GlobalSet;
use Studio1902\PeakSeo\Jobs\GenerateSocialImagesJob;

class GenerateSocialImages extends Action
{
    public $available_collections = array();

    public function __construct() {
        if (GlobalSet::findByHandle('seo')->inDefaultSite()->get('use_social_image_generation') && GlobalSet::findByHandle('seo')->inDefaultSite()->get('social_images_collections')) {
            $this->available_collections = GlobalSet::findByHandle('seo')->inDefaultSite()->get('social_images_collections');
        }
    }

    /**
     * Determine if the current thing is an entry and if it's opted in to the auto generation config (global).
     *
     * @return boolean
     */
    public function visibleTo($item)
    {
        return $item instanceof EntryInstance && in_array($item->collectionHandle(), $this->available_collections);
    }

    /**
     * Determine if the current user is allowed to run this action.
     *
     * @return boolean
     */
    public function authorize($user, $item)
    {
        return $user->can('edit', $item);
    }

     /**
     * Run the action
     *
     * @return void
     */
    public function run($items, $values)
    {
        $items->each(function ($item, $key) {
            GenerateSocialImagesJob::dispatch($item)
                ->onQueue(config('statamic-peak-seo.social_image.queue_name'));
        });

        $queue = config('queue.default');
        $driver = config("queue.connections.$queue.driver");

        return $driver === 'sync'
            ? trans_choice('strings.social_images', $items)
            : trans_choice('strings.social_images_queue', $items);
    }
}
