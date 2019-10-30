<?php

namespace N3ttech\Content\Infrastructure\Persist\Blog;

use N3ttech\Content\Domain\Model\Blog\Entry;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\Persist\AggregateRepository;
use N3ttech\Valuing as VO;

class EntryRepository extends AggregateRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAggregateRootClass(): string
    {
        return Entry::class;
    }

    /**
     * @param Entry $entry
     *
     * @throws \Exception
     */
    public function save(Entry $entry): void
    {
        $this->saveAggregateRoot($entry);
    }

    /**
     * @param string $uuid
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return AggregateRoot|Entry
     */
    public function find(string $uuid): AggregateRoot
    {
        return $this->findAggregateRoot(VO\Identity\Uuid::fromIdentity($uuid));
    }
}
