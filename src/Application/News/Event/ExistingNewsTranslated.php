<?php

namespace N3ttech\Content\Application\News\Event;

use N3ttech\Content\Domain\Common\Content;
use N3ttech\Content\Domain\Model\News\News;
use N3ttech\Messaging\Aggregate\AggregateRoot;

final class ExistingNewsTranslated extends NewsEvent
{
    /**
     * @return Content
     *
     * @throws \Assert\AssertionFailedException
     */
    public function newsContent(): Content
    {
        return Content::fromArray($this->payload['content'] ?? []);
    }

    /**
     * @param News $news
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $news): void
    {
        $news->setUuid($this->newsUuid());
        $news->setContent($this->newsContent());
    }
}
