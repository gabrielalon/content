<?php

namespace N3ttech\Content\Application\Page\Event;

use N3ttech\Content\Domain\Model\Page\Page;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

final class ExistingPageSited extends PageEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Identity\Uuids
     */
    public function pageSites(): VO\Identity\Uuids
    {
        return VO\Identity\Uuids::fromArray($this->payload['sites'] ?? []);
    }

    /**
     * @param Page $page
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $page): void
    {
        $page->setKey($this->pageKey());
        $page->setSites($this->pageSites());
    }
}
