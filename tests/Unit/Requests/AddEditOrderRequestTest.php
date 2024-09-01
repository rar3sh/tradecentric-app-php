<?php

namespace Requests;

use App\Http\Requests\Orders\AddEditOrderRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AddEditOrderRequestTest extends TestCase
{
    /**
     * @dataProvider invalidDataProvider
     */
    public function testRequestValidationWithInvalidInput(array $input, $expectedMessage): void
    {
        $request = new AddEditOrderRequest($input);
        $this->expectExceptionMessage($expectedMessage);

        Validator::validate($request->input(), $request->rules());
    }

    public static function invalidDataProvider(): array
    {
        return [
            [['buyer_name' => 'Test valid Buyer'], 'The total field is required.'],
            [['total' => 100], 'The buyer name field is required.'],

            [['buyer_name' => 'test', 'total' => 100], 'The buyer name field must be at least 5 characters.'],
            [['buyer_name' => 'Test valid Buyer', 'total' => -1], 'The total field must be at least 0.'],
        ];
    }

    public function testRequestRules(): void
    {
        self::assertEquals([
            'buyer_name' => 'required|string|min:5',
            'total' => 'required|integer|min:0',
        ], (new AddEditOrderRequest())->rules());
    }
}
