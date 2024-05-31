<?php

namespace App\Repositories\Interfaces\Tag;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

interface TagRepositoryInterface
{
    /**
     * @param string $name
     * @return Tag|null
     */
    public function getByName(string $name): ?Tag;

    /**
     * @param array $tags
     * @return array
     */
    public function createOrGet(array $tags): array;
}
