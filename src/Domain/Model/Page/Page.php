<?php

namespace N3ttech\Content\Domain\Model\Page;

use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class Page extends AggregateRoot
{
    /** @var VO\Intl\Language\Texts */
    private $names;

    /** @var VO\Intl\Language\Contents */
    private $contents;

    /** @var VO\Identity\Uuids */
    private $sites;

    /** @var VO\Option\Check */
    private $hide;

    /**
     * @param VO\Identity\Uuid $uuid
     *
     * @return Page
     */
    public function setUuid(VO\Identity\Uuid $uuid): Page
    {
        $this->setAggregateId($uuid);

        return $this;
    }

    /**
     * @param VO\Intl\Language\Texts $names
     *
     * @return Page
     */
    public function setNames(VO\Intl\Language\Texts $names): Page
    {
        $this->names = $names;

        return $this;
    }

    /**
     * @param VO\Intl\Language\Contents $contents
     *
     * @return Page
     */
    public function setContents(VO\Intl\Language\Contents $contents): Page
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * @param VO\Identity\Uuids $sites
     *
     * @return Page
     */
    public function setSites(VO\Identity\Uuids $sites): Page
    {
        $this->sites = $sites;

        return $this;
    }

    /**
     * @param VO\Option\Check $hide
     *
     * @return Page
     */
    public function setHide(VO\Option\Check $hide): Page
    {
        $this->hide = $hide;

        return $this;
    }
}
