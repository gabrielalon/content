<?php

namespace N3ttech\Content\Test\Application\Page;

use N3ttech\Content\Application\Page\Event;
use N3ttech\Content\Domain\Common;
use N3ttech\Content\Domain\Model\Page\Page;
use N3ttech\Content\Test\Application\AggregateChangedTestCase;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 * @coversNothing
 */
class PageTest extends AggregateChangedTestCase
{
    /** @var Page\Key */
    private $key;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->key = Page\Key::fromString('Some Page');
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     */
    public function itCreatesNewPageTest(): void
    {
        $page = Page::createNewPage($this->key);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($page);

        $this->assertCount(1, $events);

        /** @var Event\NewPageCreated $event */
        $event = $events[0];

        $this->assertSame(Event\NewPageCreated::class, $event->messageName());
        $this->assertTrue($this->key->equals($event->pageKey()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itTranslatesExistingPageTest(): void
    {
        /** @var Page $page */
        $page = $this->reconstituteReturnPackageFromHistory($this->newPageCreated());

        $content = Common\Content::fromData(['pl' => 'Name'], ['pl' => 'Content']);

        $page->translate($content);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($page);

        $this->assertCount(1, $events);

        /** @var Event\ExistingPageTranslated $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingPageTranslated::class, $event->messageName());
        $this->assertTrue($content->equals($event->pageContent()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itSitesExistingPageTest(): void
    {
        /** @var Page $page */
        $page = $this->reconstituteReturnPackageFromHistory($this->newPageCreated());

        $sites = VO\Identity\Uuids::fromArray([Uuid::uuid4()->toString()]);

        $page->sited($sites);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($page);

        $this->assertCount(1, $events);

        /** @var Event\ExistingPageSited $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingPageSited::class, $event->messageName());
        $this->assertTrue($sites->equals($event->pageSites()));
    }

    /**
     * @test
     */
    public function itRemovesExistingPageTest(): void
    {
        /** @var Page $page */
        $page = $this->reconstituteReturnPackageFromHistory($this->newPageCreated());
        $page->remove();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($page);

        $this->assertCount(1, $events);

        /** @var Event\ExistingPageRemoved $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingPageRemoved::class, $event->messageName());
    }

    /**
     * @param AggregateChanged ...$events
     *
     * @return AggregateRoot
     */
    private function reconstituteReturnPackageFromHistory(AggregateChanged ...$events): AggregateRoot
    {
        return $this->reconstituteAggregateFromHistory(
            Page::class,
            $events
        );
    }

    /**
     * @return AggregateChanged
     */
    private function newPageCreated(): AggregateChanged
    {
        return Event\NewPageCreated::occur($this->key->toString());
    }
}
