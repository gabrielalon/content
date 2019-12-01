<?php

namespace N3ttech\Content\Application\News\Command;

use N3ttech\Content\Domain\Model\News\News;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

final class CreateNewsHandler extends CommandHandler
{
    /**
     * @param CreateNews $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        $this->repository->save(News::createNewNews(VO\Identity\Uuid::fromIdentity($command->getUuid())));
    }
}
