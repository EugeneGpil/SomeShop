<?php

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use App\Http\Controllers\API\Users\Requests\PatchUserRequest;

class UserController extends Controller
{
    protected $userService;

    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    public function getList(int $page = 1, int  $perPage = 20, string $search = null)
    {
        return response()->json(
            $this->userService->getPage($page, $perPage, $search)
        );
    }

    public function get(int $id)
    {
        return response()->json(
            $this->userService->findWithOrders($id)
        );
    }

    public function patch(PatchUserRequest $request)
    {
        return response()->json(
            $this->userService->update($request)
        );
    }
}
