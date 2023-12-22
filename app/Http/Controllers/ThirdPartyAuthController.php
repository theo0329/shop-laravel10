<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class ThirdPartyAuthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('line')->redirect();
    }

    public function callback()
    {
        $lineUser = Socialite::driver('line')->user();
        //dd($lineUser);

        $user = User::updateOrCreate([
            'email' => 'line2@www.te', //因LINE無MAIL 先寫一組MAIL使用
        ], [
            'line_id' => $lineUser->id,
            'name' => $lineUser->name,
            'image_path' => $lineUser->avatar,
            'password' => $lineUser->id,
            'email' => 'line2@www.te',
        ]);

        Auth::login($user);

        session([
            'name' => $user->name,
            'email' => $user->email,
            'image_path' => $user->image_path,
        ]);

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
    }
}
