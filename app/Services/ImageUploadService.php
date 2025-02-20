<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploadService
{
    /**
     * Upload a single image and associate it with the given model.
     */
    public function uploadSingle(UploadedFile $file, mixed $model, string $folder, string $relation): Image
    {
        // Store the file
        $path = $file->store($folder, 'public');

        // Create a new Image instance
        $image = new Image([
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);

        // Associate the image with the model (polymorphic relationship)
        $model->$relation()->save($image);

        return $image;
    }

    /**
     * Upload multiple images and associate them with the given model.
     */
    public function uploadMultiple(array $files, mixed $model, string $folder, string $relation): array
    {
        $uploadedImages = [];

        foreach ($files as $file) {
            // Store the file
            $path = $file->store($folder, 'public');

            // Create a new Image instance
            $image = new Image([
                'filename' => $file->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);

            // Associate the image with the model (polymorphic relationship)
            $model->$relation()->save($image);

            $uploadedImages[] = $image;
        }

        return $uploadedImages;
    }

    /**
     * Delete an image from storage and the database.
     */
    public function deleteImage(Image $image): bool
    {
        $storage = Storage::disk('public');

        // Delete the file from storage
        if ($storage->exists($image->path)) {
            $storage->delete($image->path);
        }

        // Delete the image record from the database
        return $image->delete();
    }
}
