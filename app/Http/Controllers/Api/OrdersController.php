<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\BulkDeleteRequest;
use App\Http\Requests\Orders\OrderListRequest;
use App\Http\Requests\Orders\NewOrderRequest;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\JsonResponse;

class OrdersController extends Controller
{
    public function __construct(private readonly OrderRepositoryInterface $orderRepository)
    {
    }

    public function index(OrderListRequest $orderListRequest): JsonResponse {
        $orders = $this->orderRepository->getFilteredOrdersPaginated($orderListRequest);

        return response()->json($orders->toArray());
    }

    public function store(NewOrderRequest $request)
    {
        return $this->orderRepository->store($request);
    }

    public function show(string $id): JsonResponse
    {
        $order = $this->orderRepository->find($id);

        return $order ? response()->json($order->toArray()) : response()->json(status: 404);
    }

    public function update(NewOrderRequest $request, string $id)
    {
        $order = $this->orderRepository->find($id);

        if (!$order) {
            return response()->json([
                'error' => "Order $id not found."
            ], 404);
        }

        $order->update($request->validated());

        return response()->json($order->toArray());
    }

    public function delete(string $id): JsonResponse
    {
        $this->orderRepository->delete([$id]);

        return response()->json();
    }

    public function deleteBulk(BulkDeleteRequest $request): JsonResponse
    {
        $count = $this->orderRepository->delete($request->input('ids'));

        return response()->json([
            'message' => "$count order(s) deleted successfully."
        ]);
    }
}
