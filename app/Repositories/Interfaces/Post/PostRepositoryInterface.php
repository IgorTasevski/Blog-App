<?php

namespace App\Repositories\Interfaces\Post;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

interface PostRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param int $id
     * @return Post|null
     */
    public function getById(int $id): ?Post;

    /**
     * @param string $uuid
     * @return Post|null
     */
    public function getByUuid(string $uuid): ?Post;

    /**
     * @param array $data
     * @return Post
     */
    public function create(array $data): Post;

    /**
     * @param int $id
     * @param array $data
     * @return Post|null
     */
    public function update(int $id, array $data): ?Post;

    /**
     * @param Post $post
     * @param array $tagIds
     * @return mixed
     */
    public function attachTags(Post $post, array $tagIds): mixed;

    /**
     * @param array|int $id
     * @return int
     */
    public function destroy(array|int $id): int;
}
