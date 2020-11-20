<?php

namespace App\Services\User;

use App\Http\Controllers\API\Users\Requests\PatchUserRequest;
use App\Models\User;
use App\Services\User\Repositories\UserRepositoryInterface;

class UserService
{
    protected $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function find(int $id) :?User
    {
        return $this->userRepository->find($id);
    }

    public function getPage(int $page = 1, int  $perPage = 20, string $search = null): array
    {
        return $this->userRepository->getPage($page, $perPage, $search);
    }

    public function findWithOrders(int $id): ?User
    {
        return $this->userRepository->findWith($id, [
            'orders'
        ]);
    }

    public function auhtWithRoles(): ?User
    {
        return $this->userRepository->auth()->load('roles');
    }

    public function logout(): array
    {
        auth()->logout();

        \Cookie::queue('access_token', null);

        return ['message' => 'Successfully logged out'];
    }

    public function count() :int
    {
        return $this->userRepository->count();
    }

    public function update(PatchUserRequest $request) :bool
    {
        foreach($request as $userToPatch) {

            if (!isset($userToPatch['id'])) {
                continue;
            }

            $user = $this->userRepository->find($userToPatch['id']);

            if (!$user) {
                continue;
            }

            
        }
    }
}
