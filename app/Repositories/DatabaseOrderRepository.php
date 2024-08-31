<?php

namespace App\Repositories;

use App\Http\Requests\Orders\OrderListRequest;
use App\Http\Requests\Orders\AddEditOrderRequest;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class DatabaseOrderRepository implements OrderRepositoryInterface
{
    public const MAX_PER_PAGE = 100;
    public const DEFAULT_PAGE_SIZE = 10;

    public function getFilteredOrdersPaginated(OrderListRequest $listRequest): LengthAwarePaginator
    {
        $perPage = min(self::MAX_PER_PAGE, $listRequest->get('perPage', self::DEFAULT_PAGE_SIZE));
        $page = max(1, $listRequest->get('page'));
        $orderQuery = Order::query()->withoutTrashed();

        if ($listRequest->filled('buyer_name')) {
            $orderQuery->where('buyer_name', 'like', '%' . $listRequest->validated('buyer_name') . '%');
        }
        if ($listRequest->filled('order_number')) {
            $orderQuery->where('order_number', $listRequest->validated('order_number'));
        }
        if ($listRequest->filled('total_minimum')) {
            $orderQuery->where('total',  '>=', $listRequest->validated('total_minimum'));
        }

        return $orderQuery
            ->orderByDesc('created_at')
            ->paginate($perPage, page: $page);
    }

    public function find(string $orderId): ?Order
    {
        return Order::query()->find($orderId);
    }

    public function store(array $attributes): Order
    {
        $order = new Order($attributes);
        $order->order_number = 'TC000' . mb_strtoupper(Str::random());
        $order->save();

        return $order->refresh();
    }

    public function delete(array $orderIds): int
    {
        return Order::query()->whereIn('id', $orderIds)->delete();
    }
}
