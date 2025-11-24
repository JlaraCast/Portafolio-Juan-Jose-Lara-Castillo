<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Service class to handle image upload operations.
 */
class ImageUploadService
{
    /**
     * Upload an image to the specified directory.
     *
     * @param UploadedFile $file The uploaded file
     * @param string $directory The storage directory (e.g., 'projects', 'experiences')
     * @param string|null $oldPath Optional path to old image to delete
     * @return string The public path to the uploaded image
     */
    public function upload(UploadedFile $file, string $directory, ?string $oldPath = null): string
    {
        // Delete old image if exists
        if ($oldPath) {
            $this->delete($oldPath);
        }

        // Store the new image
        $path = $file->store($directory, 'public');

        return '/storage/' . $path;
    }

    /**
     * Delete an image from storage.
     *
     * @param string $path The path to the image (e.g., '/storage/projects/image.jpg')
     * @return bool Whether the deletion was successful
     */
    public function delete(string $path): bool
    {
        // Remove '/storage/' prefix to get the actual storage path
        $storagePath = str_replace('/storage/', '', $path);

        if (Storage::disk('public')->exists($storagePath)) {
            return Storage::disk('public')->delete($storagePath);
        }

        return false;
    }

    /**
     * Get the full URL for an image path.
     *
     * @param string|null $path The storage path
     * @return string|null The full URL or null
     */
    public function url(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        // If path already starts with /storage/, return as is
        if (str_starts_with($path, '/storage/')) {
            return $path;
        }

        return '/storage/' . $path;
    }
}
