<?php

namespace App\Models\Ads;

use Elastic\ScoutDriverPlus\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class ParkingSpaceSize extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia, Searchable;

    protected $fillable = ['title', 'is_active'];
    protected $translatable = ['title'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function searchableAs(): string
    {
        return 'turaq_parking_space_sizes_index';
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'is_active' => $this->is_active,
        ];
    }
}
