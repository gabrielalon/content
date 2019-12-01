<?php

namespace N3ttech\Content\Application\Blog\Event;

use N3ttech\Content\Domain\Common\Content;
use N3ttech\Content\Domain\Model\Blog\Entry;
use N3ttech\Messaging\Aggregate\AggregateRoot;

class ExistingEntryTranslated extends EntryEvent
{
    /**
     * @return Content
     *
     * @throws \Assert\AssertionFailedException
     */
    public function entryContent(): Content
    {
        return Content::fromArray($this->payload['content'] ?? []);
    }

    /**
     * @param Entry $entry
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $entry): void
    {
        $entry->setUuid($this->entryUuid());
        $entry->setContent($this->entryContent());
    }
}
