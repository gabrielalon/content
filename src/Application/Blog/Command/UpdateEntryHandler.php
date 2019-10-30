<?php

namespace N3ttech\Content\Application\Blog\Command;

use N3ttech\Content\Domain\Model\Blog\Entry;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class UpdateEntryHandler extends EntryHandler
{
    /**
     * @param UpdateEntry $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Entry $entry */
        $entry = $this->repository->find($command->getUuid());

        $entry->update(VO\Date\Time::fromTimestamp($command->getPublishDate()));

        $this->repository->save($entry);
    }
}
