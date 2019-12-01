<?php

namespace N3ttech\Content\Application\Translation\Event;

use N3ttech\Content\Domain\Model\Translation\Translation\Key;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;

abstract class TranslationEvent extends AggregateChanged
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return Key
     */
    public function translationKey(): Key
    {
        return Key::fromString($this->aggregateId());
    }
}
