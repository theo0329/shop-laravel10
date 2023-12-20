<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
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
}
