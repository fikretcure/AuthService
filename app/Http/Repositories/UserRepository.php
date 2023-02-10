<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 *
 * @property Builder $model
 */
class UserRepository
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = User::query();
    }


    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->model->get();
    }

    /**
     * @param array $attributes
     * @return Model|Builder
     */
    public function store(array $attributes): Model|Builder
    {
        return $this->model->create(
            attributes: $attributes
        );
    }

    /**
     * @param array $attributes
     * @param int $id
     * @return bool|int
     */
    public function update(array $attributes, int $id): bool|int
    {
        return $this->model->findOrFail($id)->update($attributes);
    }

    /**
     * @param int $id
     * @return Model|Collection|Builder
     */
    public function show(int $id): Model|Collection|Builder
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param int $id
     * @return bool|mixed|null
     */
    public function destroy(int $id): mixed
    {
        return $this->model->findOrFail($id)->delete();
    }

    /**
     * @param $email
     * @return mixed
     */
    public function showByEmail($email): mixed
    {
        return $this->model->whereEmail($email)->firstOrFail()->makeVisible('password');
    }

}
