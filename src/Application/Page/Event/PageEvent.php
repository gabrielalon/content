<?php

namespace N3ttech\Content\Application\Page\Event;

use N3ttech\Content\Domain\Model\Page\Page\Key;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;

abstract class PageEvent extends AggregateChanged
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return Key
     */
    public function pageKey(): Key
    {
        return Key::fromString($this->aggregateId());
    }
}
