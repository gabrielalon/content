<?php

namespace N3ttech\Content\Application\Page\Event;

use N3ttech\Content\Domain\Common\Content;
use N3ttech\Content\Domain\Model\Page\Page;
use N3ttech\Messaging\Aggregate\AggregateRoot;

final class ExistingPageTranslated extends PageEvent
{
    /**
     * @return Content
     *
     * @throws \Assert\AssertionFailedException
     */
    public function pageContent(): Content
    {
        return Content::fromArray($this->payload['content'] ?? []);
    }

    /**
     * @param Page $page
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $page): void
    {
        $page->setKey($this->pageKey());
        $page->setContent($this->pageContent());
    }
}
