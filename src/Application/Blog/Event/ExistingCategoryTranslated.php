<?php

namespace N3ttech\Content\Application\Blog\Event;

use N3ttech\Content\Domain\Model\Blog\Category;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

final class ExistingCategoryTranslated extends CategoryEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Intl\Language\Texts
     */
    public function categoryNames(): VO\Intl\Language\Texts
    {
        return VO\Intl\Language\Texts::fromArray($this->payload['names'] ?? []);
    }

    /**
     * @param Category $category
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $category): void
    {
        $category->setUuid($this->categoryUuid());
        $category->setNames($this->categoryNames());
    }
}
