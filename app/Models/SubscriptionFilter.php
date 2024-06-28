<?php

namespace App\Models;

use App\Models\Ads\City;
use App\Models\Ads\DealType;
use App\Models\Ads\ObjectType;
use App\Models\Ads\ParkingSpaceNumber;
use App\Models\Ads\ParkingSpaceSize;
use App\Models\Ads\TariffType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionFilter extends Model
{
    use HasFactory;

    protected $fillable = [
        'query',
        'distance',
        'latitude',
        'longitude',
        'user_id',
        'city_id',
        'object_type_id',
        'deal_type_id',
        'tariff_type_id',
        'parking_space_size_id',
        'parking_space_number_id',
        'min_price',
        'max_price',
        'min_area',
        'max_area'
    ];

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

    public function parkingSpaceSize(): BelongsTo
    {
        return $this->belongsTo(ParkingSpaceSize::class);
    }

    public function parkingSpaceNumber(): BelongsTo
    {
        return $this->belongsTo(ParkingSpaceNumber::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
