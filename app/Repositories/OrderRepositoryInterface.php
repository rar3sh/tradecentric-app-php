<?php

namespace App\Repositories;

use App\Http\Requests\Orders\OrderFilterRequest;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function getFilteredOrdersPaginated(OrderFilterRequest $listRequest): LengthAwarePaginator;

    public function find(string $orderId): ?Order;

    public function store(array $attributes): Order;

    public function delete(array $orderIds): int;
}
