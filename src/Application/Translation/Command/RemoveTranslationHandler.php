<?php

namespace N3ttech\Content\Application\Translation\Command;

use N3ttech\Content\Domain\Model\Translation\Translation;
use N3ttech\Messaging\Message\Domain\Message;

final class RemoveTranslationHandler extends CommandHandler
{
    /**
     * @param RemoveTranslation $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Translation $translation */
        $translation = $this->repository->find($command->getKey());

        $translation->remove();

        $this->repository->save($translation);
    }
}
