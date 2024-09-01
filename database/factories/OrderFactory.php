<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'created_at' => Carbon::now()->subDays(random_int(1, 90))->toDateTimeLocalString(),
            'updated_at' => Carbon::now()->toDateTimeLocalString(),
            'order_number' => 'TEST000' . mb_strtoupper(Str::random()),
            'buyer_name' => $this->faker->name(),
            'total' => 0,
        ];
    }
}
