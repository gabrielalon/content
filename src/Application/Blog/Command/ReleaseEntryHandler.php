<?php

namespace N3ttech\Content\Application\Blog\Command;

use N3ttech\Content\Domain\Common\Release;
use N3ttech\Content\Domain\Model\Blog\Entry;
use N3ttech\Messaging\Message\Domain\Message;

class ReleaseEntryHandler extends EntryHandler
{
    /**
     * @param ReleaseEntry $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Entry $entry */
        $entry = $this->repository->find($command->getUuid());

        $entry->release(Release::fromData($command->getReleaseDate(), $command->isHidden()));

        $this->repository->save($entry);
    }
}
