<?php

namespace N3ttech\Content\Application\Blog\Command;

use N3ttech\Content\Domain\Model\Blog\Entry;
use N3ttech\Messaging\Message\Domain\Message;

final class ShowEntryHandler extends EntryHandler
{
    /**
     * @param ShowEntry $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Entry $entry */
        $entry = $this->repository->find($command->getUuid());

        $entry->show();

        $this->repository->save($entry);
    }
}
