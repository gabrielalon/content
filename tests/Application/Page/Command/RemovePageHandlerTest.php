<?php

namespace N3ttech\Content\Test\Application\Page\Command;

use N3ttech\Content\Application\Page\Command;
use N3ttech\Content\Application\Page\Event;
use N3ttech\Content\Application\Page\Service;
use N3ttech\Content\Domain\Model\Page\Page;
use N3ttech\Content\Domain\Model\Page\Projection;
use N3ttech\Content\Infrastructure\Persist\Page\PageRepository;
use N3ttech\Content\Infrastructure\Projection\Page\InMemoryPageProjector;
use N3ttech\Content\Test\Application\HandlerTestCase;
use N3ttech\Messaging\Aggregate\AggregateType;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;

/**
 * @internal
 * @coversNothing
 */
class RemovePageHandlerTest extends HandlerTestCase
{
    /** @var Service\PageCommandManager */
    private $command;

    public function setUp(): void
    {
        $repository = new PageRepository($this->getEventStorage(), $this->getSnapshotStorage());

        $this->register(Projection\PageProjection::class, new InMemoryPageProjector());
        $this->register(Command\CreatePageHandler::class, new Command\CreatePageHandler($repository));
        $this->register(Command\RemovePageHandler::class, new Command\RemovePageHandler($repository));

        $this->command = new Service\PageCommandManager($this->getCommandBus());
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itRemovesExistingPageTest(): void
    {
        //given
        $key = Page\Key::fromString('Some Page');
        $this->command->create($key->toString());

        //when
        $this->command->remove($key->toString());

        //then
        $collection = $this->getStreamRepository()->load($key, 2);

        foreach ($collection->getArrayCopy() as $eventStream) {
            $event = $eventStream->getEventName();
            /** @var AggregateChanged $event */

            /** @var Event\ExistingPageRemoved $event */
            $event = $event::fromEventStream($eventStream);

            $this->assertInstanceOf(Event\ExistingPageRemoved::class, $event);
        }

        $snapshot = $this->getSnapshotRepository()->get(AggregateType::fromAggregateRootClass(Page::class), $key);
        $this->assertEquals($snapshot->getLastVersion(), 2);
    }
}
