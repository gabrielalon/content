<?php

namespace N3ttech\Content\Application\Blog\Event;

use N3ttech\Content\Domain\Model\Blog\Category;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

final class ExistingCategorySited extends CategoryEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Identity\Uuids
     */
    public function categorySites(): VO\Identity\Uuids
    {
        return VO\Identity\Uuids::fromArray($this->payload['sites'] ?? []);
    }

    /**
     * @param Category $category
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $category): void
    {
        $category->setUuid($this->categoryUuid());
        $category->setSites($this->categorySites());
    }
}
