<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class ApiUserController extends Controller
{
    use ApiResponser;

    public function createUser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name'=> 'required|string',
            'middle_name'=> 'nullable|string',
            'last_name'=> 'required|string',
            'email'=> 'required|unique:users',
            'phone_number'=> 'nullable|string',
            'address'=> 'nullable|string',
            'type' => [new Enum(UserTypeEnum::class)],
            'gender'=> 'nullable',
            'dob'=> 'nullable',
        ]);

        if($validator->fails()){
            $errors = $this->validatorFormatErrors($validator->errors());
            return $this->error(data: $errors);
        }

        $data = $validator->validated();
        $data['password'] = bcrypt($request->password ?? '1234');
        $create = User::query()->create($data);
        return $this->success($create);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        $authenticate = Auth::attempt($credentials);

        if (!$authenticate) return $this->error(message: 'Forbidden access', code: 401);

        $user = Auth::user();
        $data['status'] = 'success';
        $data['user'] = $user;
        $data['authorization']['token'] = $authenticate;
        $data['authorization']['type'] = 'bearer';
        return $this->success(data: $data);
    }

    public function getUser(Request $request, User $user){
        return $this->success(data: $user);
    }

    public function getUsers(Request $request){
        $data = User::all();
        return $this->success(data: $data);
    }

    public function getUsersByType(Request $request, UserTypeEnum $userType){
        $data = User::query()->where(['type' => $userType->value])->get();
        return $this->success(data: $data);
    }
}
