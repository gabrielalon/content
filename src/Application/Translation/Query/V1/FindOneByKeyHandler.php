<?php

namespace N3ttech\Content\Application\Translation\Query\V1;

use N3ttech\Messaging\Message\Domain\Message;

final class FindOneByKeyHandler extends QueryHandler
{
    /**
     * @param FindOneByKey $query
     */
    public function run(Message $query): void
    {
        $this->query->findOneByKey($query);
    }
}
