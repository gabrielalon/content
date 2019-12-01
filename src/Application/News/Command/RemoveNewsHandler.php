<?php

namespace N3ttech\Content\Application\News\Command;

use N3ttech\Content\Domain\Model\News\News;
use N3ttech\Messaging\Message\Domain\Message;

final class RemoveNewsHandler extends CommandHandler
{
    /**
     * @param RemoveNews $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var News $entry */
        $entry = $this->repository->find($command->getUuid());

        $entry->remove();

        $this->repository->save($entry);
    }
}
