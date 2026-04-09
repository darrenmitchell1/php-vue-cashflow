<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemStoreRequest;
use App\Http\Requests\ItemUpdateRequest;
use App\Models\Item;
use App\Models\ItemType;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemStoreRequest $request)
    {
        $itemType = ItemType::firstWhere('uuid', $request->item_type_id);

        Item::create(array_merge($request->validated(), ['uuid' => Str::orderedUuid(), 'item_type_id' => $itemType->id]));

        // dispatch itemCreated
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
        // Trigger Item Transaction Update on any change to
        // 'flow' => ['required', 'string', Rule::enum(Flow::class)],
        // 'frequency' => ['required', 'string', Rule::enum(Frequency::class)],
        // 'start_date' => 'required|date:Y-m-d',
        // 'end_date' => 'required|date:Y-m-d',
        // 'amount' => 'required|decimal:2',


        $itemType = ItemType::firstWhere('uuid', $request->item_type_id);

        $item->update(array_merge($request->validated(), ['item_type_id' => $itemType->id]));

        $oldValues = $item->getPrevious();
        $newValues = $item->getChanges();

        // if flow changed then invert transaction amounts

        // if frequency changed then rebuild transactions

        // if dates changed add/delete transactions

        // if amount changed update transactions

        // dispatch itemUpdated
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        if (!($item->trashed())) {
            $item->delete();

            // dispatch itemDeleted
            // on event listener handle deleted model SerializesModels
        }
    }
}
