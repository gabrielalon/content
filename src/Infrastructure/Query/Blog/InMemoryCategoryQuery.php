<?php

namespace N3ttech\Content\Infrastructure\Query\Blog;

use N3ttech\Content\Application\Blog\Query;

class InMemoryCategoryQuery implements Query\V1\CategoryQuery
{
    /** @var Query\ReadModel\CategoryCollection */
    private $entities;

    /**
     * @param Query\ReadModel\CategoryCollection|null $entities
     */
    public function __construct(Query\ReadModel\CategoryCollection $entities = null)
    {
        if (null === $entities) {
            $entities = new Query\ReadModel\CategoryCollection([]);
        }

        $this->entities = $entities;
    }

    /**
     * {@inheritdoc}
     */
    public function findAllSitedCategories(Query\V1\FindAllSitedCategories $query): void
    {
        /** @var Query\ReadModel\Category $category */
        foreach ($this->entities->getArrayCopy() as $category) {
            $query->addCategory($category);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException
     */
    public function findOneCategoryByUuid(Query\V1\FindOneCategoryByUuid $query): void
    {
        $this->checkExistence($query->getUuid());

        $query->addCategory($this->entities->get($query->getUuid()));
    }

    /**
     * @param string $uuid
     *
     * @throws \RuntimeException
     */
    private function checkExistence(string $uuid): void
    {
        if (false === $this->entities->has($uuid)) {
            throw new \RuntimeException(\sprintf('Category does not exists on given uuid: %s', $uuid));
        }
    }
}
