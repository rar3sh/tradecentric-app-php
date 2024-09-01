<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\OrdersController;
use App\Http\Requests\Orders\AddEditOrderRequest;
use App\Http\Requests\Orders\OrderFilterRequest;
use App\Models\Order;
use App\Repositories\DatabaseOrderRepository;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class OrdersControllerTest extends TestCase
{
    private MockObject $orderRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = $this->createMock(DatabaseOrderRepository::class);
    }

    private function instantiateController(): OrdersController
    {
        return new OrdersController($this->orderRepository);
    }

    public function testIndexMethodReturnAJsonResponseWithCorrectData(): void
    {
        $items = Order::factory()->count(10)->make();

        $request = new OrderFilterRequest([
            'perPage' => 5,
            'page' => 2,
        ]);

        $this->orderRepository
            ->expects($this->once())
            ->method('getFilteredOrdersPaginated')
            ->with($request)
            ->willReturn(new LengthAwarePaginator($items->toArray(), $items->count(), $request->perPage, $request->page));

        $response = $this->instantiateController()->index($request);
        self::assertJson($response->getContent());

        $decodedResponse = json_decode($response->getContent(), true);

        self::assertArrayHasKey('data', $decodedResponse);
        self::assertArrayHasKey('current_page', $decodedResponse);
        self::assertArrayHasKey('per_page', $decodedResponse);
        self::assertArrayHasKey('last_page', $decodedResponse);
        self::assertArrayHasKey('from', $decodedResponse);
        self::assertArrayHasKey('to', $decodedResponse);
        self::assertArrayHasKey('total', $decodedResponse);

        foreach ($items as $key => $item) {
            self::assertEquals($item->toArray(), $decodedResponse['data'][$key]);
        }
        self::assertEquals(2, $decodedResponse['current_page']);
        self::assertEquals(5, $decodedResponse['per_page']);
        self::assertEquals(2, $decodedResponse['last_page']);
        self::assertEquals(6, $decodedResponse['from']);
        self::assertEquals(10, $decodedResponse['total']);
    }

    public function testStoreMethodReturnAJsonResponseWithCorrectData(): void
    {
        $request = new AddEditOrderRequest([
            'buyer_name' => 'Test Buyer Name',
            'total' => 500,
        ]);

        $order = Order::factory()->makeOne($request->input());

        $this->orderRepository->expects($this->once())->method('store')->with($request->input())->willReturn($order);

        $response = $this->instantiateController()->store($request);
        self::assertJson($response->getContent());

        $decodedResponse = json_decode($response->getContent(), true);

        self::assertEquals('Test Buyer Name', $decodedResponse['buyer_name']);
        self::assertEquals(500, $decodedResponse['total']);
        self::assertEquals($order->order_number, $decodedResponse['order_number']);
        self::assertEquals(
            (string)$order->created_at,
            Carbon::parse($decodedResponse['created_at'])->toDateTimeString()
        );
    }

}
