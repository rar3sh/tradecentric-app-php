<?php

namespace Requests;

use App\Http\Requests\Orders\BulkDeleteRequest;
use Tests\TestCase;

class BulkDeleteRequestTest extends TestCase
{
    public function testRequestRules(): void
    {
        self::assertEquals([
            'ids' => 'required|array',
            'ids.*' => 'exists:orders,id'
        ], (new BulkDeleteRequest())->rules());
    }
}
