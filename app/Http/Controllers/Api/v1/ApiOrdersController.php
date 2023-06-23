<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\DeliveryTypeEnum;
use App\Enums\PaymentModeEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class ApiOrdersController extends Controller
{
    use ApiResponser;

    public function getOrders(Request $request, Restaurant $restaurant){
        $data = Order::query()->whereBelongsTo($restaurant, 'restaurant')->get();
        return $this->success(data: $data);
    }

    public function getOrdersByCustomer(Request $request, User $user){
        $data = Order::query()->whereBelongsTo($user, 'customer')->get();
        return $this->success(data: $data);
    }

    public function createOrder(Request $request, Restaurant $restaurant)
    {

        $validator = Validator::make($request->all(), [
            'order_date' => 'required|date',
            'delivery_type' => [new Enum(DeliveryTypeEnum::class)],
            'delivery_location' => 'nullable|string',
            'payment_mode' => [new Enum(PaymentModeEnum::class)],
            'total_items' => 'required',
            'total_order_price'=> 'required',
            'customer_id'=> 'required|exists:users,id',
        ]);

        if($validator->fails()){
            $errors = $this->validatorFormatErrors($validator->errors());
            return $this->error(data: $errors);
        }

        $data = $validator->validated();
        $create = $restaurant->orders()->create($data);
        return $this->success($create);
    }
}
