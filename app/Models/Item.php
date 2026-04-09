<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Enums\Flow;
use App\Enums\Frequency;

class Item extends Model
{
    /** @use HasFactory<\Database\Factories\ItemFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'item_type_id',
        'flow',
        'frequency',
        'start_date',
        'end_date',
        'description',
        'company_name',
        'amount',
        'reference'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'item_type_id'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'flow' => Flow::class,
            'frequency' => Frequency::class,
            'start_date' => 'datetime',
            'end_date' => 'datetime'
        ];
    }

    /**
     * Get the Item Type for the Item
     */
    public function itemType(): BelongsTo
    {
        return $this->belongsTo(ItemType::class);
    }

    /**
     * Get the Item Transactions for the Item
     */
    public function itemTransactions(): HasMany
    {
        return $this->hasMany(ItemTransaction::class);
    }
}
