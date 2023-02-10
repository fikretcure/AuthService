<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\JsonResponse;


/**
 *
 * @property UserRepository $base_repository
 */
class UserController extends Controller
{

    /**
     *
     */
    public function __construct()
    {
        $this->base_repository = new UserRepository;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success($this->base_repository->index())->send();
    }

    /**
     * @param UserStoreRequest $request
     * @return JsonResponse
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        return $this->success($this->base_repository->store($request->validated()))->send();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        return $this->success($this->base_repository->show($id))->send();
    }

    /**
     * @param UserUpdateRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $request, $id): JsonResponse
    {
        return $this->success($this->base_repository->update($request->validated(), $id))->send();
    }

    public function destroy($id): JsonResponse
    {
        return $this->success($this->base_repository->destroy($id))->send();
    }
}
