<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use App\Models\Post;
use App\Repositories\Abstracts\AbstractBaseRepository;
use App\Repositories\Interfaces\Comment\CommentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;


class CommentRepository
    extends AbstractBaseRepository
    implements CommentRepositoryInterface
{

    /**
    * @return string
    */
    protected function model(): string
    {
        return Comment::class;
    }

    /**
    * @var Comment $model;
    */
    protected $model;

    public function getAll(): Collection
    {
        return parent::getAll()->load('post', 'user');
    }

    public function getAllByPost(int $postId): Collection
    {
        return $this->model->where('commentable_id', $postId)
            ->where('commentable_type', Post::class)
            ->with('user', 'commentable')
            ->get();
    }

    public function create(array $data): Comment
    {
        $data['uuid'] = (string) Str::uuid();
        return parent::create($data);
    }

    /**
     * @param int $id
     * @return null|Comment
     */
    public function getById(int $id): ?Comment
    {
        return parent::getById($id);
    }

    /**
     * @param string $uuid
     * @return Comment|null
     */
    public function getByUuid(string $uuid): ?Comment
    {
        return $this->model->where('uuid', $uuid)->first();
    }

    public function update(int $id, array $data): ?Comment
    {
        //prevent any updates to the uuid
        if (isset($data['uuid'])) {
            unset($data['uuid']);
        }

        return parent::update($id, $data);
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
