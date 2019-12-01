<?php

namespace N3ttech\Content\Application\Translation\Command;

use N3ttech\Content\Domain\Model\Translation\Translation;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

final class SiteTranslationHandler extends CommandHandler
{
    /**
     * @param SiteTranslation $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Translation $translation */
        $translation = $this->repository->find($command->getKey());

        $translation->sited(VO\Identity\Uuids::fromArray($command->getSites()));

        $this->repository->save($translation);
    }
}
