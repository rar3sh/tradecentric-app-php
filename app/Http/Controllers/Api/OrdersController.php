<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\BulkDeleteRequest;
use App\Http\Requests\Orders\OrderListRequest;
use App\Http\Requests\Orders\AddEditOrderRequest;
use App\Models\Order;
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

    public function store(AddEditOrderRequest $request): Order
    {
        return $this->orderRepository->store($request->validated());
    }

    public function show(string $id): JsonResponse
    {
        $order = $this->orderRepository->find($id);

        return $order ? response()->json($order->toArray()) : response()->json(status: 404);
    }

    public function update(AddEditOrderRequest $request, string $id)
    {
        $order = $this->orderRepository->find($id);

        if (!$order) {
            return response()->json([
                'error' => "Order $id not found."
            ], 404);
        }

        $order->buyer_name = $request->input('buyer_name');
        $order->total = $request->input('total');
        $order->update();

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

    public function ordersPerDay(): JsonResponse
    {
        $ordersPerDay = Order::query()
            ->selectRaw('count(*) as count, date(created_at) as date')
            ->withoutTrashed()
            ->groupByRaw('date')
            ->get();

        return response()->json($ordersPerDay->toArray());
    }
}
