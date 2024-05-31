<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Post;
use App\Repositories\Interfaces\Comment\CommentRepositoryInterface;
use App\Repositories\Interfaces\Post\PostRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private readonly CommentRepositoryInterface $commentRepository,
        private readonly PostRepositoryInterface $postRepository
    )
    {
    }

    public function index(string $postUuid): JsonResponse
    {
        $post = $this->postRepository->getByUuid($postUuid);

        if (!$post) {
            return $this->errorResponse('Post not found', 404);
        }

        $comments = $this->commentRepository->getAllByPost($post->id);

        return $this->successResponse(CommentResource::collection($comments));
    }

    public function show(string $commentUuid): JsonResponse
    {
        $comment = $this->commentRepository->getByUuid($commentUuid);

        if (!$comment) {
            return $this->errorResponse('Comment not found', 404);
        }

        return $this->successResponse(new CommentResource($comment->load('user', 'commentable')));
    }

    public function store(CommentRequest $request, string $postUuid): JsonResponse
    {
        $post = $this->postRepository->getByUuid($postUuid);

        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['post_id'] = $post->id;

        if($post) {
            $data['commentable_type'] = Post::class;
            $data['commentable_id'] = $post->id;
        }

        $comment = $this->commentRepository->create($data);

        return response()->json(new CommentResource($comment->load('user', 'commentable')), 201);
    }

    public function update(CommentRequest $request, string $uuid): JsonResponse
    {
        $comment = $this->commentRepository->getByUuid($uuid);
        $updatedComment = $this->commentRepository->update($comment->id, $request->validated());

        if (!$comment) {
            return $this->errorResponse('Comment not found', 404);
        }

        return $this->successResponse(new CommentResource($updatedComment->load('user')));
    }

    public function destroy(string $uuid): JsonResponse
    {
        $comment = $this->commentRepository->getByUuid($uuid);

        if (!$comment) {
            return $this->errorResponse('Comment not found', 404);
        }

        $this->commentRepository->destroy($comment->id);

        return $this->successResponse('Comment deleted successfully');
    }
}
