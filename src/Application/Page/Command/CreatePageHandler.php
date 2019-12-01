<?php

namespace N3ttech\Content\Application\Page\Command;

use N3ttech\Content\Domain\Model\Page\Page;
use N3ttech\Messaging\Message\Domain\Message;

final class CreatePageHandler extends CommandHandler
{
    /**
     * @param CreatePage $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        $this->repository->save(Page::createNewPage(Page\Key::fromString($command->getKey())));
    }
}
