<?php

namespace N3ttech\Content\Application\Blog\Command;

use N3ttech\Content\Domain\Model\Blog\Entry;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class CategorizeEntryHandler extends EntryHandler
{
    /**
     * @param CategorizeEntry $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Entry $entry */
        $entry = $this->repository->find($command->getUuid());

        $entry->categorize(VO\Identity\Uuids::fromArray($command->getCategories()));

        $this->repository->save($entry);
    }
}
