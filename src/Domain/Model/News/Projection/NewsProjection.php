<?php

namespace N3ttech\Content\Domain\Model\News\Projection;

use N3ttech\Content\Application\News\Event;
use N3ttech\Messaging\Message\EventSourcing\EventProjector;

interface NewsProjection extends EventProjector
{
    /**
     * @param Event\NewNewsCreated $event
     */
    public function onNewNewsCreated(Event\NewNewsCreated $event): void;

    /**
     * @param Event\ExistingNewsTranslated $event
     */
    public function onExistingNewsTranslated(Event\ExistingNewsTranslated $event): void;

    /**
     * @param Event\ExistingNewsReleased $event
     */
    public function onExistingNewsReleased(Event\ExistingNewsReleased $event): void;

    /**
     * @param Event\ExistingNewsSited $event
     */
    public function onExistingNewsSited(Event\ExistingNewsSited $event): void;

    /**
     * @param Event\ExistingNewsRemoved $event
     */
    public function onExistingNewsRemoved(Event\ExistingNewsRemoved $event): void;
}
