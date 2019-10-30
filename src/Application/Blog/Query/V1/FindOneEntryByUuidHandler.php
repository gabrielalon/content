<?php

namespace N3ttech\Content\Application\Blog\Query\V1;

use N3ttech\Messaging\Message\Domain\Message;

class FindOneEntryByUuidHandler extends EntryQueryHandler
{
    /**
     * @param FindOneEntryByUuid $query
     */
    public function run(Message $query): void
    {
        $this->ask->findOneEntryByUuid($query);
    }
}