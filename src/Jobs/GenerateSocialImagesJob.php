<?php

namespace Studio1902\PeakSeo\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;
use Statamic\Facades\AssetContainer;
use Statamic\Globals\GlobalSet;

class GenerateSocialImagesJob implements ShouldBeUnique, ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $item;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($item) {
        $this->item = $item;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $container = AssetContainer::find('social_images');
        $disk = $container->disk();

        // Delete any old images/meta remaining.
        $image = $this->item->get('og_image');
        if ($image && $container->asset($image)?->exists()) {
            $container->asset($image)->delete();
        }

        // Prepare.
        $title = Str::of($this->item->get('title'))->slug('-');
        $unique = time();

        // Get config
        $socialConfig = config('statamic-peak-seo.social_image');

        // Usefull for clarity in code.
        $format = $socialConfig['format'];
        $resolution = explode('x', $socialConfig['resolution']);
        $selector = $socialConfig['selector'];
        $quality = $socialConfig['jpg-quality'];

        // Generate, save and set default og image/meta.
        $file = "{$title}-og-{$unique}.{$format}";
        $image = $this->setupBrowsershot()
            ->windowSize($resolution[0], $resolution[1])
            ->select("#{$selector}")
            ->waitUntilNetworkIdle();

        if ($format === 'jpg') {
            $image->setScreenshotType('jpeg', $quality);
        }

        $driver = strtolower(config("filesystems.disks.{$container->disk}.driver"));
        if ($driver === 's3') {
            $disk->put($file, $image->screenshot());
        } else {
            $image->save($disk->path($file));
        }

        $container->makeAsset($file)->save();
        $this->item->set('og_image', $file)->save();
    }

    protected function setupBrowsershot(): Browsershot {
        $id = $this->item->id();
        $absolute_url = $this->item->site()->absoluteUrl();

        if (GlobalSet::findByHandle('seo')->inDefaultSite()->get('use_no_sandbox_for_social_image_generation')) {
            $browsershot = Browsershot::url("{$absolute_url}/social-images/{$id}")->noSandbox();
        } else {
            $browsershot = Browsershot::url("{$absolute_url}/social-images/{$id}");
        }

        if ($nodeBinary = config('statamic-peak-seo.social_image.node_binary')) {
            $browsershot->setNodeBinary($nodeBinary);
        }

        if ($npmBinary = config('statamic-peak-seo.social_image.npm_binary')) {
            $browsershot->setNpmBinary($npmBinary);
        }

        if ($chromePath = config('statamic-peak-seo.social_image.chrome_path')) {
            $browsershot->setChromePath($chromePath);
        }

        return $browsershot;
    }

    public function uniqueId(): string
    {
        return $this->item->id();
    }
}
