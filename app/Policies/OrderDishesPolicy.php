<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderDishesPolicy
{
    use HandlesAuthorization;

//    /**
//     * @param User $user
//     * @param Order $order
//     * @return bool|\Illuminate\Auth\Access\Response
//     */
//    public function create(User $user, Order $order)
//    {
//        return $order->paid_at === null
//            ? true
//            : $this->deny('Dishes can\'t be added to this order anymore');
//    }
//
//    public function update(User $user, Order $order)
//    {
//        return $order->paid_at === null
//            ? true
//            : $this->deny('Dishes from this order can\'t be updated anymore');
//    }
//
//    public function delete(User $user, Order $order)
//    {
//        return $order->paid_at === null
//            ? true
//            : $this->deny('Order is paid. Dishes can\'t be deleted anymore');
//    }
}
