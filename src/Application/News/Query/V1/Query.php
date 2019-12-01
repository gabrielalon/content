<?php

namespace N3ttech\Content\Application\News\Query\V1;

use N3ttech\Content\Application\News\Query\ReadModel;
use N3ttech\Messaging\Query\Exception;

abstract class Query extends \N3ttech\Messaging\Query\Query\Query
{
    /** @var ReadModel\NewsCollection */
    private $collection;

    /**
     * @param string $key
     *
     * @throws Exception\ResourceNotFoundException
     *
     * @return ReadModel\News
     */
    public function getNews(string $key): ReadModel\News
    {
        $this->initializeCollection();

        if (0 === $this->collection->count()) {
            throw new Exception\ResourceNotFoundException('News not found');
        }

        return $this->collection->get($key);
    }

    /**
     * @param ReadModel\News $entry
     */
    public function addNews(ReadModel\News $entry): void
    {
        $this->initializeCollection();

        $this->collection->add($entry);
    }

    /**
     * @return ReadModel\NewsCollection
     */
    public function getCollection(): ReadModel\NewsCollection
    {
        $this->initializeCollection();

        return $this->collection;
    }

    private function initializeCollection(): void
    {
        if (null === $this->collection) {
            $this->collection = new ReadModel\NewsCollection();
        }
    }
}
