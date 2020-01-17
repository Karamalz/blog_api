<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationFormRequest;
use App\services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public $loginAfterSignUp = false;
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:10',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors()->first(),
                'data' => '',
            ], 422);
        }
        $input = $request->only('email', 'password');
        $token = null;

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
                'data' => '',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'login success!',
            'data' => $token,
        ], 200);
    }

    public function logout()
    {

        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully',
                'data' => '',
            ], 200);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out',
                'data' => '',
            ], 500);
        }
    }

/**
 * @param RegistrationFormRequest $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:10',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors()->first(),
                'data' => '',
            ], 422);
        }

        $user = $this->userService->register($request);

        return response()->json([
            'success' => $user ? true : false,
            'message' => $user ? 'Register success!' : 'Register fail!',
            'data' => $user ? $user : '',
        ], 200);
    }
}
