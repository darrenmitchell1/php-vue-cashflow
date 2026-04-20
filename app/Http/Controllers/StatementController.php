<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatementShowRequest;
use App\Models\Item;
use App\Models\ItemTransaction;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class StatementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Statement/Index');
    }

    /**
     * Display the specified resource.
     *
     * @param StatementShowRequest $request
     * @return JsonResponse
     */
    public function show(StatementShowRequest $request): JsonResponse
    {
        $request->validated();

        $periodFrom = $request->date('period_from');
        $periodTo = $request->date('period_to');

        $items = Item::with('itemType')
            ->whereNot('start_date', '>', $periodTo)
            ->withSum([
            'itemTransactions' => function ($query) use ($periodFrom, $periodTo) {
                $query->whereBetween('transaction_date', [$periodFrom, $periodTo]);
            }], 'amount')
            ->get()->whereNotNull('item_transactions_sum_amount');  // ignore where no transactions found

        // build the statement item structure
        $itemCategoryies = [];
        foreach ($items as $item) {
            $itemCategoryies[$item->itemType->category->value] = [
                'item_type' => $item->itemType->toResource(),
                'item' => $item->toResource(),
                'item_period_amount' => $item->item_transactions_sum_amount,
            ];
        }
 
        // ensure response date formats are YYYY-MM-DDTHH:MM:SS.uuuuuuZ 
        $response = [
            'period_from' => $periodFrom->toIso8601String(),
            'period_to' => $periodTo->toIso8601String(),
            'opening_in_balance_amount' => ItemTransaction::whereRelation ('item', 'flow', 'in')
                ->whereDate('transaction_date', '<', $periodFrom)
                ->sum('amount'),
            'opening_out_balance_amount' => ItemTransaction::whereRelation ('item', 'flow', 'out')
                ->whereDate('transaction_date', '<', $periodFrom)
                ->sum('amount'),
            'closing_in_balance_amount' => ItemTransaction::whereRelation ('item', 'flow', 'in')
                ->whereBetween('transaction_date', [$periodFrom, $periodTo])
                ->sum('amount'),
            'closing_out_balance_amount' => ItemTransaction::whereRelation ('item', 'flow', 'out')
                ->whereBetween('transaction_date', [$periodFrom, $periodTo])
                ->sum('amount'),
            'item_categories' => $itemCategoryies,
        ];

        return response()->json(['statement' => $response]);
    }
}
