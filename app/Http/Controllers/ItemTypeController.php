<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Http\Requests\ItemTypeStoreRequest;
use App\Http\Requests\ItemTypeUpdateRequest;
use App\Http\Resources\ItemTypeCollection;
use App\Models\ItemType;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('ItemType/Index', ['itemTypes' => (new ItemTypeCollection(ItemType::withTrashed()->get()))->collection]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('ItemType/Create', ['categories' => fn () => Category::toCollectionResource()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemTypeStoreRequest $request)
    {
        ItemType::create(array_merge($request->validated(), ['uuid' => Str::orderedUuid()]));

        return Redirect::route('item_types.index', ['itemTypes' => (new ItemTypeCollection(ItemType::withTrashed()->get()))->collection]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemType $itemType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemType $itemType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemTypeUpdateRequest $request, ItemType $itemType)
    {
        $itemType->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemType $itemType)
    {
        if (!($itemType->trashed())) {
            $itemType->delete();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function restore(ItemType $itemType)
    {
        if ($itemType->trashed()) {
            $itemType->restore();
        }
    }
}
