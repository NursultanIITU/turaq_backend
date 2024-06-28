<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum AdvertisementStatusEnum: int implements HasLabel, HasColor, HasIcon
{
    case ON_MODERATION = 0;
    case PUBLISHED = 1;
    case REJECTED = 2;
    case ARCHIVE = 3;

    public static function getAllValues(): array
    {
        return array_column(AdvertisementStatusEnum::cases(), 'value');
    }

    public static function getAllValuesInString(): string
    {
        return implode(',', array_column(AdvertisementStatusEnum::cases(), 'value'));
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ON_MODERATION => 'На модерации',
            self::PUBLISHED => 'Опубликовано',
            self::REJECTED => 'Отклонено',
            self::ARCHIVE => 'В архиве',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::ON_MODERATION => 'info',
            self::PUBLISHED => 'success',
            self::REJECTED => 'danger',
            self::ARCHIVE => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ON_MODERATION => 'heroicon-m-arrow-path',
            self::PUBLISHED => 'heroicon-m-check-badge',
            self::REJECTED => 'heroicon-m-x-circle',
            self::ARCHIVE => 'heroicon-o-rectangle-stack',
        };
    }

    public static function getBy($type): string
    {
        return match ($type) {
            self::ON_MODERATION => 'on_moderation',
            self::PUBLISHED => 'published',
            self::REJECTED => 'rejected',
            self::ARCHIVE => 'archive',
        };
    }
}
