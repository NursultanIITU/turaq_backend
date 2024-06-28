<?php

namespace App\Models\Ads;

use Elastic\ScoutDriverPlus\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TariffType extends Model
{
    use HasFactory, HasTranslations, Searchable;

    protected $fillable = ['title', 'is_active'];
    protected $translatable = ['title'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function searchableAs(): string
    {
        return 'turaq_tariff_types_index';
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
