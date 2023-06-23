<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\SizeTypeEnum;
use App\Enums\UnitTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class ApiMenuItemController extends Controller
{
    use ApiResponser;

    public function getMenuItems(Request $request, Restaurant $restaurant){
        $data = MenuItem::query()->whereBelongsTo($restaurant, 'restaurant')->get();
        return $this->success(data: $data);
    }

    public function createMenuItem(Request $request, Restaurant $restaurant)
    {

        $validator = Validator::make($request->all(), [
            'name'=> 'required|string',
//            'restaurant_id'=> 'required|exists:restaurants,id',
            'description'=> 'nullable|string',
            'size' => [new Enum(SizeTypeEnum::class)],
            'unit' => [new Enum(UnitTypeEnum::class)],
            'quantity'=> 'required|integer',
            'cost_price'=> 'required',
            'selling_price' => 'required',
        ]);

        if($validator->fails()){
            $errors = $this->validatorFormatErrors($validator->errors());
            return $this->error(data: $errors);
        }

        $data = $validator->validated();
        $create = $restaurant->menuItems()->create($data);
        return $this->success($create);
    }
}
