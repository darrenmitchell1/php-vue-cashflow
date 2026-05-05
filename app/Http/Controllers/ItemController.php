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
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Item/Index', ['items' => (new ItemCollection(Item::with(['itemType'])->get()))->collection]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Item/Create', [
            'flows' => fn () => Flow::toCollectionResource(),
            'frequencies' => fn () => Frequency::toCollectionResource(),
            'itemTypes' => fn () => (new ItemTypeCollection(ItemType::get()))->collection
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ItemStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ItemStoreRequest $request): RedirectResponse
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

        return Redirect::route('items.index');
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
     *
     * @param Item $item
     * @return Response
     */
    public function edit(Item $item): Response
    {
        return Inertia::render('Item/Edit', [
            'item' => $item->toResource(),
            'flows' => fn () => Flow::toCollectionResource(),
            'frequencies' => fn () => Frequency::toCollectionResource(),
            'itemTypes' => fn () => (new ItemTypeCollection(ItemType::get()))->collection
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ItemUpdateRequest $request
     * @param Item $item
     * @return RedirectResponse
     */
    public function update(ItemUpdateRequest $request, Item $item): RedirectResponse
    {
        $itemType = ItemType::firstWhere('uuid', $request->item_type_id);

        $item->update(array_merge($request->validated(), ['item_type_id' => $itemType->id]));

        $changes = [
            'old' => $item->getPrevious(),
            'new' => $item->getChanges(),
        ];

        ItemUpdated::dispatch($item, $changes);

        return Redirect::route('items.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Item $item
     * @return RedirectResponse
     */
    public function destroy(Item $item): RedirectResponse
    {
        if (!($item->trashed())) {
            // prevent any further changes being made
            $item->delete();

            ItemDeleted::dispatch($item);
        }

        return Redirect::route('items.index');
    }
}
