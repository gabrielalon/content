<?php

namespace N3ttech\Content\Infrastructure\Persist\Blog;

use N3ttech\Content\Domain\Model\Blog\Category;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\Persist\AggregateRepository;
use N3ttech\Valuing as VO;

final class CategoryRepository extends AggregateRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAggregateRootClass(): string
    {
        return Category::class;
    }

    /**
     * @param Category $category
     *
     * @throws \Exception
     */
    public function save(Category $category): void
    {
        $this->saveAggregateRoot($category);
    }

    /**
     * @param string $uuid
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return AggregateRoot|Category
     */
    public function find(string $uuid): AggregateRoot
    {
        return $this->findAggregateRoot(VO\Identity\Uuid::fromIdentity($uuid));
    }
}
