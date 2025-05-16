<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'filename',
        'file_path',
        'file_type',
        'file_size',
        'file_ext',
        'category',
        'is_image',
        'is_favorite',
        'downloads',
        'display_order'
    ];

    protected $casts = [
        'is_image' => 'boolean',
        'is_favorite' => 'boolean',
        'file_size' => 'integer',
        'downloads' => 'integer',
    ];

    /**
     * Get the user that owns the file.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include image files.
     */
    public function scopeImages($query)
    {
        return $query->where('is_image', true);
    }

    /**
     * Scope a query to only include non-image files.
     */
    public function scopeDocuments($query)
    {
        return $query->where('is_image', false);
    }

    /**
     * Scope a query to only include favorite files.
     */
    public function scopeFavorites($query)
    {
        return $query->where('is_favorite', true);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
