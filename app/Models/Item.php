<?php

namespace App\Models;

use App\Enums\Flow;
use App\Enums\Frequency;
use Database\Factories\ItemFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    /** @use HasFactory<ItemFactory> */
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
        'number_of_transactions',
        'description',
        'company_name',
        'amount',
        'reference',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'item_type_id',
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
        ];
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['itemType'];

    /**
     * Get the end date.
     *
     * The end date will be the last trasnaction date so need to reduce num of trans by one so dates are correct
     * eg. 1 transaction would start and end on same date
     */
    protected function endDate(): Attribute
    {
        return Attribute::make(
            get: fn () => (clone $this->start_date)
                ->add($this->frequency->interval($this->number_of_transactions - 1)),
        );
    }

    /**
     * Get the Item Type for this Item
     */
    public function itemType(): BelongsTo
    {
        return $this->belongsTo(ItemType::class)->withTrashed();
    }

    /**
     * Get the Item Transactions for this Item
     */
    public function itemTransactions(): HasMany
    {
        return $this->hasMany(ItemTransaction::class);
    }
}
