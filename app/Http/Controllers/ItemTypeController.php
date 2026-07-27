<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Http\Requests\ItemTypeStoreRequest;
use App\Http\Requests\ItemTypeUpdateRequest;
use App\Http\Resources\ItemTypeCollection;
use App\Models\ItemType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('ItemType/Index', ['itemTypes' => (new ItemTypeCollection(ItemType::withTrashed()->get()))->collection]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('ItemType/Create', ['categories' => fn () => Category::toCollectionResource()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemTypeStoreRequest $request): RedirectResponse
    {
        ItemType::create(array_merge($request->validated(), ['uuid' => Str::orderedUuid()]));

        return Redirect::route('item_types.index');
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
    public function edit(ItemType $itemType): Response
    {
        return Inertia::render('ItemType/Edit', [
            'itemType' => $itemType->toResource(),
            'categories' => fn () => Category::toCollectionResource()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemTypeUpdateRequest $request, ItemType $itemType): RedirectResponse
    {
        $itemType->update($request->validated());

        return Redirect::route('item_types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemType $itemType): JsonResponse
    {
        if (! ($itemType->trashed())) {
            $itemType->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Item Type Deleted successfully.',
            'data' => $itemType->toResource()
        ]);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(ItemType $itemType): JsonResponse
    {
        if ($itemType->trashed()) {
            $itemType->restore();
        }

        return response()->json([
            'success' => true,
            'message' => 'Item Type Restored successfully.',
            'data' => $itemType->toResource()
        ]);
    }
}
