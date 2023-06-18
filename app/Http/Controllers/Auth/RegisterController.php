<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Traits\ApiTraits;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class RegisterController extends Controller
{
        public function register(Request $request)
        {
    


            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'confirmed'],
                'birthday' => ['required', 'date', 'before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d')],
                'role' => [
                    'nullable',
                    Rule::in(['user', 'admin'])
                ],
            ]);
            

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }
            
            $user =  User::create([
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=> Hash::make($request->password),
                'password_confirmation'=>$request->password_confirmation,
                'birthday'=> $request->birthday,
                'role'=> $request->role,
            ]);
    
            $tokens = $user->createToken('Android')->plainTextToken;
            $user->token = 'Bearer ' . $tokens;

            return  response()->json($user, 200);

            
        }
    
}
