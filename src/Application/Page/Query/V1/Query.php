<?php

namespace N3ttech\Content\Application\Page\Query\V1;

use N3ttech\Content\Application\Page\Query\ReadModel;
use N3ttech\Messaging\Query\Exception;

class Query extends \N3ttech\Messaging\Query\Query\Query
{
    /** @var ReadModel\PageCollection */
    private $collection;

    /**
     * @param string $key
     *
     * @throws Exception\ResourceNotFoundException
     *
     * @return ReadModel\Page
     */
    public function getPage(string $key): ReadModel\Page
    {
        $this->initializeCollection();

        if (0 === $this->collection->count()) {
            throw new Exception\ResourceNotFoundException('Page not found');
        }

        return $this->collection->get($key);
    }

    /**
     * @param ReadModel\Page $entry
     */
    public function addPage(ReadModel\Page $entry): void
    {
        $this->initializeCollection();

        $this->collection->add($entry);
    }

    /**
     * @return ReadModel\PageCollection
     */
    public function getCollection(): ReadModel\PageCollection
    {
        $this->initializeCollection();

        return $this->collection;
    }

    private function initializeCollection(): void
    {
        if (null === $this->collection) {
            $this->collection = new ReadModel\PageCollection();
        }
    }
}
