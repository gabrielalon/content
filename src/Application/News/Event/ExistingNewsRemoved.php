<?php

namespace N3ttech\Content\Application\News\Event;

use N3ttech\Content\Domain\Model\News\News;
use N3ttech\Messaging\Aggregate\AggregateRoot;

final class ExistingNewsRemoved extends NewsEvent
{
    /**
     * @param News $news
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $news): void
    {
        $news->setUuid($this->newsUuid());
    }
}
