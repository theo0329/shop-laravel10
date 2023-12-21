<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|same:confirm_password',
            'confirm_password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response([
                'message' => $validator->errors(),
            ]);
        }

        try {
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);

            $response = [
                'code' => 201,
                'message' => '註冊成功,趕快手刀登入吧!',
            ];
        } catch (Exception $e) {
            $response = [
                'message' => $e->getMessage(),
            ];

            return response($response);
        }

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $form = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        try {

            $user = User::where('email', $form['email'])->first();

            if (!$user || !Hash::check($form['password'], $user->password)) {
                $response = [
                    'code' => 401,
                    'message' => '登入失敗',
                ];
                return response($response);
            }

            $token = $user->createToken($request->email)->accessToken; //passport
            //$token = $user->createToken($request->email)->plainTextToken;  //Sanctum
            $response = [
                'code' => 201,
                'user' => $user['name'],
                'email' => $user['email'],
                'token' => $token,
            ];
        } catch (Exception $e) {
            $response = [
                'message' => $e->getMessage(),
            ];
            return response($response);
        }

        return response($response);
    }

    public function logout(Request $request)
    {
        try {
            if (Auth::check()) {
                Auth::user()->token()->revoke();
                $response = [
                    'code' => 201,
                    'message' => '您已登出!',
                ];
            } else {
                $response = [
                    'code' => 201,
                    'message' => '您尚未登入!',
                ];
            }
        } catch (Exception $e) {
            $response = [
                'message' => $e->getMessage(),
            ];

            return response($response);
        }

        return response($response);
    }
}
