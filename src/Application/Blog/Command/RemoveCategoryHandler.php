<?php

namespace N3ttech\Content\Application\Blog\Command;

use N3ttech\Content\Domain\Model\Blog\Category;
use N3ttech\Messaging\Message\Domain\Message;

final class RemoveCategoryHandler extends CategoryHandler
{
    /**
     * @param MoveCategory $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Category $category */
        $category = $this->repository->find($command->getUuid());

        $category->remove();

        $this->repository->save($category);
    }
}
