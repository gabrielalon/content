<?php

namespace N3ttech\Content\Infrastructure\Query\Blog;

use N3ttech\Content\Application\Blog\Query;

final class InMemoryEntryQuery implements Query\V1\EntryQuery
{
    /** @var Query\ReadModel\EntryCollection */
    private $entities;

    /**
     * @param Query\ReadModel\EntryCollection|null $entities
     */
    public function __construct(Query\ReadModel\EntryCollection $entities = null)
    {
        if (null === $entities) {
            $entities = new Query\ReadModel\EntryCollection([]);
        }

        $this->entities = $entities;
    }

    /**
     * @param Query\V1\FindAllActiveEntries $query
     */
    public function findAllActiveEntries(Query\V1\FindAllActiveEntries $query): void
    {
        /** @var Query\ReadModel\Entry $entry */
        foreach ($this->entities->getArrayCopy() as $entry) {
            $query->addEntry($entry);
        }
    }

    /**
     * @param Query\V1\FindOneEntryByUuid $query
     */
    public function findOneEntryByUuid(Query\V1\FindOneEntryByUuid $query): void
    {
        $this->checkExistence($query->getUuid());

        $query->addEntry($this->entities->get($query->getUuid()));
    }

    /**
     * @param string $uuid
     *
     * @throws \RuntimeException
     */
    private function checkExistence(string $uuid): void
    {
        if (false === $this->entities->has($uuid)) {
            throw new \RuntimeException(\sprintf('Entry does not exists on given uuid: %s', $uuid));
        }
    }
}
