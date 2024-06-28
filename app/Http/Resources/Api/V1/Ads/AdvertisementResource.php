<?php

namespace App\Http\Resources\Api\V1\Ads;

use App\Enums\AdvertisementStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'     => $this->id,
            'name'   => $this->name,
            'slug'   => $this->slug,
            'distance' => $this->distance,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'author' => UserResource::make($this->user),
            'city' => CityResource::make($this->whenLoaded('city')),
            'object_type' => ObjectTypeResource::make($this->whenLoaded('objectType')),
            'deal_type' => DealTypeResource::make($this->whenLoaded('dealType')),
            'tariff_type' => TariffTypeResource::make($this->whenLoaded('tariffType')),
            'parking_space_size' => ParkingSpaceSizeResource::make($this->whenLoaded('parkingSpaceSize')),
            'parking_space_number' => ParkingSpaceNumberResource::make($this->whenLoaded('parkingSpaceNumber')),
            'characteristics' => CharacteristicResource::collection($this->whenLoaded('characteristics')),
            'price'   => $this->price,
            'area'   => $this->area,
            'description' => $this->description,
            'media' => MediaResource::collection($this->whenLoaded('media')),
            'status' => AdvertisementStatusEnum::getBy($this->status),
            'created_at' => $this->created_at
        ];
    }
}
