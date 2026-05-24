<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AudioUpload
{
    public static function store(
        ?UploadedFile $file,
        string $directory = 'audios',
        string $disk = 'public',
        ?string $oldPath = null,
        array $allowedExtensions = ['mp3'],
    ): ?string {
        if ($file === null || ! $file->isValid()) {
            return null;
        }

        $extension = strtolower($file->extension() ?: $file->getClientOriginalExtension());
        if ($extension === '' || ! in_array($extension, $allowedExtensions, true)) {
            return null;
        }

        $path = $file->storeAs($directory, Str::uuid()->toString().'.'.$extension, $disk);

        if ($path !== false && $oldPath) {
            self::delete($oldPath, $disk);
        }

        return $path ?: null;
    }

    public static function delete(?string $path, string $disk = 'public'): void
    {
        if ($path === null || self::isExternalUrl($path)) {
            return;
        }

        $relativePath = self::normalizePath($path);

        Storage::disk($disk)->delete($relativePath);

        $publicPath = public_path($relativePath);
        if (File::exists($publicPath)) {
            File::delete($publicPath);
        }
    }

    public static function url(?string $path): ?string
    {
        if ($path === null || trim($path) === '') {
            return null;
        }

        if (self::isExternalUrl($path)) {
            return $path;
        }

        $relativePath = self::normalizePath($path);

        if (! Storage::disk('public')->exists($relativePath)) {
            return null;
        }

        return asset('storage/'.$relativePath);
    }

    private static function isExternalUrl(string $path): bool
    {
        return preg_match('#^(https?:)?//#i', $path) === 1;
    }

    private static function normalizePath(string $path): string
    {
        $path = ltrim(trim($path), '/');

        if (str_starts_with($path, 'storage/')) {
            return substr($path, strlen('storage/'));
        }

        return $path;
    }
}
