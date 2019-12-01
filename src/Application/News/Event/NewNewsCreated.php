<?php

namespace N3ttech\Content\Application\News\Event;

use N3ttech\Content\Domain\Model\News\News;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

final class NewNewsCreated extends NewsEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Date\Time
     */
    public function newsCreationDate(): VO\Date\Time
    {
        return VO\Date\Time::fromTimestamp($this->payload['creation_date']);
    }

    /**
     * @param News $news
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $news): void
    {
        $news->setUuid($this->newsUuid());
        $news->setCreationDate($this->newsCreationDate());
    }
}
