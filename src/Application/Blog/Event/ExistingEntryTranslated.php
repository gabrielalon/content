<?php

namespace N3ttech\Content\Application\Blog\Event;

use N3ttech\Content\Domain\Model\Blog\Entry;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class ExistingEntryTranslated extends EntryEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Intl\Language\Texts
     */
    public function entryNames(): VO\Intl\Language\Texts
    {
        return VO\Intl\Language\Texts::fromArray($this->payload['names'] ?? []);
    }

    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Intl\Language\Contents
     */
    public function entryContents(): VO\Intl\Language\Contents
    {
        return VO\Intl\Language\Contents::fromArray($this->payload['contents'] ?? []);
    }

    /**
     * @param Entry $entry
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $entry): void
    {
        $entry->setUuid($this->entryUuid());
        $entry->setNames($this->entryNames());
        $entry->setContents($this->entryContents());
    }
}
