<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{    
    /**
     * Login for users
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $user = User::whereUsername($request['username'])->first();

        if ($user) {
            $check = Hash::check($request['password'], $user['password']);
            if ($check) {
                $result = Auth::loginUsingId($user['id']);

                return $this->messageSuccess('Đăng nhập thành công !');
            }
        }

        return $this->responseFail('Username hoặc mật khẩu không đúng !');
    }
    
    /**
     * Logout user
     *
     * @return mixed
     */
    public function logout()
    {
        Auth::logout();

        return redirect('login');
    }

    /**
     * Get login view
     *
     * @return mixed
     */
    public function loginView()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }

        return view('login');
    }

    /**
     * faceLogin
     *
     * @param  mixed $request
     * @return void
     */
    public function faceLogin(Request $request)
    {
        $user = User::whereUsername($request['username'])->first();

        if ($user) {
            $result = Auth::loginUsingId($user['id']);

            return $this->messageSuccess('Đăng nhập thành công !');
        }

        return $this->responseFail('Không thể nhận dạng !');
    }
}
