<?php

namespace Studio1902\PeakSeo\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;
use Statamic\Facades\AssetContainer;

class GenerateSocialImagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $item;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->item = $item;
    }

    /**
     * Middleware to prevent jobs from overlapping.
     *
     * @return void
     */
    public function middleware(): array
    {
        return [(new WithoutOverlapping('generate-social-images'))->expireAfter(60)];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $container = AssetContainer::find('social_images');
        $disk = $container->disk();

        // Delete any old images/meta remaining.
        collect([
            $this->item->get('og_image'),
            $this->item->get('twitter_image'),
        ])
        ->filter()
        ->unique()
        ->each(function ($image) use ($container) {
            if($container->asset($image) && $container->asset($image)->exists()){
                $container->asset($image)->delete();
            }
        });

        // Prepare.
        $id = $this->item->id();
        $title = Str::of($this->item->get('title'))->slug('-');
        $absolute_url = $this->item->site()->absoluteUrl();
        $unique = time();

        // Generate, save and set default og image/meta.
        $file = "{$title}-og-{$unique}.png";
        $image = Browsershot::url("{$absolute_url}/social-images/{$id}")
            ->windowSize(1200, 630)
            ->select('#og')
            ->waitUntilNetworkIdle()
            ->save($disk->path($file));
        $container->makeAsset($file)->save();
        $this->item->set('og_image', $file)->save();

        // Generate, save and set default twitter image/meta.
        $file = "{$title}-twitter-{$unique}.png";
        $image = Browsershot::url("{$absolute_url}/social-images/{$id}")
            ->windowSize(1200, 600)
            ->select('#twitter')
            ->waitUntilNetworkIdle()
            ->save($disk->path($file));
        $container->makeAsset($file)->save();
        $this->item->set('twitter_image', $file)->save();

        Artisan::call('cache:clear');
    }
}
