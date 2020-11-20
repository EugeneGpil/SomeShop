<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Redis;
use App\Services\User\Repositories\UserRepositoryInterface;

class RefreshToken
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {        
        $user = $this->userRepository->auth();

        if (!$user) {

            $oldToken = $this->getAccessToken($request);

            $newToken = Redis::get($oldToken);

            if (!$newToken) {
                $newToken  = JWTAuth::refresh(JWTAuth::getToken());
                Redis::setex($oldToken, 20, $newToken);
            }

            $user = JWTAuth::setToken($newToken)->toUser();
            $request->headers->set('Authorization', 'Bearer ' . $newToken);
            \Auth::login($user, false);
            \Cookie::queue('access_token', encrypt($newToken), 1200000); //2 weeks
        }

        return $next($request);
    }

    private function getAccessToken($request)
    {
        $header = $request->header('Authorization');

        return substr($header, 7);
    }
}
