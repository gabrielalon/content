<?php

namespace N3ttech\Content\Domain\Model\Translation\Projection;

use N3ttech\Content\Application\Translation\Event;
use N3ttech\Messaging\Message\EventSourcing\EventProjector;

interface TranslationProjection extends EventProjector
{
    /**
     * @param Event\NewTranslationCreated $event
     */
    public function onNewTranslationCreated(Event\NewTranslationCreated $event): void;

    /**
     * @param Event\ExistingTranslationUpdated $event
     */
    public function onExistingTranslationUpdated(Event\ExistingTranslationUpdated $event): void;

    /**
     * @param Event\ExistingTranslationSited $event
     */
    public function onExistingTranslationSited(Event\ExistingTranslationSited $event): void;

    /**
     * @param Event\ExistingTranslationRemoved $event
     */
    public function onExistingTranslationRemoved(Event\ExistingTranslationRemoved $event): void;
}
