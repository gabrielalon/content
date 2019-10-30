<?php

namespace N3ttech\Content\Application\Blog\Event;

use N3ttech\Content\Domain\Model\Blog\Entry;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class ExistingEntryShown extends EntryEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Option\Check
     */
    public function entryHide(): VO\Option\Check
    {
        return VO\Option\Check::fromBoolean(false);
    }

    /**
     * @param Entry $entry
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $entry): void
    {
        $entry->setUuid($this->entryUuid());
        $entry->setHide($this->entryHide());
    }
}
