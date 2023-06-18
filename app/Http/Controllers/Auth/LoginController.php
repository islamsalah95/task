<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Traits\ApiTraits;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function Login(Request $request)
    {



        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email','exists:users,email'],
            'password' => ['required'],
        ]);
        

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }


        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (!Hash::check($request->password, $user->password)) {
                return ApiTraits::errorMessage('wrong password');
            }

            $tokens = $user->createToken('Android')->plainTextToken;
            $user->token = 'Bearer ' . $tokens;
           
            return  response()->json($user, 200);


        } else{
            return ApiTraits::errorMessage('you are not register before');
        }
        
    }
}
