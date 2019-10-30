<?php

namespace N3ttech\Content\Application\Blog\Command;

use N3ttech\Content\Domain\Model\Blog\Category;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class TranslateCategoryHandler extends CategoryHandler
{
    /**
     * @param TranslateCategory $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Category $category */
        $category = $this->repository->find($command->getUuid());

        $category->translate(VO\Intl\Language\Texts::fromArray($command->getNames()));

        $this->repository->save($category);
    }
}
