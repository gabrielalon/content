<?php

namespace N3ttech\Content\Application\Blog\Query\V1;

use N3ttech\Content\Application\Blog\Query\ReadModel;
use N3ttech\Messaging\Query\Exception;
use N3ttech\Messaging\Query\Query\Query;

abstract class EntryableQuery extends Query
{
    /** @var ReadModel\EntryCollection */
    private $collection;

    /**
     * @param string $uuid
     *
     * @throws Exception\ResourceNotFoundException
     *
     * @return ReadModel\Entry
     */
    public function getEntry(string $uuid): ReadModel\Entry
    {
        $this->initializeCollection();

        if (0 === $this->collection->count()) {
            throw new Exception\ResourceNotFoundException('Entry not found');
        }

        return $this->collection->get($uuid);
    }

    /**
     * @param ReadModel\Entry $entry
     */
    public function addEntry(ReadModel\Entry $entry): void
    {
        $this->initializeCollection();

        $this->collection->add($entry);
    }

    /**
     * @return ReadModel\EntryCollection
     */
    public function getCollection(): ReadModel\EntryCollection
    {
        $this->initializeCollection();

        return $this->collection;
    }

    private function initializeCollection(): void
    {
        if (null === $this->collection) {
            $this->collection = new ReadModel\EntryCollection();
        }
    }
}
