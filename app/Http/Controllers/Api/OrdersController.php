<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\BulkDeleteRequest;
use App\Http\Requests\Orders\OrderFilterRequest;
use App\Http\Requests\Orders\AddEditOrderRequest;
use App\Models\Order;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\JsonResponse;

class OrdersController extends Controller
{
    public function __construct(private readonly OrderRepositoryInterface $orderRepository)
    {
    }

    public function index(OrderFilterRequest $orderListRequest): JsonResponse
    {
        $orders = $this->orderRepository->getFilteredOrdersPaginated($orderListRequest);

        return response()->json($orders->toArray());
    }

    public function store(AddEditOrderRequest $request): JsonResponse
    {
        return response()->json(
            $this->orderRepository->store($request->input())->toArray()
        );
    }

    public function show(string $id): JsonResponse
    {
        $order = $this->orderRepository->find($id);

        if (!$order) {
            return response()->json(['error' => "Order $id not found."], 404);
        }

        return response()->json($order->toArray());
    }

    public function update(AddEditOrderRequest $request, string $id): JsonResponse
    {
        $order = $this->orderRepository->find($id);

        if (!$order) {
            return response()->json(['error' => "Order $id not found."], 404);
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
        $data = Order::query()
            ->selectRaw('count(*) as orders_count, date(created_at) as day')
            ->withoutTrashed()
            ->groupByRaw('day')
            ->get();

        return response()->json([
            'count' => $data->pluck('orders_count'),
            'days' => $data->pluck('day')
        ]);
    }
}
