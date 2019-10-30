<?php

namespace N3ttech\Content\Domain\Model\Blog\Projection;

use N3ttech\Content\Application\Blog\Event;
use N3ttech\Messaging\Message\EventSourcing\EventProjector;

interface CategoryProjection extends EventProjector
{
    /**
     * @param Event\NewCategoryCreated $event
     */
    public function onNewCategoryCreated(Event\NewCategoryCreated $event): void;

    /**
     * @param Event\ExistingCategoryTranslated $event
     */
    public function onExistingCategoryTranslated(Event\ExistingCategoryTranslated $event): void;

    /**
     * @param Event\ExistingCategorySited $event
     */
    public function onExistingCategorySited(Event\ExistingCategorySited $event): void;

    /**
     * @param Event\ExistingCategoryMoved $event
     */
    public function onExistingCategoryMoved(Event\ExistingCategoryMoved $event): void;

    /**
     * @param Event\ExistingCategoryRemoved $event
     */
    public function onExistingCategoryRemoved(Event\ExistingCategoryRemoved $event): void;
}
