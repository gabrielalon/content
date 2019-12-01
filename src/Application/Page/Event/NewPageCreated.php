<?php

namespace N3ttech\Content\Application\Page\Event;

use N3ttech\Content\Domain\Model\Page\Page;
use N3ttech\Messaging\Aggregate\AggregateRoot;

final class NewPageCreated extends PageEvent
{
    /**
     * @param Page $page
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $page): void
    {
        $page->setKey($this->pageKey());
    }
}
