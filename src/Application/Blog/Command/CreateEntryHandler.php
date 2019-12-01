<?php

namespace N3ttech\Content\Application\Blog\Command;

use N3ttech\Content\Domain\Model\Blog\Entry;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

final class CreateEntryHandler extends EntryHandler
{
    /**
     * @param CreateEntry $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        $this->repository->save(Entry::createNewEntry(VO\Identity\Uuid::fromIdentity($command->getUuid())));
    }
}
