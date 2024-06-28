<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\AdvertisementStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\FilterRequest;
use App\Http\Requests\Api\V1\SearchRequest;
use App\Http\Resources\Api\V1\Ads\AdvertisementResource;
use App\Http\Resources\Api\V1\Ads\CharacteristicResource;
use App\Http\Resources\Api\V1\Ads\CityResource;
use App\Http\Resources\Api\V1\Ads\DealTypeResource;
use App\Http\Resources\Api\V1\Ads\ObjectTypeResource;
use App\Http\Resources\Api\V1\Ads\ParkingSpaceNumberResource;
use App\Http\Resources\Api\V1\Ads\ParkingSpaceSizeResource;
use App\Http\Resources\Api\V1\Ads\ParkingTypeResource;
use App\Http\Resources\Api\V1\Ads\TariffTypeResource;
use App\Models\Ads\Advertisement;
use App\Models\Ads\Characteristic;
use App\Models\Ads\City;
use App\Models\Ads\DealType;
use App\Models\Ads\ObjectType;
use App\Models\Ads\ParkingSpaceNumber;
use App\Models\Ads\ParkingSpaceSize;
use App\Models\Ads\ParkingType;
use App\Models\Ads\TariffType;
use App\Models\SubscriptionFilter;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\ScoutDriverPlus\Support\Query;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * @tags Advertisements
 */
class AdvertisementsController extends Controller
{
    /**
     * Поиск по объявлениям
     *
     * @param SearchRequest $request
     * @return JsonResponse
     */
    public function findNearby(SearchRequest $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);

