<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Advertisement\StoreAdvertisementRequest;
use App\Http\Requests\API\Advertisement\UpdateAdvertisementRequest;
use App\Http\Resources\Advertisement\AdvertisementCollection;
use App\Http\Resources\Advertisement\AdvertisementResource;
use App\Models\Advertisement;
use App\Services\StorageService;
use Illuminate\Http\JsonResponse;

class AdvertisementController extends Controller
{
    public function index(): AdvertisementCollection
    {
        return new AdvertisementCollection(Advertisement::query()->paginate(30));
    }

    public function store(StoreAdvertisementRequest $request, StorageService $storage): JsonResponse
    {
        $advertisement = Advertisement::query()->create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'user_id' => auth()->id(),
        ]);
        if ($request->hasFile('file')) {
            $storage->storeFile($request->file('file'), $advertisement);
        }

        return message('Объявление создано');
    }

    public function show(Advertisement $advertisement): AdvertisementResource
    {
        return new AdvertisementResource($advertisement);
    }

    public function destroy(Advertisement $advertisement): JsonResponse
    {
        $advertisement->attachments()->delete();
        $advertisement->delete();

        return message('Объявление успешно удалено');
    }

    public function update(UpdateAdvertisementRequest $request, Advertisement $advertisement): JsonResponse
    {
        $advertisement->update($request->validated());

        return message('Данные по объявлению успешно обновлены');
    }
}
