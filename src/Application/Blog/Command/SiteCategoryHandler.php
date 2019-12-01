<?php

namespace N3ttech\Content\Application\Blog\Command;

use N3ttech\Content\Domain\Model\Blog\Category;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

final class SiteCategoryHandler extends CategoryHandler
{
    /**
     * @param SiteCategory $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Category $category */
        $category = $this->repository->find($command->getUuid());

        $category->sited(VO\Identity\Uuids::fromArray($command->getSites()));

        $this->repository->save($category);
    }
}
