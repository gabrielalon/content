<?php

namespace N3ttech\Content\Application\Page\Command;

use N3ttech\Content\Domain\Model\Page\Page;
use N3ttech\Messaging\Message\Domain\Message;

final class RemovePageHandler extends CommandHandler
{
    /**
     * @param RemovePage $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Page $page */
        $page = $this->repository->find($command->getKey());

        $page->remove();

        $this->repository->save($page);
    }
}
