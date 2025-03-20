<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaUploadService
{
    /**
     * Upload a single media and associate it with the given model.
     */
    public function uploadSingle(UploadedFile $file, mixed $model, string $folder, string $relation): Media
    {
        // Store the file
        $path = $file->store($folder, 'public');

        // Create a new Media instance
        $media = new Media([
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'type' => $relation,
        ]);

        // Associate the media with the model (polymorphic relationship)
        $model->$relation()->save($media);

        return $media;
    }

    /**
     * Upload multiple medias and associate them with the given model.
     */
    public function uploadMultiple(array $files, mixed $model, string $folder, string $relation): array
    {
        $uploadedMedias = [];

        foreach ($files as $file) {
            // Store the file
            $path = $file->store($folder, 'public');

            // Create a new Media instance
            $media = new Media([
                'filename' => $file->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'type' => $relation,
            ]);

            // Associate the media with the model (polymorphic relationship)
            $model->$relation()->save($media);

            $uploadedMedias[] = $media;
        }

        return $uploadedMedias;
    }

    /**
     * Delete an media from storage and the database.
     */
    public function deleteMedia(Media $media): bool
    {
        $storage = Storage::disk('public');

        // Delete the file from storage
        if ($storage->exists($media->path)) {
            $storage->delete($media->path);
        }

        // Delete the media record from the database
        return $media->delete();
    }
}
