<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
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
    
    /**
     * Get user path username for facelogin
     *
     * @return JsonResponse
     */
    public function getUserPath(): JsonResponse
    {
        $users = User::select('username')->get();

        return $this->responseSuccess($users);
    }


    public function getModels($fileName)
    {
        // $path = public_path('vendor\faceapi\models\face_landmark_68_model-weights_manifest.json');
        
        // return response()
        // ->download($path, "face_landmark_68_model-weights_manifest.json",
        //     [
        //         'Content-Type' => 'application/octet-stream'
        //     ]);

        $file = public_path('vendor/faceapi/models/' . $fileName);

        return file_get_contents($file);
    }
}
