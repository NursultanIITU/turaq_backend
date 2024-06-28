<?php

namespace App\Models\Ads;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Elastic\ScoutDriverPlus\Searchable;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasFactory, HasTranslations, Searchable;

    protected $fillable = ['name', 'is_active'];
    protected $translatable = ['name'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function searchableAs(): string
    {
        return 'turaq_cities_index';
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_active' => $this->is_active,
        ];
    }
}
