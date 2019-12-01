<?php

namespace N3ttech\Content\Application\Blog\Command;

final class CategorizeEntry extends Command
{
    /** @var string[] */
    private $categories;

    /**
     * @param string   $uuid
     * @param string[] $categories
     */
    public function __construct(string $uuid, array $categories)
    {
        $this->setUuid($uuid);
        $this->categories = $categories;
    }

    /**
     * @return string[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }
}
