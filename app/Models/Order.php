<?php

namespace App\Models;

use App\Enums\OrderDeliveryMethodType;
use App\Enums\OrderPaymentMethodType;
use App\Enums\OrderStatusType;
use App\Traits\Models\Relations\OrderRelations;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $customer_id
 * @property OrderStatusType $status
 * @property string $delivery_method
 * @property string $payment_method
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read float $price
 * @property-read \App\Models\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $orderItems
 * @property-read int|null $order_items_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDeliveryMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    use OrderRelations;

    protected $fillable = [
        'status',
        'address',
        'delivery_method',
        'payment_method',
    ];

    protected $casts = [
        'status' => OrderStatusType::class,
        'delivery_method' => OrderDeliveryMethodType::class,
        'payment_method' => OrderPaymentMethodType::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getPriceAttribute(): float
    {
        return $this->orderItems->map(function ($item) {
            return $item->total_price;
        })->sum();
    }

} 