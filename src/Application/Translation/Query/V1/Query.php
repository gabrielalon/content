<?php

namespace N3ttech\Content\Application\Translation\Query\V1;

use N3ttech\Content\Application\Translation\Query\ReadModel;
use N3ttech\Messaging\Query\Exception;

class Query extends \N3ttech\Messaging\Query\Query\Query
{
    /** @var ReadModel\TranslationCollection */
    private $collection;

    /**
     * @param string $key
     *
     * @throws Exception\ResourceNotFoundException
     *
     * @return ReadModel\Translation
     */
    public function getTranslation(string $key): ReadModel\Translation
    {
        $this->initializeCollection();

        if (0 === $this->collection->count()) {
            throw new Exception\ResourceNotFoundException('Translation not found');
        }

        return $this->collection->get($key);
    }

    /**
     * @param ReadModel\Translation $entry
     */
    public function addTranslation(ReadModel\Translation $entry): void
    {
        $this->initializeCollection();

        $this->collection->add($entry);
    }

    /**
     * @return ReadModel\TranslationCollection
     */
    public function getCollection(): ReadModel\TranslationCollection
    {
        $this->initializeCollection();

        return $this->collection;
    }

    private function initializeCollection(): void
    {
        if (null === $this->collection) {
            $this->collection = new ReadModel\TranslationCollection();
        }
    }
}
