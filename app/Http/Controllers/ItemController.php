<?php

namespace App\Http\Controllers;

use App\Enums\Flow;
use App\Enums\Frequency;
use App\Events\ItemCreated;
use App\Events\ItemDeleted;
use App\Events\ItemUpdated;
use App\Http\Requests\ItemStoreRequest;
use App\Http\Requests\ItemUpdateRequest;
use App\Http\Resources\ItemCollection;
use App\Http\Resources\ItemTypeCollection;
use App\Models\Item;
use App\Models\ItemType;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Item/Index', ['items' => (new ItemCollection(Item::with(['itemType'])->get()))->collection]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Item/Create', [
            'flows' => fn () => Flow::toCollectionResource(),
            'frequencies' => fn () => Frequency::toCollectionResource(),
            'itemTypes' => fn () => (new ItemTypeCollection(ItemType::get()))->collection
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemStoreRequest $request)
    {
        $request->validated();

        $itemType = ItemType::firstWhere('uuid', $request->item_type_id);

        $amount = $request->amount;

        // ensure the amount is + or - depending on the flow
        if ($request->flow === 'in' && $amount < 0) {
            $amount = abs($amount);
        } elseif ($request->flow === 'out' && $amount > 0) {
            $amount = -$amount;
        }

        $item = Item::create(array_merge($request->validated(), [
            'uuid' => Str::orderedUuid(),
            'item_type_id' => $itemType->id,
            'amount' => $amount
        ]));

        ItemCreated::dispatch($item);

        return Inertia::render('Item/Index', ['items' => (new ItemCollection(Item::get()))->collection]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemUpdateRequest $request, Item $item)
    {
        $itemType = ItemType::firstWhere('uuid', $request->item_type_id);

        $item->update(array_merge($request->validated(), ['item_type_id' => $itemType->id]));

        $changes = [
            'old' => $item->getPrevious(),
            'new' => $item->getChanges(),
        ];

        ItemUpdated::dispatch($item, $changes);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        if (!($item->trashed())) {
            // prevent any further changes being made
            $item->delete();

            ItemDeleted::dispatch($item);
        }
    }
}
