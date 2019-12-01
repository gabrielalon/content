<?php

namespace N3ttech\Content\Application\Blog\Event;

use N3ttech\Content\Domain\Model\Blog\Category;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

final class ExistingCategoryMoved extends CategoryEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Identity\Uuid
     */
    public function categoryParental(): VO\Identity\Uuid
    {
        return VO\Identity\Uuid::fromIdentity($this->payload['parental'] ?? '');
    }

    /**
     * @param Category $category
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $category): void
    {
        $category->setUuid($this->categoryUuid());
        $category->setParental($this->categoryParental());
    }
}
