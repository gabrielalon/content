<?php

namespace N3ttech\Content\Application\News\Query\V1;

use N3ttech\Messaging\Message\Domain\Message;

final class FindAllActiveNewsHandler extends QueryHandler
{
    /**
     * @param FindAllActiveNews $query
     */
    public function run(Message $query): void
    {
        $this->query->findAllActiveNews($query);
    }
}
