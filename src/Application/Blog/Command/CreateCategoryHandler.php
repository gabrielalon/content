<?php

namespace N3ttech\Content\Application\Blog\Command;

use N3ttech\Content\Domain\Model\Blog\Category;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

final class CreateCategoryHandler extends CategoryHandler
{
    /**
     * @param CreateCategory $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        $this->repository->save(Category::createNewCategory(VO\Identity\Uuid::fromIdentity($command->getUuid())));
    }
}
