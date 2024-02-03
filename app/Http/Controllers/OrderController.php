<?php

namespace App\Http\Controllers;

use App\Events\OrderPaidEvent;
use App\Http\Requests\DeleteOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Jobs\OrderReceipt;
use App\Models\Order;
use DateTime;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Builder[]|Collection|Response
     */
    public function index(Request $request)
    {
        return Order::when(
            $request->table_no,
            fn(Builder $query, string $value) => $query->where('table_no', '=', $value)
        )->simplePaginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOrderRequest $request
     * @return mixed
     */
    public function store(StoreOrderRequest $request)
    {
        return Order::create([
            'table_no' => $request->table_no,
            'total' => 0,
            'paid_at' => null,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $orderId)
    {
        return Order::findOrFail($orderId)->load('dishes');
    }

    /**
     * @param UpdateOrderRequest $request
     * @param int $orderId
     * @return mixed
     * @throws AuthorizationException
     */
    public function update(UpdateOrderRequest $request, int $orderId)
    {
        $order = Order::findOrFail($orderId);
//        $this->authorize('update', $order);   //varianta pentru policy  => nu mai poate fi folosita

        $data = $request->only('table_no');
//        $data = $request->validated();  // imi returneaza si campurile merge-uite
        $order->update($data);

        return $order;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return string[]
     */
    public function destroy(DeleteOrderRequest $request, int $orderId): array
    {
//        $result = $orderService->delete($request->route("order"));   // => pentru a nu mai pune parametru cu orderId

        $order = Order::findOrFail($orderId);

        $order->delete();
        return ['status' => 'success'];
    }

    /**
     * @param Request $request
     * @param int $orderId
     * @return mixed
     * @throws AuthorizationException
     */
    public function pay(Request $request, int $orderId)
    {
        $order = Order::findOrFail($orderId);
        $this->authorize('pay', $order);

//        gate version
//        if (! Gate::allows('modify-order', $order)) {
//            abort(403);
//        }

        $now = new DateTime();
        $timestamp = $now->format('Y-m-d H:i:s');    // MySQL datetime format

        $order->paid_at = $timestamp;
        $order->save();

//        OrderPaidEvent::dispatch($order);
        event(new OrderPaidEvent($order));

        return $order;
    }
}
