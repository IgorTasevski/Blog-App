<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Repositories\Abstracts\AbstractBaseRepository;
use App\Repositories\Interfaces\Post\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;


class PostRepository
    extends AbstractBaseRepository
    implements PostRepositoryInterface
{

    /**
    * @return string
    */
    protected function model(): string
    {
        return Post::class;
    }

    /**
    * @var Post $model;
    */
    protected $model;

    public function getAll(): Collection
    {
        return parent::getAll()->load('tags', 'user');
    }

    public function create(array $data): Post
    {
        $data['uuid'] = (string) Str::uuid();
        return parent::create($data);
    }

    /**
     * @param int $id
     * @return null|Post
     */
    public function getById(int $id): ?Post
    {
        return parent::getById($id);
    }

    /**
     * @param string $uuid
     * @return Post|null
     */
    public function getByUuid(string $uuid): ?Post
    {
        return $this->model->where('uuid', $uuid)->first();
    }

    public function update(int $id, array $data): ?Post
    {
        //prevent any updates to the uuid
        if (isset($data['uuid'])) {
            unset($data['uuid']);
        }

        return parent::update($id, $data);
    }

    /**
     * @param Post $post
     * @param array $tagIds
     * @return array
     */
    public function attachTags(Post $post, array $tagIds): array
    {
        return $post->tags()->sync($tagIds);
    }

    /**
     * @param array|int $id
     * @return int
     */
    public function destroy(array|int $id): int
    {
        return parent::destroy($id);
    }


}
