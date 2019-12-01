<?php

namespace N3ttech\Content\Domain\Model\Blog\Projection;

use N3ttech\Content\Application\Blog\Event;
use N3ttech\Messaging\Message\EventSourcing\EventProjector;

interface EntryProjection extends EventProjector
{
    /**
     * @param Event\NewEntryCreated $event
     */
    public function onNewEntryCreated(Event\NewEntryCreated $event): void;

    /**
     * @param Event\ExistingEntryCategorized $event
     */
    public function onExistingEntryCategorized(Event\ExistingEntryCategorized $event): void;

    /**
     * @param Event\ExistingEntryTranslated $event
     */
    public function onExistingEntryTranslated(Event\ExistingEntryTranslated $event): void;

    /**
     * @param Event\ExistingEntryReleased $event
     */
    public function onExistingEntryReleased(Event\ExistingEntryReleased $event): void;

    /**
     * @param Event\ExistingEntryRemoved $event
     */
    public function onExistingEntryRemoved(Event\ExistingEntryRemoved $event): void;
}
