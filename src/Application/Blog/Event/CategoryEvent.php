<?php

namespace N3ttech\Content\Application\Blog\Event;

use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;

abstract class CategoryEvent extends AggregateChanged
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Identity\Uuid
     */
    public function categoryUuid(): VO\Identity\Uuid
    {
        return VO\Identity\Uuid::fromIdentity($this->aggregateId());
    }
}
