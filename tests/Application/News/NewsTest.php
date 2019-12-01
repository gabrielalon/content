<?php

namespace N3ttech\Content\Test\Application\News;

use N3ttech\Content\Application\News\Event;
use N3ttech\Content\Domain\Common;
use N3ttech\Content\Domain\Model\News\News;
use N3ttech\Content\Test\Application\AggregateChangedTestCase;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 * @coversNothing
 */
class NewsTest extends AggregateChangedTestCase
{
    /** @var VO\Identity\Uuid */
    private $uuid;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->uuid = VO\Identity\Uuid::fromIdentity(Uuid::uuid4()->toString());
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     */
    public function itCreatesNewNewsTest(): void
    {
        $news = News::createNewNews($this->uuid);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($news);

        $this->assertCount(1, $events);

        /** @var Event\NewNewsCreated $event */
        $event = $events[0];

        $this->assertSame(Event\NewNewsCreated::class, $event->messageName());
        $this->assertTrue($this->uuid->equals($event->newsUuid()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itReleasesExistingNewsTest(): void
    {
        /** @var News $news */
        $news = $this->reconstituteReturnPackageFromHistory($this->newNewsCreated());

        $release = Common\Release::fromData(time(), true);

        $news->release($release);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($news);

        $this->assertCount(1, $events);

        /** @var Event\ExistingNewsReleased $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingNewsReleased::class, $event->messageName());
        $this->assertTrue($release->equals($event->newsRelease()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itTranslatesExistingNewsTest(): void
    {
        /** @var News $news */
        $news = $this->reconstituteReturnPackageFromHistory($this->newNewsCreated());

        $content = Common\Content::fromData(['pl' => 'Name'], ['pl' => 'Content']);

        $news->translate($content);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($news);

        $this->assertCount(1, $events);

        /** @var Event\ExistingNewsTranslated $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingNewsTranslated::class, $event->messageName());
        $this->assertTrue($content->equals($event->newsContent()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itSitesExistingNewsTest(): void
    {
        /** @var News $news */
        $news = $this->reconstituteReturnPackageFromHistory($this->newNewsCreated());

        $sites = VO\Identity\Uuids::fromArray([Uuid::uuid4()->toString()]);
        $news->sited($sites);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($news);

        $this->assertCount(1, $events);

        /** @var Event\ExistingNewsSited $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingNewsSited::class, $event->messageName());
        $this->assertTrue($sites->equals($event->newsSites()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itShowsExistingNewsTest(): void
    {
        /** @var News $news */
        $news = $this->reconstituteReturnPackageFromHistory($this->newNewsCreated());

        $news->show();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($news);

        $this->assertCount(1, $events);

        /** @var Event\ExistingNewsReleased $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingNewsReleased::class, $event->messageName());
        $this->assertFalse($event->newsRelease()->hidden()->raw());
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itHidesExistingNewsTest(): void
    {
        /** @var News $news */
        $news = $this->reconstituteReturnPackageFromHistory($this->newNewsCreated());

        $news->hide();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($news);

        $this->assertCount(1, $events);

        /** @var Event\ExistingNewsReleased $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingNewsReleased::class, $event->messageName());
        $this->assertTrue($event->newsRelease()->hidden()->raw());
    }

    /**
     * @test
     */
    public function itRemovesExistingNewsTest(): void
    {
        /** @var News $news */
        $news = $this->reconstituteReturnPackageFromHistory($this->newNewsCreated());
        $news->remove();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($news);

        $this->assertCount(1, $events);

        /** @var Event\ExistingNewsRemoved $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingNewsRemoved::class, $event->messageName());
    }

    /**
     * @param AggregateChanged ...$events
     *
     * @return AggregateRoot
     */
    private function reconstituteReturnPackageFromHistory(AggregateChanged ...$events): AggregateRoot
    {
        return $this->reconstituteAggregateFromHistory(
            News::class,
            $events
        );
    }

    /**
     * @return AggregateChanged
     */
    private function newNewsCreated(): AggregateChanged
    {
        return Event\NewNewsCreated::occur($this->uuid->toString(), [
            'creation_date' => time(),
        ]);
    }
}
