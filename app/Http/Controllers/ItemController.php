<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use App\Serializers\ItemSerializer;
use App\Serializers\ItemsSerializer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\CommonMark\CommonMarkConverter;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();

        return JsonResponse::create(['items' => (new ItemsSerializer($items))->getData()]);
    }

    public function store(StoreItemRequest $request)
    {
        $item = Item::create($request->validated());

        $serializer = new ItemSerializer($item);

        return new JsonResponse(['item' => $serializer->getData()]);
    }

    public function show(Item $item)
    {
        $serializer = new ItemSerializer($item);

        return new JsonResponse(['item' => $serializer->getData()]);
    }

    public function update(UpdateItemRequest $request, Item $item): JsonResponse
    {
        $item->fill($request->validated())->save();

        return new JsonResponse(
            [
                'item' => (new ItemSerializer($item))->getData()
            ]
        );
    }
}
