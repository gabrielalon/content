<?php

namespace N3ttech\Content\Domain\Model\News;

use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class News extends AggregateRoot
{
    /** @var VO\Date\Time */
    private $publishDate;

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
     * @return News
     */
    public function setUuid(VO\Identity\Uuid $uuid): News
    {
        $this->setAggregateId($uuid);

        return $this;
    }

    /**
     * @param VO\Date\Time $publishDate
     *
     * @return News
     */
    public function setPublishDate(VO\Date\Time $publishDate): News
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    /**
     * @param VO\Intl\Language\Texts $names
     *
     * @return News
     */
    public function setNames(VO\Intl\Language\Texts $names): News
    {
        $this->names = $names;

        return $this;
    }

    /**
     * @param VO\Intl\Language\Contents $contents
     *
     * @return News
     */
    public function setContents(VO\Intl\Language\Contents $contents): News
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * @param VO\Identity\Uuids $sites
     *
     * @return News
     */
    public function setSites(VO\Identity\Uuids $sites): News
    {
        $this->sites = $sites;

        return $this;
    }

    /**
     * @param VO\Option\Check $hide
     *
     * @return News
     */
    public function setHide(VO\Option\Check $hide): News
    {
        $this->hide = $hide;

        return $this;
    }
}
