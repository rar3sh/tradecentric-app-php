<?php

namespace App\Repositories;

use App\Http\Requests\Orders\OrderListRequest;
use App\Http\Requests\Orders\AddEditOrderRequest;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function getFilteredOrdersPaginated(OrderListRequest $listRequest): LengthAwarePaginator;

    public function find(string $orderId): ?Order;

    public function store(array $attributes): Order;

    public function delete(array $orderIds): int;
}
