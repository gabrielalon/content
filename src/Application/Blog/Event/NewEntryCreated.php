<?php

namespace N3ttech\Content\Application\Blog\Event;

use N3ttech\Content\Domain\Model\Blog\Entry;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

final class NewEntryCreated extends EntryEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Date\Time
     */
    public function entryCreationDate(): VO\Date\Time
    {
        return VO\Date\Time::fromTimestamp($this->payload['creation_date']);
    }

    /**
     * @param Entry $entry
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $entry): void
    {
        $entry->setUuid($this->entryUuid());
        $entry->setCreationDate($this->entryCreationDate());
    }
}
