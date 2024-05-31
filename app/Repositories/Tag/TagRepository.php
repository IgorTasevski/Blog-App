<?php

namespace App\Repositories\Tag;

use App\Models\Tag;
use App\Repositories\Abstracts\AbstractBaseRepository;
use App\Repositories\Interfaces\Tag\TagRepositoryInterface;
use Illuminate\Support\Str;

class TagRepository
    extends AbstractBaseRepository
    implements TagRepositoryInterface
{

        /**
        * @var Tag $model;
        */
        protected $model;

        /**
         * @return string
         */
        protected function model(): string
        {
            return Tag::class;
        }

        public function getByName(string $name): ?Tag
        {
            return $this->model->where('name', $name)->first();
        }

        public function createOrGet(array $tags): array
        {
            $tagIds = [];

            foreach ($tags as $tag) {
                $tagModel = $this->model->firstOrCreate(
                    ['name' => $tag],
                    ['uuid' => (string) Str::uuid()]
                );
                $tagIds[] = $tagModel->id;
            }

            return $tagIds;
        }
}
