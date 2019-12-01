<?php

namespace N3ttech\Content\Application\Translation\Command;

use N3ttech\Content\Domain\Model\Translation\Translation;
use N3ttech\Messaging\Message\Domain\Message;

final class CreateTranslationHandler extends CommandHandler
{
    /**
     * @param CreateTranslation $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        $this->repository->save(Translation::createNewTranslation(Translation\Key::fromString($command->getKey())));
    }
}
