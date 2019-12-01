<?php

namespace N3ttech\Content\Application\Page\Command;

use N3ttech\Content\Domain\Model\Page\Page;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

final class SitePageHandler extends CommandHandler
{
    /**
     * @param SitePage $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Page $page */
        $page = $this->repository->find($command->getKey());

        $page->sited(VO\Identity\Uuids::fromArray($command->getSites()));

        $this->repository->save($page);
    }
}
