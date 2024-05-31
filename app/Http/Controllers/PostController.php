<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\PostCreateRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\Interfaces\Post\PostRepositoryInterface;
use App\Repositories\Interfaces\Tag\TagRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private readonly PostRepositoryInterface $postRepository,
        private readonly TagRepositoryInterface $tagRepository
    )
    {
    }

    public function index(): JsonResponse
    {
        return $this->successResponse(PostResource::collection($this->postRepository->getAll()));
    }

    public function store(PostCreateRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['user_id'] = auth()->id();

        $post = $this->postRepository->create($data);

        $tagIds = $this->tagRepository->createOrGet($data['tags']);

        $this->postRepository->attachTags($post, $tagIds);

        return $this->successResponse(new PostResource($post->load('tags', 'user')), 'Post created successfully', 201);
    }

    public function showByUuid(string $uuid): JsonResponse
    {
        $post = $this->postRepository->getByUuid($uuid);

        if(! $post) {
            return $this->errorResponse('Post not found', 404);
        }

        return $this->successResponse(new PostResource($post->load('tags', 'user')));
    }

    public function update(PostUpdateRequest $request, string $uuid): JsonResponse
    {
        $data = $request->validated();

        $post = $this->postRepository->getByUuid($uuid);

        if(! $post) {
            return $this->errorResponse('Post not found', 404);
        }

        $updatedPost = $this->postRepository->update($post->id, $data);

        // Handle tags
        if (isset($data['tags'])) {
            $tagIds = $this->tagRepository->createOrGet($data['tags']);
            // Sync tags, removing any that are not in the new list
            $updatedPost->tags()->sync($tagIds);
        } else {
            // If no tags are provided, detach all existing tags
            $updatedPost->tags()->sync([]);
        }

        return $this->successResponse(new PostResource($post->load('tags', 'user')), 'Post updated successfully');
    }

    public function destroy(string $uuid): JsonResponse
    {
        $post = $this->postRepository->getByUuid($uuid);

        $this->postRepository->destroy($post->id);

        return $this->successResponse(null, 'Post deleted successfully');
    }
}
