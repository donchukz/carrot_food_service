<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Restaurant;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiRestaurantsController extends Controller
{
    use ApiResponser;

    public function getRestaurants(Request $request, Business $business){
        $data = Restaurant::query()->whereBelongsTo($business, 'business')->get();
        return $this->success(data: $data);
    }

    public function createRestaurant(Request $request, Business $business)
    {

        $validator = Validator::make($request->all(), [
            'name'=> 'required|string',
            'description'=> 'nullable|string',
            'location'=> 'nullable',
            'phone_number'=> 'nullable',
        ]);

        if($validator->fails()){
            $errors = $this->validatorFormatErrors($validator->errors());
            return $this->error(data: $errors);
        }

        $data = $validator->validated();
        $create = $business->restaurants()->create($data);
        return $this->success($create);
    }
}
