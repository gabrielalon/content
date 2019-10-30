<?php

namespace N3ttech\Content\Application\Blog\Event;

use N3ttech\Content\Domain\Model\Blog\Category;
use N3ttech\Messaging\Aggregate\AggregateRoot;

class ExistingCategoryRemoved extends CategoryEvent
{
    /**
     * @param Category $category
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $category): void
    {
        $category->setUuid($this->categoryUuid());
    }
}
