<?php

namespace N3ttech\Content\Test\Application\Translation\Command;

use N3ttech\Content\Application\Translation\Command;
use N3ttech\Content\Application\Translation\Event;
use N3ttech\Content\Application\Translation\Service;
use N3ttech\Content\Domain\Model\Translation\Projection;
use N3ttech\Content\Domain\Model\Translation\Translation;
use N3ttech\Content\Infrastructure\Persist\Translation\TranslationRepository;
use N3ttech\Content\Infrastructure\Projection\Translation\InMemoryTranslationProjector;
use N3ttech\Content\Test\Application\HandlerTestCase;
use N3ttech\Messaging\Aggregate\AggregateType;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;

/**
 * @internal
 * @coversNothing
 */
class RemoveTranslationHandlerTest extends HandlerTestCase
{
    /** @var Service\TranslationCommandManager */
    private $command;

    public function setUp(): void
    {
        $repository = new TranslationRepository($this->getEventStorage(), $this->getSnapshotStorage());

        $this->register(Projection\TranslationProjection::class, new InMemoryTranslationProjector());
        $this->register(Command\CreateTranslationHandler::class, new Command\CreateTranslationHandler($repository));
        $this->register(Command\RemoveTranslationHandler::class, new Command\RemoveTranslationHandler($repository));

        $this->command = new Service\TranslationCommandManager($this->getCommandBus());
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itRemovesExistingTranslationTest(): void
    {
        //given
        $key = Translation\Key::fromString('Some Translation');
        $this->command->create($key->toString());

        //when
        $this->command->remove($key->toString());

        //then
        $collection = $this->getStreamRepository()->load($key, 2);

        foreach ($collection->getArrayCopy() as $eventStream) {
            $event = $eventStream->getEventName();
            /** @var AggregateChanged $event */

            /** @var Event\ExistingTranslationRemoved $event */
            $event = $event::fromEventStream($eventStream);

            $this->assertInstanceOf(Event\ExistingTranslationRemoved::class, $event);
        }

        $snapshot = $this->getSnapshotRepository()->get(AggregateType::fromAggregateRootClass(Translation::class), $key);
        $this->assertEquals($snapshot->getLastVersion(), 2);
    }
}
