<?php

namespace N3ttech\Content\Application\News\Event;

use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;

abstract class NewsEvent extends AggregateChanged
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Identity\Uuid
     */
    public function newsUuid(): VO\Identity\Uuid
    {
        return VO\Identity\Uuid::fromIdentity($this->aggregateId());
    }
}
