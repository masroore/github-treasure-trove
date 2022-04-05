<?php

namespace App\Jobs;

use App\User;
use File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Image;
use Storage;

class UploadAvatar implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $fileId;

    protected $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, $fileId)
    {
        $this->user = $user;
        $this->fileId = $fileId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // uploads a user's avatar to S3
        $path = storage_path() . '/avatars/' . $this->fileId;
        $fileName = $this->fileId . '.png';

        Image::make($path)->encode('png')->fit(100, 100, function ($constraint): void {
            $constraint->upsize();
        });

        Storage::disk('s3')->put('avatars/' . $fileName, fopen($path, 'r+b'));
        //File::delete($path); -- not working

        $this->user->avatar = $fileName;
        $this->user->save();
    }
}
