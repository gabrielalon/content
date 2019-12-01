<?php

namespace N3ttech\Content\Application\News\Query\ReadModel;

use N3ttech\Messaging\Query\Query;

class NewsCollection extends \ArrayIterator implements Query\ViewableCollection
{
    /**
     * @param News $entry
     */
    public function add(Query\Viewable $entry): void
    {
        $this->offsetSet($entry->identifier(), $entry);
    }

    /**
     * @param string $uuid
     *
     * @return News
     */
    public function get(string $uuid): News
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
     * @return News[]
     */
    public function all(): array
    {
        return $this->getArrayCopy();
    }
}
