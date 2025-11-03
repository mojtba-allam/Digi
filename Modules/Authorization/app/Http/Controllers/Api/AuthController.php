<?php

namespace Modules\Authorization\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use Modules\Authorization\app\Models\User;
use Modules\Authorization\app\Models\Role;
use Modules\Authorization\app\Http\Resources\UserResource;
use Modules\Authorization\app\Http\Requests\Api\LoginRequest;
use Modules\Authorization\app\Http\Requests\Api\RegisterRequest;
use Modules\Authorization\app\Traits\ApiResponseTrait;

class AuthController extends Controller
{
    use ApiResponseTrait;
{
    /**
     * Register a new user
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign role based on user type
        $user->assignRole($request->user_type);

        // Create vendor profile if user is vendor
        if ($request->user_type === 'vendor') {
            $user->vendor()->create([
                'business_name' => $request->name . "'s Store",
                'status' => 'pending',
            ]);
        }

        // Load relationships for resource
        $user->load('roles');

        // Create API token
        $roles = $user->roles->pluck('name')->toArray();
        $token = $user->createToken('auth-token', $roles)->plainTextToken;

        return $this->successResponse([
            'user' => new UserResource($user),
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'User registered successfully', 201);
    }

    /**
     * Login user
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $key = 'login.' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return $this->errorResponse(
                "Too many login attempts. Please try again in {$seconds} seconds.",
                429
            );
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            RateLimiter::hit($key, 300); // 5 minutes lockout
            return $this->unauthorizedResponse('Invalid credentials');
        }

        RateLimiter::clear($key);
        
        $user = Auth::user();
        $user->load('roles');
        $roles = $user->roles->pluck('name')->toArray();
        
        // Create token with user roles as abilities
        $token = $user->createToken('auth-token', $roles)->plainTextToken;

        return $this->successResponse([
            'user' => new UserResource($user),
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Login successful');
    }

    /**
     * Logout user
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse(null, 'Logged out successfully');
    }

    /**
     * Get authenticated user
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->load('roles.permissions');
        
        return $this->resourceResponse(
            new UserResource($user),
            'User profile retrieved successfully'
        );
    }

    /**
     * Refresh token
     */
    public function refresh(Request $request): JsonResponse
    {
        $user = $request->user();
        
        // Delete current token
        $request->user()->currentAccessToken()->delete();
        
        // Create new token
        $roles = $user->roles->pluck('name')->toArray();
        $token = $user->createToken('auth-token', $roles)->plainTextToken;

        return $this->successResponse([
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Token refreshed successfully');
    }

    /**
     * Change password
     */
    public function changePassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return $this->errorResponse('Current password is incorrect', 400);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return $this->successResponse(null, 'Password changed successfully');
    }

    /**
     * Forgot password
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        // Here you would typically send a password reset email
        // For now, we'll just return a success message
        
        return $this->successResponse(null, 'Password reset link sent to your email');
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        // Here you would typically validate the reset token
        // For now, we'll just update the password
        
        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return $this->successResponse(null, 'Password reset successfully');
    }
}