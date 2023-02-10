<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


/**
 *
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



    public function update(UserUpdateRequest $request, $id): JsonResponse
    {
        return $this->success($this->base_repository->update($request->validated(),$id))->send();

    }


    /**
     * @param $id
     * @return void
     */
    public function destroy($id): void
    {
        //
    }
}
