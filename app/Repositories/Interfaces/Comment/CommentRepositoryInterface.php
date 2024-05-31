<?php

namespace App\Repositories\Interfaces\Comment;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

interface CommentRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection;

    public function getAllByPost(int $postId): Collection;

    /**
     * @param int $id
     * @return Comment|null
     */
    public function getById(int $id): ?Comment;

    /**
     * @param string $uuid
     * @return Comment|null
     */
    public function getByUuid(string $uuid): ?Comment;

    /**
     * @param array $data
     * @return Comment
     */
    public function create(array $data): Comment;

    /**
     * @param int $id
     * @param array $data
     * @return Comment|null
     */
    public function update(int $id, array $data): ?Comment;

    /**
     * @param array|int $id
     * @return int
     */
    public function destroy(array|int $id): int;
}
