<?php

namespace Requests;

use App\Http\Requests\Orders\OrderFilterRequest;
use Tests\TestCase;

class OrderFilterRequestTest extends TestCase
{
    public function testRequestRules(): void
    {
        self::assertEquals([
            'perPage' => 'integer|min:1',
            'page' => 'integer|min:1',
            'order_number' => 'sometimes|string|nullable',
            'buyer_name' => 'sometimes|string|nullable',
            'total_minimum' => 'sometimes|integer|nullable',
            'created_after' => 'date|nullable',
        ], (new OrderFilterRequest())->rules());
    }
}
