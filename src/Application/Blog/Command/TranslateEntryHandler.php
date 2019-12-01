<?php

namespace N3ttech\Content\Application\Blog\Command;

use N3ttech\Content\Domain\Common\Content;
use N3ttech\Content\Domain\Model\Blog\Entry;
use N3ttech\Messaging\Message\Domain\Message;

final class TranslateEntryHandler extends EntryHandler
{
    /**
     * @param TranslateEntry $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Entry $entry */
        $entry = $this->repository->find($command->getUuid());

        $entry->translate(Content::fromData($command->getNames(), $command->getContents()));

        $this->repository->save($entry);
    }
}
