<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\AdvertisementStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\SubmitAnAddRequest;
use App\Http\Requests\Api\V1\UpdateAnAddRequest;
use App\Http\Resources\Api\V1\Ads\AdvertisementResource;
use App\Models\Ads\Advertisement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @tags Advertisements
 */
class MyAdvertisementsController extends Controller
{
    /**
     * Получить список моих объявлений
     *
     * @return AnonymousResourceCollection
     */
    public function getAll(): AnonymousResourceCollection
    {
        $advertisements = Advertisement::with('city', 'media', 'objectType', 'tariffType')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return AdvertisementResource::collection($advertisements);
    }

    /**
     * Получить мою объявлению через slug
     *
     * @param Advertisement $advertisement
     * @return AdvertisementResource
     */
    public function get($advertisement): AdvertisementResource
    {
        $advertisement = Advertisement::with('city', 'objectType', 'dealType', 'tariffType', 'parkingSpaceSize',  'parkingSpaceNumber', 'characteristics', 'media')
            ->where('user_id', auth()->id())
            ->where('slug', $advertisement)
            ->firstOrFail();

        return AdvertisementResource::make($advertisement);
    }


    /**
     * Подать объявление
     *
     * @param SubmitAnAddRequest $request
     * @return AdvertisementResource
     */
    public function create(SubmitAnAddRequest $request): AdvertisementResource
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $advertisement = Advertisement::create($data);
        foreach ($data['images'] as $image) {
            $advertisement->addMedia($image)->toMediaCollection('images');
        }
        $advertisement->characteristics()->attach($data['characteristics_ids']);
        $advertisement->refresh();
        $advertisement->load('city', 'objectType', 'dealType', 'tariffType', 'parkingSpaceSize', 'parkingSpaceNumber', 'media');

        return AdvertisementResource::make($advertisement);
    }

    /**
     * Редактировать объявление
     *
     * @param UpdateAnAddRequest $request
     * @param $advertisement
     * @return AdvertisementResource
     */
    public function update(UpdateAnAddRequest $request, $advertisement): AdvertisementResource
    {
        $data = $request->validated();

        $advertisement = Advertisement::where('user_id', auth()->id())
            ->where('slug', $advertisement)
            ->firstOrFail();

        $data['status'] = AdvertisementStatusEnum::ON_MODERATION;
        $advertisement->update($data);
        if (array_key_exists('images', $data)) {
            $advertisement->clearMediaCollection('images');
            foreach ($data['images'] as $image) {
                $advertisement->addMedia($image)->toMediaCollection('images');
            }
        }

        $advertisement->refresh();
        $advertisement->load('city', 'objectType', 'dealType', 'tariffType', 'parkingSpaceSize', 'parkingSpaceNumber', 'media');

        return AdvertisementResource::make($advertisement);
    }


    /**
     * Удалить объявление
     *
     * @param $advertisement
     * @return JsonResponse
     */
    public function delete($advertisement): JsonResponse
    {
        $advertisement = Advertisement::where('user_id', auth()->id())
            ->where('slug', $advertisement)
            ->firstOrFail();

        if ($advertisement) {
            $advertisement->delete();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Отправить в архив
     *
     * @param $advertisement
     * @return AdvertisementResource
     */
    public function sendToArchive($advertisement): AdvertisementResource
    {
        $advertisement = Advertisement::where('user_id', auth()->id())
            ->where('slug', $advertisement)
            ->firstOrFail();

        $advertisement->update(['status' => AdvertisementStatusEnum::ARCHIVE]);

        $advertisement->refresh();
        $advertisement->load('city', 'objectType', 'dealType', 'tariffType', 'parkingSpaceSize', 'parkingSpaceNumber', 'media');

        return AdvertisementResource::make($advertisement);
    }

    /**
     * Отправить в архив
     *
     * @param $advertisement
     * @return AdvertisementResource
     */
    public function sendToUnArchive($advertisement): AdvertisementResource
    {
        $advertisement = Advertisement::where('user_id', auth()->id())
            ->where('slug', $advertisement)
            ->firstOrFail();

        $advertisement->update(['status' => AdvertisementStatusEnum::PUBLISHED]);

        $advertisement->refresh();
        $advertisement->load('city', 'objectType', 'dealType', 'tariffType', 'parkingSpaceSize', 'parkingSpaceNumber', 'media');

        return AdvertisementResource::make($advertisement);
    }

}
