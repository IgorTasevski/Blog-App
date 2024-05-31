<?php

namespace App\Repositories\Abstracts;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;

abstract class AbstractBaseRepository
{
    /**
     * @var Model $model
     */
    protected $model;
    private App $app;
    protected int $perPage;

    public function __construct(App $app) {
        $this->app = $app;
        $this->setModel();
        $this->perPage = 15;
    }

    /**
     * @return void
     * @throws BindingResolutionException
     */
    private function setModel(): void {
        $modelInstance = $this->app->make($this->model());

        if (!($modelInstance instanceof Model)) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        $this->model = $modelInstance;
    }


    /**
     * @return string
     */
    abstract protected function model(): string;

    /**
     * @return Collection
     */
    public function getAll(): Collection {
        return $this->model->all();
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model {
        return $this->model->find($id);
    }

    /**
     * @param array $data
     * @return Model|null
     */
    public function create(array $data): ?Model {
        return $this->model->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function update(int $id, array $data): ?Model {
        $modelInstance = $this->model->find($id);

        if ($modelInstance) {
            $modelInstance->update($data);
            return $modelInstance;
        }
        return null;
    }

    /**
     * @param int|array $id
     * @return int
     */
    public function destroy(int|array $id): int {
        return $this->model->destroy($id);
    }
}
