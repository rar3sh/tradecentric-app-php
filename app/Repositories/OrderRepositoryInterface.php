<?php

namespace App\Repositories;

use App\Http\Requests\OrderListRequest;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function getFilteredOrdersPaginated(OrderListRequest $listRequest): LengthAwarePaginator;

    public function find(string $orderId): ?Order;

    public function store(OrderRequest $request): Order;

    public function delete(string $orderId): int;
}
