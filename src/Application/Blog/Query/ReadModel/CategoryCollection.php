<?php

namespace N3ttech\Content\Application\Blog\Query\ReadModel;

use N3ttech\Messaging\Query\Query;

class CategoryCollection extends \ArrayIterator implements Query\ViewableCollection
{
    /**
     * @param Category $category
     */
    public function add(Query\Viewable $category): void
    {
        $this->offsetSet($category->identifier(), $category);
    }

    /**
     * @param string $uuid
     *
     * @return Category
     */
    public function get(string $uuid): Category
    {
        return $this->offsetGet($uuid);
    }

    /**
     * @param string $uuid
     *
     * @return bool
     */
    public function has(string $uuid): bool
    {
        return $this->offsetExists($uuid);
    }

    /**
     * @param string $uuid
     */
    public function remove(string $uuid): void
    {
        $this->offsetUnset($uuid);
    }

    /**
     * @return Category[]
     */
    public function all(): array
    {
        return $this->getArrayCopy();
    }
}
