<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Image as ImageModel;
use Throwable;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as ImageThumb;
//use Image;

class ImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     *
     * @var int
     */
    public $maxExceptions = 3;

    public $Image;

    /**
     * Create a new job instance.
     */
    public function __construct(ImageModel $Image)
    {
        $this->Image = $Image;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $path_external = $this->Image->path_external;
        //$folderName = Str::off($this->Image->page[0]['namePage'])->slug('-');
        $folderName = 'download';
        $fileName = $this->Image->id.".jpg";
        $basename = "public/{$folderName}/{$fileName}";
        $basenameThumbnail = "public/{$folderName}/thumb_{$fileName}";
        //$basename_thumbnail = "public/videos_external_server/{$fileName}";

        $contents = file_get_contents($path_external);
        Storage::put($basename, $contents, 'public');

        $parsePath = public_path("storage/{$folderName}/{$fileName}");
        $parsePathTH = public_path("storage/{$folderName}/thumb_{$fileName}");

        $img = ImageThumb::make($parsePath)->resize(200, 200, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($parsePathTH,60);


        $this->Image->path_local = $fileName;
        $this->Image->path_local_thumbnail = "thumb_{$fileName}";
        $this->Image->save();
    }

    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        // Send user notification of failure, etc...
    }
}
