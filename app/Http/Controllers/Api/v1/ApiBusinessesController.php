<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiBusinessesController extends Controller
{
    use ApiResponser;

    public function getBusiness(Request $request, User $user){
        $data = Business::query()->whereBelongsTo($user, 'businessOwner')->get();
        return $this->success(data: $data);
    }

    public function createBusiness(Request $request, User $user)
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
        $create = $user->businesses()->create($data);
        return $this->success($create);
    }
}
