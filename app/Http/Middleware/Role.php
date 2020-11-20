<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Services\User\Repositories\UserRepositoryInterface;

class Role
{
    protected $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ... $roles)
    {
        foreach($roles as $role) {
            if (!$this->userRepository->auth()->hasRole($role)) {
                return response()->json($role . ' role required', 403);
            }
        }

        return $next($request);
    }
}
