<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function postEmail(Request $request): JsonResponse
    {
        $this->validate($request, ['email' => 'required|email']);

        $user = User::where('email', $request->input('email'))->first();
        if($user) {
            $token = Password::createToken($user);
            return response()->json([
                'status' => 'success',
                'email_token' => $token
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'There is no user with such email'
        ], 403);
    }

    /**
     * @param Request $request
     * @param $token
     * @return JsonResponse
     * @throws ValidationException
     */
    public function resetEmail(Request $request, $token): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:55',
        ]);

        $user = Password::getUser($request->only('email'));
        if($user) {
            if(Password::tokenExists($user, $token)) {
                $user->password = Hash::make($request->input('password'));
                $user->save();

                Password::deleteToken($user);

                return response()->json([
                    'status' => 'success',
                    'message' => 'User password updated successfully'
                ]);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'There is such token'
            ], 403);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'There is no user with such email'
        ], 403);
    }
}
