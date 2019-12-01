<?php

namespace N3ttech\Content\Application\News\Event;

use N3ttech\Content\Domain\Model\News\News;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

final class ExistingNewsSited extends NewsEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Identity\Uuids
     */
    public function newsSites(): VO\Identity\Uuids
    {
        return VO\Identity\Uuids::fromArray($this->payload['sites'] ?? []);
    }

    /**
     * @param News $news
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $news): void
    {
        $news->setUuid($this->newsUuid());
        $news->setSites($this->newsSites());
    }
}
