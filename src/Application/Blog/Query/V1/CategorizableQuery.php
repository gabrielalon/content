<?php

namespace N3ttech\Content\Application\Blog\Query\V1;

use N3ttech\Content\Application\Blog\Query\ReadModel;
use N3ttech\Messaging\Query\Exception;
use N3ttech\Messaging\Query\Query\Query;

abstract class CategorizableQuery extends Query
{
    /** @var ReadModel\CategoryCollection */
    private $collection;

    /**
     * @param string $uuid
     *
     * @throws Exception\ResourceNotFoundException
     *
     * @return ReadModel\Category
     */
    public function getCategory(string $uuid): ReadModel\Category
    {
        $this->initializeCollection();

        if (0 === $this->collection->count()) {
            throw new Exception\ResourceNotFoundException('Category not found');
        }

        return $this->collection->get($uuid);
    }

    /**
     * @param ReadModel\Category $category
     */
    public function addCategory(ReadModel\Category $category): void
    {
        $this->initializeCollection();

        $this->collection->add($category);
    }

    /**
     * @return ReadModel\CategoryCollection
     */
    public function getCollection(): ReadModel\CategoryCollection
    {
        $this->initializeCollection();

        return $this->collection;
    }

    private function initializeCollection(): void
    {
        if (null === $this->collection) {
            $this->collection = new ReadModel\CategoryCollection();
        }
    }
}
