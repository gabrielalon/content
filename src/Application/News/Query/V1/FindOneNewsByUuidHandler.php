<?php

namespace N3ttech\Content\Application\News\Query\V1;

use N3ttech\Messaging\Message\Domain\Message;

final class FindOneNewsByUuidHandler extends QueryHandler
{
    /**
     * @param FindOneNewsByUuid $query
     */
    public function run(Message $query): void
    {
        $this->query->findOneNewsByUuid($query);
    }
}
