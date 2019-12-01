<?php

namespace N3ttech\Content\Application\News\Command;

use N3ttech\Content\Domain\Model\News\News;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

final class SiteNewsHandler extends CommandHandler
{
    /**
     * @param SiteNews $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var News $category */
        $category = $this->repository->find($command->getUuid());

        $category->sited(VO\Identity\Uuids::fromArray($command->getSites()));

        $this->repository->save($category);
    }
}
