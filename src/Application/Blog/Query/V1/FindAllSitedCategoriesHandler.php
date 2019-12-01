<?php

namespace N3ttech\Content\Application\Blog\Query\V1;

use N3ttech\Messaging\Message\Domain\Message;

class FindAllSitedCategoriesHandler extends CategoryQueryHandler
{
    /**
     * @param FindAllSitedCategories $query
     */
    public function run(Message $query): void
    {
        $this->query->findAllSitedCategories($query);
    }
}
