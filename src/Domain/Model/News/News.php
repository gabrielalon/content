<?php

namespace N3ttech\Content\Domain\Model\News;

use N3ttech\Content\Domain\Common;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class News extends AggregateRoot
{
    /** @var VO\Date\Time */
    private $creationDate;

    /** @var Common\Release */
    private $release;

    /** @var Common\Content */
    private $content;

    /** @var VO\Identity\Uuids */
    private $sites;

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
     * @param VO\Date\Time $creationDate
     *
     * @return News
     */
    public function setCreationDate(VO\Date\Time $creationDate): News
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @param Common\Release $release
     *
     * @return News
     */
    public function setRelease(Common\Release $release): News
    {
        $this->release = $release;

        return $this;
    }

    /**
     * @param Common\Content $content
     *
     * @return News
     */
    public function setContent(Common\Content $content): News
    {
        $this->content = $content;

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
}