        try {
            $client = ClientBuilder::create()
                ->setHosts(config('elastic.client.connections.default.hosts'))
                ->setBasicAuthentication(env('ELASTIC_USERNAME'), env('ELASTIC_PASSWORD'))
                ->build();

            $query = $this->buildFilters($request);

            $params = [
                'index' => 'turaq_advertisements_index',
                'body'  => [
                    '_source' => ['id'],
                    'query' => $query,
                    'from' => ($page - 1) * $perPage,
                    'size' => $perPage,
                ],
            ];

            if ($request->filled('latitude') && $request->filled('longitude')) {
                $params['body']['sort'] = [
                    '_geo_distance' => [
                        'location' => [
                            'lat' => $request->get('latitude'),
                            'lon' => $request->get('longitude'),
                        ],
                        'order' => 'asc',
                        'unit' => 'km',
                        'distance_type' => 'arc',
                    ],
                ];

                $params['body']['script_fields'] = [
                    'distance' => [
                        'script' => [
                            'source' => "doc['location'].arcDistance(params.lat, params.lon)",
                            'params' => [
                                'lat' => floatval($request->get('latitude')),
                                'lon' => floatval($request->get('longitude')),
                            ],
                        ],
                    ]
                ];
            }

            $response = $client->search($params);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'Failed to fetch advertisements from Elasticsearch',
                'message' => $e->getMessage(),
            ], 500);
        }

        $advertisementIds = [];
        $distances = [];
        foreach ($response['hits']['hits'] as $hit) {
            if (isset($hit['_source']['id'])) {
                $advertisementIds[] = $hit['_source']['id'];
                if (isset($hit['fields']['distance'])) {
                    $distances[$hit['_source']['id']] = $hit['fields']['distance'][0];
                }
            }
        }
        $advertisements = Advertisement::query()->whereIn('id', $advertisementIds)
            ->with(['city', 'media', 'objectType', 'tariffType'])
            ->get();

        foreach ($advertisements as $advertisement) {
            if (isset($distances[$advertisement->id])) {
                $advertisement->distance = $distances[$advertisement->id];
            }
        }
        $sortedAdvertisements = $advertisements->sortBy('distance')->values();

        $total = $response['hits']['total']['value'];
        $paginator = new LengthAwarePaginator($sortedAdvertisements, $total, $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return AdvertisementResource::collection($paginator);
    }

    private function buildFilters(SearchRequest $request): array
    {
        $query = ['bool' => ['must' => [], 'filter' => []]];

//        if ($request->filled('query')) {
//            $name = $request->input('query');
//            $query['bool']['must'][] = [
//                'wildcard' => [
//                    'name' => '*' . $name . '*',
//                ],
//            ];
//        }

        if ($request->filled('latitude') && $request->filled('longitude')) {
            $distance = $request->input('distance', '10');
            $query['bool']['filter'][] = [
                'geo_distance' => [
                    'distance' => $distance.'km',
                    'location' => [
                        'lat' => $request->get('latitude'),
                        'lon' => $request->get('longitude'),
                    ],
                ],
            ];
        }

        if ($request->filled('city_id')) {
            $query['bool']['filter'][] = [
                'term' => [
                    'city_id' => $request->get('city_id'),
                ],
            ];
        }

        if ($request->filled('object_type_id')) {
            $query['bool']['filter'][] = [
                'term' => [
                    'object_type_id' => $request->get('object_type_id'),
                ],
            ];
        }

        if ($request->filled('deal_type_id')) {
            $query['bool']['filter'][] = [
                'term' => [
                    'deal_type_id' => $request->get('deal_type_id'),
                ],
            ];
        }

        if ($request->filled('tariff_type_id')) {
            $query['bool']['filter'][] = [
                'term' => [
                    'tariff_type_id' => $request->get('tariff_type_id'),
                ],
            ];
        }

        if ($request->filled('parking_space_size_id')) {
            $query['bool']['filter'][] = [
                'term' => [
                    'parking_space_size_id' => $request->get('parking_space_size_id'),
                ],
            ];
        }

        if ($request->filled('parking_space_number_id')) {
            $query['bool']['filter'][] = [
                'term' => [
                    'parking_space_number_id' => $request->get('parking_space_number_id'),
                ],
            ];
        }

        if ($request->filled('parking_type_id')) {
            $query['bool']['filter'][] = [
                'term' => [
                    'parking_type_id' => $request->get('parking_type_id'),
                ],
            ];
        }

//        if ($request->filled('characteristic_ids')) {
//            $query['bool']['filter'][] = [
//                'terms' => [
//                    'city_id' => $request->get('city_id'),
//                ],
//            ];
//        }

        $areaRange = [];
        if ($request->filled('min_area')) {
            $areaRange['gte'] = $request->get('min_area');
        }
        if ($request->filled('max_area')) {
            $areaRange['lte'] = $request->get('max_area');
        }
        if (!empty($areaRange)) {
            $query['bool']['filter'][] = [
                'range' => [
                    'area' => $areaRange,
                ],
            ];
        }

        $priceRange = [];
        if ($request->filled('min_price')) {
            $priceRange['gte'] = $request->get('min_price');
        }
        if ($request->filled('max_price')) {
            $priceRange['lte'] = $request->get('max_price');
        }
        if (!empty($priceRange)) {
            $query['bool']['filter'][] = [
                'range' => [
                    'price' => $priceRange,
                ],
            ];
        }

        $query['bool']['filter'][] = [
            'term' => [
                'status' => AdvertisementStatusEnum::PUBLISHED,
            ],
        ];

        return $query;
    }

    /**
     * Получить объявление
     *
     * @param Advertisement $advertisement
     * @return AdvertisementResource
     */
    public function get(Advertisement $advertisement): AdvertisementResource
    {
        $advertisement->load('city', 'objectType', 'dealType', 'tariffType', 'parkingSpaceSize',  'parkingSpaceNumber', 'characteristics', 'media');

        return AdvertisementResource::make($advertisement);
    }

    /**
     * Получение справочника
     *
     * @return array
     */
    public function getDictionaries(): array
    {
        $filter = Query::term()
            ->field('is_active')
            ->value(true);
        $query = Query::bool()->filter($filter);

        $cities = City::searchQuery($query)->execute()->models();
        $objectTypes = ObjectType::searchQuery($query)->execute()->models();
        $dealTypes = DealType::searchQuery($query)->execute()->models();
        $tariffTypes = TariffType::searchQuery($query)->execute()->models();
        $parkingSpaceSizes = ParkingSpaceSize::with('media')->where('is_active', true)->orderBy('created_at')->get();
        $parkingSpaceNumbers = ParkingSpaceNumber::searchQuery($query)->execute()->models();
        $characteristics = Characteristic::searchQuery($query)->execute()->models();
        $parkingTypes = ParkingType::searchQuery($query)->execute()->models();

        return [
            'cities' => CityResource::collection($cities),
            'object_types' => ObjectTypeResource::collection($objectTypes),
            'deal_types' => DealTypeResource::collection($dealTypes),
            'tariff_types' => TariffTypeResource::collection($tariffTypes),
            'parking_space_sizes' => ParkingSpaceSizeResource::collection($parkingSpaceSizes),
            'parking_space_numbers' => ParkingSpaceNumberResource::collection($parkingSpaceNumbers),
            'characteristics' => CharacteristicResource::collection($characteristics),
            'parking_types' => ParkingTypeResource::collection($parkingTypes),
        ];
    }

    /**
     * Подписаться на фильтры
     *
     * @param FilterRequest $request
     * @return JsonResponse
     */
    public function subscriptionToFilters(FilterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        SubscriptionFilter::create($data);

        return response()->json(['success' => true]);
    }

}
