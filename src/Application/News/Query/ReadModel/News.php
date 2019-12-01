<?php

namespace N3ttech\Content\Application\News\Query\ReadModel;

use N3ttech\Messaging\Query\Query\Viewable;
use N3ttech\Valuing as VO;

class News implements Viewable
{
    /** @var VO\Identity\Uuid */
    private $uuid;

    /** @var VO\Date\Time */
    private $creationDate;

    /** @var VO\Date\Time */
    private $releaseDate;

    /** @var VO\Option\Check */
    private $hidden;

    /** @var VO\Intl\Language\Texts */
    private $names;

    /** @var VO\Intl\Language\Contents */
    private $contents;

    /** @var VO\Identity\Uuids */
    private $sites;

    /**
     * @param string $uuid
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return News
     */
    public static function fromUuid(string $uuid): News
    {
        $entry = new static();

        return $entry->setUuid(VO\Identity\Uuid::fromIdentity($uuid));
    }

    /**
     * @return string
     */
    public function identifier()
    {
        return $this->uuid->toString();
    }

    /**
     * @return VO\Identity\Uuid
     */
    public function getUuid(): VO\Identity\Uuid
    {
        return $this->uuid;
    }

    /**
     * @param VO\Identity\Uuid $uuid
     *
     * @return News
     */
    public function setUuid(VO\Identity\Uuid $uuid): News
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return string
     */
    public function creationDate(): string
    {
        return $this->creationDate->toString();
    }

    /**
     * @return VO\Date\Time
     */
    public function getCreationDate(): VO\Date\Time
    {
        return $this->creationDate;
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
     * @return \DateTime
     */
    public function releaseDate(): \DateTime
    {
        return date_timestamp_set(date_create(), $this->releaseDate->raw());
    }

    /**
     * @return VO\Date\Time
     */
    public function getReleaseDate(): VO\Date\Time
    {
        return $this->releaseDate;
    }

    /**
     * @param VO\Date\Time $releaseDate
     *
     * @return News
     */
    public function setReleaseDate(VO\Date\Time $releaseDate): News
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHidden(): bool
    {
        return $this->hidden->raw();
    }

    /**
     * @return VO\Option\Check
     */
    public function getHidden(): VO\Option\Check
    {
        return $this->hidden;
    }

    /**
     * @param VO\Option\Check $hidden
     *
     * @return News
     */
    public function setHidden(VO\Option\Check $hidden): News
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * @return string[]
     */
    public function names(): array
    {
        return $this->names->raw();
    }

    /**
     * @return VO\Intl\Language\Texts
     */
    public function getNames(): VO\Intl\Language\Texts
    {
        return $this->names;
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
     * @param string $locale
     * @param string $name
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return News
     */
    public function addName(string $locale, string $name): News
    {
        if (null === $this->names) {
            $this->setNames(VO\Intl\Language\Texts::fromArray([]));
        }

        $this->names->addLocale($locale, $name);
    }

    /**
     * @return string[]
     */
    public function contents(): array
    {
        return $this->contents->raw();
    }

    /**
     * @return VO\Intl\Language\Contents
     */
    public function getContents(): VO\Intl\Language\Contents
    {
        return $this->contents;
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
     * @param string $locale
     * @param string $content
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return News
     */
    public function addContent(string $locale, string $content): News
    {
        if (null === $this->contents) {
            $this->setContents(VO\Intl\Language\Contents::fromArray([]));
        }

        $this->contents->addLocale($locale, $content);
    }

    /**
     * @return array
     */
    public function sites(): array
    {
        return $this->sites->toArray();
    }

    /**
     * @return VO\Identity\Uuids
     */
    public function getSites(): VO\Identity\Uuids
    {
        return $this->sites;
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
