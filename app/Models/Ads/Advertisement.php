<?php

namespace App\Models\Ads;

use App\Enums\AdvertisementStatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Elastic\ScoutDriverPlus\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Advertisement extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasSlug, Searchable;

    protected $fillable = [
        'name',
        'slug',
        'latitude',
        'longitude',
        'user_id',
        'city_id',
        'object_type_id',
        'deal_type_id',
        'tariff_type_id',
        'parking_space_size_id',
        'parking_space_number_id',
        'parking_type_id',
        'price',
        'area',
        'description',
        'status',
        'created_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'status' => AdvertisementStatusEnum::class
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function objectType(): BelongsTo
    {
        return $this->belongsTo(ObjectType::class);
    }

    public function dealType(): BelongsTo
    {
        return $this->belongsTo(DealType::class);
    }

    public function tariffType(): BelongsTo
    {
        return $this->belongsTo(TariffType::class);
    }

    public function parkingType(): BelongsTo
    {
        return $this->belongsTo(ParkingType::class);
    }

    public function parkingSpaceSize(): BelongsTo
    {
        return $this->belongsTo(ParkingSpaceSize::class);
    }

    public function parkingSpaceNumber(): BelongsTo
    {
        return $this->belongsTo(ParkingSpaceNumber::class);
    }

    public function characteristics(): BelongsToMany
    {
        return $this->belongsToMany(Characteristic::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function searchableAs(): string
    {
        return 'turaq_advertisements_index';
    }

    public function toSearchableArray(): array
    {
        $data = $this->toArray();
        $data['location'] = [
            'lat' => floatval($this->latitude),
            'lon' => floatval($this->longitude)
        ];
        return $data;
    }

}
