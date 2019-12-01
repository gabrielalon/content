<?php

namespace N3ttech\Content\Domain\Model\Page\Projection;

use N3ttech\Content\Application\Page\Event;
use N3ttech\Messaging\Message\EventSourcing\EventProjector;

interface PageProjection extends EventProjector
{
    /**
     * @param Event\NewPageCreated $event
     */
    public function onNewPageCreated(Event\NewPageCreated $event): void;

    /**
     * @param Event\ExistingPageTranslated $event
     */
    public function onExistingPageTranslated(Event\ExistingPageTranslated $event): void;

    /**
     * @param Event\ExistingPageSited $event
     */
    public function onExistingPageSited(Event\ExistingPageSited $event): void;

    /**
     * @param Event\ExistingPageRemoved $event
     */
    public function onExistingPageRemoved(Event\ExistingPageRemoved $event): void;
}
