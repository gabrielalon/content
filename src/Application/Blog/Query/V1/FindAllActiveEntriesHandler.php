<?php

namespace N3ttech\Content\Application\Blog\Query\V1;

use N3ttech\Messaging\Message\Domain\Message;

class FindAllActiveEntriesHandler extends EntryQueryHandler
{
    /**
     * @param FindAllActiveEntries $query
     */
    public function run(Message $query): void
    {
        $this->query->findAllActiveEntries($query);
    }
}
