<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\Order\Repositories\OrderRepositoryInterface;
use App\Services\User\Repositories\UserRepositoryInterface;

class AdminOr
{
    protected $orderRepository;
    protected $userRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, string $mode)
    {
        $user = $this->userRepository->auth();

        if ($user->hasRole('admin')) {
            return $next($request);
        }
        
        if ($mode == 'user') {
            return $this->checkUserAccess($user, $request, $next);
        }

        if ($mode == 'order_owner') {
            $order = $this->orderRepository->find($request->id);
            if ($order->user_id == $user->id) {
                return $next($request);
            }
        }

        return response()->json('access_denied', 403);
    }

    private function checkUserAccess($user, $request, $next)
    {
        if ($request->isMethod('get')) {

            if ($user->id == $request->id) {
                return $next($request);

            } else {
                return response()->json('user may get only himself', 403);
            }
        }

        if ($request->isMethod('patch')) {

            if (count($request->update) == 1) {

                if ($request->update[0]['id'] == $user->id) {
                    return $next($request);

                } else {
                    return response()->json('user may update only himself', 403);
                }

            } else {
                return response()->json('user may update only one element at once', 403);
            }
        }

        return response()->json('access denied for user', 403);
    }
}
