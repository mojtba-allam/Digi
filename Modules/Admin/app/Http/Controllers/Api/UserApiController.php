<?php

namespace Modules\Admin\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Modules\Authorization\app\Models\User;
use Modules\Authorization\app\Models\Role;
use Modules\Admin\App\Http\Requests\Api\StoreUserRequest;
use Modules\Admin\App\Http\Requests\Api\UpdateUserRequest;

class UserApiController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request): JsonResponse
    {
        $query = User::with(['roles', 'profile']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->get('role'));
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        $perPage = $request->get('per_page', 15);
        $users = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $users->items(),
            'meta' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem(),
            ]
        ]);
    }

    /**
     * Store a newly created user.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'email_verified_at' => now(),
        ]);

        // Assign roles
        $user->roles()->sync($request->roles);
        $user->load(['roles', 'profile']);

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'User created successfully.'
        ], 201);
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): JsonResponse
    {
        $user->load(['roles', 'profile', 'orders', 'reviews']);
        
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    /**
     * Update the specified user.
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        // Update roles
        $user->roles()->sync($request->roles);
        $user->load(['roles', 'profile']);

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'User updated successfully.'
        ]);
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user): JsonResponse
    {
        // Prevent deletion of admin users or users with orders
        if ($user->isAdmin() || $user->orders()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete this user.'
            ], 422);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.'
        ]);
    }

    /**
     * Toggle user status.
     */
    public function toggleStatus(User $user): JsonResponse
    {
        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => "User status updated to {$newStatus}."
        ]);
    }

    /**
     * Bulk actions for users.
     */
    public function bulkAction(Request $request): JsonResponse
    {
        $request->validate([
            'action' => ['required', 'in:activate,deactivate,suspend,delete'],
            'users' => ['required', 'array'],
            'users.*' => ['exists:users,id'],
        ]);

        $users = User::whereIn('id', $request->users)->get();
        $processedCount = 0;

        switch ($request->action) {
            case 'activate':
                $users->each(function($user) use (&$processedCount) {
                    $user->update(['status' => 'active']);
                    $processedCount++;
                });
                $message = "Activated {$processedCount} users successfully.";
                break;
            case 'deactivate':
                $users->each(function($user) use (&$processedCount) {
                    $user->update(['status' => 'inactive']);
                    $processedCount++;
                });
                $message = "Deactivated {$processedCount} users successfully.";
                break;
            case 'suspend':
                $users->each(function($user) use (&$processedCount) {
                    $user->update(['status' => 'suspended']);
                    $processedCount++;
                });
                $message = "Suspended {$processedCount} users successfully.";
                break;
            case 'delete':
                $users->each(function($user) use (&$processedCount) {
                    if (!$user->isAdmin() && !$user->orders()->exists()) {
                        $user->delete();
                        $processedCount++;
                    }
                });
                $message = "Deleted {$processedCount} users successfully.";
                break;
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'processed_count' => $processedCount
        ]);
    }

    /**
     * Get available roles for user assignment.
     */
    public function roles(): JsonResponse
    {
        $roles = Role::all();

        return response()->json([
            'success' => true,
            'data' => $roles
        ]);
    }

    /**
     * Get user statistics.
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'inactive_users' => User::where('status', 'inactive')->count(),
            'suspended_users' => User::where('status', 'suspended')->count(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
            'unverified_users' => User::whereNull('email_verified_at')->count(),
            'users_by_role' => User::join('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->join('roles', 'user_roles.role_id', '=', 'roles.id')
                ->selectRaw('roles.name as role, COUNT(*) as count')
                ->groupBy('roles.name')
                ->get(),
            'recent_registrations' => User::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}