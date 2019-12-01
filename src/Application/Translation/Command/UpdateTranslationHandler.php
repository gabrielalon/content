<?php

namespace N3ttech\Content\Application\Translation\Command;

use N3ttech\Content\Domain\Model\Translation\Translation;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

final class UpdateTranslationHandler extends CommandHandler
{
    /**
     * @param UpdateTranslation $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Translation $translation */
        $translation = $this->repository->find($command->getKey());

        $translation->update(VO\Intl\Language\Contents::fromArray($command->getValues()));

        $this->repository->save($translation);
    }
}
