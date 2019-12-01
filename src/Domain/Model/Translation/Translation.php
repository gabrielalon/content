<?php

namespace N3ttech\Content\Domain\Model\Translation;

use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class Translation extends AggregateRoot
{
    /** @var VO\Char\Text */
    private $key;

    /** @var VO\Intl\Language\Contents */
    private $contents;

    /**
     * @param VO\Identity\Uuid $uuid
     *
     * @return Translation
     */
    public function setUuid(VO\Identity\Uuid $uuid): Translation
    {
        $this->setAggregateId($uuid);

        return $this;
    }

    /**
     * @param VO\Char\Text $key
     *
     * @return Translation
     */
    public function setKey(VO\Char\Text $key): Translation
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @param VO\Intl\Language\Contents $contents
     *
     * @return Translation
     */
    public function setContents(VO\Intl\Language\Contents $contents): Translation
    {
        $this->contents = $contents;

        return $this;
    }
}
