<?php

namespace N3ttech\Content\Application\Translation\Query\ReadModel;

use N3ttech\Messaging\Query\Query;

class TranslationCollection extends \ArrayIterator implements Query\ViewableCollection
{
    /**
     * @param Translation $translation
     */
    public function add(Query\Viewable $translation): void
    {
        $this->offsetSet($translation->identifier(), $translation);
    }

    /**
     * @param string $key
     *
     * @return Translation
     */
    public function get(string $key): Translation
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
     * @return Translation[]
     */
    public function all(): array
    {
        return $this->getArrayCopy();
    }
}
