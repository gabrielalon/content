<?php

namespace N3ttech\Content\Application\Blog\Command;

use N3ttech\Content\Domain\Model\Blog\Entry;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class TranslateEntryHandler extends EntryHandler
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

        $entry->translate(
            VO\Intl\Language\Texts::fromArray($command->getNames()),
            VO\Intl\Language\Contents::fromArray($command->getContents())
        );

        $this->repository->save($entry);
    }
}
