<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static OrderFactory factory(...$parameters)
 */
class Order extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'order_number',
        'buyer_name',
        'total',
    ];

    protected $casts = [
      'created_at' => 'datetime',
      'updated_at' => 'datetime',
    ];
}
