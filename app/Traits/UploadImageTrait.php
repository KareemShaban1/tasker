<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait UploadImageTrait
{
    /**
     * Process and upload an image.
     *
     * @param Request $request
     * @param string $file_name
     * @param string $folder_name
     * @param string|null $currentImage
     * @return string|null
     */
    public function processImage(Request $request, $file_name, $folder_name, $currentImage = null)
    {
        if ($request->hasFile($file_name)) {
            $request->validate([
                $file_name => 'required|image|mimes:jpg,jpeg,png,gif,svg',
            ]);

            $image = $request->file($file_name);
            $newImageName = time() . '.' . $image->getClientOriginalExtension();
            $uploadPath = storage_path('app/uploads/' . $folder_name);

            // Ensure the upload directory exists
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $imgFile = Image::make($image->getRealPath());
            $imgFile->resize(900, 900, function ($constraint) {
                $constraint->aspectRatio();
            })->save($uploadPath . '/' . $newImageName);

            // Delete the old image if updating
            if ($currentImage) {
                $this->deleteImage($currentImage, $folder_name);
            }

            return '/' . $newImageName;
        }

        // Return the current image if no new image is uploaded
        return $currentImage;
    }

    /**
     * Delete an image file from the storage.
     *
     * @param string $imagePath
     * @param string $folder_name
     * @return void
     */
    public function deleteImage($imagePath, $folder_name)
    {
        $uploadPath = storage_path('app/uploads/' . $folder_name . '/' . $imagePath);

        if (file_exists($uploadPath)) {
            unlink($uploadPath);
        }
    }
}
