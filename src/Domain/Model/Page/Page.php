<?php

namespace N3ttech\Content\Domain\Model\Page;

use N3ttech\Content\Application\Page\Event;
use N3ttech\Content\Domain\Common;
use N3ttech\Content\Domain\Model\Page\Page\Key;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class Page extends AggregateRoot
{
    /** @var Common\Content */
    private $content;

    /** @var VO\Identity\Uuids */
    private $sites;

    /**
     * @param Page\Key $key
     *
     * @return Page
     */
    public function setKey(Page\Key $key): Page
    {
        $this->setAggregateId($key);

        return $this;
    }

    /**
     * @param Common\Content $content
     *
     * @return Page
     */
    public function setContent(Common\Content $content): Page
    {
        $this->content = $content;

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
     * @param Key $key
     *
     * @return Page
     *
     * @throws \Assert\AssertionFailedException
     */
    public static function createNewPage(Key $key): Page
    {
        $category = new static();

        $category->recordThat(Event\NewPageCreated::occur($key->toString()));

        return $category;
    }

    /**
     * @param Common\Content $content
     */
    public function translate(Common\Content $content): void
    {
        $this->recordThat(Event\ExistingPageTranslated::occur($this->aggregateId(), [
            'content' => $content->raw(),
        ]));
    }

    /**
     * @param VO\Identity\Uuids $sites
     */
    public function sited(VO\Identity\Uuids $sites): void
    {
        $this->recordThat(Event\ExistingPageSited::occur($this->aggregateId(), [
            'sites' => $sites->toArray(),
        ]));
    }

    public function remove(): void
    {
        $this->recordThat(Event\ExistingPageRemoved::occur($this->aggregateId()));
    }
}
