<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait UploadVideoTrait
{
    /**
     * Process and upload a video.
     *
     * @param Request $request
     * @param string $file_name
     * @param string $folder_name
     * @param string|null $currentVideo
     * @return string|null
     */
    public function processVideo(Request $request, $file_name, $folder_name, $currentVideo = null)
    {
        if ($request->hasFile($file_name)) {
            $request->validate([
                $file_name => 'required|mimes:mp4,mov,ogg,qt|max:20000', // 20MB max
            ]);

            $video = $request->file($file_name);
            $newVideoName = time() . '.' . $video->getClientOriginalExtension();
            $uploadPath = storage_path('app/uploads/' . $folder_name);

            // Ensure the upload directory exists
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $video->move($uploadPath, $newVideoName);

            // Delete the old video if updating
            if ($currentVideo) {
                $this->deleteVideo($currentVideo, $folder_name);
            }

            return '/' . $newVideoName;
        }

        // Return the current video if no new video is uploaded
        return $currentVideo;
    }

    /**
     * Delete a video file from the storage.
     *
     * @param string $videoPath
     * @param string $folder_name
     * @return void
     */
    public function deleteVideo($videoPath, $folder_name)
    {
        $uploadPath = storage_path('app/uploads/' . $folder_name . '/' . $videoPath);

        if (file_exists($uploadPath)) {
            unlink($uploadPath);
        }
    }
}
