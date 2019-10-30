<?php

namespace N3ttech\Content\Domain\Model\Snippet;

use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class Snippet extends AggregateRoot
{
    /** @var VO\Char\Text */
    private $key;

    /** @var VO\Intl\Language\Contents */
    private $contents;

    /**
     * @param VO\Identity\Uuid $uuid
     *
     * @return Snippet
     */
    public function setUuid(VO\Identity\Uuid $uuid): Snippet
    {
        $this->setAggregateId($uuid);

        return $this;
    }

    /**
     * @param VO\Char\Text $key
     *
     * @return Snippet
     */
    public function setKey(VO\Char\Text $key): Snippet
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @param VO\Intl\Language\Contents $contents
     *
     * @return Snippet
     */
    public function setContents(VO\Intl\Language\Contents $contents): Snippet
    {
        $this->contents = $contents;

        return $this;
    }
}
