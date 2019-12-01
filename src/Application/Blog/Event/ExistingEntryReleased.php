<?php

namespace N3ttech\Content\Application\Blog\Event;

use N3ttech\Content\Domain\Common\Release;
use N3ttech\Content\Domain\Model\Blog\Entry;
use N3ttech\Messaging\Aggregate\AggregateRoot;

final class ExistingEntryReleased extends EntryEvent
{
    /**
     * @return Release
     *
     * @throws \Assert\AssertionFailedException
     */
    public function entryRelease(): Release
    {
        return Release::fromArray($this->payload['release'] ?? []);
    }

    /**
     * @param Entry $entry
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $entry): void
    {
        $entry->setUuid($this->entryUuid());
        $entry->setRelease($this->entryRelease());
    }
}
