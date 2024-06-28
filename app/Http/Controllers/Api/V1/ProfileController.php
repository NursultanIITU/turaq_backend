<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ProfileRequest;
use App\Http\Resources\Api\V1\ProfileResource;
use Illuminate\Support\Facades\Auth;

/**
 * @tags Profile
 */
class ProfileController extends Controller
{
    /**
     * Получение информаций о профиле
     *
     * @return ProfileResource
     */
    public function getProfile(): ProfileResource
    {
        $user = auth()->user();

        return ProfileResource::make($user);
    }

    /**
     * Обновление профиля
     *
     * @param ProfileRequest $request
     * @return ProfileResource
     */
    public function update(ProfileRequest $request): ProfileResource
    {
        $data = $request->validated();

        auth()->user()->update($data);

        return ProfileResource::make(auth()->user());
    }

}
