<?php

namespace N3ttech\Content\Application\Page\Query\ReadModel;

use N3ttech\Messaging\Query\Query;

class PageCollection extends \ArrayIterator implements Query\ViewableCollection
{
    /**
     * @param Page $page
     */
    public function add(Query\Viewable $page): void
    {
        $this->offsetSet($page->identifier(), $page);
    }

    /**
     * @param string $key
     *
     * @return Page
     */
    public function get(string $key): Page
    {
        return $this->offsetGet($key);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return $this->offsetExists($key);
    }

    /**
     * @param string $key
     */
    public function remove(string $key): void
    {
        $this->offsetUnset($key);
    }

    /**
     * @return Page[]
     */
    public function all(): array
    {
        return $this->getArrayCopy();
    }
}
