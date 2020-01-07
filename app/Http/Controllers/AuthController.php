<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationFormRequest;
use App\services\UserService;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public $loginAfterSignUp = true;
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $token = null;

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

    public function logout()
    {

        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully',
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out',
            ], 500);
        }
    }

/**
 * @param RegistrationFormRequest $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function register(RegistrationFormRequest $request)
    {
        $user = $this->userService->register($request);

        if ($this->loginAfterSignUp) {
            return $this->login($request);
        }

        return response()->json([
            'success' => $user ? true : false,
            'message' => $user ? 'Register success!' : 'Register fail!',
            'data' => $user ? $user : '',
        ], 200);
    }
}
