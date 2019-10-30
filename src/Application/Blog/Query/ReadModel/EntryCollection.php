<?php

namespace N3ttech\Content\Application\Blog\Query\ReadModel;

use N3ttech\Messaging\Query\Query;

class EntryCollection extends \ArrayIterator implements Query\ViewableCollection
{
    /**
     * @param Entry $site
     */
    public function add(Query\Viewable $site): void
    {
        $this->offsetSet($site->identifier(), $site);
    }

    /**
     * @param string $uuid
     *
     * @return Entry
     */
    public function get(string $uuid): Entry
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
     * @return Entry[]
     */
    public function all(): array
    {
        return $this->getArrayCopy();
    }
}
