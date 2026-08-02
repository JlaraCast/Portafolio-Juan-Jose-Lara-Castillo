<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
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
     * @param  UploadedFile  $file  The uploaded file
     * @param  string  $directory  The storage directory (e.g., 'projects', 'experiences')
     * @param  string|null  $oldPath  Optional path to old image to delete
     * @return string The public path to the uploaded image
     */
    public function upload(UploadedFile $file, string $directory, ?string $oldPath = null): string
    {
        // Delete old image if exists
        if ($oldPath) {
            $this->delete($oldPath);
        }

        // Determine disk based on environment
        $disk = env('FILESYSTEM_DISK', 'public');

        if ($disk === 'cloudinary') {
            // Upload to Cloudinary
            $result = $file->storeOnCloudinary($directory);

            return $result->getSecurePath();
        }

        // Store locally (public disk)
        $path = $file->store($directory, 'public');

        return '/storage/'.$path;
    }

    /**
     * Delete an image from storage.
     *
     * @param  string  $path  The path to the image (e.g., '/storage/projects/image.jpg')
     * @return bool Whether the deletion was successful
     */
    public function delete(string $path): bool
    {
        // Determine disk based on environment
        $disk = env('FILESYSTEM_DISK', 'public');

        if ($disk === 'cloudinary' && str_contains($path, 'cloudinary.com')) {
            $publicId = $this->extractCloudinaryPublicId($path);

            if (! $publicId) {
                return false;
            }

            $result = Cloudinary::destroy($publicId);

            return ($result['result'] ?? null) === 'ok';
        }

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
     * @param  string|null  $path  The storage path
     * @return string|null The full URL or null
     */
    public function url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        // If path is already a full URL (Cloudinary), return it
        if (str_starts_with($path, 'http')) {
            return $path;
        }

        // If path already starts with /storage/, return as is
        if (str_starts_with($path, '/storage/')) {
            return $path;
        }

        return '/storage/'.$path;
    }

    /**
     * Get a Cloudinary URL with delivery optimizations applied (auto format/quality).
     * Non-Cloudinary URLs (local storage) are returned unchanged.
     *
     * @param  string|null  $url  The image URL
     * @param  string  $transformations  Cloudinary transformation string
     */
    public function optimizedUrl(?string $url, string $transformations = 'f_auto,q_auto'): ?string
    {
        if (! $url || ! str_contains($url, '/upload/')) {
            return $url;
        }

        return str_replace('/upload/', "/upload/{$transformations}/", $url);
    }

    /**
     * Extract the Cloudinary public ID (folder/filename without version or extension)
     * from a delivery URL.
     */
    private function extractCloudinaryPublicId(string $url): ?string
    {
        $path = parse_url($url, PHP_URL_PATH);

        if (! $path || ! str_contains($path, '/upload/')) {
            return null;
        }

        // Everything after "/upload/", e.g. "v1700000000/projects/abc123.jpg"
        $afterUpload = substr($path, strpos($path, '/upload/') + strlen('/upload/'));

        // Drop a leading version segment like "v1700000000/"
        $afterUpload = preg_replace('#^v\d+/#', '', $afterUpload);

        // Drop the file extension
        return preg_replace('#\.[a-zA-Z0-9]+$#', '', $afterUpload);
    }
}
