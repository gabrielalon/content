<?php

namespace N3ttech\Content\Application\Blog\Event;

use N3ttech\Content\Domain\Model\Blog\Entry;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class ExistingEntryCategorized extends EntryEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Identity\Uuids
     */
    public function entryCategories(): VO\Identity\Uuids
    {
        return VO\Identity\Uuids::fromArray($this->payload['categories'] ?? []);
    }

    /**
     * @param Entry $entry
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $entry): void
    {
        $entry->setUuid($this->entryUuid());
        $entry->setCategories($this->entryCategories());
    }
}
