<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AuthController extends Controller
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
    public function register(Request $request): JsonResponse
    {
        $this->validate($request, [
            'first_name' => 'required|string|min:3|max:55',
            'last_name' => 'nullable|string|max:55',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|max:55',
            'phone' => 'nullable|string|max:13',
        ]);

        $name = $request->input('first_name');
        $last_name = null;
        if ($request->has('last_name') && !empty($request->input('last_name'))) {
            $name = "{$name} {$request->input('last_name')}";
            $last_name = $request->input('last_name');
        }
        $user = new User();
        $user->fill([
            'first_name' => $request->input('first_name'),
            'last_name' => $last_name,
            'name' => $name,
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone' => $request->input('phone')
        ])->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully'
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function signIn(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:55',
        ]);

        $user = User::where('email', $request->input('email'))->first();
        if(!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'There is no user with such email'
            ], 403);
        } elseif (!Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'These credentials do not match our records'
            ], 403);
        } else {
            $user->api_token = Str::random(40);
            $user->save();
        }
        return response()->json([
            'status' => 'success',
            'api_token' => $user->api_token
        ]);
    }
}
