<?php

namespace N3ttech\Content\Application\News\Command;

use N3ttech\Content\Domain\Common\Release;
use N3ttech\Content\Domain\Model\News\News;
use N3ttech\Messaging\Message\Domain\Message;

final class ReleaseNewsHandler extends CommandHandler
{
    /**
     * @param ReleaseNews $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var News $entry */
        $entry = $this->repository->find($command->getUuid());

        $entry->release(Release::fromData($command->getReleaseDate(), $command->isHidden()));

        $this->repository->save($entry);
    }
}
