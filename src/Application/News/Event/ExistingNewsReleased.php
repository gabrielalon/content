<?php

namespace N3ttech\Content\Application\News\Event;

use N3ttech\Content\Domain\Common\Release;
use N3ttech\Content\Domain\Model\News\News;
use N3ttech\Messaging\Aggregate\AggregateRoot;

final class ExistingNewsReleased extends NewsEvent
{
    /**
     * @return Release
     *
     * @throws \Assert\AssertionFailedException
     */
    public function newsRelease(): Release
    {
        return Release::fromArray($this->payload['release'] ?? []);
    }

    /**
     * @param News $news
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $news): void
    {
        $news->setUuid($this->newsUuid());
        $news->setRelease($this->newsRelease());
    }
}
