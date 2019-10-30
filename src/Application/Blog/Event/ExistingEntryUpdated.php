<?php

namespace N3ttech\Content\Application\Blog\Event;

use N3ttech\Content\Domain\Model\Blog\Entry;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class ExistingEntryUpdated extends EntryEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Date\Time
     */
    public function entryPublishDate(): VO\Date\Time
    {
        return VO\Date\Time::fromTimestamp((int) $this->payload['publish_date'] ?? 0);
    }

    /**
     * @param Entry $entry
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $entry): void
    {
        $entry->setUuid($this->entryUuid());
        $entry->setPublishDate($this->entryPublishDate());
    }
}
