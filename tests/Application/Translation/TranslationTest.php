<?php

namespace N3ttech\Content\Test\Application\Translation;

use N3ttech\Content\Application\Translation\Event;
use N3ttech\Content\Domain\Model\Translation\Translation;
use N3ttech\Content\Test\Application\AggregateChangedTestCase;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 * @coversNothing
 */
class TranslationTest extends AggregateChangedTestCase
{
    /** @var Translation\Key */
    private $key;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->key = Translation\Key::fromString('Some Translation');
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     */
    public function itCreatesNewTranslationTest(): void
    {
        $translation = Translation::createNewTranslation($this->key);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($translation);

        $this->assertCount(1, $events);

        /** @var Event\NewTranslationCreated $event */
        $event = $events[0];

        $this->assertSame(Event\NewTranslationCreated::class, $event->messageName());
        $this->assertTrue($this->key->equals($event->translationKey()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itUpdatesExistingTranslationTest(): void
    {
        /** @var Translation $translation */
        $translation = $this->reconstituteReturnPackageFromHistory($this->newTranslationCreated());

        $values = VO\Intl\Language\Contents::fromArray(['pl' => 'Name']);

        $translation->update($values);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($translation);

        $this->assertCount(1, $events);

        /** @var Event\ExistingTranslationUpdated $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingTranslationUpdated::class, $event->messageName());
        $this->assertTrue($values->equals($event->translationValues()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itSitesExistingTranslationTest(): void
    {
        /** @var Translation $translation */
        $translation = $this->reconstituteReturnPackageFromHistory($this->newTranslationCreated());

        $sites = VO\Identity\Uuids::fromArray([Uuid::uuid4()->toString()]);

        $translation->sited($sites);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($translation);

        $this->assertCount(1, $events);

        /** @var Event\ExistingTranslationSited $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingTranslationSited::class, $event->messageName());
        $this->assertTrue($sites->equals($event->translationSites()));
    }

    /**
     * @test
     */
    public function itRemovesExistingTranslationTest(): void
    {
        /** @var Translation $translation */
        $translation = $this->reconstituteReturnPackageFromHistory($this->newTranslationCreated());
        $translation->remove();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($translation);

        $this->assertCount(1, $events);

        /** @var Event\ExistingTranslationRemoved $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingTranslationRemoved::class, $event->messageName());
    }

    /**
     * @param AggregateChanged ...$events
     *
     * @return AggregateRoot
     */
    private function reconstituteReturnPackageFromHistory(AggregateChanged ...$events): AggregateRoot
    {
        return $this->reconstituteAggregateFromHistory(
            Translation::class,
            $events
        );
    }

    /**
     * @return AggregateChanged
     */
    private function newTranslationCreated(): AggregateChanged
    {
        return Event\NewTranslationCreated::occur($this->key->toString());
    }
}
