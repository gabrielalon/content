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
class TranslatePageHandlerTest extends HandlerTestCase
{
    /** @var Service\PageCommandManager */
    private $command;

    public function setUp(): void
    {
        $repository = new PageRepository($this->getEventStorage(), $this->getSnapshotStorage());

        $this->register(Projection\PageProjection::class, new InMemoryPageProjector());
        $this->register(Command\CreatePageHandler::class, new Command\CreatePageHandler($repository));
        $this->register(Command\TranslatePageHandler::class, new Command\TranslatePageHandler($repository));

        $this->command = new Service\PageCommandManager($this->getCommandBus());
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itCategorizesExistingPagePageTest(): void
    {
        //given
        $key = Page\Key::fromString('Some Page');
        $names = ['pl' => 'test'];
        $contents = ['pl' => 'test'];
        $this->command->create($key->toString());

        //when
        $this->command->translate($key->toString(), $names, $contents);

        //then
        /** @var InMemoryPageProjector $projector */
        $projector = $this->container->get(Projection\PageProjection::class);
        $entity = $projector->get($key->toString());

        $this->assertEquals($entity->identifier(), $key->toString());
        $this->assertEquals($entity->names(), $names);
        $this->assertEquals($entity->contents(), $contents);

        $collection = $this->getStreamRepository()->load($key, 2);

        foreach ($collection->getArrayCopy() as $eventStream) {
            $event = $eventStream->getEventName();
            /** @var AggregateChanged $event */

            /** @var Event\ExistingPageTranslated $event */
            $event = $event::fromEventStream($eventStream);

            $this->assertTrue($entity->getKey()->equals($event->pageKey()));
            $this->assertTrue($entity->getNames()->equals($event->pageContent()->names()));
            $this->assertTrue($entity->getContents()->equals($event->pageContent()->texts()));
        }

        $snapshot = $this->getSnapshotRepository()->get(AggregateType::fromAggregateRootClass(Page::class), $key);
        $this->assertEquals($snapshot->getLastVersion(), 2);
    }
}
