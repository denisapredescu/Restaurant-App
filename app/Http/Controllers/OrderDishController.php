<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderDishRequest;
use App\Http\Requests\UpdateOrderDishRequest;
use App\Models\Order;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class OrderDishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Builder[]|Collection
     */
    public function index($orderId)
    {
          return Order::findOrFail($orderId)->dishes;
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @param $orderId
     * @return mixed
     * @throws AuthorizationException
     */
    public function store(StoreOrderDishRequest $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $this->authorize('create', $order);

        $order->dishes()->attach(
            $request->dish_id,
            ['quantity' => $request->quantity]
        );

        $dishPrice = $order->dishes->find($request->dish_id)->price;

        $order->total = $order->total + ($request->quantity * $dishPrice);
        $order->save();

        return $order
            ->dishes()
            ->find($request->dish_id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show(int $orderId, int $dishId)
    {
        return Order::findOrFail($orderId)
            ->dishes()
            ->findOrFail($dishId);
    }

    /**
     * @param Request $request
     * @param $orderId
     * @param $dishId
     * @return mixed
     * @throws AuthorizationException
     */
    public function update(UpdateOrderDishRequest $request, int $orderId, int $dishId)
    {
        $order = Order::findOrFail($orderId);

        $this->authorize('update', $order);

        $dishOrder = $order
            ->dishes()
            ->findOrFail($dishId);

        $oldQuantity = $dishOrder->pivot->quantity;

        $order->dishes()
            ->updateExistingPivot($dishOrder->id, ['quantity' => $request->quantity]);

        $newQuantity = $request->quantity;

        $order->total = $order->total + ($newQuantity - $oldQuantity) * $dishOrder->price;
        $order->save();

        return Order::findOrFail($orderId)
            ->dishes()
            ->findOrFail($dishId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return string[]
     * @throws AuthorizationException
     */
    public function destroy($orderId, $dishId): array
    {
        $order = Order::findOrFail($orderId);

        $this->authorize('delete', $order);

        $dish = $order
            ->dishes()
            ->findOrFail($dishId);

        $quantity = $dish->pivot->quantity;
        $price = $dish->price;

        Order::findOrFail($orderId)
            ->dishes()
            ->detach($dishId);

        $order->total = $order->total - $quantity * $price;
        $order->save();

        return ['status' => 'success'];

    }
}
