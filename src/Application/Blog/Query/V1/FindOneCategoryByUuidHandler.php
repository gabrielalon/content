<?php

namespace N3ttech\Content\Application\Blog\Query\V1;

use N3ttech\Messaging\Message\Domain\Message;

final class FindOneCategoryByUuidHandler extends CategoryQueryHandler
{
    /**
     * @param FindOneCategoryByUuid $query
     */
    public function run(Message $query): void
    {
        $this->query->findOneCategoryByUuid($query);
    }
}
