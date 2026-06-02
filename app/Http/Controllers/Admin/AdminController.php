<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

abstract class AdminController extends Controller
{
    /**
     * Generate a unique slug for the given model class. Handles collisions by
     * appending -1, -2, etc. Honours soft-deleted rows when applicable.
     */
    protected function uniqueSlug(string $modelClass, string $name, ?int $ignoreId = null, string $column = 'slug'): string
    {
        $base = Str::slug($name);
        $slug = $base !== '' ? $base : 'item';
        $i = 1;

        while ($this->slugExists($modelClass, $column, $slug, $ignoreId)) {
            $slug = $base . '-' . (++$i);
        }
        return $slug;
    }

    private function slugExists(string $modelClass, string $column, string $slug, ?int $ignoreId): bool
    {
        $query = $modelClass::query()->where($column, $slug);
        if ($ignoreId !== null) {
            $query->where('id', '!=', $ignoreId);
        }
        if (method_exists($modelClass, 'bootSoftDeletes')) {
            $query->withTrashed();
        }
        return $query->exists();
    }

    /**
     * Store an uploaded file to public disk and return the relative path.
     * If $oldPath is provided, deletes the previous file.
     */
    protected function storeImage(?UploadedFile $file, string $folder, ?string $oldPath = null): ?string
    {
        if (! $file || ! $file->isValid()) {
            return $oldPath;
        }
        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }
        return $file->store($folder, 'public');
    }

    /**
     * Delete a file from public disk if it exists.
     */
    protected function deleteImage(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Build options list of integers 1..max for an "order" dropdown.
     */
    protected function orderOptions(int $max = 50): array
    {
        return range(1, $max);
    }
}
